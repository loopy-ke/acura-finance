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
                                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">New Limit Request</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl">
                    Credit Limit Request
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Request a new credit limit or modify an existing customer credit limit
                </p>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('credit-financing.limits.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Customer Information -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Customer Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="customer_search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Search Customer <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" name="customer_search" id="customer_search" required
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Enter customer name or account number">
                                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label for="account_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Account Number
                                </label>
                                <input type="text" name="account_number" id="account_number" readonly
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
                                       placeholder="Will be populated after search">
                            </div>

                            <div>
                                <label for="customer_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Customer Name
                                </label>
                                <input type="text" name="customer_name" id="customer_name" readonly
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
                                       placeholder="Will be populated after search">
                            </div>

                            <div>
                                <label for="industry" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Industry
                                </label>
                                <input type="text" name="industry" id="industry" readonly
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
                                       placeholder="Will be populated after search">
                            </div>

                            <div>
                                <label for="current_risk_grade" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Current Risk Grade
                                </label>
                                <input type="text" name="current_risk_grade" id="current_risk_grade" readonly
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
                                       placeholder="Will be populated after search">
                            </div>

                            <div>
                                <label for="existing_limit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Existing Credit Limit
                                </label>
                                <input type="text" name="existing_limit" id="existing_limit" readonly
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
                                       placeholder="Will be populated after search">
                            </div>
                        </div>
                    </div>

                    <!-- Credit Limit Details -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Credit Limit Details</h3>
                        
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="request_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Request Type <span class="text-red-500">*</span>
                                    </label>
                                    <select name="request_type" id="request_type" required
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select Request Type</option>
                                        <option value="new_limit">New Credit Limit</option>
                                        <option value="increase">Increase Existing Limit</option>
                                        <option value="decrease">Decrease Existing Limit</option>
                                        <option value="temporary">Temporary Limit Increase</option>
                                        <option value="renewal">Limit Renewal</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="requested_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Requested Amount <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="requested_amount" id="requested_amount" step="1000" min="0" required
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Enter requested credit limit">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="effective_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Effective Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="effective_date" id="effective_date" required
                                           min="{{ now()->format('Y-m-d') }}"
                                           value="{{ now()->format('Y-m-d') }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="expiry_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Expiry Date
                                    </label>
                                    <input type="date" name="expiry_date" id="expiry_date"
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
                                        <option value="">Select Purpose</option>
                                        <option value="working_capital">Working Capital</option>
                                        <option value="seasonal_needs">Seasonal Business Needs</option>
                                        <option value="expansion">Business Expansion</option>
                                        <option value="equipment_purchase">Equipment Purchase</option>
                                        <option value="inventory_financing">Inventory Financing</option>
                                        <option value="general_business">General Business Purposes</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Currency <span class="text-red-500">*</span>
                                    </label>
                                    <select name="currency" id="currency" required
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="USD" selected>USD - US Dollar</option>
                                        <option value="EUR">EUR - Euro</option>
                                        <option value="GBP">GBP - British Pound</option>
                                        <option value="CAD">CAD - Canadian Dollar</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="business_justification" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Business Justification <span class="text-red-500">*</span>
                                </label>
                                <textarea name="business_justification" id="business_justification" rows="4" required
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Provide detailed business justification for the credit limit request..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Risk Assessment -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Risk Assessment</h3>
                        
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="debt_service_coverage" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Debt Service Coverage Ratio
                                    </label>
                                    <input type="number" name="debt_service_coverage" id="debt_service_coverage" step="0.01" min="0"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="e.g., 1.25">
                                </div>

                                <div>
                                    <label for="current_ratio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Current Ratio
                                    </label>
                                    <input type="number" name="current_ratio" id="current_ratio" step="0.01" min="0"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="e.g., 2.15">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="annual_revenue" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Annual Revenue
                                    </label>
                                    <input type="number" name="annual_revenue" id="annual_revenue" step="1000" min="0"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Enter annual revenue">
                                </div>

                                <div>
                                    <label for="net_worth" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Net Worth
                                    </label>
                                    <input type="number" name="net_worth" id="net_worth" step="1000" min="0"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Enter net worth">
                                </div>
                            </div>

                            <div>
                                <label for="collateral_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Collateral Description
                                </label>
                                <textarea name="collateral_description" id="collateral_description" rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Describe any collateral supporting this credit limit..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Supporting Documents -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Supporting Documents</h3>
                        
                        <div class="space-y-4">
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                Select the documents that support this credit limit request:
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <input type="checkbox" name="supporting_documents[]" value="financial_statements" checked
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">Financial Statements</span>
                                </label>

                                <label class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <input type="checkbox" name="supporting_documents[]" value="tax_returns"
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">Tax Returns</span>
                                </label>

                                <label class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <input type="checkbox" name="supporting_documents[]" value="business_plan" checked
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">Business Plan</span>
                                </label>

                                <label class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <input type="checkbox" name="supporting_documents[]" value="cash_flow_projections"
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">Cash Flow Projections</span>
                                </label>

                                <label class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <input type="checkbox" name="supporting_documents[]" value="collateral_appraisal"
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">Collateral Appraisal</span>
                                </label>

                                <label class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <input type="checkbox" name="supporting_documents[]" value="credit_report"
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">Credit Report</span>
                                </label>
                            </div>

                            <div>
                                <label for="additional_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Additional Notes
                                </label>
                                <textarea name="additional_notes" id="additional_notes" rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Any additional information relevant to this credit limit request..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Customer Summary -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Customer Summary</h4>
                        <div class="space-y-3" id="customer_summary">
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                Select a customer to view summary
                            </div>
                        </div>
                    </div>

                    <!-- Impact Analysis -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Impact Analysis</h4>
                        <div class="space-y-3" id="impact_analysis">
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                Impact analysis will appear after entering requested amount
                            </div>
                        </div>
                    </div>

                    <!-- Approval Workflow -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Approval Workflow</h4>
                        <div class="space-y-3">
                            <div class="flex items-center text-sm">
                                <div class="w-6 h-6 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-xs font-medium">1</span>
                                </div>
                                <span class="text-gray-600 dark:text-gray-400">Credit Analyst Review</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <div class="w-6 h-6 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-xs font-medium">2</span>
                                </div>
                                <span class="text-gray-600 dark:text-gray-400">Risk Assessment</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <div class="w-6 h-6 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-xs font-medium">3</span>
                                </div>
                                <span class="text-gray-600 dark:text-gray-400">Management Approval</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <div class="w-6 h-6 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-xs font-medium">4</span>
                                </div>
                                <span class="text-gray-600 dark:text-gray-400">Implementation</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Actions</h4>
                        <div class="space-y-3">
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                Submit Request
                            </button>
                            <button type="button" onclick="saveDraft()" class="w-full px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors">
                                Save as Draft
                            </button>
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
        function saveDraft() {
            alert('Draft saved successfully!');
        }

        // Mock customer search functionality
        document.getElementById('customer_search').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            
            // Sample data
            const sampleCustomers = {
                'abc manufacturing': {
                    account_number: 'CFA-2024-001',
                    customer_name: 'ABC Manufacturing',
                    industry: 'Manufacturing',
                    current_risk_grade: 'B+',
                    existing_limit: '500,000'
                },
                'cfa-2024-001': {
                    account_number: 'CFA-2024-001',
                    customer_name: 'ABC Manufacturing',
                    industry: 'Manufacturing',
                    current_risk_grade: 'B+',
                    existing_limit: '500,000'
                }
            };
            
            if (sampleCustomers[query]) {
                const customer = sampleCustomers[query];
                document.getElementById('account_number').value = customer.account_number;
                document.getElementById('customer_name').value = customer.customer_name;
                document.getElementById('industry').value = customer.industry;
                document.getElementById('current_risk_grade').value = customer.current_risk_grade;
                document.getElementById('existing_limit').value = customer.existing_limit;
                
                updateCustomerSummary();
            }
        });

        // Update impact analysis when requested amount changes
        document.getElementById('requested_amount').addEventListener('input', function() {
            const amount = parseFloat(this.value) || 0;
            updateImpactAnalysis(amount);
        });

        function updateCustomerSummary() {
            const summaryContainer = document.getElementById('customer_summary');
            summaryContainer.innerHTML = `
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Years with Bank:</span>
                        <span class="text-gray-900 dark:text-white">3.5 years</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Payment History:</span>
                        <span class="text-green-600 dark:text-green-400">Excellent</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Current Utilization:</span>
                        <span class="text-yellow-600 dark:text-yellow-400">85%</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Last Review:</span>
                        <span class="text-gray-900 dark:text-white">Dec 15, 2024</span>
                    </div>
                </div>
            `;
        }

        function updateImpactAnalysis(amount) {
            const analysisContainer = document.getElementById('impact_analysis');
            const existingLimit = 500000; // Sample existing limit
            const change = amount - existingLimit;
            const changePercent = ((change / existingLimit) * 100).toFixed(1);
            
            analysisContainer.innerHTML = `
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
                            ${change > 0 ? '+' : ''}${changePercent}%
                        </span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Risk Impact:</span>
                        <span class="text-yellow-600 dark:text-yellow-400">Moderate</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Approval Level:</span>
                        <span class="text-gray-900 dark:text-white">${amount > 1000000 ? 'Board' : (amount > 500000 ? 'VP' : 'Manager')}</span>
                    </div>
                </div>
            `;
        }

        // Auto-set expiry date when effective date changes (1 year later)
        document.getElementById('effective_date').addEventListener('change', function() {
            const effectiveDate = new Date(this.value);
            const expiryDate = new Date(effectiveDate);
            expiryDate.setFullYear(effectiveDate.getFullYear() + 1);
            
            document.getElementById('expiry_date').value = expiryDate.toISOString().split('T')[0];
        });
    </script>
@endsection