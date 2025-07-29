<?php

namespace LoopyLabs\CreditFinancing\Services;

use LoopyLabs\CreditFinancing\Models\CreditApplication;
use LoopyLabs\CreditFinancing\Models\CreditDisbursement;
use LoopyLabs\CreditFinancing\Models\CreditRepayment;
use LoopyLabs\CreditFinancing\Models\InvoiceFinancing;
use LoopyLabs\CreditFinancing\Events\DisbursementCreated;
use LoopyLabs\CreditFinancing\Events\DisbursementProcessed;
use LoopyLabs\CreditFinancing\Events\PaymentReceived;
use App\Models\User;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreditDisbursementService
{
    public function createDisbursement(CreditApplication $application, array $disbursementData): CreditDisbursement
    {
        return DB::transaction(function () use ($application, $disbursementData) {
            // Calculate amounts
            $disbursementAmount = $disbursementData['disbursement_amount'];
            $feePercentage = $disbursementData['fee_percentage'] ?? $application->approved_fee_percentage;
            $feeAmount = $disbursementAmount * $feePercentage;
            $netAmount = $disbursementAmount - $feeAmount;

            // Calculate dates
            $termMonths = $disbursementData['term_months'] ?? $application->approved_term_months;
            $dueDate = now()->addMonths($termMonths);
            $maturityDate = $dueDate;

            $disbursement = CreditDisbursement::create([
                'credit_application_id' => $application->id,
                'customer_id' => $application->customer_id,
                'credit_limit_id' => $application->customer->creditLimit?->id,
                'disbursement_amount' => $disbursementAmount,
                'fee_amount' => $feeAmount,
                'net_amount' => $netAmount,
                'currency' => $disbursementData['currency'] ?? 'KES',
                'term_months' => $termMonths,
                'interest_rate' => $disbursementData['interest_rate'] ?? $application->approved_interest_rate,
                'fee_percentage' => $feePercentage,
                'due_date' => $dueDate,
                'maturity_date' => $maturityDate,
                'disbursement_method' => $disbursementData['disbursement_method'],
                'bank_name' => $disbursementData['bank_name'] ?? null,
                'account_number' => $disbursementData['account_number'] ?? null,
                'account_name' => $disbursementData['account_name'] ?? null,
                'mobile_number' => $disbursementData['mobile_number'] ?? null,
                'payment_reference' => $disbursementData['payment_reference'] ?? null,
                'first_payment_due' => now()->addDays(30), // Default 30 days
                'created_by' => auth()->id(),
                'disbursement_notes' => $disbursementData['notes'] ?? null,
                'terms_and_conditions' => $disbursementData['terms_and_conditions'] ?? null,
                'metadata' => $disbursementData['metadata'] ?? null,
            ]);

            $disbursement->updateBalances();

            // Handle invoice financing if applicable
            if ($disbursementData['disbursement_method'] === 'invoice_financing' && 
                isset($disbursementData['invoice_id'])) {
                $this->createInvoiceFinancing($disbursement, $disbursementData);
            }

            // Fire event
            event(new DisbursementCreated($disbursement));

            Log::info('Credit disbursement created', [
                'disbursement_id' => $disbursement->id,
                'application_id' => $application->id,
                'amount' => $disbursementAmount,
                'method' => $disbursementData['disbursement_method'],
            ]);

            return $disbursement;
        });
    }

    public function processDisbursement(CreditDisbursement $disbursement, User $processedBy, array $processingData = []): bool
    {
        return DB::transaction(function () use ($disbursement, $processedBy, $processingData) {
            if (!$disbursement->canBeDisbursed()) {
                throw new \Exception('Disbursement cannot be processed in current status');
            }

            $transactionId = $processingData['transaction_id'] ?? null;
            
            // Update disbursement status
            $disbursement->markAsDisbursed($processedBy, $transactionId);

            // Create accounting entries if integration is enabled
            if (setting('credit_financing.accounting.enabled', true)) {
                $this->createAccountingEntries($disbursement);
            }

            // Fire event
            event(new DisbursementProcessed($disbursement, $processedBy));

            Log::info('Credit disbursement processed', [
                'disbursement_id' => $disbursement->id,
                'processed_by' => $processedBy->id,
                'transaction_id' => $transactionId,
                'amount' => $disbursement->disbursement_amount,
            ]);

            return true;
        });
    }

    public function recordPayment(CreditDisbursement $disbursement, array $paymentData): CreditRepayment
    {
        return DB::transaction(function () use ($disbursement, $paymentData) {
            if (!$disbursement->canReceivePayment()) {
                throw new \Exception('Disbursement cannot receive payments in current status');
            }

            // Allocate payment to principal, interest, and fees
            $allocation = $this->allocatePayment($disbursement, $paymentData['payment_amount']);

            $repayment = $disbursement->addRepayment([
                'customer_id' => $disbursement->customer_id,
                'payment_amount' => $paymentData['payment_amount'],
                'principal_amount' => $allocation['principal'],
                'interest_amount' => $allocation['interest'],
                'fee_amount' => $allocation['fees'],
                'penalty_amount' => $allocation['penalty'] ?? 0,
                'currency' => $paymentData['currency'] ?? $disbursement->currency,
                'payment_method' => $paymentData['payment_method'],
                'payment_reference' => $paymentData['payment_reference'] ?? null,
                'transaction_id' => $paymentData['transaction_id'] ?? null,
                'bank_reference' => $paymentData['bank_reference'] ?? null,
                'mobile_reference' => $paymentData['mobile_reference'] ?? null,
                'payment_date' => $paymentData['payment_date'] ?? now(),
                'created_by' => auth()->id(),
                'payment_notes' => $paymentData['notes'] ?? null,
                'metadata' => $paymentData['metadata'] ?? null,
            ]);

            // Mark as completed if auto-process is enabled
            if (setting('credit_financing.auto_process_payments', true)) {
                $repayment->markAsCompleted(auth()->user());
            }

            // Create accounting entries
            if (setting('credit_financing.accounting.enabled', true)) {
                $this->createPaymentAccountingEntries($repayment);
            }

            // Fire event
            event(new PaymentReceived($disbursement, $repayment));

            Log::info('Credit payment recorded', [
                'disbursement_id' => $disbursement->id,
                'repayment_id' => $repayment->id,
                'amount' => $paymentData['payment_amount'],
                'method' => $paymentData['payment_method'],
            ]);

            return $repayment;
        });
    }

    public function calculateRepaymentSchedule(CreditDisbursement $disbursement): array
    {
        $schedule = [];
        $principalBalance = $disbursement->disbursement_amount;
        $monthlyInterestRate = $disbursement->interest_rate / 12;
        $termMonths = $disbursement->term_months;

        // Calculate monthly payment (principal + interest)
        if ($monthlyInterestRate > 0) {
            $monthlyPayment = $principalBalance * 
                ($monthlyInterestRate * pow(1 + $monthlyInterestRate, $termMonths)) /
                (pow(1 + $monthlyInterestRate, $termMonths) - 1);
        } else {
            $monthlyPayment = $principalBalance / $termMonths;
        }

        $currentDate = $disbursement->first_payment_due ?? now()->addDays(30);

        for ($month = 1; $month <= $termMonths; $month++) {
            $interestPayment = $principalBalance * $monthlyInterestRate;
            $principalPayment = $monthlyPayment - $interestPayment;
            $principalBalance -= $principalPayment;

            $schedule[] = [
                'payment_number' => $month,
                'due_date' => $currentDate->copy(),
                'payment_amount' => round($monthlyPayment, 2),
                'principal_amount' => round($principalPayment, 2),
                'interest_amount' => round($interestPayment, 2),
                'principal_balance' => round(max(0, $principalBalance), 2),
            ];

            $currentDate->addMonth();
        }

        return $schedule;
    }

    public function getOverdueDisbursements(): \Illuminate\Database\Eloquent\Collection
    {
        return CreditDisbursement::overdue()
            ->with(['customer', 'creditApplication'])
            ->get();
    }

    public function generatePortfolioReport(array $filters = []): array
    {
        $query = CreditDisbursement::disbursed();

        // Apply filters
        if (isset($filters['customer_id'])) {
            $query->where('customer_id', $filters['customer_id']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['date_from'])) {
            $query->where('disbursed_at', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->where('disbursed_at', '<=', $filters['date_to']);
        }

        $disbursements = $query->get();

        return [
            'total_disbursed' => $disbursements->sum('disbursement_amount'),
            'total_outstanding' => $disbursements->sum('outstanding_balance'),
            'total_repaid' => $disbursements->sum('total_repaid'),
            'count_active' => $disbursements->whereIn('status', ['disbursed', 'partially_repaid'])->count(),
            'count_overdue' => $disbursements->where('status', 'overdue')->count(),
            'count_fully_repaid' => $disbursements->where('status', 'fully_repaid')->count(),
            'average_days_overdue' => $disbursements->where('days_overdue', '>', 0)->avg('days_overdue') ?? 0,
            'portfolio_at_risk' => $disbursements->where('status', 'overdue')->sum('outstanding_balance'),
        ];
    }

    protected function createInvoiceFinancing(CreditDisbursement $disbursement, array $data): InvoiceFinancing
    {
        $invoice = Invoice::findOrFail($data['invoice_id']);
        $advanceRate = $data['advance_rate'] ?? 0.8; // Default 80%
        $discountRate = $data['discount_rate'] ?? 0.03; // Default 3%

        return InvoiceFinancing::create([
            'credit_disbursement_id' => $disbursement->id,
            'invoice_id' => $invoice->id,
            'invoice_amount' => $invoice->total_amount,
            'financed_amount' => $disbursement->disbursement_amount,
            'advance_rate' => $advanceRate,
            'discount_rate' => $discountRate,
            'discount_amount' => $disbursement->fee_amount,
            'invoice_date' => $invoice->invoice_date,
            'invoice_due_date' => $invoice->due_date,
            'financing_date' => now(),
            'collection_due_date' => $invoice->due_date,
        ]);
    }

    protected function allocatePayment(CreditDisbursement $disbursement, float $paymentAmount): array
    {
        $allocation = [
            'fees' => 0,
            'interest' => 0,
            'principal' => 0,
            'penalty' => 0,
        ];

        $remainingPayment = $paymentAmount;

        // Allocate to fees first
        $feesOwed = $disbursement->fee_amount - $disbursement->fees_repaid;
        if ($feesOwed > 0 && $remainingPayment > 0) {
            $allocation['fees'] = min($feesOwed, $remainingPayment);
            $remainingPayment -= $allocation['fees'];
        }

        // Then to interest
        $interestOwed = $disbursement->total_interest - $disbursement->interest_repaid;
        if ($interestOwed > 0 && $remainingPayment > 0) {
            $allocation['interest'] = min($interestOwed, $remainingPayment);
            $remainingPayment -= $allocation['interest'];
        }

        // Finally to principal
        $principalOwed = $disbursement->disbursement_amount - $disbursement->principal_repaid;
        if ($principalOwed > 0 && $remainingPayment > 0) {
            $allocation['principal'] = min($principalOwed, $remainingPayment);
            $remainingPayment -= $allocation['principal'];
        }

        return $allocation;
    }

    protected function createAccountingEntries(CreditDisbursement $disbursement): void
    {
        // This would integrate with the accounting system
        // Implementation depends on the accounting module structure
        Log::info('Creating accounting entries for disbursement', [
            'disbursement_id' => $disbursement->id,
            'amount' => $disbursement->disbursement_amount,
        ]);
    }

    protected function createPaymentAccountingEntries(CreditRepayment $repayment): void
    {
        // This would integrate with the accounting system
        // Implementation depends on the accounting module structure
        Log::info('Creating accounting entries for payment', [
            'repayment_id' => $repayment->id,
            'amount' => $repayment->payment_amount,
        ]);
    }
}