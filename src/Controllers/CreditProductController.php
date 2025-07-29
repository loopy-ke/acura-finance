<?php

namespace LoopyLabs\CreditFinancing\Controllers;

use App\Http\Controllers\Controller;
use LoopyLabs\CreditFinancing\Models\CreditProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CreditProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $products = CreditProduct::orderBy('category')
            ->orderBy('name')
            ->paginate(15);

        $stats = [
            'total' => CreditProduct::count(),
            'active' => CreditProduct::where('is_active', true)->count(),
            'short_term' => CreditProduct::where('category', 'Short Term')->count(),
            'mid_term' => CreditProduct::where('category', 'Mid Term')->count(),
            'long_term' => CreditProduct::where('category', 'Long Term')->count(),
        ];

        return view('credit-financing::products.index', compact('products', 'stats'));
    }

    public function create()
    {
        return view('credit-financing::products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'required|in:Short Term,Mid Term,Long Term',
            'min_amount' => 'required|numeric|min:1000',
            'max_amount' => 'required|numeric|gt:min_amount',
            'min_term_months' => 'required|integer|min:1',
            'max_term_months' => 'required|integer|gt:min_term_months',
            'interest_rate' => 'required|numeric|min:0|max:1',
            'processing_fee_percentage' => 'required|numeric|min:0|max:1',
            'min_credit_score' => 'nullable|integer|min:300|max:850',
            'max_debt_to_income_ratio' => 'nullable|numeric|min:0|max:1',
            'requires_collateral' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        CreditProduct::create($validated);

        return redirect()
            ->route('credit.products.index')
            ->with('success', 'Credit product created successfully.');
    }

    public function show(CreditProduct $product)
    {
        $product->load('applications.customer');
        
        $stats = [
            'total_applications' => $product->applications()->count(),
            'approved_applications' => $product->applications()->where('status', 'approved')->count(),
            'total_disbursed' => $product->applications()->where('status', 'approved')->sum('approved_amount'),
            'avg_amount' => $product->applications()->avg('requested_amount'),
        ];

        return view('credit-financing::products.show', compact('product', 'stats'));
    }

    public function edit(CreditProduct $product)
    {
        return view('credit-financing::products.edit', compact('product'));
    }

    public function update(Request $request, CreditProduct $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'required|in:Short Term,Mid Term,Long Term',
            'min_amount' => 'required|numeric|min:1000',
            'max_amount' => 'required|numeric|gt:min_amount',
            'min_term_months' => 'required|integer|min:1',
            'max_term_months' => 'required|integer|gt:min_term_months',
            'interest_rate' => 'required|numeric|min:0|max:1',
            'processing_fee_percentage' => 'required|numeric|min:0|max:1',
            'min_credit_score' => 'nullable|integer|min:300|max:850',
            'max_debt_to_income_ratio' => 'nullable|numeric|min:0|max:1',
            'requires_collateral' => 'boolean',
            'is_active' => 'boolean',
        ]);

        if ($validated['name'] !== $product->name) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $product->update($validated);

        return redirect()
            ->route('credit.products.show', $product)
            ->with('success', 'Credit product updated successfully.');
    }

    public function destroy(CreditProduct $product)
    {
        if ($product->applications()->exists()) {
            return redirect()
                ->route('credit.products.show', $product)
                ->with('error', 'Cannot delete credit product that has applications.');
        }

        $product->delete();

        return redirect()
            ->route('credit.products.index')
            ->with('success', 'Credit product deleted successfully.');
    }
}