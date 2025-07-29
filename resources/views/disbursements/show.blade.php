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
                                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">Disbursement Details</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <div class="flex items-center space-x-4">
                    <h1 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl">
                        {{ $disbursement->reference ?? 'DIS-2025-001' }}
                    </h1>
                    <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full {{ ($disbursement->status ?? 'completed') === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : (($disbursement->status ?? 'completed') === 'processing' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : (($disbursement->status ?? 'completed') === 'failed' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400')) }}">
                        {{ ucfirst($disbursement->status ?? 'Completed') }}
                    </span>
                </div>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Disbursement to {{ $disbursement->borrower_name ?? 'ABC Manufacturing' }} • {{ \Carbon\Carbon::parse($disbursement->scheduled_date ?? '2025-07-28')->format('M j, Y') }}
                </p>
            </div>
            <div class="mt-4 flex space-x-3 sm:mt-0">
                @if(($disbursement->status ?? 'completed') === 'pending')
                <button type="button" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-full hover:bg-green-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Process Disbursement
                </button>
                @elseif(($disbursement->status ?? 'completed') === 'failed')
                <button type="button" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-full hover:bg-red-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Retry Disbursement
                </button>
                @endif
                <button type="button" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-full hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Download Receipt
                </button>
            </div>
        </div>

        <!-- Disbursement Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @php
                $overview = [
                    ['label' => 'Disbursement Amount', 'value' => 125000, 'format' => 'currency', 'color' => 'blue'],
                    ['label' => 'Fees Deducted', 'value' => 2500, 'format' => 'currency', 'color' => 'red'],
                    ['label' => 'Net Amount', 'value' => 122500, 'format' => 'currency', 'color' => 'green'],
                    ['label' => 'Processing Time', 'value' => '2.5 hrs', 'color' => 'purple'],
                ];
            @endphp

            @foreach($overview as $item)
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-{{ $item['color'] }}-100 dark:bg-{{ $item['color'] }}-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-{{ $item['color'] }}-600 dark:text-{{ $item['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">{{ $item['label'] }}</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                @if(isset($item['format']) && $item['format'] === 'currency')
                                    {{ number_format($item['value'], 2) }}
                                @else
                                    {{ $item['value'] }}
                                @endif
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Disbursement Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Loan Information -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Loan Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Loan Account</dt>
                            <dd class="mt-1 text-sm font-mono text-gray-900 dark:text-white">{{ $disbursement->loan_account ?? 'CFA-2024-001' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Borrower</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $disbursement->borrower_name ?? 'ABC Manufacturing' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Loan Type</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $disbursement->loan_type ?? 'Business Loan' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Loan Officer</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $disbursement->loan_officer ?? 'John Smith' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Approved</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ number_format($disbursement->approved_amount ?? 125000, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Remaining Balance</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ number_format($disbursement->remaining_balance ?? 0, 2) }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Banking Information -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Banking Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Bank Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $disbursement->bank_name ?? 'First National Bank' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Account Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $disbursement->account_name ?? 'ABC Manufacturing LLC' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Routing Number</dt>
                            <dd class="mt-1 text-sm font-mono text-gray-900 dark:text-white">{{ $disbursement->routing_number ?? '123456789' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Account Number</dt>
                            <dd class="mt-1 text-sm font-mono text-gray-900 dark:text-white">****{{ substr($disbursement->account_number ?? '1234567890', -4) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Account Type</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $disbursement->account_type ?? 'business_checking')) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Method</dt>
                            <dd class="mt-1">
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                    {{ $disbursement->method ?? 'ACH Transfer' }}
                                </span>
                            </dd>
                        </div>
                    </div>
                </div>

                <!-- Disbursement Timeline -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Processing Timeline</h3>
                    <div class="flow-root">
                        <ul class="-mb-8">
                            @php
                                $timeline = [
                                    ['event' => 'Disbursement Requested', 'user' => 'John Smith', 'date' => '2025-07-28 09:00', 'status' => 'completed'],
                                    ['event' => 'Approval Received', 'user' => 'Sarah Johnson', 'date' => '2025-07-28 09:15', 'status' => 'completed'],
                                    ['event' => 'Banking Details Verified', 'user' => 'System', 'date' => '2025-07-28 09:30', 'status' => 'completed'],
                                    ['event' => 'Funds Transfer Initiated', 'user' => 'System', 'date' => '2025-07-28 10:00', 'status' => 'completed'],
                                    ['event' => 'Transfer Confirmed', 'user' => 'First National Bank', 'date' => '2025-07-28 11:30', 'status' => 'completed'],
                                ];
                            @endphp

                            @foreach($timeline as $index => $event)
                            <li>
                                <div class="relative pb-8">
                                    @if($index < count($timeline) - 1)
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-600" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white dark:ring-gray-800 {{ $event['status'] === 'completed' ? 'bg-green-500' : 'bg-gray-400' }}">
                                                @if($event['status'] === 'completed')
                                                    <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                @else
                                                    <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                    </svg>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div>
                                                <div class="text-sm text-gray-900 dark:text-white">
                                                    {{ $event['event'] }}
                                                </div>
                                                <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $event['user'] }} • {{ \Carbon\Carbon::parse($event['date'])->format('M j, Y g:i A') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Transaction Details -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Transaction Details</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 dark:text-gray-400">Reference Number:</span>
                            <span class="font-mono text-gray-900 dark:text-white">{{ $disbursement->reference ?? 'DIS-2025-001' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 dark:text-gray-400">Transaction ID:</span>
                            <span class="font-mono text-gray-900 dark:text-white">{{ $disbursement->transaction_id ?? 'TXN-789456123' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 dark:text-gray-400">Scheduled Date:</span>
                            <span class="text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($disbursement->scheduled_date ?? '2025-07-28')->format('M j, Y') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 dark:text-gray-400">Processed Date:</span>
                            <span class="text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($disbursement->processed_date ?? '2025-07-28')->format('M j, Y g:i A') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 dark:text-gray-400">Created By:</span>
                            <span class="text-gray-900 dark:text-white">{{ $disbursement->created_by ?? 'John Smith' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Fee Breakdown -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Fee Breakdown</h4>
                    <div class="space-y-3">
                        @php
                            $fees = [
                                ['label' => 'Processing Fee', 'amount' => 500],
                                ['label' => 'Wire Transfer Fee', 'amount' => 25],
                                ['label' => 'Documentation Fee', 'amount' => 150],
                            ];
                        @endphp

                        @foreach($fees as $fee)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">{{ $fee['label'] }}:</span>
                            <span class="text-gray-900 dark:text-white">{{ number_format($fee['amount'], 2) }}</span>
                        </div>
                        @endforeach
                        
                        <div class="border-t border-gray-200 dark:border-gray-600 pt-3">
                            <div class="flex justify-between text-sm font-bold">
                                <span class="text-gray-900 dark:text-white">Total Fees:</span>
                                <span class="text-red-600 dark:text-red-400">{{ number_format(array_sum(array_column($fees, 'amount')), 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Supporting Documents -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Documents</h4>
                    <div class="space-y-3">
                        @php
                            $documents = [
                                ['name' => 'Disbursement Authorization', 'type' => 'PDF', 'size' => '245 KB'],
                                ['name' => 'Banking Verification', 'type' => 'PDF', 'size' => '128 KB'],
                                ['name' => 'Wire Transfer Receipt', 'type' => 'PDF', 'size' => '89 KB'],
                            ];
                        @endphp

                        @foreach($documents as $doc)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $doc['name'] }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $doc['type'] }} • {{ $doc['size'] }}</div>
                                </div>
                            </div>
                            <button class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 text-sm font-medium">
                                Download
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6">
                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Quick Actions</h4>
                    <div class="space-y-3">
                        <button class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Email Confirmation
                        </button>
                        <button class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2v0M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                            </svg>
                            Duplicate Transaction
                        </button>
                        <button class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                            Edit Details
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection