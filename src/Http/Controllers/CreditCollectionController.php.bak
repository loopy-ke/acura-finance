<?php

namespace LoopyLabs\CreditFinancing\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use LoopyLabs\CreditFinancing\Models\CollectionCase;
use LoopyLabs\CreditFinancing\Models\CollectionActivity;
use LoopyLabs\CreditFinancing\Models\PaymentPlan;
use LoopyLabs\CreditFinancing\Models\CreditDisbursement;
use LoopyLabs\CreditFinancing\Services\CreditCollectionService;
use LoopyLabs\CreditFinancing\Http\Requests\CreateCollectionCaseRequest;
use LoopyLabs\CreditFinancing\Http\Requests\CreatePaymentPlanRequest;
use LoopyLabs\CreditFinancing\Http\Requests\RecordActivityRequest;
use App\Models\User;
use Carbon\Carbon;

class CreditCollectionController extends Controller
{
    protected CreditCollectionService $collectionService;

    public function __construct(CreditCollectionService $collectionService)
    {
        $this->collectionService = $collectionService;
        $this->middleware('auth');
    }

    /**
     * Display collection dashboard
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', CollectionCase::class);

        $filters = $request->only(['status', 'stage', 'priority', 'assigned_to']);
        
        $cases = CollectionCase::query()
            ->when($filters['status'] ?? null, fn($q, $status) => $q->where('status', $status))
            ->when($filters['stage'] ?? null, fn($q, $stage) => $q->where('collection_stage', $stage))
            ->when($filters['priority'] ?? null, fn($q, $priority) => $q->where('priority', $priority))
            ->when($filters['assigned_to'] ?? null, fn($q, $assigned) => $q->where('assigned_to', $assigned))
            ->with(['customer', 'assignedTo', 'creditDisbursement'])
            ->orderBy('priority')
            ->orderBy('days_overdue', 'desc')
            ->paginate(25);

        $metrics = $this->collectionService->getCollectionMetrics();
        $casesRequiringAction = $this->collectionService->getCasesRequiringAction(auth()->user());
        $overduePromises = $this->collectionService->getOverduePromises();

        $collectors = User::role(['collection_agent', 'senior_collection_agent', 'collection_supervisor', 'collection_manager'])
            ->get(['id', 'name']);

        return view('credit-financing::collection.index', compact(
            'cases', 'metrics', 'casesRequiringAction', 'overduePromises', 'collectors', 'filters'
        ));
    }

    /**
     * Show collection case details
     */
    public function show(CollectionCase $case): View
    {
        $this->authorize('view', $case);

        $case->load([
            'customer',
            'creditDisbursement',
            'assignedTo',
            'createdBy',
            'resolvedBy',
            'activities' => fn($q) => $q->orderBy('activity_date', 'desc'),
            'activities.performedBy',
            'paymentPlans' => fn($q) => $q->orderBy('created_at', 'desc'),
            'paymentPlans.createdBy',
            'paymentPlans.approvedBy'
        ]);

        $availableCollectors = User::role(['collection_agent', 'senior_collection_agent', 'collection_supervisor', 'collection_manager'])
            ->get(['id', 'name']);

        return view('credit-financing::collection.show', compact('case', 'availableCollectors'));
    }

    /**
     * Create new collection case
     */
    public function create(): View
    {
        $this->authorize('create', CollectionCase::class);

        $overdueDisbursements = CreditDisbursement::where('status', 'active')
            ->where('outstanding_amount', '>', 0)
            ->whereDoesntHave('collectionCases', fn($q) => $q->where('status', 'active'))
            ->with('customer')
            ->get();

        return view('credit-financing::collection.create', compact('overdueDisbursements'));
    }

    /**
     * Store new collection case
     */
    public function store(CreateCollectionCaseRequest $request): RedirectResponse
    {
        $disbursement = CreditDisbursement::findOrFail($request->credit_disbursement_id);
        
        $case = $this->collectionService->createCollectionCase(
            $disbursement,
            $request->validated()
        );

        return redirect()
            ->route('collection.show', $case)
            ->with('success', 'Collection case created successfully.');
    }

    /**
     * Update collection case
     */
    public function update(Request $request, CollectionCase $case): RedirectResponse
    {
        $this->authorize('update', $case);

        $validated = $request->validate([
            'priority' => 'sometimes|in:low,medium,high,urgent',
            'assigned_to' => 'sometimes|exists:users,id',
            'collection_stage' => 'sometimes|in:early_stage,middle_stage,late_stage,legal_stage',
            'case_notes' => 'sometimes|string',
        ]);

        $case->update($validated);

        return back()->with('success', 'Collection case updated successfully.');
    }

    /**
     * Record collection activity
     */
    public function recordActivity(RecordActivityRequest $request, CollectionCase $case): RedirectResponse
    {
        $this->authorize('update', $case);

        $this->collectionService->recordActivity($case, $request->validated());

        return back()->with('success', 'Activity recorded successfully.');
    }

    /**
     * Create payment plan
     */
    public function createPaymentPlan(CreatePaymentPlanRequest $request, CollectionCase $case): RedirectResponse
    {
        $this->authorize('update', $case);

        $plan = $this->collectionService->createPaymentPlan($case, $request->validated());

        return redirect()
            ->route('collection.payment-plans.show', $plan)
            ->with('success', 'Payment plan created successfully.');
    }

    /**
     * Process payment
     */
    public function processPayment(Request $request, CollectionCase $case): RedirectResponse
    {
        $this->authorize('update', $case);

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,bank_transfer,cheque,mobile_money,card',
            'payment_date' => 'required|date',
            'reference_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        $this->collectionService->processPayment($case, $validated['amount'], $validated);

        return back()->with('success', 'Payment processed successfully.');
    }

    /**
     * Escalate case
     */
    public function escalate(Request $request, CollectionCase $case): RedirectResponse
    {
        $this->authorize('update', $case);

        $validated = $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $this->collectionService->escalateCase($case, $validated['reason']);

        return back()->with('success', 'Case escalated successfully.');
    }

    /**
     * Assign case to collector
     */
    public function assign(Request $request, CollectionCase $case): RedirectResponse
    {
        $this->authorize('update', $case);

        $validated = $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $collector = User::findOrFail($validated['assigned_to']);
        $case->assignTo($collector);

        return back()->with('success', "Case assigned to {$collector->name} successfully.");
    }

    /**
     * Resolve case
     */
    public function resolve(Request $request, CollectionCase $case): RedirectResponse
    {
        $this->authorize('update', $case);

        $validated = $request->validate([
            'resolution_type' => 'required|in:full_payment,partial_payment,settlement,written_off,legal_action',
            'resolution_notes' => 'nullable|string',
        ]);

        $case->update([
            'status' => 'resolved',
            'resolution_type' => $validated['resolution_type'],
            'resolved_at' => now(),
            'resolved_by' => auth()->id(),
            'case_notes' => $validated['resolution_notes'] ?? $case->case_notes,
        ]);

        // Record activity
        $this->collectionService->recordActivity($case, [
            'activity_type' => 'other',
            'outcome' => 'case_escalated',
            'activity_notes' => "Case resolved: {$validated['resolution_type']}",
            'activity_date' => now(),
        ]);

        return back()->with('success', 'Case resolved successfully.');
    }

    /**
     * Close case
     */
    public function close(Request $request, CollectionCase $case): RedirectResponse
    {
        $this->authorize('update', $case);

        $validated = $request->validate([
            'closure_reason' => 'required|string|max:500',
        ]);

        $case->update([
            'status' => 'closed',
            'resolved_at' => now(),
            'resolved_by' => auth()->id(),
            'case_notes' => $validated['closure_reason'],
        ]);

        return back()->with('success', 'Case closed successfully.');
    }

    /**
     * Get collection metrics API
     */
    public function getMetrics(Request $request): JsonResponse
    {
        $this->authorize('viewAny', CollectionCase::class);

        $startDate = $request->date('start_date');
        $endDate = $request->date('end_date');

        $metrics = $this->collectionService->getCollectionMetrics($startDate, $endDate);

        return response()->json($metrics);
    }

    /**
     * Export collection report
     */
    public function exportReport(Request $request)
    {
        $this->authorize('viewAny', CollectionCase::class);

        $filters = $request->only([
            'status', 'stage', 'assigned_to', 'date_from', 'date_to'
        ]);

        $report = $this->collectionService->generateCollectionReport($filters);

        // Return CSV download
        $filename = 'collection_report_' . now()->format('Y_m_d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($report) {
            $file = fopen('php://output', 'w');
            
            // Write headers
            fputcsv($file, [
                'Case Number', 'Customer', 'Original Amount', 'Outstanding Amount',
                'Collected Amount', 'Days Overdue', 'Stage', 'Priority', 'Status',
                'Assigned To', 'Created Date', 'Resolved Date'
            ]);

            // Write data
            foreach ($report['cases'] as $case) {
                fputcsv($file, [
                    $case->case_number,
                    $case->customer->name,
                    number_format($case->original_amount, 2),
                    number_format($case->outstanding_amount, 2),
                    number_format($case->collected_amount, 2),
                    $case->days_overdue,
                    str_replace('_', ' ', title_case($case->collection_stage)),
                    title_case($case->priority),
                    title_case($case->status),
                    $case->assignedTo?->name ?? 'Unassigned',
                    $case->created_at->format('Y-m-d'),
                    $case->resolved_at?->format('Y-m-d') ?? '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Bulk update cases
     */
    public function bulkUpdate(Request $request): RedirectResponse
    {
        $this->authorize('update', CollectionCase::class);

        $validated = $request->validate([
            'case_ids' => 'required|array',
            'case_ids.*' => 'exists:collection_cases,id',
            'action' => 'required|in:assign,escalate,close',
            'assigned_to' => 'required_if:action,assign|exists:users,id',
            'escalation_reason' => 'required_if:action,escalate|string',
            'closure_reason' => 'required_if:action,close|string',
        ]);

        $cases = CollectionCase::whereIn('id', $validated['case_ids'])->get();
        $updated = 0;

        foreach ($cases as $case) {
            if ($this->authorize('update', $case, false)) {
                switch ($validated['action']) {
                    case 'assign':
                        $collector = User::find($validated['assigned_to']);
                        $case->assignTo($collector);
                        $updated++;
                        break;
                    
                    case 'escalate':
                        $this->collectionService->escalateCase($case, $validated['escalation_reason']);
                        $updated++;
                        break;
                    
                    case 'close':
                        $case->update([
                            'status' => 'closed',
                            'resolved_at' => now(),
                            'resolved_by' => auth()->id(),
                            'case_notes' => $validated['closure_reason'],
                        ]);
                        $updated++;
                        break;
                }
            }
        }

        return back()->with('success', "{$updated} cases updated successfully.");
    }
}