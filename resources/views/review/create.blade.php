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
                                <a href="{{ route('credit-financing.review.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400 hover:text-blue-600 dark:hover:text-white">
                                    Credit Review
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">Schedule Review</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl">
                    Schedule Credit Review
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Schedule a comprehensive credit review for an existing loan account
                </p>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('credit-financing.review.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Account Selection -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Account Information</h3>
                        
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
                                    Outstanding Balance
                                </label>
                                <input type="text" name="current_balance" id="current_balance" readonly
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
                        </div>
                    </div>

                    <!-- Review Details -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Review Details</h3>
                        
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="review_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Review Type <span class="text-red-500">*</span>
                                    </label>
                                    <select name="review_type" id="review_type" required
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select Review Type</option>
                                        <option value="annual">Annual Review</option>
                                        <option value="quarterly">Quarterly Review</option>
                                        <option value="semi_annual">Semi-Annual Review</option>
                                        <option value="triggered">Risk Triggered Review</option>
                                        <option value="regulatory">Regulatory Review</option>
                                        <option value="special">Special Review</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Priority <span class="text-red-500">*</span>
                                    </label>
                                    <select name="priority" id="priority" required
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="normal" selected>Normal</option>
                                        <option value="high">High</option>
                                        <option value="urgent">Urgent</option>
                                        <option value="critical">Critical</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="scheduled_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Scheduled Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="scheduled_date" id="scheduled_date" required
                                           min="{{ now()->format('Y-m-d') }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="due_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Due Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="due_date" id="due_date" required
                                           min="{{ now()->format('Y-m-d') }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>

                            <div>
                                <label for="assigned_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Assign To <span class="text-red-500">*</span>
                                </label>
                                <select name="assigned_to" id="assigned_to" required
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Reviewer</option>
                                    <option value="john_smith">John Smith - Senior Credit Analyst</option>
                                    <option value="sarah_johnson">Sarah Johnson - Credit Manager</option>
                                    <option value="mike_davis">Mike Davis - Risk Analyst</option>
                                    <option value="lisa_brown">Lisa Brown - Senior Underwriter</option>
                                </select>
                            </div>

                            <div>
                                <label for="review_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Review Reason/Trigger <span class="text-red-500">*</span>
                                </label>
                                <textarea name="review_reason" id="review_reason" rows="3" required
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Explain the reason for scheduling this review..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Review Scope -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Review Scope</h3>
                        
                        <div class="space-y-4">
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                Select the areas to be covered in this credit review:
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <input type="checkbox" name="scope[]" value="financial_performance" checked
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">Financial Performance</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Review financial statements and ratios</div>
                                    </div>
                                </label>

                                <label class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <input type="checkbox" name="scope[]" value="payment_history" checked
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">Payment History</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Analyze payment patterns and delinquencies</div>
                                    </div>
                                </label>

                                <label class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <input type="checkbox" name="scope[]" value="collateral_valuation" checked
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">Collateral Valuation</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Update collateral values and coverage</div>
                                    </div>
                                </label>

                                <label class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <input type="checkbox" name="scope[]" value="industry_analysis"
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">Industry Analysis</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Assess industry trends and outlook</div>
                                    </div>
                                </label>

                                <label class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <input type="checkbox" name="scope[]" value="covenant_compliance" checked
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">Covenant Compliance</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Check compliance with loan covenants</div>
                                    </div>
                                </label>

                                <label class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <input type="checkbox" name="scope[]" value="risk_reassessment" checked
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">Risk Reassessment</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Update risk rating and provisions</div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Special Instructions -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Special Instructions</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="special_instructions" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Additional Instructions
                                </label>
                                <textarea name="special_instructions" id="special_instructions" rows="4"
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Any specific areas of focus or special considerations for this review..."></textarea>
                            </div>

                            <div>
                                <label for="required_documents" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Required Documents
                                </label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="required_documents[]" value="financial_statements" checked
                                               class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Financial Statements</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="required_documents[]" value="tax_returns"
                                               class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Tax Returns</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="required_documents[]" value="accounts_receivable" checked
                                               class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">A/R Aging Report</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="required_documents[]" value="inventory_report"
                                               class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Inventory Report</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="required_documents[]" value="collateral_appraisal"
                                               class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Collateral Appraisal</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="required_documents[]" value="cash_flow_projections"
                                               class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Cash Flow Projections</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Review History -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Previous Reviews</h4>
                        <div class="space-y-3" id="review_history">
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                Select an account to view review history
                            </div>
                        </div>
                    </div>

                    <!-- Risk Indicators -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Risk Indicators</h4>
                        <div class="space-y-3" id="risk_indicators">
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                Risk indicators will appear after account selection
                            </div>
                        </div>
                    </div>

                    <!-- Notification Settings -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Notification Settings</h4>
                        <div class="space-y-4">
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="notify_reviewer" value="1" checked
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Notify assigned reviewer</span>
                                </label>
                            </div>

                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="notify_manager" value="1" checked
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Notify credit manager</span>
                                </label>
                            </div>

                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="send_reminders" value="1" checked
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Send reminder notifications</span>
                                </label>
                            </div>

                            <div>
                                <label for="reminder_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Reminder Days Before Due
                                </label>
                                <select name="reminder_days" id="reminder_days"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                    <option value="1">1 day</option>
                                    <option value="3" selected>3 days</option>
                                    <option value="7">7 days</option>
                                    <option value="14">14 days</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Actions</h4>
                        <div class="space-y-3">
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                Schedule Review
                            </button>
                            <button type="button" onclick="saveDraft()" class="w-full px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors">
                                Save as Draft
                            </button>
                            <a href="{{ route('credit-financing.review.index') }}" class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors text-center">
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

        // Auto-set due date when scheduled date changes
        document.getElementById('scheduled_date').addEventListener('change', function() {
            const scheduledDate = new Date(this.value);
            const dueDate = new Date(scheduledDate);
            dueDate.setDate(scheduledDate.getDate() + 14); // Add 14 days
            
            document.getElementById('due_date').value = dueDate.toISOString().split('T')[0];
        });

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
                    current_risk_grade: 'B+'
                },
                'abc manufacturing': {
                    account_number: 'CFA-2024-001',
                    customer_name: 'ABC Manufacturing',
                    product_type: 'Business Loan',
                    current_balance: '125,000',
                    current_risk_grade: 'B+'
                }
            };
            
            if (sampleAccounts[query]) {
                const account = sampleAccounts[query];
                document.getElementById('account_number').value = account.account_number;
                document.getElementById('customer_name').value = account.customer_name;
                document.getElementById('product_type').value = account.product_type;
                document.getElementById('current_balance').value = account.current_balance;
                document.getElementById('current_risk_grade').value = account.current_risk_grade;
                
                // Update review history
                updateReviewHistory();
                updateRiskIndicators();
            }
        });

        function updateReviewHistory() {
            const historyContainer = document.getElementById('review_history');
            historyContainer.innerHTML = `
                <div class="space-y-2">
                    <div class="text-xs text-gray-500 dark:text-gray-400">Last Review: Dec 15, 2023</div>
                    <div class="text-xs bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 px-2 py-1 rounded">Satisfactory</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Next Scheduled: Dec 15, 2024</div>
                </div>
            `;
        }

        function updateRiskIndicators() {
            const indicatorsContainer = document.getElementById('risk_indicators');
            indicatorsContainer.innerHTML = `
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-600 dark:text-gray-400">Payment Status</span>
                        <span class="text-xs bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 px-2 py-1 rounded">Current</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-600 dark:text-gray-400">Covenant Status</span>
                        <span class="text-xs bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 px-2 py-1 rounded">Compliant</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-600 dark:text-gray-400">Collateral Coverage</span>
                        <span class="text-xs bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400 px-2 py-1 rounded">125%</span>
                    </div>
                </div>
            `;
        }
    </script>
@endsection