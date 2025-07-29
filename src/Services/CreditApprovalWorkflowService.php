<?php

namespace LoopyLabs\CreditFinancing\Services;

use LoopyLabs\CreditFinancing\Models\CreditApplication;
use LoopyLabs\CreditFinancing\Models\CreditDecision;
use LoopyLabs\CreditFinancing\Models\CreditLimit;
use LoopyLabs\CreditFinancing\Events\ApplicationSubmitted;
use LoopyLabs\CreditFinancing\Events\ApplicationApproved;
use LoopyLabs\CreditFinancing\Events\ApplicationDenied;
use LoopyLabs\CreditFinancing\Events\ApplicationEscalated;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreditApprovalWorkflowService
{
    protected array $approvalLevels = [
        'junior' => [
            'max_amount' => 50000,
            'required_score' => 70,
            'permissions' => ['credit.applications.approve.junior'],
        ],
        'senior' => [
            'max_amount' => 250000,
            'required_score' => 60,
            'permissions' => ['credit.applications.approve.senior'],
        ],
        'manager' => [
            'max_amount' => 1000000,
            'required_score' => 50,
            'permissions' => ['credit.applications.approve.manager'],
        ],
        'director' => [
            'max_amount' => PHP_INT_MAX,
            'required_score' => 0,
            'permissions' => ['credit.applications.approve.director'],
        ],
    ];

    public function submitForReview(CreditApplication $application, User $submittedBy): void
    {
        DB::transaction(function () use ($application, $submittedBy) {
            // Update application status
            $application->update([
                'status' => 'under_review',
                'submitted_at' => now(),
                'submitted_by' => $submittedBy->id,
                'review_level' => $this->determineRequiredApprovalLevel($application),
                'escalation_date' => now()->addHours(setting('credit_financing.escalation_hours', 72)),
            ]);

            // Create review record
            $this->createReviewRecord($application, $submittedBy);

            // Assign to appropriate reviewer
            $this->assignToReviewer($application);

            // Fire event
            event(new ApplicationSubmitted($application, $submittedBy));

            Log::info('Credit application submitted for review', [
                'application_id' => $application->id,
                'submitted_by' => $submittedBy->id,
                'review_level' => $application->review_level,
                'amount' => $application->requested_amount,
            ]);
        });
    }

    public function approveApplication(
        CreditApplication $application, 
        User $approver, 
        array $terms,
        string $comments = null
    ): CreditDecision {
        return DB::transaction(function () use ($application, $approver, $terms, $comments) {
            // Validate approver authority
            $this->validateApproverAuthority($application, $approver);

            // Create credit limit if needed
            $this->createOrUpdateCreditLimit($application, $terms);

            // Update application
            $application->update([
                'status' => 'approved',
                'decision_date' => now(),
                'approved_by' => $approver->id,
                'approved_amount' => $terms['amount'],
                'approved_term_months' => $terms['term_months'],
                'approved_interest_rate' => $terms['interest_rate'],
                'approved_fee_percentage' => $terms['fee_percentage'],
                'approval_comments' => $comments,
                'approval_conditions' => $terms['conditions'] ?? null,
            ]);

            // Create decision record
            $decision = CreditDecision::create([
                'credit_application_id' => $application->id,
                'decision' => 'approved',
                'decision_maker' => 'manual',
                'decided_by' => $approver->id,
                'credit_score' => $application->credit_score_at_application,
                'approved_amount' => $terms['amount'],
                'approved_term_months' => $terms['term_months'],
                'interest_rate' => $terms['interest_rate'],
                'fee_percentage' => $terms['fee_percentage'],
                'approval_conditions' => $terms['conditions'] ?? null,
                'decision_comments' => $comments,
            ]);

            // Update review record
            $this->updateReviewRecord($application, $approver, 'approved', $comments);

            // Fire event
            event(new ApplicationApproved($application, $approver, $decision));

            Log::info('Credit application approved', [
                'application_id' => $application->id,
                'approved_by' => $approver->id,
                'approved_amount' => $terms['amount'],
                'review_level' => $application->review_level,
            ]);

            return $decision;
        });
    }

    public function denyApplication(
        CreditApplication $application, 
        User $denier, 
        string $reason,
        string $comments = null
    ): CreditDecision {
        return DB::transaction(function () use ($application, $denier, $reason, $comments) {
            // Validate denier authority
            $this->validateApproverAuthority($application, $denier);

            // Update application
            $application->update([
                'status' => 'denied',
                'decision_date' => now(),
                'denied_by' => $denier->id,
                'denial_reason' => $reason,
                'denial_comments' => $comments,
            ]);

            // Create decision record
            $decision = CreditDecision::create([
                'credit_application_id' => $application->id,
                'decision' => 'denied',
                'decision_maker' => 'manual',
                'decided_by' => $denier->id,
                'credit_score' => $application->credit_score_at_application,
                'denial_reason_text' => $reason,
                'decision_comments' => $comments,
            ]);

            // Update review record
            $this->updateReviewRecord($application, $denier, 'denied', $comments);

            // Fire event
            event(new ApplicationDenied($application, $denier, $decision));

            Log::info('Credit application denied', [
                'application_id' => $application->id,
                'denied_by' => $denier->id,
                'reason' => $reason,
                'review_level' => $application->review_level,
            ]);

            return $decision;
        });
    }

    public function escalateApplication(CreditApplication $application, string $reason = null): void
    {
        DB::transaction(function () use ($application, $reason) {
            $currentLevel = $application->review_level;
            $nextLevel = $this->getNextApprovalLevel($currentLevel);

            if (!$nextLevel) {
                throw new \Exception('Application cannot be escalated further');
            }

            $application->update([
                'review_level' => $nextLevel,
                'escalation_date' => now()->addHours(setting('credit_financing.escalation_hours', 72)),
                'escalation_reason' => $reason,
                'escalated_at' => now(),
            ]);

            // Assign to new reviewer
            $this->assignToReviewer($application);

            // Create escalation record
            $this->createEscalationRecord($application, $currentLevel, $nextLevel, $reason);

            // Fire event
            event(new ApplicationEscalated($application, $currentLevel, $nextLevel));

            Log::info('Credit application escalated', [
                'application_id' => $application->id,
                'from_level' => $currentLevel,
                'to_level' => $nextLevel,
                'reason' => $reason,
            ]);
        });
    }

    public function reassignApplication(CreditApplication $application, User $newReviewer): void
    {
        $application->update([
            'assigned_to' => $newReviewer->id,
            'assigned_at' => now(),
        ]);

        // Create assignment record
        DB::table('credit_application_assignments')->insert([
            'credit_application_id' => $application->id,
            'assigned_to' => $newReviewer->id,
            'assigned_by' => auth()->id(),
            'assigned_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::info('Credit application reassigned', [
            'application_id' => $application->id,
            'assigned_to' => $newReviewer->id,
            'assigned_by' => auth()->id(),
        ]);
    }

    public function getApplicationsForReview(User $user, array $filters = []): \Illuminate\Database\Eloquent\Collection
    {
        $query = CreditApplication::with(['customer', 'createdBy', 'assignedTo'])
            ->whereIn('status', ['under_review', 'escalated'])
            ->where(function ($q) use ($user) {
                // Applications assigned to user
                $q->where('assigned_to', $user->id)
                  // Or applications at user's approval level that are unassigned
                  ->orWhere(function ($subQ) use ($user) {
                      $subQ->whereNull('assigned_to')
                           ->whereIn('review_level', $this->getUserApprovalLevels($user));
                  });
            });

        // Apply filters
        if (isset($filters['review_level'])) {
            $query->where('review_level', $filters['review_level']);
        }

        if (isset($filters['amount_min'])) {
            $query->where('requested_amount', '>=', $filters['amount_min']);
        }

        if (isset($filters['amount_max'])) {
            $query->where('requested_amount', '<=', $filters['amount_max']);
        }

        if (isset($filters['overdue'])) {
            $query->where('escalation_date', '<', now());
        }

        return $query->orderBy('escalation_date')
                    ->orderBy('submitted_at')
                    ->get();
    }

    protected function determineRequiredApprovalLevel(CreditApplication $application): string
    {
        $amount = $application->requested_amount;
        $score = $application->credit_score_at_application ?? 0;

        foreach ($this->approvalLevels as $level => $requirements) {
            if ($amount <= $requirements['max_amount'] && $score >= $requirements['required_score']) {
                return $level;
            }
        }

        return 'director'; // Fallback to highest level
    }

    protected function validateApproverAuthority(CreditApplication $application, User $approver): void
    {
        $requiredLevel = $application->review_level;
        $userLevels = $this->getUserApprovalLevels($approver);

        if (!in_array($requiredLevel, $userLevels)) {
            throw new \Exception("User does not have authority to approve at {$requiredLevel} level");
        }

        $levelConfig = $this->approvalLevels[$requiredLevel];
        
        if ($application->requested_amount > $levelConfig['max_amount']) {
            throw new \Exception("Application amount exceeds user's approval limit");
        }
    }

    protected function getUserApprovalLevels(User $user): array
    {
        $levels = [];
        
        foreach ($this->approvalLevels as $level => $config) {
            foreach ($config['permissions'] as $permission) {
                if ($user->hasPermissionTo($permission)) {
                    $levels[] = $level;
                    break;
                }
            }
        }

        return $levels;
    }

    protected function getNextApprovalLevel(string $currentLevel): ?string
    {
        $levels = array_keys($this->approvalLevels);
        $currentIndex = array_search($currentLevel, $levels);
        
        return $levels[$currentIndex + 1] ?? null;
    }

    protected function assignToReviewer(CreditApplication $application): void
    {
        $level = $application->review_level;
        $permissions = $this->approvalLevels[$level]['permissions'] ?? [];

        if (empty($permissions)) {
            return;
        }

        // Find users with appropriate permissions
        $reviewers = User::whereHas('permissions', function ($query) use ($permissions) {
            $query->whereIn('name', $permissions);
        })->where('is_active', true)->get();

        if ($reviewers->isEmpty()) {
            Log::warning('No reviewers found for approval level', ['level' => $level]);
            return;
        }

        // Simple round-robin assignment (could be enhanced with workload balancing)
        $reviewer = $reviewers->random();

        $application->update([
            'assigned_to' => $reviewer->id,
            'assigned_at' => now(),
        ]);
    }

    protected function createReviewRecord(CreditApplication $application, User $submittedBy): void
    {
        DB::table('credit_application_reviews')->insert([
            'credit_application_id' => $application->id,
            'review_level' => $application->review_level,
            'status' => 'pending',
            'submitted_by' => $submittedBy->id,
            'submitted_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    protected function updateReviewRecord(CreditApplication $application, User $reviewer, string $decision, ?string $comments): void
    {
        DB::table('credit_application_reviews')
            ->where('credit_application_id', $application->id)
            ->where('status', 'pending')
            ->update([
                'status' => $decision,
                'reviewed_by' => $reviewer->id,
                'reviewed_at' => now(),
                'review_comments' => $comments,
                'updated_at' => now(),
            ]);
    }

    protected function createEscalationRecord(CreditApplication $application, string $fromLevel, string $toLevel, ?string $reason): void
    {
        DB::table('credit_application_escalations')->insert([
            'credit_application_id' => $application->id,
            'from_level' => $fromLevel,
            'to_level' => $toLevel,
            'escalation_reason' => $reason,
            'escalated_by' => auth()->id(),
            'escalated_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    protected function createOrUpdateCreditLimit(CreditApplication $application, array $terms): void
    {
        $customer = $application->customer;
        
        $existingLimit = $customer->creditLimit;
        
        if ($existingLimit && $existingLimit->status === 'active') {
            // Update existing limit if approved amount is higher
            if ($terms['amount'] > $existingLimit->credit_limit) {
                $existingLimit->update([
                    'credit_limit' => $terms['amount'],
                    'interest_rate' => $terms['interest_rate'],
                    'fee_percentage' => $terms['fee_percentage'],
                    'updated_at' => now(),
                ]);
            }
        } else {
            // Create new credit limit
            CreditLimit::create([
                'customer_id' => $customer->id,
                'credit_limit' => $terms['amount'],
                'utilized_amount' => 0,
                'interest_rate' => $terms['interest_rate'],
                'fee_percentage' => $terms['fee_percentage'],
                'effective_date' => now(),
                'expiry_date' => now()->addMonths($terms['term_months']),
                'status' => 'active',
                'approved_by' => auth()->id(),
                'terms_and_conditions' => $terms['conditions'] ?? null,
            ]);
        }
    }
}