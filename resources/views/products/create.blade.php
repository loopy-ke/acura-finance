@extends('layouts.app')

@section('title', 'Create Credit Product')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Create Credit Product</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">Configure a new credit product with terms and conditions</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <a href="{{ route('credit.products.index') }}" 
               class="inline-flex items-center rounded-full bg-gray-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Products
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <form method="POST" action="{{ route('credit.products.store') }}" class="space-y-8 p-6">
            @csrf

            <!-- Basic Information -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Basic Information</h3>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Product Name *</label>
                        <input type="text" name="name" id="name" required
                               value="{{ old('name') }}"
                               class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('name') border-red-300 @enderror"
                               placeholder="e.g., Business Working Capital">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                        <textarea name="description" id="description" rows="3"
                                  class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('description') border-red-300 @enderror"
                                  placeholder="Brief description of the credit product">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category *</label>
                        <select name="category" id="category" required
                                class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('category') border-red-300 @enderror">
                            <option value="">Select Category</option>
                            <option value="Short Term" {{ old('category') === 'Short Term' ? 'selected' : '' }}>Short Term (1-6 months)</option>
                            <option value="Mid Term" {{ old('category') === 'Mid Term' ? 'selected' : '' }}>Mid Term (6-24 months)</option>
                            <option value="Long Term" {{ old('category') === 'Long Term' ? 'selected' : '' }}>Long Term (24+ months)</option>
                        </select>
                        @error('category')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                               class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900 dark:text-white">
                            Active (available for applications)
                        </label>
                    </div>
                </div>
            </div>

            <!-- Amount Configuration -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Amount Configuration</h3>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="min_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Minimum Amount (KES) *</label>
                        <input type="number" name="min_amount" id="min_amount" required step="0.01" min="1000"
                               value="{{ old('min_amount') }}"
                               class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('min_amount') border-red-300 @enderror"
                               placeholder="10000">
                        @error('min_amount')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="max_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Maximum Amount (KES) *</label>
                        <input type="number" name="max_amount" id="max_amount" required step="0.01"
                               value="{{ old('max_amount') }}"
                               class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('max_amount') border-red-300 @enderror"
                               placeholder="1000000">
                        @error('max_amount')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            <!-- Term Configuration -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Term Configuration</h3>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="min_term_months" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Minimum Term (Months) *</label>
                        <input type="number" name="min_term_months" id="min_term_months" required min="1"
                               value="{{ old('min_term_months') }}"
                               class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('min_term_months') border-red-300 @enderror"
                               placeholder="1">
                        @error('min_term_months')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="max_term_months" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Maximum Term (Months) *</label>
                        <input type="number" name="max_term_months" id="max_term_months" required min="1"
                               value="{{ old('max_term_months') }}"
                               class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('max_term_months') border-red-300 @enderror"
                               placeholder="60">
                        @error('max_term_months')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            <!-- Interest & Fees -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Interest & Fees</h3>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="interest_rate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Annual Interest Rate (%) *</label>
                        <input type="number" name="interest_rate" id="interest_rate" required step="0.01" min="0" max="100"
                               value="{{ old('interest_rate') }}"
                               class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('interest_rate') border-red-300 @enderror"
                               placeholder="15.50">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Enter as percentage (e.g., 15.5 for 15.5%)</p>
                        @error('interest_rate')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="processing_fee_percentage" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Processing Fee (%) *</label>
                        <input type="number" name="processing_fee_percentage" id="processing_fee_percentage" required step="0.01" min="0" max="100"
                               value="{{ old('processing_fee_percentage') }}"
                               class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('processing_fee_percentage') border-red-300 @enderror"
                               placeholder="2.50">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Enter as percentage (e.g., 2.5 for 2.5%)</p>
                        @error('processing_fee_percentage')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Eligibility Criteria -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Eligibility Criteria</h3>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="min_credit_score" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Minimum Credit Score</label>
                        <input type="number" name="min_credit_score" id="min_credit_score" min="300" max="850"
                               value="{{ old('min_credit_score') }}"
                               class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('min_credit_score') border-red-300 @enderror"
                               placeholder="600">
                        @error('min_credit_score')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="max_debt_to_income_ratio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Max Debt-to-Income Ratio (%)</label>
                        <input type="number" name="max_debt_to_income_ratio" id="max_debt_to_income_ratio" step="0.01" min="0" max="100"
                               value="{{ old('max_debt_to_income_ratio') }}"
                               class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('max_debt_to_income_ratio') border-red-300 @enderror"
                               placeholder="40.00">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Enter as percentage (e.g., 40 for 40%)</p>
                        @error('max_debt_to_income_ratio')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <div class="flex items-center">
                            <input id="requires_collateral" name="requires_collateral" type="checkbox" value="1" {{ old('requires_collateral') ? 'checked' : '' }}
                                   class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded">
                            <label for="requires_collateral" class="ml-2 block text-sm text-gray-900 dark:text-white">
                                Requires Collateral
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-between items-center pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('credit.products.index') }}" 
                   class="inline-flex items-center rounded-full bg-white dark:bg-gray-700 px-6 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 shadow-sm border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Cancel
                </a>
                <button type="submit" 
                        class="inline-flex items-center rounded-full bg-blue-600 px-8 py-3 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Create Credit Product
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Convert percentage inputs to decimal on form submission
    const form = document.querySelector('form');
    const interestRateInput = document.getElementById('interest_rate');
    const processingFeeInput = document.getElementById('processing_fee_percentage');
    const debtToIncomeInput = document.getElementById('max_debt_to_income_ratio');
    
    form.addEventListener('submit', function(e) {
        // Convert percentages to decimals
        if (interestRateInput.value) {
            interestRateInput.value = parseFloat(interestRateInput.value) / 100;
        }
        if (processingFeeInput.value) {
            processingFeeInput.value = parseFloat(processingFeeInput.value) / 100;
        }
        if (debtToIncomeInput.value) {
            debtToIncomeInput.value = parseFloat(debtToIncomeInput.value) / 100;
        }
    });
});
</script>
@endsection