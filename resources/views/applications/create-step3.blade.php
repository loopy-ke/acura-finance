@extends('layouts.app')

@section('title', 'New Credit Application - Review')

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
                    <svg class="w-3.5 h-3.5 text-blue-600 lg:w-4 lg:h-4 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                    </svg>
                </span>
                <span class="ml-3 text-sm font-medium text-blue-600 dark:text-blue-300">Application Details</span>
            </li>
            <li class="flex items-center text-blue-600 dark:text-blue-500">
                <span class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full lg:h-12 lg:w-12 dark:bg-blue-800 shrink-0">
                    <span class="text-blue-600 dark:text-blue-300 font-semibold text-sm lg:text-base">3</span>
                </span>
                <span class="ml-3 text-sm font-medium text-blue-600 dark:text-blue-300">Review</span>
            </li>
        </ol>
    </div>

    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">New Credit Application</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">Review and confirm all application details before submitting</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <a href="{{ route('credit.applications.create.step2') }}" 
               class="inline-flex items-center rounded-full bg-gray-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Application Details
            </a>
        </div>
    </div>

    <!-- Customer Summary -->
    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-700/50 p-6">
        <!-- Customer Header -->
        <div class="flex items-center space-x-4 mb-4">
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

        <!-- Credit Summary -->
        <div class="pt-4 border-t border-blue-200 dark:border-blue-700/50">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="text-center sm:text-left">
                    <div class="text-lg font-bold text-gray-900 dark:text-white">
                        KES {{ number_format($customer->credit_limit, 2) }}
                    </div>
                    <div class="text-xs text-gray-600 dark:text-gray-400">Credit Limit</div>
                </div>
                <div class="text-center sm:text-left">
                    <div class="text-lg font-bold text-green-600 dark:text-green-400">
                        KES {{ number_format($customer->credit_limit - ($customer->creditCustomer?->total_financed_amount ?? 0), 2) }}
                    </div>
                    <div class="text-xs text-gray-600 dark:text-gray-400">Available</div>
                </div>
                @if($customer->creditCustomer?->credit_score)
                <div class="text-center sm:text-left">
                    <span 
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        @if($customer->creditCustomer->credit_score >= 80) bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                        @elseif($customer->creditCustomer->credit_score >= 60) bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                        @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                        @endif"
                    >
                        Score: {{ $customer->creditCustomer->credit_score }}
                    </span>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Application Review -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Application Review</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                Please review all details before submitting your application
            </p>
        </div>
        
        <div class="px-4 py-5 sm:p-6">
            <div class="space-y-6">
                <!-- Product Configuration -->
                <div>
                    <h4 class="text-base font-medium text-gray-900 dark:text-white mb-4">Product Configuration</h4>
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Credit Product:</span>
                            <span class="text-sm text-gray-900 dark:text-white">
                                @if($creditProduct)
                                    {{ $creditProduct->name }} ({{ $creditProduct->category_name }})
                                @else
                                    Default Product
                                @endif
                            </span>
                        </div>
                        @if($creditProduct)
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Interest Rate:</span>
                            <span class="text-sm text-gray-900 dark:text-white">{{ number_format($creditProduct->interest_rate * 100, 2) }}% APR</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Financial Details -->
                <div>
                    <h4 class="text-base font-medium text-gray-900 dark:text-white mb-4">Financial Details</h4>
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Requested Amount:</span>
                            <span class="text-lg font-bold text-gray-900 dark:text-white">KES {{ number_format($validated['requested_amount'], 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Term:</span>
                            <span class="text-sm text-gray-900 dark:text-white">{{ $validated['requested_term_months'] }} months</span>
                        </div>
                        @if($creditProduct)
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Estimated Monthly Payment:</span>
                            <span class="text-sm text-gray-900 dark:text-white">
                                KES {{ number_format($creditProduct->calculateMonthlyPayment($validated['requested_amount'], $validated['requested_term_months']), 2) }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Processing Fee:</span>
                            <span class="text-sm text-gray-900 dark:text-white">
                                KES {{ number_format($creditProduct->calculateProcessingFee($validated['requested_amount']), 2) }}
                            </span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Application Details -->
                <div>
                    <h4 class="text-base font-medium text-gray-900 dark:text-white mb-4">Application Details</h4>
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 space-y-3">
                        <div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 block mb-1">Purpose:</span>
                            <span class="text-sm text-gray-900 dark:text-white">{{ $validated['purpose'] }}</span>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 block mb-1">Business Justification:</span>
                            <span class="text-sm text-gray-900 dark:text-white">{{ $validated['business_justification'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Processing Options -->
                @if($validated['auto_submit'] ?? false)
                <div>
                    <h4 class="text-base font-medium text-gray-900 dark:text-white mb-4">Processing Options</h4>
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Auto-submit enabled - Application will be automatically submitted for processing</span>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Actions -->
        <div class="px-4 py-4 sm:px-6 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700 rounded-b-lg">
            <div class="flex justify-between items-center">
                <a href="{{ route('credit.applications.create.step2') }}" 
                   class="inline-flex items-center rounded-full bg-white dark:bg-gray-700 px-6 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 shadow-sm border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Edit Details
                </a>
                
                <form method="POST" action="{{ route('credit.applications.store') }}" class="inline">
                    @csrf
                    <button type="submit" 
                            class="inline-flex items-center rounded-full bg-green-600 px-8 py-3 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Submit Application
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection