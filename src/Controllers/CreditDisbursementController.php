<?php

namespace LoopyLabs\CreditFinancing\Controllers;

use App\Http\Controllers\Controller;
use LoopyLabs\CreditFinancing\Models\CreditDisbursement;
use LoopyLabs\CreditFinancing\Models\CreditApplication;
use LoopyLabs\CreditFinancing\Services\CreditDisbursementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreditDisbursementController extends Controller
{
    protected CreditDisbursementService $disbursementService;

    public function __construct(CreditDisbursementService $disbursementService)
    {
        $this->disbursementService = $disbursementService;
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', CreditDisbursement::class);

        $query = CreditDisbursement::with(['customer', 'creditApplication', 'createdBy'])
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        if ($request->filled('disbursement_method')) {
            $query->where('disbursement_method', $request->disbursement_method);
        }

        if ($request->filled('date_from')) {
            $query->where('disbursed_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('disbursed_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('disbursement_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($customerQuery) use ($search) {
                      $customerQuery->where('company_name', 'like', "%{$search}%");
                  });
            });
        }

        $disbursements = $query->paginate(15);

        // Get summary statistics
        $stats = [
            'total_disbursements' => CreditDisbursement::count(),
            'pending_disbursements' => CreditDisbursement::where('status', 'pending')->count(),
            'active_disbursements' => CreditDisbursement::active()->count(),
            'overdue_disbursements' => CreditDisbursement::overdue()->count(),
            'total_disbursed_amount' => CreditDisbursement::disbursed()->sum('disbursement_amount'),
            'total_outstanding_balance' => CreditDisbursement::active()->sum('outstanding_balance'),
        ];

        return view('credit-financing::disbursements.index', compact('disbursements', 'stats'));
    }

    public function show(CreditDisbursement $disbursement)
    {
        $this->authorize('view', $disbursement);

        $disbursement->load([
            'customer',
            'creditApplication',
            'creditLimit',
            'createdBy',
            'approvedBy',
            'disbursedBy',
            'repayments.createdBy',
            'repayments.processedBy',
            'invoiceFinancing.invoice'
        ]);

        // Calculate repayment schedule
        $repaymentSchedule = $this->disbursementService->calculateRepaymentSchedule($disbursement);

        return view('credit-financing::disbursements.show', compact('disbursement', 'repaymentSchedule'));
    }

    public function create()
    {
        $this->authorize('create', CreditDisbursement::class);

        // Get approved applications without disbursements
        $applications = CreditApplication::where('status', 'approved')
            ->whereDoesntHave('disbursements')
            ->with('customer')
            ->orderBy('decision_date', 'desc')
            ->get();

        return view('credit-financing::disbursements.create', compact('applications'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', CreditDisbursement::class);

        $validated = $request->validate([
            'credit_application_id' => 'required|exists:credit_applications,id',
            'disbursement_amount' => 'required|numeric|min:1',
            'term_months' => 'required|integer|min:1|max:60',
            'interest_rate' => 'required|numeric|min:0|max:1',
            'fee_percentage' => 'required|numeric|min:0|max:1',
            'disbursement_method' => 'required|in:bank_transfer,mobile_money,check,cash,invoice_financing',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:50',
            'account_name' => 'nullable|string|max:255',
            'mobile_number' => 'nullable|string|max:20',
            'payment_reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'terms_and_conditions' => 'nullable|string|max:2000',
            'invoice_id' => 'nullable|exists:invoices,id',
            'advance_rate' => 'nullable|numeric|min:0|max:1',
            'discount_rate' => 'nullable|numeric|min:0|max:1',
        ]);

        $application = CreditApplication::findOrFail($validated['credit_application_id']);

        // Validate disbursement amount doesn't exceed approved amount
        if ($validated['disbursement_amount'] > $application->approved_amount) {
            return back()->withErrors(['disbursement_amount' => 'Disbursement amount cannot exceed approved amount.']);
        }

        $disbursement = $this->disbursementService->createDisbursement($application, $validated);

        return redirect()
            ->route('credit.disbursements.show', $disbursement)
            ->with('success', 'Credit disbursement created successfully.');
    }

    public function edit(CreditDisbursement $disbursement)
    {
        $this->authorize('update', $disbursement);

        if (!$disbursement->canBeEdited()) {
            return redirect()
                ->route('credit.disbursements.show', $disbursement)
                ->with('error', 'This disbursement cannot be edited in its current status.');
        }

        return view('credit-financing::disbursements.edit', compact('disbursement'));
    }

    public function update(Request $request, CreditDisbursement $disbursement)
    {
        $this->authorize('update', $disbursement);

        if (!$disbursement->canBeEdited()) {
            return redirect()
                ->route('credit.disbursements.show', $disbursement)
                ->with('error', 'This disbursement cannot be edited in its current status.');
        }

        $validated = $request->validate([
            'disbursement_amount' => 'required|numeric|min:1',
            'term_months' => 'required|integer|min:1|max:60',
            'interest_rate' => 'required|numeric|min:0|max:1',
            'fee_percentage' => 'required|numeric|min:0|max:1',
            'disbursement_method' => 'required|in:bank_transfer,mobile_money,check,cash,invoice_financing',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:50',
            'account_name' => 'nullable|string|max:255',
            'mobile_number' => 'nullable|string|max:20',
            'payment_reference' => 'nullable|string|max:255',
            'disbursement_notes' => 'nullable|string|max:1000',
            'terms_and_conditions' => 'nullable|string|max:2000',
        ]);

        // Recalculate amounts
        $feeAmount = $validated['disbursement_amount'] * $validated['fee_percentage'];
        $netAmount = $validated['disbursement_amount'] - $feeAmount;
        $dueDate = now()->addMonths($validated['term_months']);

        $validated['fee_amount'] = $feeAmount;
        $validated['net_amount'] = $netAmount;
        $validated['due_date'] = $dueDate;
        $validated['maturity_date'] = $dueDate;

        $disbursement->update($validated);
        $disbursement->updateBalances();

        return redirect()
            ->route('credit.disbursements.show', $disbursement)
            ->with('success', 'Disbursement updated successfully.');
    }

    public function destroy(CreditDisbursement $disbursement)
    {
        $this->authorize('delete', $disbursement);

        if (!$disbursement->canBeCancelled()) {
            return redirect()
                ->route('credit.disbursements.show', $disbursement)
                ->with('error', 'This disbursement cannot be cancelled in its current status.');
        }

        $disbursement->update(['status' => 'cancelled']);

        return redirect()
            ->route('credit.disbursements.index')
            ->with('success', 'Disbursement cancelled successfully.');
    }

    public function process(Request $request, CreditDisbursement $disbursement)
    {
        $this->authorize('update', $disbursement);

        $request->validate([
            'transaction_id' => 'nullable|string|max:255',
            'processing_notes' => 'nullable|string|max:1000',
        ]);

        try {
            $this->disbursementService->processDisbursement(
                $disbursement,
                auth()->user(),
                $request->only(['transaction_id', 'processing_notes'])
            );

            return redirect()
                ->route('credit.disbursements.show', $disbursement)
                ->with('success', 'Disbursement processed successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->route('credit.disbursements.show', $disbursement)
                ->with('error', $e->getMessage());
        }
    }

    public function recordPayment(Request $request, CreditDisbursement $disbursement)
    {
        $this->authorize('update', $disbursement);

        $validated = $request->validate([
            'payment_amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:bank_transfer,mobile_money,cash,check,card,offset,adjustment',
            'payment_reference' => 'nullable|string|max:255',
            'transaction_id' => 'nullable|string|max:255',
            'bank_reference' => 'nullable|string|max:255',
            'mobile_reference' => 'nullable|string|max:255',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            $repayment = $this->disbursementService->recordPayment($disbursement, $validated);

            return redirect()
                ->route('credit.disbursements.show', $disbursement)
                ->with('success', 'Payment recorded successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->route('credit.disbursements.show', $disbursement)
                ->with('error', $e->getMessage());
        }
    }

    public function portfolio(Request $request)
    {
        $this->authorize('viewAny', CreditDisbursement::class);

        $filters = $request->only(['customer_id', 'status', 'date_from', 'date_to']);
        $portfolioData = $this->disbursementService->generatePortfolioReport($filters);

        // Get overdue disbursements
        $overdueDisbursements = $this->disbursementService->getOverdueDisbursements();

        // Get disbursements by status
        $disbursementsByStatus = CreditDisbursement::select('status', DB::raw('count(*) as count'), DB::raw('sum(outstanding_balance) as total_outstanding'))
            ->groupBy('status')
            ->get();

        return view('credit-financing::disbursements.portfolio', compact(
            'portfolioData', 'overdueDisbursements', 'disbursementsByStatus', 'filters'
        ));
    }

    public function export(Request $request)
    {
        $this->authorize('viewAny', CreditDisbursement::class);

        $query = CreditDisbursement::with(['customer', 'creditApplication']);

        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }
        if ($request->filled('date_from')) {
            $query->where('disbursed_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('disbursed_at', '<=', $request->date_to);
        }

        $disbursements = $query->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="disbursements_' . now()->format('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($disbursements) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, [
                'Disbursement Number', 'Customer', 'Application Number', 'Disbursement Amount',
                'Outstanding Balance', 'Status', 'Method', 'Disbursed Date', 'Due Date', 'Days Overdue'
            ]);

            foreach ($disbursements as $disbursement) {
                fputcsv($file, [
                    $disbursement->disbursement_number,
                    $disbursement->customer->company_name,
                    $disbursement->creditApplication->application_number,
                    number_format($disbursement->disbursement_amount, 2),
                    number_format($disbursement->outstanding_balance, 2),
                    ucfirst($disbursement->status),
                    ucfirst(str_replace('_', ' ', $disbursement->disbursement_method)),
                    $disbursement->disbursed_at?->format('Y-m-d'),
                    $disbursement->due_date?->format('Y-m-d'),
                    $disbursement->days_overdue,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}