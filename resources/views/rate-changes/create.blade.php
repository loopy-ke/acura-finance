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
                                <a href="{{ route('credit-financing.rate-changes.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400 hover:text-blue-600 dark:hover:text-white">
                                    Rate Changes
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">New Rate Change</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl">
                    New Interest Rate Change
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Request a rate adjustment for an existing loan account
                </p>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('credit-financing.rate-changes.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Account Selection -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Loan Account Details</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="account_search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Search Account <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" name="account_search" id="account_search" required
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Enter account number or customer name">
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
                                <label for="product_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Product Type
                                </label>
                                <input type="text" name="product_type" id="product_type" readonly
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
                                       placeholder="Will be populated after search">
                            </div>

                            <div>
                                <label for="current_balance" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Current Balance
                                </label>
                                <input type="text" name="current_balance" id="current_balance" readonly
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
                                       placeholder="Will be populated after search">
                            </div>

                            <div>
                                <label for="current_rate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Current Interest Rate
                                </label>
                                <div class="relative">
                                    <input type="number" name="current_rate" id="current_rate" step="0.01" readonly
                                           class="w-full px-3 py-2 pr-8 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
                                           placeholder="0.00">
                                    <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm text-gray-500">%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rate Change Details -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Rate Change Details</h3>
                        
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="new_rate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        New Interest Rate <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="number" name="new_rate" id="new_rate" step="0.01" min="0" max="50" required
                                               class="w-full px-3 py-2 pr-8 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                               placeholder="0.00">
                                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm text-gray-500">%</span>
                                    </div>
                                </div>

                                <div>
                                    <label for="rate_change" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Rate Change
                                    </label>
                                    <div class="relative">
                                        <input type="text" name="rate_change" id="rate_change" readonly
                                               class="w-full px-3 py-2 pr-8 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
                                               placeholder="Calculated automatically">
                                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm text-gray-500">%</span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="effective_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Effective Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="effective_date" id="effective_date" required
                                       min="{{ now()->format('Y-m-d') }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label for="change_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Change Type <span class="text-red-500">*</span>
                                </label>
                                <select name="change_type" id="change_type" required
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Change Type</option>
                                    <option value="market_adjustment">Market Rate Adjustment</option>
                                    <option value="risk_reassessment">Risk Reassessment</option>
                                    <option value="customer_request">Customer Request</option>
                                    <option value="promotional">Promotional Rate</option>
                                    <option value="restructure">Loan Restructure</option>
                                    <option value="regulatory">Regulatory Compliance</option>
                                </select>
                            </div>

                            <div>
                                <label for="justification" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Justification <span class="text-red-500">*</span>
                                </label>
                                <textarea name="justification" id="justification" rows="4" required
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Provide detailed justification for this rate change..."></textarea>
                            </div>

                            <div>
                                <label for="customer_notification" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Customer Notification
                                </label>
                                <textarea name="customer_notification" id="customer_notification" rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Optional: Custom message to include in customer notification"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Supporting Documents -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Supporting Documents</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="documents" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Upload Documents
                                </label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                            <label for="documents" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 focus-within:outline-none">
                                                <span>Upload files</span>
                                                <input id="documents" name="documents[]" type="file" class="sr-only" multiple accept=".pdf,.doc,.docx,.xls,.xlsx">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            PDF, DOC, XLS up to 10MB each
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Impact Analysis -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Impact Analysis</h4>
                        <div class="space-y-4">
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Monthly Payment Change</div>
                                <div class="text-lg font-medium text-gray-900 dark:text-white" id="payment_impact">
                                    Calculate after rate input
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Annual Revenue Impact</div>
                                <div class="text-lg font-medium text-gray-900 dark:text-white" id="revenue_impact">
                                    Calculate after rate input
                                </div>
                            </div>
                            
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                * Calculations are estimates based on current balance and remaining term
                            </div>
                        </div>
                    </div>

                    <!-- Approval Workflow -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Approval Workflow</h4>
                        <div class="space-y-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                <span class="text-sm text-gray-700 dark:text-gray-300">1. Credit Manager Review</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-2 h-2 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">2. Risk Assessment</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-2 h-2 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">3. Final Approval</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-2 h-2 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">4. Implementation</span>
                            </div>
                        </div>
                    </div>

                    <!-- Settings -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Additional Settings</h4>
                        <div class="space-y-4">
                            <div>
                                <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Priority</label>
                                <select name="priority" id="priority"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                    <option value="normal" selected>Normal</option>
                                    <option value="high">High</option>
                                    <option value="urgent">Urgent</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="notify_customer" value="1" checked
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Notify customer</span>
                                </label>
                            </div>

                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="auto_implement" value="1"
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Auto-implement if approved</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Actions</h4>
                        <div class="space-y-3">
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                Submit Rate Change Request
                            </button>
                            <button type="button" onclick="saveDraft()" class="w-full px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors">
                                Save as Draft
                            </button>
                            <a href="{{ route('credit-financing.rate-changes.index') }}" class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors text-center">
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

        // Calculate rate change when new rate is entered
        document.getElementById('new_rate').addEventListener('input', function() {
            const currentRate = parseFloat(document.getElementById('current_rate').value) || 0;
            const newRate = parseFloat(this.value) || 0;
            const change = newRate - currentRate;
            
            const changeField = document.getElementById('rate_change');
            if (changeField) {
                changeField.value = (change > 0 ? '+' : '') + change.toFixed(2);
                changeField.className = changeField.className.replace(/text-(red|green)-600/, '');
                changeField.classList.add(change > 0 ? 'text-red-600' : 'text-green-600');
            }

            // Update impact analysis
            updateImpactAnalysis(currentRate, newRate);
        });

        function updateImpactAnalysis(currentRate, newRate) {
            const balance = parseFloat(document.getElementById('current_balance').value?.replace(/[,$]/g, '')) || 0;
            
            if (balance > 0) {
                // Simplified calculation - actual implementation would consider remaining term, payment schedule, etc.
                const rateDiff = (newRate - currentRate) / 100;
                const monthlyImpact = (balance * rateDiff) / 12;
                const annualImpact = balance * rateDiff;
                
                document.getElementById('payment_impact').textContent = 
                    (monthlyImpact >= 0 ? '+' : '') + monthlyImpact.toLocaleString('en-US', {
                        style: 'currency',
                        currency: 'USD'
                    }) + '/month';
                    
                document.getElementById('revenue_impact').textContent = 
                    (annualImpact >= 0 ? '+' : '') + annualImpact.toLocaleString('en-US', {
                        style: 'currency',
                        currency: 'USD'
                    }) + '/year';
            }
        }

        // Mock account search functionality
        document.getElementById('account_search').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            
            // Sample data - in real implementation, this would be an AJAX call
            const sampleAccounts = {
                'cfa-2024-001': {
                    account_number: 'CFA-2024-001',
                    customer_name: 'ABC Manufacturing',
                    product_type: 'Business Loan',
                    current_balance: '125,000',
                    current_rate: '12.5'
                },
                'abc manufacturing': {
                    account_number: 'CFA-2024-001',
                    customer_name: 'ABC Manufacturing',
                    product_type: 'Business Loan', 
                    current_balance: '125,000',
                    current_rate: '12.5'
                }
            };
            
            if (sampleAccounts[query]) {
                const account = sampleAccounts[query];
                document.getElementById('account_number').value = account.account_number;
                document.getElementById('customer_name').value = account.customer_name;
                document.getElementById('product_type').value = account.product_type;
                document.getElementById('current_balance').value = account.current_balance;
                document.getElementById('current_rate').value = account.current_rate;
            }
        });
    </script>
@endsection