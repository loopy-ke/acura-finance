<?php

namespace LoopyLabs\CreditFinancing\Controllers;

use App\Http\Controllers\Controller;
use LoopyLabs\CreditFinancing\Models\CreditApplication;
use LoopyLabs\CreditFinancing\Services\CreditApprovalWorkflowService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreditReviewController extends Controller
{
    protected CreditApprovalWorkflowService $workflowService;

    public function __construct(CreditApprovalWorkflowService $workflowService)
    {
        $this->workflowService = $workflowService;
        $this->middleware('auth');
    }

    public function dashboard(Request $request)
    {
        $this->authorize('viewAny', CreditApplication::class);

        $user = auth()->user();

        // Get applications for review
        $filters = $request->only(['review_level', 'amount_min', 'amount_max', 'overdue']);
        $applicationsForReview = $this->workflowService->getApplicationsForReview($user, $filters);

        // Get review statistics
        $stats = [
            'pending_review' => $applicationsForReview->where('status', 'under_review')->count(),
            'assigned_to_me' => $applicationsForReview->where('assigned_to', $user->id)->count(),
            'overdue' => $applicationsForReview->where('escalation_date', '<', now())->count(),
            'escalated' => $applicationsForReview->where('status', 'escalated')->count(),
        ];

        // Get recent decisions made by user
        $recentDecisions = CreditApplication::whereIn('status', ['approved', 'denied'])
            ->where(function($query) use ($user) {
                $query->where('approved_by', $user->id)
                      ->orWhere('denied_by', $user->id);
            })
            ->with(['customer', 'latestDecision'])
            ->orderBy('decision_date', 'desc')
            ->limit(10)
            ->get();

        return view('credit-financing::review.dashboard', compact(
            'applicationsForReview', 'stats', 'recentDecisions', 'filters'
        ));
    }

    public function show(CreditApplication $application)
    {
        $this->authorize('view', $application);

        $application->load([
            'customer',
            'financingPartner',
            'createdBy',
            'submittedBy',
            'assignedTo',
            'approvedBy',
            'deniedBy',
            'decisions.decidedBy',
            'reviews.submittedByUser',
            'reviews.reviewedByUser',
            'escalations.escalatedByUser',
            'assignments.assignedToUser',
            'assignments.assignedByUser'
        ]);

        // Check if user can approve/deny this application
        $canApprove = $this->userCanApprove($application, auth()->user());
        $canEscalate = $this->userCanEscalate($application, auth()->user());
        $canReassign = $this->userCanReassign($application, auth()->user());

        // Get potential reviewers for reassignment
        $potentialReviewers = $this->getPotentialReviewers($application);

        return view('credit-financing::review.show', compact(
            'application', 'canApprove', 'canEscalate', 'canReassign', 'potentialReviewers'
        ));
    }

    public function approve(Request $request, CreditApplication $application)
    {
        $this->authorize('approve', $application);

        $request->validate([
            'approved_amount' => 'required|numeric|min:1|max:' . $application->requested_amount,
            'approved_term_months' => 'required|integer|min:1|max:60',
            'approved_interest_rate' => 'required|numeric|min:0|max:1',
            'approved_fee_percentage' => 'required|numeric|min:0|max:1',
            'approval_conditions' => 'nullable|string|max:1000',
            'approval_comments' => 'nullable|string|max:1000',
        ]);

        $terms = [
            'amount' => $request->approved_amount,
            'term_months' => $request->approved_term_months,
            'interest_rate' => $request->approved_interest_rate,
            'fee_percentage' => $request->approved_fee_percentage,
            'conditions' => $request->approval_conditions,
        ];

        $this->workflowService->approveApplication(
            $application,
            auth()->user(),
            $terms,
            $request->approval_comments
        );

        return redirect()
            ->route('credit.review.show', $application)
            ->with('success', 'Credit application approved successfully.');
    }

    public function deny(Request $request, CreditApplication $application)
    {
        $this->authorize('approve', $application);

        $request->validate([
            'denial_reason' => 'required|string|max:1000',
            'denial_comments' => 'nullable|string|max:1000',
        ]);

        $this->workflowService->denyApplication(
            $application,
            auth()->user(),
            $request->denial_reason,
            $request->denial_comments
        );

        return redirect()
            ->route('credit.review.show', $application)
            ->with('success', 'Credit application denied.');
    }

    public function escalate(Request $request, CreditApplication $application)
    {
        $this->authorize('update', $application);

        $request->validate([
            'escalation_reason' => 'required|string|max:1000',
        ]);

        try {
            $this->workflowService->escalateApplication($application, $request->escalation_reason);

            return redirect()
                ->route('credit.review.show', $application)
                ->with('success', 'Application escalated to next approval level.');
        } catch (\Exception $e) {
            return redirect()
                ->route('credit.review.show', $application)
                ->with('error', $e->getMessage());
        }
    }

    public function reassign(Request $request, CreditApplication $application)
    {
        $this->authorize('update', $application);

        $request->validate([
            'assigned_to' => 'required|exists:users,id',
            'assignment_notes' => 'nullable|string|max:500',
        ]);

        $newReviewer = User::find($request->assigned_to);

        $this->workflowService->reassignApplication($application, $newReviewer);

        return redirect()
            ->route('credit.review.show', $application)
            ->with('success', "Application reassigned to {$newReviewer->name}.");
    }

    public function submitForReview(CreditApplication $application)
    {
        $this->authorize('update', $application);

        if ($application->status !== 'draft') {
            return redirect()
                ->route('credit.applications.show', $application)
                ->with('error', 'Only draft applications can be submitted for review.');
        }

        $this->workflowService->submitForReview($application, auth()->user());

        return redirect()
            ->route('credit.applications.show', $application)
            ->with('success', 'Application submitted for review.');
    }

    public function bulkAssign(Request $request)
    {
        $this->authorize('viewAny', CreditApplication::class);

        $request->validate([
            'application_ids' => 'required|array',
            'application_ids.*' => 'exists:credit_applications,id',
            'assigned_to' => 'required|exists:users,id',
        ]);

        $reviewer = User::find($request->assigned_to);
        $assigned = 0;

        foreach ($request->application_ids as $applicationId) {
            $application = CreditApplication::find($applicationId);
            
            if ($application && $application->status === 'under_review') {
                $this->workflowService->reassignApplication($application, $reviewer);
                $assigned++;
            }
        }

        return redirect()
            ->route('credit.review.dashboard')
            ->with('success', "Assigned {$assigned} applications to {$reviewer->name}.");
    }

    protected function userCanApprove(CreditApplication $application, User $user): bool
    {
        if ($application->status !== 'under_review') {
            return false;
        }

        try {
            $levels = $this->workflowService->getUserApprovalLevels($user);
            return in_array($application->review_level, $levels);
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function userCanEscalate(CreditApplication $application, User $user): bool
    {
        return $application->status === 'under_review' && 
               ($application->assigned_to === $user->id || $user->hasPermissionTo('credit.applications.escalate'));
    }

    protected function userCanReassign(CreditApplication $application, User $user): bool
    {
        return $application->status === 'under_review' && 
               $user->hasPermissionTo('credit.applications.reassign');
    }

    protected function getPotentialReviewers(CreditApplication $application): \Illuminate\Database\Eloquent\Collection
    {
        $requiredLevel = $application->review_level;
        $levelConfig = config('credit-financing.approval_levels')[$requiredLevel] ?? [];
        $permissions = $levelConfig['permissions'] ?? [];

        if (empty($permissions)) {
            return collect();
        }

        return User::whereHas('permissions', function ($query) use ($permissions) {
            $query->whereIn('name', $permissions);
        })
        ->where('is_active', true)
        ->where('id', '!=', $application->assigned_to)
        ->orderBy('name')
        ->get();
    }
}