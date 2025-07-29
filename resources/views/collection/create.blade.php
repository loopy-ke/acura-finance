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
                                <a href="{{ route('credit-financing.collection.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400 hover:text-blue-600 dark:hover:text-white">
                                    Collections
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">New Collection Action</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl">
                    New Collection Action
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Record a new collection activity or create a collection case
                </p>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('credit-financing.collection.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Action Type -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Action Type</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label class="relative">
                                <input type="radio" name="action_type" value="phone_call" class="sr-only peer" checked>
                                <div class="p-4 border-2 border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-white">Phone Call</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">Record a phone conversation</div>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <label class="relative">
                                <input type="radio" name="action_type" value="email" class="sr-only peer">
                                <div class="p-4 border-2 border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-white">Email</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">Send payment reminder</div>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <label class="relative">
                                <input type="radio" name="action_type" value="letter" class="sr-only peer">
                                <div class="p-4 border-2 border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-white">Formal Letter</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">Send demand letter</div>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <label class="relative">
                                <input type="radio" name="action_type" value="note" class="sr-only peer">
                                <div class="p-4 border-2 border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-white">Add Note</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">Record observation or update</div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Customer Selection -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Customer Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="customer_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Customer <span class="text-red-500">*</span>
                                </label>
                                <select name="customer_id" id="customer_id" required
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Customer</option>
                                    <option value="1">ABC Manufacturing</option>
                                    <option value="2">XYZ Corporation</option>
                                    <option value="3">Global Enterprises</option>
                                    <option value="4">Local Business LLC</option>
                                    <option value="5">Tech Solutions Inc</option>
                                </select>
                            </div>

                            <div>
                                <label for="account_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Account Number
                                </label>
                                <input type="text" name="account_number" id="account_number"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="CFA-2024-001">
                            </div>

                            <div>
                                <label for="outstanding_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Outstanding Amount
                                </label>
                                <input type="number" name="outstanding_amount" id="outstanding_amount" step="0.01"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="0.00">
                            </div>

                            <div>
                                <label for="days_overdue" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Days Overdue
                                </label>
                                <input type="number" name="days_overdue" id="days_overdue"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="30">
                            </div>
                        </div>
                    </div>

                    <!-- Action Details -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Action Details</h3>
                        
                        <div class="space-y-6">
                            <div>
                                <label for="action_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Action Date <span class="text-red-500">*</span>
                                </label>
                                <input type="datetime-local" name="action_date" id="action_date" required
                                       value="{{ now()->format('Y-m-d\TH:i') }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label for="outcome" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Outcome
                                </label>
                                <select name="outcome" id="outcome"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Outcome</option>
                                    <option value="contacted">Successfully Contacted</option>
                                    <option value="no_answer">No Answer</option>
                                    <option value="busy">Line Busy</option>
                                    <option value="voicemail">Left Voicemail</option>
                                    <option value="payment_promised">Payment Promised</option>
                                    <option value="dispute">Customer Disputes</option>
                                    <option value="hardship">Financial Hardship</option>
                                    <option value="payment_plan">Payment Plan Agreed</option>
                                </select>
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Description <span class="text-red-500">*</span>
                                </label>
                                <textarea name="description" id="description" rows="4" required
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Describe the collection activity and any customer response..."></textarea>
                            </div>

                            <div>
                                <label for="next_action" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Next Action
                                </label>
                                <textarea name="next_action" id="next_action" rows="2"
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="What should be done next?"></textarea>
                            </div>

                            <div>
                                <label for="follow_up_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Follow-up Date
                                </label>
                                <input type="date" name="follow_up_date" id="follow_up_date"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Priority -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Priority & Assignment</h4>
                        <div class="space-y-4">
                            <div>
                                <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Priority</label>
                                <select name="priority" id="priority"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                    <option value="low">Low</option>
                                    <option value="medium" selected>Medium</option>
                                    <option value="high">High</option>
                                    <option value="urgent">Urgent</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="assigned_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Assigned To</label>
                                <select name="assigned_to" id="assigned_to"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                    <option value="">Unassigned</option>
                                    <option value="john_smith">John Smith</option>
                                    <option value="sarah_johnson">Sarah Johnson</option>
                                    <option value="mike_davis">Mike Davis</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Case Status</h4>
                        <div class="space-y-4">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                                <select name="status" id="status"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                    <option value="new">New</option>
                                    <option value="in_progress" selected>In Progress</option>
                                    <option value="pending_customer">Pending Customer</option>
                                    <option value="resolved">Resolved</option>
                                    <option value="written_off">Written Off</option>
                                </select>
                            </div>

                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="create_case" value="1" 
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Create new collection case</span>
                                </label>
                            </div>

                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="send_notifications" value="1" checked
                                           class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Send notifications</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Actions</h4>
                        <div class="space-y-3">
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                Save Collection Action
                            </button>
                            <button type="button" onclick="saveDraft()" class="w-full px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors">
                                Save as Draft
                            </button>
                            <a href="{{ route('credit-financing.collection.index') }}" class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors text-center">
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
            // Add draft save functionality
            alert('Draft saved successfully!');
        }

        // Auto-populate account details when customer is selected
        document.getElementById('customer_id').addEventListener('change', function() {
            const customerId = this.value;
            if (customerId) {
                // In a real implementation, this would fetch customer data via AJAX
                document.getElementById('account_number').value = 'CFA-2024-' + customerId.padStart(3, '0');
                
                // Sample data based on selection
                const customerData = {
                    '1': { amount: 15000, days: 45 },
                    '2': { amount: 8500, days: 32 },
                    '3': { amount: 22000, days: 78 },
                    '4': { amount: 5200, days: 15 },
                    '5': { amount: 12750, days: 92 }
                };
                
                if (customerData[customerId]) {
                    document.getElementById('outstanding_amount').value = customerData[customerId].amount;
                    document.getElementById('days_overdue').value = customerData[customerId].days;
                }
            }
        });
    </script>
@endsection