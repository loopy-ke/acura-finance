@extends('layouts.app')

@section('title', 'New Credit Application - Application Details')

@section('content')
<div class="space-y-6">
    <!-- Progress Steps -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
        <ol class="flex items-center w-full">
            <li class="flex w-full items-center text-blue-600 dark:text-blue-500 after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-100 after:border-4 after:inline-block dark:after:border-blue-800">
                <span class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full lg:h-12 lg:w-12 dark:bg-blue-800 shrink-0">
                    <svg class="w-3.5 h-3.5 text-blue-600 lg:w-4 lg:h-4 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                    </svg>
                </span>
                <span class="ml-3 text-sm font-medium text-blue-600 dark:text-blue-300">Select Customer</span>
            </li>
            <li class="flex w-full items-center text-blue-600 dark:text-blue-500 after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-100 after:border-4 after:inline-block dark:after:border-blue-800">
                <span class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full lg:h-12 lg:w-12 dark:bg-blue-800 shrink-0">
                    <span class="text-blue-600 dark:text-blue-300 font-semibold text-sm lg:text-base">2</span>
                </span>
                <span class="ml-3 text-sm font-medium text-blue-600 dark:text-blue-300">Application Details</span>
            </li>
            <li class="flex items-center">
                <span class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 dark:bg-gray-700 shrink-0">
                    <span class="text-gray-500 dark:text-gray-100 font-semibold text-sm lg:text-base">3</span>
                </span>
                <span class="ml-3 text-sm font-medium text-gray-500 dark:text-gray-400">Review</span>
            </li>
        </ol>
    </div>

    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">New Credit Application</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">Enter the application details for {{ $customer->company_name }}</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <a href="{{ route('credit.applications.create.step1') }}" 
               class="inline-flex items-center rounded-full bg-gray-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Customer Selection
            </a>
        </div>
    </div>

    <!-- Selected Customer Summary -->
    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-700/50 p-6">
        <!-- Customer Header -->
        <div class="flex items-center space-x-4">
            <!-- Avatar -->
            <div class="flex-shrink-0">
                <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center ring-4 ring-white dark:ring-gray-800">
                    <span class="text-xl font-bold text-white">{{ substr($customer->company_name, 0, 1) }}</span>
                </div>
            </div>
            
            <!-- Info -->
            <div class="flex-1">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $customer->company_name }}</h3>
                <div class="mt-2 flex items-center space-x-6 text-sm text-gray-600 dark:text-gray-400">
                    <div class="flex items-center space-x-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ $customer->email }}</span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span>{{ $customer->phone }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Credit Summary -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
        <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-4 flex items-center">
            <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
            </svg>
            Credit Information
        </h4>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="text-center sm:text-left">
                <div class="text-2xl font-bold text-gray-900 dark:text-white">
                    KES {{ number_format($customer->credit_limit, 2) }}
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Credit Limit</div>
            </div>
            <div class="text-center sm:text-left">
                <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                    KES {{ number_format($customer->credit_limit - ($customer->creditCustomer?->total_financed_amount ?? 0), 2) }}
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Available Credit</div>
            </div>
            @if($customer->creditCustomer?->credit_score)
            <div class="text-center sm:text-left">
                <div class="mb-2">
                    <span 
                        class="inline-flex items-center px-4 py-2 rounded-full text-base font-medium
                        @if($customer->creditCustomer->credit_score >= 80) bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                        @elseif($customer->creditCustomer->credit_score >= 60) bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                        @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                        @endif"
                    >
                        {{ $customer->creditCustomer->credit_score }}
                    </span>
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Credit Score</div>
            </div>
            @endif
        </div>
    </div>

    <!-- Application Form -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Application Details</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                Configure the credit application terms and requirements
            </p>
        </div>
        
        <form method="POST" action="{{ route('credit.applications.create.step3') }}" class="px-4 py-5 sm:p-6">
            @csrf
            <input type="hidden" name="customer_id" value="{{ $customer->id }}">

            <div class="space-y-8">
                <!-- Product Configuration Section -->
                <div>
                    <h4 class="text-base font-medium text-gray-900 dark:text-white mb-4">Product Configuration</h4>
                    <div class="space-y-6">
                        <!-- Credit Product Selection -->
                        <div>
                            <label for="credit_product_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Credit Product</label>
                            <select name="credit_product_id" id="credit_product_id"
                                    class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('credit_product_id') border-red-300 @enderror">
                                <option value="">Select a credit product</option>
                                @foreach($creditProducts as $product)
                                    <option value="{{ $product->id }}" 
                                            data-min-amount="{{ $product->min_amount }}" 
                                            data-max-amount="{{ $product->max_amount }}"
                                            data-min-term="{{ $product->min_term_months }}"
                                            data-max-term="{{ $product->max_term_months }}"
                                            data-default-term="{{ $product->default_term_months }}"
                                            data-interest-rate="{{ $product->interest_rate }}"
                                            data-processing-fee="{{ $product->processing_fee_percentage }}"
                                            {{ old('credit_product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} ({{ $product->category_name }}) - {{ number_format($product->interest_rate * 100, 2) }}% APR
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                Select a credit product to automatically apply terms and limits
                            </p>
                            @error('credit_product_id')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                <!-- Financial Details Section -->
                <div>
                    <h4 class="text-base font-medium text-gray-900 dark:text-white mb-4">Financial Details</h4>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="requested_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Requested Amount *</label>
                            <div class="relative rounded-lg shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400 sm:text-sm">KES</span>
                                </div>
                                <input type="number" name="requested_amount" id="requested_amount" required
                                       value="{{ old('requested_amount') }}" step="0.01" min="0"
                                       max="{{ $customer->credit_limit - ($customer->creditCustomer?->total_financed_amount ?? 0) }}"
                                       class="pl-12 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('requested_amount') border-red-300 @enderror"
                                       placeholder="0.00">
                            </div>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                Maximum available: KES {{ number_format($customer->credit_limit - ($customer->creditCustomer?->total_financed_amount ?? 0), 2) }}
                            </p>
                            @error('requested_amount')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="requested_term_months" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Term (Months) *</label>
                            <input type="number" name="requested_term_months" id="requested_term_months" required
                                   value="{{ old('requested_term_months', 12) }}" min="1" max="60"
                                   class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('requested_term_months') border-red-300 @enderror"
                                   placeholder="12">
                            @error('requested_term_months')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Application Details Section -->
                <div>
                    <h4 class="text-base font-medium text-gray-900 dark:text-white mb-4">Application Details</h4>
                    <div class="space-y-6">
                        <!-- Purpose -->
                        <div>
                            <label for="purpose" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Purpose *</label>
                            <input type="text" name="purpose" id="purpose" required
                                   value="{{ old('purpose') }}" maxlength="500"
                                   class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('purpose') border-red-300 @enderror"
                                   placeholder="Brief description of the credit purpose">
                            @error('purpose')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Business Justification -->
                        <div>
                            <label for="business_justification" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Business Justification *</label>
                            <textarea name="business_justification" id="business_justification" rows="4" required
                                      maxlength="1000"
                                      class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('business_justification') border-red-300 @enderror"
                                      placeholder="Detailed justification for this credit request...">{{ old('business_justification') }}</textarea>
                            @error('business_justification')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Processing Options Section -->
                <div>
                    <h4 class="text-base font-medium text-gray-900 dark:text-white mb-4">Processing Options</h4>
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                        <div class="relative flex items-start">
                            <div class="flex items-center h-5">
                                <input id="auto_submit" name="auto_submit" type="checkbox" value="1" {{ old('auto_submit') ? 'checked' : '' }}
                                       class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="auto_submit" class="font-medium text-gray-700 dark:text-gray-300">Auto-submit for processing</label>
                                <p class="text-gray-500 dark:text-gray-400">Automatically submit this application for credit scoring and decision</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-between items-center pt-8 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('credit.applications.create.step1') }}" 
                   class="inline-flex items-center rounded-full bg-white dark:bg-gray-700 px-6 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 shadow-sm border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Customer Selection
                </a>
                <button type="submit" 
                        class="inline-flex items-center rounded-full bg-blue-600 px-8 py-3 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                    Continue to Review
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get form elements
    const productSelect = document.getElementById('credit_product_id');
    const amountInput = document.getElementById('requested_amount');
    const termInput = document.getElementById('requested_term_months');
    const maxAmount = {{ $customer->credit_limit - ($customer->creditCustomer?->total_financed_amount ?? 0) }};
    
    let currentProductLimits = {
        minAmount: 0,
        maxAmount: maxAmount,
        minTerm: 1,
        maxTerm: 60,
        defaultTerm: 12,
        interestRate: 0,
        processingFee: 0
    };

    // Update form limits when product changes
    productSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (selectedOption.value) {
            currentProductLimits = {
                minAmount: parseFloat(selectedOption.dataset.minAmount) || 0,
                maxAmount: Math.min(parseFloat(selectedOption.dataset.maxAmount) || maxAmount, maxAmount),
                minTerm: parseInt(selectedOption.dataset.minTerm) || 1,
                maxTerm: parseInt(selectedOption.dataset.maxTerm) || 60,
                defaultTerm: parseInt(selectedOption.dataset.defaultTerm) || 12,
                interestRate: parseFloat(selectedOption.dataset.interestRate) || 0,
                processingFee: parseFloat(selectedOption.dataset.processingFee) || 0
            };
            
            // Update form field attributes
            amountInput.min = currentProductLimits.minAmount;
            amountInput.max = currentProductLimits.maxAmount;
            termInput.min = currentProductLimits.minTerm;
            termInput.max = currentProductLimits.maxTerm;
            termInput.value = currentProductLimits.defaultTerm;
            
            // Update helper text
            const amountHelp = amountInput.parentElement.nextElementSibling;
            if (amountHelp && amountHelp.classList.contains('text-xs')) {
                amountHelp.textContent = `Range: KES ${currentProductLimits.minAmount.toLocaleString()} - ${currentProductLimits.maxAmount.toLocaleString()}`;
            }
            
        } else {
            // Reset to defaults
            currentProductLimits = {
                minAmount: 0,
                maxAmount: maxAmount,
                minTerm: 1,
                maxTerm: 60,
                defaultTerm: 12,
                interestRate: 0,
                processingFee: 0
            };
            
            amountInput.min = 0;
            amountInput.max = maxAmount;
            termInput.min = 1;
            termInput.max = 60;
            
            const amountHelp = amountInput.parentElement.nextElementSibling;
            if (amountHelp && amountHelp.classList.contains('text-xs')) {
                amountHelp.textContent = `Maximum available: KES ${maxAmount.toLocaleString()}`;
            }
        }
        
        validateAmount();
        updateEstimate();
    });
    
    // Validate amount input
    function validateAmount() {
        const value = parseFloat(amountInput.value) || 0;
        let message = '';
        
        if (value > currentProductLimits.maxAmount) {
            message = `Amount cannot exceed ${currentProductLimits.maxAmount.toLocaleString()}`;
        } else if (value < currentProductLimits.minAmount && value > 0) {
            message = `Amount must be at least ${currentProductLimits.minAmount.toLocaleString()}`;
        }
        
        amountInput.setCustomValidity(message);
    }
    
    amountInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^\d.]/g, '');
        e.target.value = value;
        validateAmount();
        updateEstimate();
    });

    // Calculate estimated monthly payment
    function updateEstimate() {
        const amount = parseFloat(amountInput.value) || 0;
        const term = parseInt(termInput.value) || currentProductLimits.defaultTerm;
        
        if (amount > 0 && term > 0 && currentProductLimits.interestRate > 0) {
            // Calculate with interest
            const monthlyRate = currentProductLimits.interestRate / 12;
            const totalWithInterest = amount * (1 + (currentProductLimits.interestRate * term / 12));
            const monthlyPayment = totalWithInterest / term;
            const processingFee = amount * currentProductLimits.processingFee;
            
            console.log(`Estimated monthly payment: KES ${monthlyPayment.toLocaleString()}`);
            console.log(`Processing fee: KES ${processingFee.toLocaleString()}`);
        }
    }
    
    termInput.addEventListener('input', updateEstimate);
    
    // Initialize
    if (productSelect.value) {
        productSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection