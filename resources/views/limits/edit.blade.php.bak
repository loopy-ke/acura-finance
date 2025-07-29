@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="min-w-0 flex-1">
                <nav class="flex mb-3" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400 hover:text-blue-600 dark:hover:text-white">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                                <a href="{{ route('credit-financing.limits.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400 hover:text-blue-600 dark:hover:text-white">
                                    Credit Limits
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">Edit Limit</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl">
                    Edit Credit Limit
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Modify credit limit details for {{ $limit->customer_name ?? 'ABC Manufacturing' }}
                </p>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('credit-financing.limits.update', $limit->id ?? 1) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Customer Information (Read-only) -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Customer Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Account Number
                                </label>
                                <input type="text" value="{{ $limit->account_number ?? 'CFA-2024-001' }}" readonly
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Customer Name
                                </label>
                                <input type="text" value="{{ $limit->customer_name ?? 'ABC Manufacturing' }}" readonly
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Industry
                                </label>
                                <input type="text" value="{{ $limit->industry ?? 'Manufacturing' }}" readonly
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Current Risk Grade
                                </label>
                                <input type="text" value="{{ $limit->risk_grade ?? 'B+' }}" readonly
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
                            </div>
                        </div>
                    </div>

                    <!-- Credit Limit Details -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Credit Limit Details</h3>
                        
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="credit_limit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Credit Limit <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="credit_limit" id="credit_limit" step="1000" min="0" required
                                           value="{{ $limit->credit_limit ?? 500000 }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Status <span class="text-red-500">*</span>
                                    </label>
                                    <select name="status" id="status" required
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="active" {{ ($limit->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="suspended" {{ ($limit->status ?? 'active') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                                        <option value="under_review" {{ ($limit->status ?? 'active') === 'under_review' ? 'selected' : '' }}>Under Review</option>
                                        <option value="expired" {{ ($limit->status ?? 'active') === 'expired' ? 'selected' : '' }}>Expired</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="effective_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Effective Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="effective_date" id="effective_date" required
                                           value="{{ ($limit->effective_date ?? now())->format('Y-m-d') }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="expiry_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Expiry Date
                                    </label>
                                    <input type="date" name="expiry_date" id="expiry_date"
                                           value="{{ isset($limit->expiry_date) ? \Carbon\Carbon::parse($limit->expiry_date)->format('Y-m-d') : '' }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="purpose" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Purpose <span class="text-red-500">*</span>
                                    </label>
                                    <select name="purpose" id="purpose" required
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="working_capital" {{ ($limit->purpose ?? 'working_capital') === 'working_capital' ? 'selected' : '' }}>Working Capital</option>
                                        <option value="seasonal_needs" {{ ($limit->purpose ?? 'working_capital') === 'seasonal_needs' ? 'selected' : '' }}>Seasonal Business Needs</option>
                                        <option value="expansion" {{ ($limit->purpose ?? 'working_capital') === 'expansion' ? 'selected' : '' }}>Business Expansion</option>
                                        <option value="equipment_purchase" {{ ($limit->purpose ?? 'working_capital') === 'equipment_purchase' ? 'selected' : '' }}>Equipment Purchase</option>
                                        <option value="inventory_financing" {{ ($limit->purpose ?? 'working_capital') === 'inventory_financing' ? 'selected' : '' }}>Inventory Financing</option>
                                        <option value="general_business" {{ ($limit->purpose ?? 'working_capital') === 'general_business' ? 'selected' : '' }}>General Business Purposes</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Currency <span class="text-red-500">*</span>
                                    </label>
                                    <select name="currency" id="currency" required
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="USD" {{ ($limit->currency ?? 'USD') === 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                                        <option value="EUR" {{ ($limit->currency ?? 'USD') === 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                        <option value="GBP" {{ ($limit->currency ?? 'USD') === 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                                        <option value="CAD" {{ ($limit->currency ?? 'USD') === 'CAD' ? 'selected' : '' }}>CAD - Canadian Dollar</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="next_review_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Next Review Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="next_review_date" id="next_review_date" required
                                           value="{{ ($limit->next_review_date ?? now()->addMonths(12))->format('Y-m-d') }}"
                                           min="{{ now()->format('Y-m-d') }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="account_manager" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Account Manager <span class="text-red-500">*</span>
                                    </label>
                                    <select name="account_manager" id="account_manager" required
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="john_smith" {{ ($limit->account_manager ?? 'john_smith') === 'john_smith' ? 'selected' : '' }}>John Smith</option>
                                        <option value="sarah_johnson" {{ ($limit->account_manager ?? 'john_smith') === 'sarah_johnson' ? 'selected' : '' }}>Sarah Johnson</option>
                                        <option value="mike_davis" {{ ($limit->account_manager ?? 'john_smith') === 'mike_davis' ? 'selected' : '' }}>Mike Davis</option>
                                        <option value="lisa_brown" {{ ($limit->account_manager ?? 'john_smith') === 'lisa_brown' ? 'selected' : '' }}>Lisa Brown</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="modification_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Reason for Modification <span class="text-red-500">*</span>
                                </label>
                                <textarea name="modification_reason" id="modification_reason" rows="3" required
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Explain the reason for modifying this credit limit...">{{ $limit->modification_reason ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Risk Parameters -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Risk Parameters</h3>
                        
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="debt_service_coverage" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Debt Service Coverage Ratio
                                    </label>
                                    <input type="number" name="debt_service_coverage" id="debt_service_coverage" step="0.01" min="0"
                                           value="{{ $limit->debt_service_coverage ?? 1.45 }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="current_ratio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Current Ratio
                                    </label>
                                    <input type="number" name="current_ratio" id="current_ratio" step="0.01" min="0"
                                           value="{{ $limit->current_ratio ?? 2.1 }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="utilization_threshold" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Utilization Alert Threshold (%)
                                    </label>
                                    <input type="number" name="utilization_threshold" id="utilization_threshold" min="0" max="100"
                                           value="{{ $limit->utilization_threshold ?? 80 }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="covenant_compliance" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Covenant Compliance
                                    </label>
                                    <select name="covenant_compliance" id="covenant_compliance"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="compliant" {{ ($limit->covenant_compliance ?? 'compliant') === 'compliant' ? 'selected' : '' }}>Compliant</option>
                                        <option value="minor_breach" {{ ($limit->covenant_compliance ?? 'compliant') === 'minor_breach' ? 'selected' : '' }}>Minor Breach</option>
                                        <option value="material_breach" {{ ($limit->covenant_compliance ?? 'compliant') === 'material_breach' ? 'selected' : '' }}>Material Breach</option>
                                        <option value="waiver_granted" {{ ($limit->covenant_compliance ?? 'compliant') === 'waiver_granted' ? 'selected' : '' }}>Waiver Granted</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="collateral_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Collateral Description
                                </label>
                                <textarea name="collateral_description" id="collateral_description" rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Describe any collateral supporting this credit limit...">{{ $limit->collateral_description ?? 'Real estate property valued at $750,000 and equipment valued at $325,000' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Conditions and Covenants -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Conditions and Covenants</h3>
                        
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <input type="checkbox" name="conditions[]" value="annual_financial_statements" checked
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">Annual Financial Statements Required</span>
                                </label>

                                <label class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <input type="checkbox" name="conditions[]" value="maintain_insurance" checked
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">Maintain Adequate Insurance</span>
                                </label>

                                <label class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <input type="checkbox" name="conditions[]" value="current_ratio_covenant"
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">Current Ratio > 1.5</span>
                                </label>

                                <label class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <input type="checkbox" name="conditions[]" value="debt_service_covenant" checked
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">DSCR > 1.25</span>
                                </label>

                                <label class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <input type="checkbox" name="conditions[]" value="no_additional_debt"
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">No Additional Senior Debt</span>
                                </label>

                                <label class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <input type="checkbox" name="conditions[]" value="quarterly_reporting"
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">Quarterly Financial Reporting</span>
                                </label>
                            </div>

                            <div>
                                <label for="special_conditions" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Special Conditions or Notes
                                </label>
                                <textarea name="special_conditions" id="special_conditions" rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Any special conditions or additional notes...">{{ $limit->special_conditions ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Current Status -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Current Status</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Current Limit:</span>
                                <span class="font-mono text-gray-900 dark:text-white">{{ number_format($limit->credit_limit ?? 500000, 0) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Outstanding:</span>
                                <span class="text-gray-900 dark:text-white">{{ number_format($limit->outstanding_balance ?? 425000, 0) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Utilization:</span>
                                <span class="text-red-600 dark:text-red-400">85%</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Status:</span>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                    {{ ucfirst($limit->status ?? 'Active') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Change Impact -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Change Impact</h4>
                        <div class="space-y-3" id="change_impact">
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                Impact analysis will update based on changes
                            </div>
                        </div>
                    </div>

                    <!-- Approval Required -->
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-6">
                        <h4 class="text-lg font-medium text-yellow-900 dark:text-yellow-100 mb-4">Approval Required</h4>
                        <div class="space-y-3">
                            <div class="flex items-center text-sm">
                                <div class="w-6 h-6 bg-yellow-200 dark:bg-yellow-800 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-xs font-medium">1</span>
                                </div>
                                <span class="text-yellow-800 dark:text-yellow-200">Credit Committee Review</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <div class="w-6 h-6 bg-yellow-200 dark:bg-yellow-800 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-xs font-medium">2</span>
                                </div>
                                <span class="text-yellow-800 dark:text-yellow-200">Risk Assessment Update</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <div class="w-6 h-6 bg-yellow-200 dark:bg-yellow-800 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-xs font-medium">3</span>
                                </div>
                                <span class="text-yellow-800 dark:text-yellow-200">Management Approval</span>
                            </div>
                        </div>
                    </div>

                    <!-- Verification -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Verification</h4>
                        <div class="space-y-4">
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="verify_changes" value="1" required
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">I verify these changes are accurate</span>
                                </label>
                            </div>

                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="verify_authorization" value="1" required
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">I have proper authorization to make these changes</span>
                                </label>
                            </div>

                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="send_notification" value="1" checked
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Notify customer of changes</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Actions</h4>
                        <div class="space-y-3">
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                Update Credit Limit
                            </button>
                            <a href="{{ route('credit-financing.limits.show', $limit->id ?? 1) }}" class="block w-full px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors text-center">
                                View Details
                            </a>
                            <a href="{{ route('credit-financing.limits.index') }}" class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors text-center">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- JavaScript for form interactions -->
    <script>
        // Monitor credit limit changes for impact analysis
        document.getElementById('credit_limit').addEventListener('input', function() {
            const newLimit = parseFloat(this.value) || 0;
            const currentLimit = {{ $limit->credit_limit ?? 500000 }};
            const change = newLimit - currentLimit;
            const changePercent = currentLimit > 0 ? ((change / currentLimit) * 100).toFixed(1) : 0;
            
            updateChangeImpact(change, changePercent, newLimit);
        });

        function updateChangeImpact(change, changePercent, newLimit) {
            const impactContainer = document.getElementById('change_impact');
            const riskLevel = Math.abs(changePercent) > 50 ? 'High' : (Math.abs(changePercent) > 25 ? 'Medium' : 'Low');
            const approvalLevel = newLimit > 1000000 ? 'Board' : (newLimit > 500000 ? 'VP' : 'Manager');
            
            impactContainer.innerHTML = `
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Change Amount:</span>
                        <span class="font-medium ${change > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}">
                            ${change > 0 ? '+' : ''}${change.toLocaleString('en-US', {style: 'currency', currency: 'USD'})}
                        </span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Change %:</span>
                        <span class="font-medium ${change > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}">
                            ${changePercent > 0 ? '+' : ''}${changePercent}%
                        </span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Risk Impact:</span>
                        <span class="text-${riskLevel === 'High' ? 'red' : riskLevel === 'Medium' ? 'yellow' : 'green'}-600 dark:text-${riskLevel === 'High' ? 'red' : riskLevel === 'Medium' ? 'yellow' : 'green'}-400">${riskLevel}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Approval Level:</span>
                        <span class="text-gray-900 dark:text-white">${approvalLevel}</span>
                    </div>
                </div>
            `;
        }

        // Auto-calculate new utilization when limit changes
        document.getElementById('credit_limit').addEventListener('input', function() {
            const newLimit = parseFloat(this.value) || 0;
            const outstanding = {{ $limit->outstanding_balance ?? 425000 }};
            const newUtilization = newLimit > 0 ? ((outstanding / newLimit) * 100).toFixed(1) : 0;
            
            // You could update a utilization display here if needed
        });

        // Initialize change impact on page load
        updateChangeImpact(0, 0, {{ $limit->credit_limit ?? 500000 }});
    </script>
@endsection