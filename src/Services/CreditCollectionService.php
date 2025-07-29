<?php

namespace LoopyLabs\CreditFinancing\Services;

use App\Models\User;
use App\Models\Customer;
use LoopyLabs\CreditFinancing\Models\CollectionCase;
use LoopyLabs\CreditFinancing\Models\CollectionActivity;
use LoopyLabs\CreditFinancing\Models\PaymentPlan;
use LoopyLabs\CreditFinancing\Models\CreditDisbursement;
use LoopyLabs\CreditFinancing\Models\CreditRepayment;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CreditCollectionService
{
    /**
     * Create a new collection case for overdue disbursement
     */
    public function createCollectionCase(CreditDisbursement $disbursement, array $data = []): CollectionCase
    {
        return DB::transaction(function () use ($disbursement, $data) {
            $overdueAmount = $disbursement->outstanding_amount;
            $overdueDate = $disbursement->due_date ?? $disbursement->disbursement_date->addDays(30);
            $daysOverdue = $overdueDate->diffInDays(now());

            $collectionCase = CollectionCase::create(array_merge([
                'credit_disbursement_id' => $disbursement->id,
                'customer_id' => $disbursement->customer_id,
                'original_amount' => $disbursement->disbursement_amount,
                'outstanding_amount' => $overdueAmount,
                'total_recoverable' => $overdueAmount,
                'days_overdue' => $daysOverdue,
                'overdue_since' => $overdueDate,
                'status' => 'active',
                'collection_stage' => $this->determineCollectionStage($daysOverdue),
                'priority' => $this->determinePriority($daysOverdue, $overdueAmount),
                'created_by' => auth()->id(),
                'next_action_date' => $this->getNextActionDate($daysOverdue),
            ], $data));

            // Auto-assign based on workload and stage
            $this->autoAssignCase($collectionCase);

            // Create initial activity
            $this->recordActivity($collectionCase, [
                'activity_type' => 'other',
                'outcome' => 'case_escalated',
                'activity_notes' => 'Collection case created for overdue payment',
                'activity_date' => now(),
            ]);

            return $collectionCase->fresh();
        });
    }

    /**
     * Auto-assign collection case to available collector
     */
    public function autoAssignCase(CollectionCase $case): void
    {
        // Get collectors based on stage requirements
        $roleRequirements = match($case->collection_stage) {
            'early_stage' => ['collection_agent', 'senior_collection_agent'],
            'middle_stage' => ['senior_collection_agent', 'collection_supervisor'],
            'late_stage' => ['collection_supervisor', 'collection_manager'],
            'legal_stage' => ['collection_manager', 'legal_officer'],
            default => ['collection_agent']
        };

        $collector = User::role($roleRequirements)
            ->withCount(['assignedCollectionCases as active_cases' => function($query) {
                $query->where('status', 'active');
            }])
            ->orderBy('active_cases')
            ->first();

        if ($collector) {
            $case->assignTo($collector);
        }
    }

    /**
     * Record collection activity
     */
    public function recordActivity(CollectionCase $case, array $activityData): CollectionActivity
    {
        return $case->recordActivity($activityData);
    }

    /**
     * Create payment plan for collection case
     */
    public function createPaymentPlan(CollectionCase $case, array $planData): PaymentPlan
    {
        return DB::transaction(function () use ($case, $planData) {
            $plan = PaymentPlan::create(array_merge([
                'collection_case_id' => $case->id,
                'customer_id' => $case->customer_id,
                'credit_disbursement_id' => $case->credit_disbursement_id,
                'total_amount' => $case->outstanding_amount,
                'outstanding_balance' => $case->outstanding_amount - ($planData['down_payment'] ?? 0),
                'created_by' => auth()->id(),
            ], $planData));

            // Record activity
            $this->recordActivity($case, [
                'activity_type' => 'payment_plan',
                'outcome' => 'contact_made',
                'activity_notes' => "Payment plan {$plan->plan_number} created",
                'activity_date' => now(),
            ]);

            return $plan;
        });
    }

    /**
     * Process payment against collection case
     */
    public function processPayment(CollectionCase $case, float $amount, array $paymentData = []): CreditRepayment
    {
        return DB::transaction(function () use ($case, $amount, $paymentData) {
            // Create repayment record
            $repayment = CreditRepayment::create(array_merge([
                'credit_disbursement_id' => $case->credit_disbursement_id,
                'customer_id' => $case->customer_id,
                'repayment_amount' => $amount,
                'payment_method' => $paymentData['payment_method'] ?? 'bank_transfer',
                'payment_date' => $paymentData['payment_date'] ?? now(),
                'status' => 'completed',
                'processed_by' => auth()->id(),
            ], $paymentData));

            // Update collection case
            $case->recordPayment($amount);

            // Update active payment plans
            $activePlans = $case->paymentPlans()->where('status', 'active')->get();
            foreach ($activePlans as $plan) {
                if ($plan->canReceivePayment()) {
                    $plan->recordPayment($amount);
                    break; // Apply to first active plan only
                }
            }

            // Record activity
            $this->recordActivity($case, [
                'activity_type' => 'other',
                'outcome' => 'payment_received',
                'activity_notes' => "Payment of " . number_format($amount, 2) . " received",
                'payment_promise_amount' => $amount,
                'activity_date' => now(),
            ]);

            return $repayment;
        });
    }

    /**
     * Escalate case to next stage
     */
    public function escalateCase(CollectionCase $case, string $reason = null): void
    {
        $newStage = match($case->collection_stage) {
            'early_stage' => 'middle_stage',
            'middle_stage' => 'late_stage',
            'late_stage' => 'legal_stage',
            default => $case->collection_stage
        };

        if ($newStage !== $case->collection_stage) {
            $case->update([
                'collection_stage' => $newStage,
                'priority' => $this->determinePriority($case->days_overdue, $case->outstanding_amount),
            ]);

            // Reassign if needed
            $this->autoAssignCase($case);

            // Record activity
            $this->recordActivity($case, [
                'activity_type' => 'other',
                'outcome' => 'case_escalated',
                'activity_notes' => "Case escalated to {$newStage}" . ($reason ? ": {$reason}" : ''),
                'activity_date' => now(),
            ]);
        }
    }

    /**
     * Get collection performance metrics
     */
    public function getCollectionMetrics(Carbon $startDate = null, Carbon $endDate = null): array
    {
        $startDate = $startDate ?? now()->startOfMonth();
        $endDate = $endDate ?? now()->endOfMonth();

        $totalCases = CollectionCase::whereBetween('created_at', [$startDate, $endDate])->count();
        $resolvedCases = CollectionCase::whereBetween('resolved_at', [$startDate, $endDate])->count();
        $totalCollected = CollectionCase::whereBetween('resolved_at', [$startDate, $endDate])->sum('collected_amount');
        $totalOutstanding = CollectionCase::where('status', 'active')->sum('outstanding_amount');

        $resolutionRate = $totalCases > 0 ? ($resolvedCases / $totalCases) * 100 : 0;

        // Stage distribution
        $stageDistribution = CollectionCase::where('status', 'active')
            ->groupBy('collection_stage')
            ->selectRaw('collection_stage, count(*) as count')
            ->pluck('count', 'collection_stage')
            ->toArray();

        // Priority distribution
        $priorityDistribution = CollectionCase::where('status', 'active')
            ->groupBy('priority')
            ->selectRaw('priority, count(*) as count')
            ->pluck('count', 'priority')
            ->toArray();

        return [
            'total_cases' => $totalCases,
            'resolved_cases' => $resolvedCases,
            'resolution_rate' => round($resolutionRate, 2),
            'total_collected' => $totalCollected,
            'total_outstanding' => $totalOutstanding,
            'stage_distribution' => $stageDistribution,
            'priority_distribution' => $priorityDistribution,
        ];
    }

    /**
     * Get cases requiring action
     */
    public function getCasesRequiringAction(User $user = null): Collection
    {
        $query = CollectionCase::requiresAction()
            ->with(['customer', 'assignedTo', 'creditDisbursement']);

        if ($user) {
            $query->assignedTo($user);
        }

        return $query->orderBy('priority')
            ->orderBy('days_overdue', 'desc')
            ->get();
    }

    /**
     * Get overdue payment promises
     */
    public function getOverduePromises(): Collection
    {
        return CollectionActivity::withPromiseToPay()
            ->where('payment_promise_date', '<', now())
            ->with(['collectionCase', 'customer'])
            ->orderBy('payment_promise_date')
            ->get();
    }

    /**
     * Update all active cases (daily maintenance)
     */
    public function updateActiveCases(): int
    {
        $updated = 0;
        
        CollectionCase::active()->chunk(100, function($cases) use (&$updated) {
            foreach ($cases as $case) {
                $case->updateDaysOverdue();
                $updated++;
            }
        });

        return $updated;
    }

    /**
     * Generate collection report
     */
    public function generateCollectionReport(array $filters = []): array
    {
        $query = CollectionCase::query();

        // Apply filters
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['stage'])) {
            $query->where('collection_stage', $filters['stage']);
        }

        if (isset($filters['assigned_to'])) {
            $query->where('assigned_to', $filters['assigned_to']);
        }

        if (isset($filters['date_from'])) {
            $query->where('created_at', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->where('created_at', '<=', $filters['date_to']);
        }

        $cases = $query->with(['customer', 'assignedTo', 'activities'])
            ->orderBy('created_at', 'desc')
            ->get();

        return [
            'cases' => $cases,
            'summary' => [
                'total_cases' => $cases->count(),
                'total_outstanding' => $cases->sum('outstanding_amount'),
                'total_collected' => $cases->sum('collected_amount'),
                'average_days_overdue' => $cases->avg('days_overdue'),
                'collection_rate' => $cases->count() > 0 ? 
                    ($cases->sum('collected_amount') / $cases->sum('original_amount')) * 100 : 0,
            ]
        ];
    }

    /**
     * Determine collection stage based on days overdue
     */
    protected function determineCollectionStage(int $daysOverdue): string
    {
        return match(true) {
            $daysOverdue <= 30 => 'early_stage',
            $daysOverdue <= 90 => 'middle_stage',
            $daysOverdue <= 180 => 'late_stage',
            $daysOverdue > 180 => 'legal_stage',
            default => 'early_stage',
        };
    }

    /**
     * Determine priority based on days overdue and amount
     */
    protected function determinePriority(int $daysOverdue, float $amount): string
    {
        if ($daysOverdue > 180) {
            return 'urgent';
        }

        if ($daysOverdue > 90) {
            return 'high';
        }

        if ($daysOverdue > 30 || $amount > 100000) {
            return 'medium';
        }

        return 'low';
    }

    /**
     * Get next action date based on stage
     */
    protected function getNextActionDate(int $daysOverdue): Carbon
    {
        $daysToAdd = match(true) {
            $daysOverdue <= 30 => 7,  // Weekly follow-up
            $daysOverdue <= 90 => 3,  // Every 3 days
            $daysOverdue <= 180 => 1, // Daily
            default => 1,             // Daily for legal stage
        };

        return now()->addDays($daysToAdd);
    }
}