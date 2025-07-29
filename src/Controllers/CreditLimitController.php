<?php

namespace LoopyLabs\CreditFinancing\Controllers;

use App\Http\Controllers\Controller;
use LoopyLabs\CreditFinancing\Models\CreditLimit;
use App\Models\Customer;
use Illuminate\Http\Request;

class CreditLimitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', CreditLimit::class);

        $query = CreditLimit::with(['customer'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by customer
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        // Search by customer name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('customer', function($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%");
            });
        }

        $limits = $query->paginate(15);

        $stats = [
            'total_limits' => CreditLimit::count(),
            'active_limits' => CreditLimit::where('status', 'active')->count(),
            'total_limit_amount' => CreditLimit::where('status', 'active')->sum('credit_limit'),
            'total_utilized_amount' => CreditLimit::where('status', 'active')->sum('used_credit'),
        ];

        return view('credit-financing::limits.index', compact('limits', 'stats'));
    }

    public function create()
    {
        $this->authorize('create', CreditLimit::class);

        $customers = Customer::where('is_active', true)
            ->where('financing_enabled', true)
            ->whereDoesntHave('creditLimit', function($query) {
                $query->where('status', 'active');
            })
            ->orderBy('company_name')
            ->get();

        return view('credit-financing::limits.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', CreditLimit::class);

        $validated = $request->validate([
            'customer_id' => [
                'required',
                'exists:customers,id',
                function ($attribute, $value, $fail) {
                    $customer = Customer::find($value);
                    if (!$customer || !$customer->financing_enabled) {
                        $fail('Selected customer is not eligible for financing.');
                    }
                    
                    // Check if customer already has an active credit limit
                    $hasActiveLimit = CreditLimit::where('customer_id', $value)
                        ->where('status', 'active')
                        ->exists();
                        
                    if ($hasActiveLimit) {
                        $fail('Customer already has an active credit limit.');
                    }
                },
            ],
            'credit_limit' => 'required|numeric|min:1000',
            'interest_rate' => 'required|numeric|min:0|max:1',
            'fee_percentage' => 'required|numeric|min:0|max:1',
            'effective_date' => 'required|date|after_or_equal:today',
            'expiry_date' => 'required|date|after:effective_date',
            'terms_and_conditions' => 'nullable|string|max:2000',
            'auto_activate' => 'boolean',
        ]);

        $validated['status'] = $request->boolean('auto_activate') ? 'active' : 'draft';
        $validated['approved_by'] = auth()->id();

        $limit = CreditLimit::create($validated);

        return redirect()
            ->route('credit.limits.show', $limit)
            ->with('success', 'Credit limit created successfully.');
    }

    public function show(CreditLimit $limit)
    {
        $this->authorize('view', $limit);

        $limit->load([
            'customer',
            'approvedBy',
            'creditApplications' => function($query) {
                $query->latest()->limit(10);
            }
        ]);

        return view('credit-financing::limits.show', compact('limit'));
    }

    public function edit(CreditLimit $limit)
    {
        $this->authorize('update', $limit);

        if (!$limit->canBeEdited()) {
            return redirect()
                ->route('credit.limits.show', $limit)
                ->with('error', 'This credit limit cannot be edited in its current status.');
        }

        return view('credit-financing::limits.edit', compact('limit'));
    }

    public function update(Request $request, CreditLimit $limit)
    {
        $this->authorize('update', $limit);

        if (!$limit->canBeEdited()) {
            return redirect()
                ->route('credit.limits.show', $limit)
                ->with('error', 'This credit limit cannot be edited in its current status.');
        }

        $validated = $request->validate([
            'credit_limit' => 'required|numeric|min:1000',
            'interest_rate' => 'required|numeric|min:0|max:1',
            'fee_percentage' => 'required|numeric|min:0|max:1',
            'effective_date' => 'required|date',
            'expiry_date' => 'required|date|after:effective_date',
            'terms_and_conditions' => 'nullable|string|max:2000',
        ]);

        $limit->update($validated);

        return redirect()
            ->route('credit.limits.show', $limit)
            ->with('success', 'Credit limit updated successfully.');
    }

    public function destroy(CreditLimit $limit)
    {
        $this->authorize('delete', $limit);

        if (!$limit->canBeDeleted()) {
            return redirect()
                ->route('credit.limits.show', $limit)
                ->with('error', 'This credit limit cannot be deleted in its current status.');
        }

        $limit->delete();

        return redirect()
            ->route('credit.limits.index')
            ->with('success', 'Credit limit deleted successfully.');
    }

    public function activate(CreditLimit $limit)
    {
        $this->authorize('update', $limit);

        if ($limit->status !== 'draft') {
            return redirect()
                ->route('credit.limits.show', $limit)
                ->with('error', 'Only draft credit limits can be activated.');
        }

        $limit->update([
            'status' => 'active',
            'activated_at' => now(),
        ]);

        return redirect()
            ->route('credit.limits.show', $limit)
            ->with('success', 'Credit limit activated successfully.');
    }

    public function suspend(CreditLimit $limit)
    {
        $this->authorize('update', $limit);

        if ($limit->status !== 'active') {
            return redirect()
                ->route('credit.limits.show', $limit)
                ->with('error', 'Only active credit limits can be suspended.');
        }

        $limit->update([
            'status' => 'suspended',
            'suspended_at' => now(),
        ]);

        return redirect()
            ->route('credit.limits.show', $limit)
            ->with('success', 'Credit limit suspended successfully.');
    }
}