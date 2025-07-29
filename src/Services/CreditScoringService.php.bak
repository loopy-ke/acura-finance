<?php

namespace LoopyLabs\CreditFinancing\Services;

use LoopyLabs\CreditFinancing\Contracts\CreditScoringInterface;
use LoopyLabs\CreditFinancing\Models\CreditApplication;
use LoopyLabs\CreditFinancing\Models\CreditScoringHistory;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class CreditScoringService implements CreditScoringInterface
{
    public function scoreApplication(CreditApplication $application): array
    {
        $customer = $application->customer;
        $scoreResult = $this->scoreCustomer($customer);
        
        // Save scoring history
        CreditScoringHistory::create([
            'customer_id' => $customer->id,
            'credit_application_id' => $application->id,
            'credit_score' => $scoreResult['total_score'],
            'score_version' => config('credit-financing.scoring.algorithm_version', '1.0'),
            'payment_history_score' => $scoreResult['breakdown']['payment_history'],
            'current_balance_score' => $scoreResult['breakdown']['current_balance'],
            'credit_utilization_score' => $scoreResult['breakdown']['credit_utilization'],
            'business_relationship_score' => $scoreResult['breakdown']['business_relationship'],
            'financial_stability_score' => $scoreResult['breakdown']['financial_stability'],
            'total_invoices_count' => $scoreResult['supporting_data']['total_invoices'],
            'paid_on_time_count' => $scoreResult['supporting_data']['paid_on_time'],
            'average_days_to_pay' => $scoreResult['supporting_data']['avg_days_to_pay'],
            'current_outstanding_balance' => $scoreResult['supporting_data']['outstanding_balance'],
            'longest_relationship_months' => $scoreResult['supporting_data']['relationship_months'],
            'scoring_factors' => $scoreResult['factors'],
        ]);

        return $scoreResult;
    }

    public function scoreCustomer(Customer $customer): array
    {
        $weights = config('credit-financing.scoring.weights');
        
        $breakdown = [
            'payment_history' => $this->scorePaymentHistory($customer),
            'current_balance' => $this->scoreCurrentBalance($customer),
            'credit_utilization' => $this->scoreCreditUtilization($customer),
            'business_relationship' => $this->scoreBusinessRelationship($customer),
            'financial_stability' => $this->scoreFinancialStability($customer),
        ];

        $totalScore = 0;
        foreach ($breakdown as $factor => $score) {
            $totalScore += $score * ($weights[$factor] ?? 0.2);
        }

        $supportingData = $this->getSupportingData($customer);

        return [
            'total_score' => round($totalScore),
            'breakdown' => $breakdown,
            'supporting_data' => $supportingData,
            'factors' => $this->getScoringFactors($customer, $breakdown),
        ];
    }

    public function getScoreBreakdown(Customer $customer): array
    {
        return $this->scoreCustomer($customer)['breakdown'];
    }

    public function updateCustomerScore(Customer $customer): int
    {
        $scoreResult = $this->scoreCustomer($customer);
        
        $customer->update([
            'credit_score' => $scoreResult['total_score'],
            'credit_score_updated_at' => now(),
        ]);

        return $scoreResult['total_score'];
    }

    protected function scorePaymentHistory(Customer $customer): int
    {
        // Get invoice payment data
        $invoiceData = DB::table('invoices')
            ->where('customer_id', $customer->id)
            ->where('created_at', '>=', now()->subMonths(24)) // Last 24 months
            ->select([
                'total_amount',
                'due_date',
                'paid_date',
                'status'
            ])
            ->get();

        if ($invoiceData->isEmpty()) {
            return 50; // Neutral score for new customers
        }

        $totalInvoices = $invoiceData->count();
        $paidOnTime = 0;
        $totalDelayDays = 0;
        $paidInvoices = $invoiceData->where('status', 'paid');

        foreach ($paidInvoices as $invoice) {
            if ($invoice->paid_date && $invoice->due_date) {
                $daysLate = max(0, strtotime($invoice->paid_date) - strtotime($invoice->due_date)) / 86400;
                
                if ($daysLate <= 7) { // Grace period
                    $paidOnTime++;
                }
                
                $totalDelayDays += $daysLate;
            }
        }

        $onTimePercentage = $totalInvoices > 0 ? ($paidOnTime / $totalInvoices) * 100 : 0;
        $avgDaysLate = $paidInvoices->count() > 0 ? $totalDelayDays / $paidInvoices->count() : 0;

        // Score calculation
        $score = 100;
        
        // Reduce score based on late payments
        if ($onTimePercentage < 95) {
            $score -= (95 - $onTimePercentage) * 0.8;
        }
        
        // Reduce score based on average delay
        if ($avgDaysLate > 7) {
            $score -= min(30, ($avgDaysLate - 7) * 0.5);
        }

        return max(0, min(100, round($score)));
    }

    protected function scoreCurrentBalance(Customer $customer): int
    {
        $outstandingBalance = DB::table('invoices')
            ->where('customer_id', $customer->id)
            ->where('status', 'sent')
            ->sum('total_amount');

        $overdueBalance = DB::table('invoices')
            ->where('customer_id', $customer->id)
            ->where('status', 'sent')
            ->where('due_date', '<', now())
            ->sum('total_amount');

        // Score based on outstanding amount relative to credit limit
        $creditLimit = $customer->credit_limit ?: 100000; // Default if no limit set
        $utilizationRatio = $outstandingBalance / $creditLimit;

        $score = 100;

        // Reduce score for high utilization
        if ($utilizationRatio > 0.8) {
            $score -= 40;
        } elseif ($utilizationRatio > 0.6) {
            $score -= 25;
        } elseif ($utilizationRatio > 0.4) {
            $score -= 10;
        }

        // Heavy penalty for overdue amounts
        if ($overdueBalance > 0) {
            $overdueRatio = $overdueBalance / max($outstandingBalance, 1);
            $score -= $overdueRatio * 50;
        }

        return max(0, min(100, round($score)));
    }

    protected function scoreCreditUtilization(Customer $customer): int
    {
        $utilization = $customer->credit_utilization ?: 0;

        // Optimal utilization is 10-30%
        if ($utilization <= 30 && $utilization >= 10) {
            return 100;
        } elseif ($utilization < 10) {
            return 85; // Good but could show more usage
        } elseif ($utilization <= 50) {
            return 75;
        } elseif ($utilization <= 70) {
            return 50;
        } elseif ($utilization <= 90) {
            return 25;
        } else {
            return 0; // Over-utilized
        }
    }

    protected function scoreBusinessRelationship(Customer $customer): int
    {
        $firstInvoice = DB::table('invoices')
            ->where('customer_id', $customer->id)
            ->orderBy('created_at')
            ->first();

        if (!$firstInvoice) {
            return 30; // New customer
        }

        $relationshipMonths = now()->diffInMonths($firstInvoice->created_at);
        
        // Score based on relationship length
        if ($relationshipMonths >= 36) {
            return 100;
        } elseif ($relationshipMonths >= 24) {
            return 90;
        } elseif ($relationshipMonths >= 12) {
            return 75;
        } elseif ($relationshipMonths >= 6) {
            return 60;
        } elseif ($relationshipMonths >= 3) {
            return 45;
        } else {
            return 30;
        }
    }

    protected function scoreFinancialStability(Customer $customer): int
    {
        // Get revenue trend over last 12 months
        $monthlyRevenue = DB::table('invoices')
            ->where('customer_id', $customer->id)
            ->where('created_at', '>=', now()->subMonths(12))
            ->select([
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_amount) as revenue')
            ])
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        if ($monthlyRevenue->count() < 3) {
            return 50; // Insufficient data
        }

        $revenues = $monthlyRevenue->pluck('revenue')->toArray();
        $avgRevenue = array_sum($revenues) / count($revenues);
        
        // Calculate trend (simple linear regression slope)
        $trend = $this->calculateTrend($revenues);
        
        $score = 70; // Base score

        // Positive trend bonus
        if ($trend > 0) {
            $score += min(20, $trend * 100);
        } else {
            $score += max(-30, $trend * 100);
        }

        // Consistency bonus (low variance is good)
        $variance = $this->calculateVariance($revenues);
        $coefficientOfVariation = $avgRevenue > 0 ? sqrt($variance) / $avgRevenue : 1;
        
        if ($coefficientOfVariation < 0.2) {
            $score += 10; // Very consistent
        } elseif ($coefficientOfVariation > 0.5) {
            $score -= 15; // Very volatile
        }

        return max(0, min(100, round($score)));
    }

    protected function getSupportingData(Customer $customer): array
    {
        $invoiceStats = DB::table('invoices')
            ->where('customer_id', $customer->id)
            ->selectRaw('
                COUNT(*) as total_invoices,
                COUNT(CASE WHEN status = "paid" AND paid_date <= due_date THEN 1 END) as paid_on_time,
                AVG(CASE WHEN status = "paid" AND paid_date IS NOT NULL AND due_date IS NOT NULL 
                    THEN DATEDIFF(paid_date, due_date) ELSE 0 END) as avg_days_to_pay,
                SUM(CASE WHEN status = "sent" THEN total_amount ELSE 0 END) as outstanding_balance
            ')
            ->first();

        $firstInvoice = DB::table('invoices')
            ->where('customer_id', $customer->id)
            ->orderBy('created_at')
            ->first();

        $relationshipMonths = $firstInvoice ? 
            now()->diffInMonths($firstInvoice->created_at) : 0;

        return [
            'total_invoices' => $invoiceStats->total_invoices ?? 0,
            'paid_on_time' => $invoiceStats->paid_on_time ?? 0,
            'avg_days_to_pay' => round($invoiceStats->avg_days_to_pay ?? 0, 2),
            'outstanding_balance' => $invoiceStats->outstanding_balance ?? 0,
            'relationship_months' => $relationshipMonths,
        ];
    }

    protected function getScoringFactors(Customer $customer, array $breakdown): array
    {
        $factors = [];

        foreach ($breakdown as $factor => $score) {
            if ($score >= 80) {
                $factors[] = ucfirst(str_replace('_', ' ', $factor)) . ': Excellent';
            } elseif ($score >= 60) {
                $factors[] = ucfirst(str_replace('_', ' ', $factor)) . ': Good';
            } elseif ($score >= 40) {
                $factors[] = ucfirst(str_replace('_', ' ', $factor)) . ': Fair';
            } else {
                $factors[] = ucfirst(str_replace('_', ' ', $factor)) . ': Poor';
            }
        }

        return $factors;
    }

    protected function calculateTrend(array $values): float
    {
        $n = count($values);
        if ($n < 2) return 0;

        $sumX = array_sum(range(0, $n - 1));
        $sumY = array_sum($values);
        $sumXY = 0;
        $sumXX = 0;

        for ($i = 0; $i < $n; $i++) {
            $sumXY += $i * $values[$i];
            $sumXX += $i * $i;
        }

        $slope = ($n * $sumXY - $sumX * $sumY) / ($n * $sumXX - $sumX * $sumX);
        
        return $slope / max(array_sum($values) / $n, 1); // Normalize by average
    }

    protected function calculateVariance(array $values): float
    {
        $mean = array_sum($values) / count($values);
        $squaredDiffs = array_map(function($value) use ($mean) {
            return pow($value - $mean, 2);
        }, $values);
        
        return array_sum($squaredDiffs) / count($values);
    }
}