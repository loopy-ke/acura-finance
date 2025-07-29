<?php

namespace LoopyLabs\CreditFinancing\Controllers;

use App\Http\Controllers\Controller;
use LoopyLabs\CreditFinancing\Models\CreditApplication;
use LoopyLabs\CreditFinancing\Models\CreditLimit;
use LoopyLabs\CreditFinancing\Models\FinancedInvoice;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CustomerCreditController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', CreditApplication::class);

        // Build query for customers with credit applications
        $query = Customer::query()
            ->whereHas('creditApplications')
            ->withCount([
                'creditApplications as total_applications',
                'creditApplications as approved_applications' => function($q) {
                    $q->where('status', 'approved');
                },
                'creditApplications as pending_applications' => function($q) {
                    $q->whereIn('status', ['submitted', 'under_review']);
                },
                'creditApplications as rejected_applications' => function($q) {
                    $q->where('status', 'denied');
                }
            ])
            ->withSum(['creditApplications as total_approved_amount' => function($q) {
                $q->where('status', 'approved');
            }], 'approved_amount')
            ->with(['creditLimits' => function($q) {
                $q->where('status', 'active');
            }]);

        // Apply search filters
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('company_name', 'ILIKE', "%{$search}%")
                  ->orWhere('email', 'ILIKE', "%{$search}%")
                  ->orWhere('account_number', 'ILIKE', "%{$search}%");
            });
        }

        if ($request->filled('credit_score_range')) {
            $range = $request->get('credit_score_range');
            $query->whereHas('creditApplications', function($q) use ($range) {
                switch($range) {
                    case '800+':
                        $q->where('credit_score_at_application', '>=', 800);
                        break;
                    case '740-799':
                        $q->whereBetween('credit_score_at_application', [740, 799]);
                        break;
                    case '670-739':
                        $q->whereBetween('credit_score_at_application', [670, 739]);
                        break;
                    case '580-669':
                        $q->whereBetween('credit_score_at_application', [580, 669]);
                        break;
                    case 'below-580':
                        $q->where('credit_score_at_application', '<', 580);
                        break;
                }
            });
        }

        if ($request->filled('application_status')) {
            $status = $request->get('application_status');
            switch($status) {
                case 'approved':
                    $query->whereHas('creditApplications', function($q) {
                        $q->where('status', 'approved');
                    });
                    break;
                case 'pending':
                    $query->whereHas('creditApplications', function($q) {
                        $q->whereIn('status', ['submitted', 'under_review']);
                    });
                    break;
                case 'rejected':
                    $query->whereHas('creditApplications', function($q) {
                        $q->where('status', 'denied');
                    });
                    break;
                case 'active_loans':
                    $query->whereHas('creditLimits', function($q) {
                        $q->where('status', 'active')->where('used_credit', '>', 0);
                    });
                    break;
            }
        }

        $customers = $query->orderBy('company_name')->paginate(20);

        // Calculate statistics
        $stats = [
            'total_customers' => Customer::whereHas('creditApplications')->count(),
            'active_applications' => CreditApplication::whereIn('status', ['submitted', 'under_review'])->count(),
            'approved_this_month' => CreditApplication::where('status', 'approved')
                ->whereMonth('decision_date', now()->month)
                ->whereYear('decision_date', now()->year)
                ->count(),
            'average_credit_score' => CreditApplication::whereNotNull('credit_score_at_application')
                ->avg('credit_score_at_application') ?? 0,
        ];

        return view('credit-financing::customers.index', compact('customers', 'stats'));
    }

    public function show(Customer $customer)
    {
        $this->authorize('view', $customer);

        // Load customer with credit-related data
        $customer->load([
            'creditApplications' => function($q) {
                $q->with(['createdBy', 'approvedBy', 'deniedBy'])
                  ->orderBy('created_at', 'desc');
            },
            'creditLimits' => function($q) {
                $q->where('status', 'active');
            },
            'financedInvoices' => function($q) {
                $q->with('creditApplication')
                  ->where('status', 'active')
                  ->orderBy('created_at', 'desc');
            }
        ]);

        // Calculate credit profile data
        $creditProfile = $this->calculateCreditProfile($customer);

        // Get recent activity
        $recentActivity = $this->getRecentActivity($customer);

        return view('credit-financing::customers.show', compact('customer', 'creditProfile', 'recentActivity'));
    }

    public function edit(Customer $customer)
    {
        $this->authorize('update', $customer);

        return view('credit-financing::customers.profile', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $this->authorize('update', $customer);

        $validatedData = $request->validate([
            'company_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:2',
            'zip_code' => 'nullable|string|max:10',
            'tax_id' => 'nullable|string|max:20',
            'industry' => 'nullable|string|max:100',
            'business_type' => 'nullable|string|max:50',
            'years_in_business' => 'nullable|integer|min:0|max:100',
            'annual_revenue' => 'nullable|numeric|min:0',
            'employees' => 'nullable|string|max:20',
            'bank_account_years' => 'nullable|integer|min:0|max:50',
            'primary_bank' => 'nullable|string|max:255',
            'monthly_cash_flow' => 'nullable|numeric',
            'seasonal_business' => 'nullable|in:yes,no',
            'existing_debt' => 'nullable|numeric|min:0',
            'monthly_debt_payment' => 'nullable|numeric|min:0',
            'credit_references' => 'nullable|string|max:1000',
        ]);

        $customer->update($validatedData);

        return redirect()
            ->route('credit-financing.customers.show', $customer)
            ->with('success', 'Customer profile updated successfully.');
    }

    protected function calculateCreditProfile(Customer $customer): array
    {
        // Get latest credit score from applications
        $latestApplication = $customer->creditApplications()
            ->whereNotNull('credit_score_at_application')
            ->orderBy('created_at', 'desc')
            ->first();

        $creditScore = $latestApplication?->credit_score_at_application ?? null;

        // Calculate risk grade based on credit score and payment history
        $riskGrade = $this->calculateRiskGrade($customer, $creditScore);

        // Get total credit limits and utilization
        $activeLimits = $customer->creditLimits()->where('status', 'active')->get();
        $totalCreditLimit = $activeLimits->sum('credit_limit');
        $totalUtilized = $activeLimits->sum('used_credit');
        $utilizationRate = $totalCreditLimit > 0 ? ($totalUtilized / $totalCreditLimit) * 100 : 0;

        // Calculate DSCR if available
        $dscr = $this->calculateDSCR($customer);

        return [
            'credit_score' => $creditScore,
            'risk_grade' => $riskGrade,
            'total_credit_limit' => $totalCreditLimit,
            'total_utilized' => $totalUtilized,
            'utilization_rate' => $utilizationRate,
            'dscr' => $dscr,
            'active_limits_count' => $activeLimits->count(),
            'customer_since' => $customer->created_at,
        ];
    }

    protected function calculateRiskGrade(Customer $customer, ?float $creditScore): string
    {
        if (!$creditScore) {
            return 'N/A';
        }

        // Basic risk grading based on credit score
        if ($creditScore >= 800) return 'A+';
        if ($creditScore >= 780) return 'A';
        if ($creditScore >= 740) return 'A-';
        if ($creditScore >= 720) return 'B+';
        if ($creditScore >= 680) return 'B';
        if ($creditScore >= 650) return 'B-';
        if ($creditScore >= 620) return 'C+';
        if ($creditScore >= 580) return 'C';
        if ($creditScore >= 550) return 'C-';
        
        return 'D';
    }

    protected function calculateDSCR(Customer $customer): ?float
    {
        // This would need to be implemented based on your financial data structure
        // For now, return null as placeholder
        return null;
    }

    protected function getRecentActivity(Customer $customer): array
    {
        $activities = [];

        // Get recent credit applications
        $recentApplications = $customer->creditApplications()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        foreach ($recentApplications as $app) {
            $activities[] = [
                'action' => 'Credit application ' . $app->status,
                'date' => $app->created_at,
                'type' => 'application',
                'details' => 'Application #' . $app->application_number . ' for $' . number_format($app->requested_amount, 0),
            ];
        }

        // Get recent payment activities (if you have payment records)
        // This would be implemented based on your invoicing/payment system

        // Sort by date
        usort($activities, function($a, $b) {
            return $b['date']->timestamp - $a['date']->timestamp;
        });

        return array_slice($activities, 0, 10);
    }
}