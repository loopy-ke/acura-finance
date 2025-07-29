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
                                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">Edit Disbursement</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl">
                    Edit Disbursement
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Modify disbursement details for {{ $disbursement->reference ?? 'DIS-2025-001' }}
                </p>
            </div>
        </div>

        <!-- Status Alert -->
        @if(($disbursement->status ?? 'pending') !== 'pending')
        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                        Limited Editing Available
                    </h3>
                    <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                        <p>This disbursement has been {{ $disbursement->status ?? 'processed' }}. Only certain fields can be modified.</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('credit-financing.disbursements.update', $disbursement->id ?? 1) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Loan Information (Read-only) -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Loan Account Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Loan Account
                                </label>
                                <input type="text" value="{{ $disbursement->loan_account ?? 'CFA-2024-001' }}" readonly
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Borrower Name
                                </label>
                                <input type="text" value="{{ $disbursement->borrower_name ?? 'ABC Manufacturing' }}" readonly
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Loan Type
                                </label>
                                <input type="text" value="{{ $disbursement->loan_type ?? 'Business Loan' }}" readonly
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Reference Number
                                </label>
                                <input type="text" value="{{ $disbursement->reference ?? 'DIS-2025-001' }}" readonly
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
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
                                           value="{{ $disbursement->amount ?? 125000 }}"
                                           {{ ($disbursement->status ?? 'pending') !== 'pending' ? 'readonly' : '' }}
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm {{ ($disbursement->status ?? 'pending') !== 'pending' ? 'bg-gray-50 dark:bg-gray-700' : 'bg-white dark:bg-gray-700' }} text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="disbursement_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Disbursement Type <span class="text-red-500">*</span>
                                    </label>
                                    <select name="disbursement_type" id="disbursement_type" required
                                            {{ ($disbursement->status ?? 'pending') !== 'pending' ? 'disabled' : '' }}
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm {{ ($disbursement->status ?? 'pending') !== 'pending' ? 'bg-gray-50 dark:bg-gray-700' : 'bg-white dark:bg-gray-700' }} text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="initial" {{ ($disbursement->type ?? 'initial') === 'initial' ? 'selected' : '' }}>Initial Disbursement</option>
                                        <option value="partial" {{ ($disbursement->type ?? 'initial') === 'partial' ? 'selected' : '' }}>Partial Disbursement</option>
                                        <option value="final" {{ ($disbursement->type ?? 'initial') === 'final' ? 'selected' : '' }}>Final Disbursement</option>
                                        <option value="advance" {{ ($disbursement->type ?? 'initial') === 'advance' ? 'selected' : '' }}>Construction Advance</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="scheduled_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Scheduled Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="scheduled_date" id="scheduled_date" required
                                           value="{{ ($disbursement->scheduled_date ?? now())->format('Y-m-d') }}"
                                           min="{{ now()->format('Y-m-d') }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="disbursement_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Disbursement Method <span class="text-red-500">*</span>
                                    </label>
                                    <select name="disbursement_method" id="disbursement_method" required
                                            {{ ($disbursement->status ?? 'pending') !== 'pending' ? 'disabled' : '' }}
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm {{ ($disbursement->status ?? 'pending') !== 'pending' ? 'bg-gray-50 dark:bg-gray-700' : 'bg-white dark:bg-gray-700' }} text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="ach" {{ ($disbursement->method ?? 'ach') === 'ach' ? 'selected' : '' }}>ACH Transfer</option>
                                        <option value="wire" {{ ($disbursement->method ?? 'ach') === 'wire' ? 'selected' : '' }}>Wire Transfer</option>
                                        <option value="check" {{ ($disbursement->method ?? 'ach') === 'check' ? 'selected' : '' }}>Check</option>
                                        <option value="direct_deposit" {{ ($disbursement->method ?? 'ach') === 'direct_deposit' ? 'selected' : '' }}>Direct Deposit</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="purpose" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Purpose of Disbursement <span class="text-red-500">*</span>
                                </label>
                                <textarea name="purpose" id="purpose" rows="3" required
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ $disbursement->purpose ?? 'Working capital for business operations and equipment purchase' }}</textarea>
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
                                           value="{{ $disbursement->bank_name ?? 'First National Bank' }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="account_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Account Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="account_name" id="account_name" required
                                           value="{{ $disbursement->account_name ?? 'ABC Manufacturing LLC' }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="routing_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Routing Number <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="routing_number" id="routing_number" required
                                           pattern="[0-9]{9}" maxlength="9"
                                           value="{{ $disbursement->routing_number ?? '123456789' }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="account_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Account Number <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="account_number" id="account_number" required
                                           value="{{ $disbursement->account_number ?? '1234567890' }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>

                            <div>
                                <label for="account_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Account Type <span class="text-red-500">*</span>
                                </label>
                                <select name="account_type" id="account_type" required
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="checking" {{ ($disbursement->account_type ?? 'business_checking') === 'checking' ? 'selected' : '' }}>Checking</option>
                                    <option value="savings" {{ ($disbursement->account_type ?? 'business_checking') === 'savings' ? 'selected' : '' }}>Savings</option>
                                    <option value="business_checking" {{ ($disbursement->account_type ?? 'business_checking') === 'business_checking' ? 'selected' : '' }}>Business Checking</option>
                                    <option value="business_savings" {{ ($disbursement->account_type ?? 'business_checking') === 'business_savings' ? 'selected' : '' }}>Business Savings</option>
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
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ $disbursement->special_instructions ?? '' }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="reference_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Reference Number
                                    </label>
                                    <input type="text" name="reference_number" id="reference_number"
                                           value="{{ $disbursement->reference_number ?? '' }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="fee_deduction" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Deduct Fees
                                    </label>
                                    <input type="number" name="fee_deduction" id="fee_deduction" step="0.01" min="0"
                                           value="{{ $disbursement->fee_deduction ?? 2500 }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>

                            <div>
                                <label for="edit_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Reason for Edit <span class="text-red-500">*</span>
                                </label>
                                <textarea name="edit_reason" id="edit_reason" rows="3" required
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Explain why this disbursement is being modified..."></textarea>
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
                                <span class="text-gray-500 dark:text-gray-400">Status:</span>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ ($disbursement->status ?? 'pending') === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : (($disbursement->status ?? 'pending') === 'processing' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400') }}">
                                    {{ ucfirst($disbursement->status ?? 'Pending') }}
                                </span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Created:</span>
                                <span class="text-gray-900 dark:text-white">{{ ($disbursement->created_at ?? now())->format('M j, Y') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Last Modified:</span>
                                <span class="text-gray-900 dark:text-white">{{ ($disbursement->updated_at ?? now())->format('M j, Y g:i A') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Change Log -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Change History</h4>
                        <div class="space-y-3">
                            @php
                                $changes = [
                                    ['field' => 'Scheduled Date', 'old' => 'Jan 15, 2025', 'new' => 'Jan 18, 2025', 'user' => 'John Smith', 'date' => '2025-01-10'],
                                    ['field' => 'Amount', 'old' => '$120,000', 'new' => '$125,000', 'user' => 'Sarah Johnson', 'date' => '2025-01-08'],
                                ];
                            @endphp

                            @forelse($changes as $change)
                            <div class="border-b border-gray-200 dark:border-gray-600 pb-3 last:border-b-0">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $change['field'] }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $change['old'] }} → {{ $change['new'] }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $change['user'] }} • {{ \Carbon\Carbon::parse($change['date'])->format('M j, Y') }}
                                </div>
                            </div>
                            @empty
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                No previous changes
                            </div>
                            @endforelse
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
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Notify relevant parties of changes</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Actions</h4>
                        <div class="space-y-3">
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                Update Disbursement
                            </button>
                            <a href="{{ route('credit-financing.disbursements.show', $disbursement->id ?? 1) }}" class="block w-full px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors text-center">
                                View Details
                            </a>
                            <a href="{{ route('credit-financing.disbursements.index') }}" class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors text-center">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection