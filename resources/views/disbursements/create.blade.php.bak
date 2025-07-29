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
                                <a href="{{ route('credit-financing.disbursements.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400 hover:text-blue-600 dark:hover:text-white">
                                    Disbursements
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">New Disbursement</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl">
                    New Loan Disbursement
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Process fund disbursement for an approved loan
                </p>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('credit-financing.disbursements.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Loan Selection -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Loan Account Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="loan_search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Search Approved Loan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" name="loan_search" id="loan_search" required
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Enter loan account or borrower name">
                                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label for="loan_account" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Loan Account
                                </label>
                                <input type="text" name="loan_account" id="loan_account" readonly
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
                                       placeholder="Will be populated after search">
                            </div>

                            <div>
                                <label for="borrower_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Borrower Name
                                </label>
                                <input type="text" name="borrower_name" id="borrower_name" readonly
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
                                       placeholder="Will be populated after search">
                            </div>

                            <div>
                                <label for="loan_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Loan Type
                                </label>
                                <input type="text" name="loan_type" id="loan_type" readonly
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
                                       placeholder="Will be populated after search">
                            </div>

                            <div>
                                <label for="approved_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Approved Amount
                                </label>
                                <input type="text" name="approved_amount" id="approved_amount" readonly
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
                                       placeholder="Will be populated after search">
                            </div>

                            <div>
                                <label for="remaining_balance" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Available for Disbursement
                                </label>
                                <input type="text" name="remaining_balance" id="remaining_balance" readonly
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
                                       placeholder="Will be populated after search">
                            </div>
                        </div>
                    </div>

                    <!-- Disbursement Details -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Disbursement Details</h3>
                        
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="disbursement_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Disbursement Amount <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="disbursement_amount" id="disbursement_amount" step="0.01" min="0" required
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="0.00">
                                </div>

                                <div>
                                    <label for="disbursement_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Disbursement Type <span class="text-red-500">*</span>
                                    </label>
                                    <select name="disbursement_type" id="disbursement_type" required
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select Type</option>
                                        <option value="initial">Initial Disbursement</option>
                                        <option value="partial">Partial Disbursement</option>
                                        <option value="final">Final Disbursement</option>
                                        <option value="advance">Construction Advance</option>
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
                                           value="{{ now()->format('Y-m-d') }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="disbursement_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Disbursement Method <span class="text-red-500">*</span>
                                    </label>
                                    <select name="disbursement_method" id="disbursement_method" required
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select Method</option>
                                        <option value="ach">ACH Transfer</option>
                                        <option value="wire">Wire Transfer</option>
                                        <option value="check">Check</option>
                                        <option value="direct_deposit">Direct Deposit</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="purpose" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Purpose of Disbursement <span class="text-red-500">*</span>
                                </label>
                                <textarea name="purpose" id="purpose" rows="3" required
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Describe the purpose and use of funds..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Banking Information -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Banking Information</h3>
                        
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="bank_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Bank Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="bank_name" id="bank_name" required
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Enter bank name">
                                </div>

                                <div>
                                    <label for="account_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Account Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="account_name" id="account_name" required
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Account holder name">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="routing_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Routing Number <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="routing_number" id="routing_number" required
                                           pattern="[0-9]{9}" maxlength="9"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="9-digit routing number">
                                </div>

                                <div>
                                    <label for="account_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Account Number <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="account_number" id="account_number" required
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Bank account number">
                                </div>
                            </div>

                            <div>
                                <label for="account_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Account Type <span class="text-red-500">*</span>
                                </label>
                                <select name="account_type" id="account_type" required
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Account Type</option>
                                    <option value="checking">Checking</option>
                                    <option value="savings">Savings</option>
                                    <option value="business_checking">Business Checking</option>
                                    <option value="business_savings">Business Savings</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Additional Information</h3>
                        
                        <div class="space-y-6">
                            <div>
                                <label for="special_instructions" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Special Instructions
                                </label>
                                <textarea name="special_instructions" id="special_instructions" rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Any special instructions for the disbursement..."></textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="reference_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Reference Number
                                    </label>
                                    <input type="text" name="reference_number" id="reference_number"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Optional reference number">
                                </div>

                                <div>
                                    <label for="fee_deduction" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Deduct Fees
                                    </label>
                                    <input type="number" name="fee_deduction" id="fee_deduction" step="0.01" min="0"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="0.00">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Disbursement Summary -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Disbursement Summary</h4>
                        <div class="space-y-3" id="disbursement_summary">
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                Summary will appear after entering amount
                            </div>
                        </div>
                    </div>

                    <!-- Loan Details -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Loan Details</h4>
                        <div class="space-y-3" id="loan_details">
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                Select a loan to view details
                            </div>
                        </div>
                    </div>

                    <!-- Previous Disbursements -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Previous Disbursements</h4>
                        <div class="space-y-3" id="previous_disbursements">
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                No previous disbursements
                            </div>
                        </div>
                    </div>

                    <!-- Verification -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Verification</h4>
                        <div class="space-y-4">
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="verify_borrower" value="1" required
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Borrower identity verified</span>
                                </label>
                            </div>

                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="verify_banking" value="1" required
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Banking details verified</span>
                                </label>
                            </div>

                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="verify_conditions" value="1" required
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Loan conditions met</span>
                                </label>
                            </div>

                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="send_notification" value="1" checked
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Send notification to borrower</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Actions</h4>
                        <div class="space-y-3">
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                Submit Disbursement
                            </button>
                            <button type="button" onclick="saveDraft()" class="w-full px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors">
                                Save as Draft
                            </button>
                            <a href="{{ route('credit-financing.disbursements.index') }}" class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors text-center">
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

        // Update disbursement summary when amount changes
        document.getElementById('disbursement_amount').addEventListener('input', function() {
            const amount = parseFloat(this.value) || 0;
            const fee = parseFloat(document.getElementById('fee_deduction').value) || 0;
            const netAmount = amount - fee;
            
            updateDisbursementSummary(amount, fee, netAmount);
        });

        document.getElementById('fee_deduction').addEventListener('input', function() {
            const amount = parseFloat(document.getElementById('disbursement_amount').value) || 0;
            const fee = parseFloat(this.value) || 0;
            const netAmount = amount - fee;
            
            updateDisbursementSummary(amount, fee, netAmount);
        });

        function updateDisbursementSummary(amount, fee, netAmount) {
            const summaryContainer = document.getElementById('disbursement_summary');
            summaryContainer.innerHTML = `
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Disbursement Amount:</span>
                        <span class="font-medium text-gray-900 dark:text-white">${amount.toLocaleString('en-US', {style: 'currency', currency: 'USD'})}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Less: Fees:</span>
                        <span class="font-medium text-red-600 dark:text-red-400">-${fee.toLocaleString('en-US', {style: 'currency', currency: 'USD'})}</span>
                    </div>
                    <div class="border-t border-gray-200 dark:border-gray-600 pt-2">
                        <div class="flex justify-between text-sm font-bold">
                            <span class="text-gray-900 dark:text-white">Net Amount:</span>
                            <span class="text-green-600 dark:text-green-400">${netAmount.toLocaleString('en-US', {style: 'currency', currency: 'USD'})}</span>
                        </div>
                    </div>
                </div>
            `;
        }

        // Mock loan search functionality
        document.getElementById('loan_search').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            
            // Sample data
            const sampleLoans = {
                'cfa-2024-001': {
                    loan_account: 'CFA-2024-001',
                    borrower_name: 'ABC Manufacturing',
                    loan_type: 'Business Loan',
                    approved_amount: '125,000',
                    remaining_balance: '125,000'
                },
                'abc manufacturing': {
                    loan_account: 'CFA-2024-001',
                    borrower_name: 'ABC Manufacturing',
                    loan_type: 'Business Loan',
                    approved_amount: '125,000',
                    remaining_balance: '125,000'
                }
            };
            
            if (sampleLoans[query]) {
                const loan = sampleLoans[query];
                document.getElementById('loan_account').value = loan.loan_account;
                document.getElementById('borrower_name').value = loan.borrower_name;
                document.getElementById('loan_type').value = loan.loan_type;
                document.getElementById('approved_amount').value = loan.approved_amount;
                document.getElementById('remaining_balance').value = loan.remaining_balance;
                
                updateLoanDetails();
                updatePreviousDisbursements();
            }
        });

        function updateLoanDetails() {
            const detailsContainer = document.getElementById('loan_details');
            detailsContainer.innerHTML = `
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Approval Date:</span>
                        <span class="text-gray-900 dark:text-white">Dec 15, 2024</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Interest Rate:</span>
                        <span class="text-gray-900 dark:text-white">12.5%</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Term:</span>
                        <span class="text-gray-900 dark:text-white">24 months</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Status:</span>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span>
                    </div>
                </div>
            `;
        }

        function updatePreviousDisbursements() {
            const historyContainer = document.getElementById('previous_disbursements');
            historyContainer.innerHTML = `
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    No previous disbursements for this loan
                </div>
            `;
        }

        // Validate routing number
        document.getElementById('routing_number').addEventListener('input', function() {
            const routingNumber = this.value;
            if (routingNumber.length === 9) {
                // Simple validation - in real implementation, use proper routing number validation
                if (!/^\d{9}$/.test(routingNumber)) {
                    this.setCustomValidity('Please enter a valid 9-digit routing number');
                } else {
                    this.setCustomValidity('');
                }
            }
        });
    </script>
@endsection