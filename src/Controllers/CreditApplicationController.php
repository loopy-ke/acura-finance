<?php

namespace LoopyLabs\CreditFinancing\Controllers;

use App\Http\Controllers\Controller;
use LoopyLabs\CreditFinancing\Contracts\CreditProcessorInterface;
use LoopyLabs\CreditFinancing\Models\CreditApplication;
use LoopyLabs\CreditFinancing\Models\CreditProduct;
use LoopyLabs\CreditFinancing\Requests\StoreCreditApplicationRequest;
use LoopyLabs\CreditFinancing\Requests\UpdateCreditApplicationRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreditApplicationController extends Controller
{
    protected CreditProcessorInterface $creditProcessor;

    public function __construct(CreditProcessorInterface $creditProcessor)
    {
        $this->creditProcessor = $creditProcessor;
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', CreditApplication::class);

        $query = CreditApplication::with(['customer', 'creditProduct', 'createdBy', 'latestDecision'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by customer
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        // Filter by date range
        if ($request->filled('from_date')) {
            $query->where('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->where('created_at', '<=', $request->to_date);
        }

        // Search by application number or customer name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('application_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($customerQuery) use ($search) {
                      $customerQuery->where('company_name', 'like', "%{$search}%");
                  });
            });
        }

        $applications = $query->paginate(15);

        $stats = $this->getApplicationStats();

        return view('credit-financing::applications.index', compact('applications', 'stats'));
    }

    public function createStep1()
    {
        $this->authorize('create', CreditApplication::class);

        return view('credit-financing::applications.create-step1');
    }

    public function createStep2(Request $request)
    {
        $this->authorize('create', CreditApplication::class);

        $request->validate([
            'customer_id' => 'required|exists:customers,id'
        ]);

        $customer = Customer::with('creditCustomer')->findOrFail($request->customer_id);
        
        // Verify customer can apply for credit
        if (!$customer->canApplyForCredit()) {
            return redirect()
                ->route('credit.applications.create.step1')
                ->with('error', 'Selected customer is not eligible for credit applications.');
        }

        // Get available credit products for this customer
        $creditProducts = CreditProduct::getAvailableForCustomer($customer);

        return view('credit-financing::applications.create-step2', compact('customer', 'creditProducts'));
    }

    public function createStep3(Request $request)
    {
        $this->authorize('create', CreditApplication::class);

        // Validate the form data
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'credit_product_id' => 'nullable|exists:credit_products,id',
            'requested_amount' => 'required|numeric|min:1000',
            'requested_term_months' => 'required|integer|min:1|max:60',
            'purpose' => 'required|string|max:500',
            'business_justification' => 'required|string|max:1000',
            'auto_submit' => 'boolean',
        ]);

        // Get customer and related data
        $customer = Customer::with('creditCustomer')->findOrFail($validated['customer_id']);
        
        // Get selected credit product if any
        $creditProduct = null;
        if ($validated['credit_product_id']) {
            $creditProduct = CreditProduct::find($validated['credit_product_id']);
        }

        // Store form data in session for the review step
        $request->session()->put('application_data', $validated);

        return view('credit-financing::applications.create-step3', compact(
            'customer', 
            'creditProduct', 
            'validated'
        ));
    }

    // Keep the old create method for backward compatibility (redirects to step 1)
    public function create()
    {
        return redirect()->route('credit.applications.create.step1');
    }

    public function store(Request $request)
    {
        $this->authorize('create', CreditApplication::class);

        // Get application data from session
        $applicationData = $request->session()->get('application_data');
        
        if (!$applicationData) {
            return redirect()
                ->route('credit.applications.create.step1')
                ->with('error', 'Session expired. Please start over.');
        }

        $application = DB::transaction(function () use ($applicationData) {
            $application = CreditApplication::create([
                'customer_id' => $applicationData['customer_id'],
                'credit_product_id' => $applicationData['credit_product_id'] ?? null,
                'requested_amount' => $applicationData['requested_amount'],
                'requested_term_months' => $applicationData['requested_term_months'],
                'purpose' => $applicationData['purpose'],
                'business_justification' => $applicationData['business_justification'],
                'created_by' => auth()->id(),
                'status' => 'draft',
            ]);

            // If auto-submit is requested, process immediately
            if ($applicationData['auto_submit'] ?? false) {
                return $this->submitApplication($application);
            }

            return $application;
        });

        // Clear session data
        $request->session()->forget('application_data');

        if ($applicationData['auto_submit'] ?? false) {
            return redirect()
                ->route('credit.applications.show', $application)
                ->with('success', 'Credit application submitted and processed successfully.');
        }

        return redirect()
            ->route('credit.applications.show', $application)
            ->with('success', 'Credit application created successfully.');
    }

    public function show(CreditApplication $application)
    {
        $this->authorize('view', $application);

        $application->load([
            'customer',
            'createdBy',
            'approvedBy',
            'deniedBy',
            'decisions.decidedBy',
            'financedInvoices'
        ]);

        return view('credit-financing::applications.show', compact('application'));
    }

    public function edit(CreditApplication $application)
    {
        $this->authorize('update', $application);

        if (!$application->canBeEdited()) {
            return redirect()
                ->route('credit.applications.show', $application)
                ->with('error', 'This application cannot be edited in its current status.');
        }

        return view('credit-financing::applications.edit', compact('application'));
    }

    public function update(UpdateCreditApplicationRequest $request, CreditApplication $application)
    {
        $this->authorize('update', $application);

        if (!$application->canBeEdited()) {
            return redirect()
                ->route('credit.applications.show', $application)
                ->with('error', 'This application cannot be edited in its current status.');
        }

        $application->update([
            'customer_id' => $request->customer_id,
            'requested_amount' => $request->requested_amount,
            'requested_term_months' => $request->requested_term_months,
            'purpose' => $request->purpose,
            'business_justification' => $request->business_justification,
        ]);

        return redirect()
            ->route('credit.applications.show', $application)
            ->with('success', 'Credit application updated successfully.');
    }

    public function destroy(CreditApplication $application)
    {
        $this->authorize('delete', $application);

        if (!$application->canBeDeleted()) {
            return redirect()
                ->route('credit.applications.show', $application)
                ->with('error', 'This application cannot be deleted in its current status.');
        }

        $application->delete();

        return redirect()
            ->route('credit.applications.index')
            ->with('success', 'Credit application deleted successfully.');
    }

    public function submit(CreditApplication $application)
    {
        $this->authorize('update', $application);

        if ($application->status !== 'draft') {
            return redirect()
                ->route('credit.applications.show', $application)
                ->with('error', 'Only draft applications can be submitted.');
        }

        $this->submitApplication($application);

        return redirect()
            ->route('credit.applications.show', $application)
            ->with('success', 'Credit application submitted and processed successfully.');
    }

    public function approve(Request $request, CreditApplication $application)
    {
        $this->authorize('approve', $application);

        if (!$application->canBeApproved()) {
            return redirect()
                ->route('credit.applications.show', $application)
                ->with('error', 'This application cannot be approved in its current status.');
        }

        $request->validate([
            'approved_amount' => 'required|numeric|min:1|max:' . $application->requested_amount,
            'approved_term_months' => 'required|integer|min:1|max:60',
            'approved_interest_rate' => 'required|numeric|min:0|max:1',
            'approved_fee_percentage' => 'required|numeric|min:0|max:1',
            'conditions' => 'nullable|string|max:1000',
        ]);

        $terms = [
            'amount' => $request->approved_amount,
            'term_months' => $request->approved_term_months,
            'interest_rate' => $request->approved_interest_rate,
            'fee_percentage' => $request->approved_fee_percentage,
            'conditions' => $request->conditions,
        ];

        $this->creditProcessor->approveCredit($application, $terms);

        return redirect()
            ->route('credit.applications.show', $application)
            ->with('success', 'Credit application approved successfully.');
    }

    public function deny(Request $request, CreditApplication $application)
    {
        $this->authorize('approve', $application);

        if (!$application->canBeDenied()) {
            return redirect()
                ->route('credit.applications.show', $application)
                ->with('error', 'This application cannot be denied in its current status.');
        }

        $request->validate([
            'denial_reason' => 'required|string|max:1000',
        ]);

        $this->creditProcessor->denyCredit($application, $request->denial_reason);

        return redirect()
            ->route('credit.applications.show', $application)
            ->with('success', 'Credit application denied.');
    }

    public function export(Request $request)
    {
        $this->authorize('viewAny', CreditApplication::class);

        $query = CreditApplication::with(['customer', 'createdBy']);

        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }
        if ($request->filled('from_date')) {
            $query->where('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->where('created_at', '<=', $request->to_date);
        }

        $applications = $query->get();

        // Return CSV export
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="credit_applications_' . now()->format('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($applications) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'Application Number',
                'Customer',
                'Requested Amount',
                'Approved Amount',
                'Status',
                'Submission Date',
                'Decision Date',
                'Created By',
            ]);

            // CSV data
            foreach ($applications as $application) {
                fputcsv($file, [
                    $application->application_number,
                    $application->customer->company_name,
                    number_format($application->requested_amount, 2),
                    $application->approved_amount ? number_format($application->approved_amount, 2) : '',
                    ucfirst($application->status),
                    $application->submission_date?->format('Y-m-d'),
                    $application->decision_date?->format('Y-m-d'),
                    $application->createdBy->name,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function searchCustomers(Request $request)
    {
        $this->authorize('create', CreditApplication::class);

        $query = $request->get('q', '');
        $limit = $request->get('limit', 20);

        $baseQuery = Customer::active()
            ->financingEnabled()
            ->with('creditCustomer');

        // If no search query, return recent customers with credit applications, or all if none
        if (strlen($query) < 2) {
            $customers = $baseQuery
                ->whereHas('creditApplications')
                ->orderBy('updated_at', 'desc')
                ->limit(min($limit, 10))
                ->get();
            
            // If no customers with applications, get recent customers by creation date
            if ($customers->isEmpty()) {
                $customers = $baseQuery
                    ->orderBy('created_at', 'desc')
                    ->limit(min($limit, 10))
                    ->get();
            }
        } else {
            // Search by name, email, or phone
            $customers = $baseQuery
                ->where(function($q) use ($query) {
                    $q->where('name', 'ILIKE', "%{$query}%")
                      ->orWhere('email', 'ILIKE', "%{$query}%")
                      ->orWhere('phone', 'ILIKE', "%{$query}%");
                })
                ->limit($limit)
                ->get();
        }

        $mappedCustomers = $customers->map(function($customer) {
            return [
                'id' => $customer->id,
                'name' => $customer->company_name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'credit_limit' => number_format($customer->credit_limit, 2),
                'available_credit' => number_format($customer->credit_limit - ($customer->creditCustomer?->total_financed_amount ?? 0), 2),
                'credit_score' => $customer->creditCustomer?->credit_score,
                'display' => $customer->company_name . ' (' . $customer->email . ')'
            ];
        });

        return response()->json($mappedCustomers);
    }

    protected function submitApplication(CreditApplication $application): CreditApplication
    {
        $application->update([
            'status' => 'submitted',
            'submission_date' => now(),
        ]);

        // Process the application
        $this->creditProcessor->processApplication($application);

        return $application->fresh();
    }

    protected function getApplicationStats(): array
    {
        return [
            'total' => CreditApplication::count(),
            'pending' => CreditApplication::whereIn('status', ['submitted', 'under_review'])->count(),
            'approved' => CreditApplication::where('status', 'approved')->count(),
            'denied' => CreditApplication::where('status', 'denied')->count(),
            'total_approved_amount' => CreditApplication::where('status', 'approved')->sum('approved_amount'),
        ];
    }
}