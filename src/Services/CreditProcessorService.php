<?php

namespace LoopyLabs\CreditFinancing\Services;

use LoopyLabs\CreditFinancing\Contracts\CreditProcessorInterface;
use LoopyLabs\CreditFinancing\Contracts\CreditScoringInterface;
use LoopyLabs\CreditFinancing\Models\CreditApplication;
use LoopyLabs\CreditFinancing\Models\CreditDecision;
use LoopyLabs\CreditFinancing\Models\FinancingPartner;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreditProcessorService implements CreditProcessorInterface
{
    protected CreditScoringInterface $scoringService;

    public function __construct(CreditScoringInterface $scoringService)
    {
        $this->scoringService = $scoringService;
    }

    public function processApplication(CreditApplication $application): CreditDecision
    {
        return DB::transaction(function () use ($application) {
            Log::info('Processing credit application', ['application_id' => $application->id]);

            // 1. Validate the application
            $validationErrors = $this->validateApplication($application);
            if (!empty($validationErrors)) {
                return $this->createDecision($application, 'denied', null, $validationErrors);
            }

            // 2. Score the application
            $scoreResult = $this->scoringService->scoreApplication($application);
            $application->update(['credit_score_at_application' => $scoreResult['total_score']]);

            // 3. Calculate terms
            $terms = $this->calculateTerms($application);

            // 4. Make automated decision
            $decision = $this->makeAutomatedDecision($application, $scoreResult, $terms);

            // 5. Create decision record
            $creditDecision = $this->createDecision($application, $decision['decision'], $decision['terms'], $decision['reason']);

            // 6. Update application status
            $application->update([
                'status' => $decision['decision'] === 'approved' ? 'approved' : 'denied',
                'decision_date' => now(),
                'automated_decision' => $decision['decision'],
                'automated_decision_reason' => $decision['reason'],
                'approved_amount' => $decision['terms']['amount'] ?? null,
                'approved_term_months' => $decision['terms']['term_months'] ?? null,
                'approved_interest_rate' => $decision['terms']['interest_rate'] ?? null,
                'approved_fee_percentage' => $decision['terms']['fee_percentage'] ?? null,
            ]);

            Log::info('Credit application processed', [
                'application_id' => $application->id,
                'decision' => $decision['decision'],
                'score' => $scoreResult['total_score']
            ]);

            return $creditDecision;
        });
    }

    public function checkCreditLimit(Customer $customer, float $amount): bool
    {
        // Check customer's built-in credit limit
        $availableCredit = $customer->credit_limit - ($customer->creditCustomer?->total_financed_amount ?? 0);
        return $availableCredit >= $amount;
    }

    public function approveCredit(CreditApplication $application, array $terms): CreditDecision
    {
        return DB::transaction(function () use ($application, $terms) {
            $application->update([
                'status' => 'approved',
                'decision_date' => now(),
                'approved_amount' => $terms['amount'],
                'approved_term_months' => $terms['term_months'],
                'approved_interest_rate' => $terms['interest_rate'],
                'approved_fee_percentage' => $terms['fee_percentage'],
                'approved_by' => auth()->id(),
            ]);

            return $this->createDecision($application, 'approved', $terms);
        });
    }

    public function denyCredit(CreditApplication $application, string $reason): CreditDecision
    {
        return DB::transaction(function () use ($application, $reason) {
            $application->update([
                'status' => 'denied',
                'decision_date' => now(),
                'denial_reason' => $reason,
                'denied_by' => auth()->id(),
            ]);

            return $this->createDecision($application, 'denied', null, $reason);
        });
    }

    public function calculateTerms(CreditApplication $application): array
    {
        $partner = $application->financingPartner ?: $this->getDefaultPartner();
        $customer = $application->customer;

        // Base terms from partner or application
        $baseTerms = [
            'amount' => $application->requested_amount,
            'term_months' => $application->requested_term_months,
            'interest_rate' => $partner->default_interest_rate ?? 0.12,
            'fee_percentage' => $partner->default_fee_percentage ?? 0.03,
        ];

        // Adjust terms based on credit score and risk
        $creditScore = $application->credit_score_at_application ?? 70;
        $riskAdjustment = $this->calculateRiskAdjustment($creditScore);

        return [
            'amount' => min($baseTerms['amount'], $this->getMaxApprovalAmount($customer, $creditScore)),
            'term_months' => $baseTerms['term_months'],
            'interest_rate' => $baseTerms['interest_rate'] * $riskAdjustment['interest_multiplier'],
            'fee_percentage' => $baseTerms['fee_percentage'] * $riskAdjustment['fee_multiplier'],
        ];
    }

    public function validateApplication(CreditApplication $application): array
    {
        $errors = [];

        // Check minimum amount
        $minAmount = config('credit-financing.limits.min_application_amount', 10000);
        if ($application->requested_amount < $minAmount) {
            $errors[] = "Requested amount must be at least {$minAmount}";
        }

        // Check maximum amount
        $maxAmount = config('credit-financing.limits.max_single_application', 1000000);
        if ($application->requested_amount > $maxAmount) {
            $errors[] = "Requested amount cannot exceed {$maxAmount}";
        }

        // Check customer eligibility
        if (!$application->customer->financing_enabled) {
            $errors[] = "Customer is not eligible for financing";
        }

        // Check for duplicate active applications
        $duplicateApplications = CreditApplication::where('customer_id', $application->customer_id)
            ->whereIn('status', ['submitted', 'under_review'])
            ->where('id', '!=', $application->id)
            ->exists();

        if ($duplicateApplications) {
            $errors[] = "Customer already has an active credit application";
        }

        return $errors;
    }

    protected function makeAutomatedDecision(CreditApplication $application, array $scoreResult, array $terms): array
    {
        $config = config('credit-financing');
        $creditScore = $scoreResult['total_score'];
        $requestedAmount = $application->requested_amount;

        // Auto-deny if score too low
        if ($creditScore < $config['scoring']['minimum_score']) {
            return [
                'decision' => 'denied',
                'reason' => 'Credit score below minimum threshold',
                'terms' => null
            ];
        }

        // Auto-approve if within limits
        $autoApproveLimit = $config['approval']['auto_approve_limit'];
        if ($requestedAmount <= $autoApproveLimit && $creditScore >= 80) {
            return [
                'decision' => 'approved',
                'reason' => 'Auto-approved based on credit score and amount',
                'terms' => $terms
            ];
        }

        // Require manual review for larger amounts or moderate scores
        $application->update(['requires_manual_approval' => true]);
        
        return [
            'decision' => 'manual_review',
            'reason' => 'Requires manual review due to amount or credit score',
            'terms' => $terms
        ];
    }

    protected function createDecision(CreditApplication $application, string $decision, ?array $terms = null, ?string $reason = null): CreditDecision
    {
        $decisionData = [
            'credit_application_id' => $application->id,
            'decision' => $decision,
            'decision_maker' => 'automated',
            'decided_by' => auth()->id(),
            'credit_score' => $application->credit_score_at_application,
        ];

        if ($terms) {
            $decisionData = array_merge($decisionData, [
                'approved_amount' => $terms['amount'],
                'approved_term_months' => $terms['term_months'],
                'interest_rate' => $terms['interest_rate'],
                'fee_percentage' => $terms['fee_percentage'],
            ]);
        }

        if ($reason) {
            $decisionData['denial_reason_text'] = $reason;
        }

        return CreditDecision::create($decisionData);
    }

    protected function calculateRiskAdjustment(int $creditScore): array
    {
        if ($creditScore >= 90) {
            return ['interest_multiplier' => 0.8, 'fee_multiplier' => 0.8];
        } elseif ($creditScore >= 80) {
            return ['interest_multiplier' => 0.9, 'fee_multiplier' => 0.9];
        } elseif ($creditScore >= 70) {
            return ['interest_multiplier' => 1.0, 'fee_multiplier' => 1.0];
        } elseif ($creditScore >= 60) {
            return ['interest_multiplier' => 1.2, 'fee_multiplier' => 1.1];
        } else {
            return ['interest_multiplier' => 1.5, 'fee_multiplier' => 1.3];
        }
    }

    protected function getMaxApprovalAmount(Customer $customer, int $creditScore): float
    {
        $baseLimit = config('credit-financing.limits.max_single_application', 1000000);
        
        // Reduce limit based on credit score
        if ($creditScore < 70) {
            $baseLimit *= 0.5;
        } elseif ($creditScore < 80) {
            $baseLimit *= 0.7;
        }

        // Check customer's available credit
        $availableCredit = $customer->credit_limit - ($customer->creditCustomer?->total_financed_amount ?? 0);
        return min($baseLimit, $availableCredit);

        return $baseLimit;
    }

    protected function getDefaultPartner(): FinancingPartner
    {
        return FinancingPartner::where('partner_type', 'internal')
            ->where('is_active', true)
            ->first() ?? FinancingPartner::factory()->create([
                'partner_code' => 'INT001',
                'partner_name' => 'Internal Financing',
                'partner_type' => 'internal',
                'is_active' => true,
            ]);
    }
}