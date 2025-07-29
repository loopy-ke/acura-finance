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
                                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">Limit Details</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <div class="flex items-center space-x-4">
                    <h1 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl">
                        {{ $limit->customer_name ?? 'ABC Manufacturing' }}
                    </h1>
                    <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full {{ ($limit->status ?? 'active') === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : (($limit->status ?? 'active') === 'under_review' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400') }}">
                        {{ ucfirst(str_replace('_', ' ', $limit->status ?? 'Active')) }}
                    </span>
                </div>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Account {{ $limit->account_number ?? 'CFA-2024-001' }} • Credit Limit {{ number_format($limit->credit_limit ?? 500000, 0) }}
                </p>
            </div>
            <div class="mt-4 flex space-x-3 sm:mt-0">
                <a href="{{ route('credit-financing.limits.edit', $limit->id ?? 1) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-full hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Edit Limit
                </a>
                <button type="button" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-full hover:bg-green-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Generate Report
                </button>
            </div>
        </div>

        <!-- Credit Limit Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @php
                $overview = [
                    ['label' => 'Credit Limit', 'value' => 500000, 'format' => 'currency', 'color' => 'blue'],
                    ['label' => 'Outstanding Balance', 'value' => 425000, 'format' => 'currency', 'color' => 'purple'],
                    ['label' => 'Available Credit', 'value' => 75000, 'format' => 'currency', 'color' => 'green'],
                    ['label' => 'Utilization Rate', 'value' => '85%', 'color' => 'red'],
                ];
            @endphp

            @foreach($overview as $item)
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-{{ $item['color'] }}-100 dark:bg-{{ $item['color'] }}-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-{{ $item['color'] }}-600 dark:text-{{ $item['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">{{ $item['label'] }}</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                @if(isset($item['format']) && $item['format'] === 'currency')
                                    {{ number_format($item['value'], 0) }}
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
            <!-- Credit Limit Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Customer Information -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Customer Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Account Number</dt>
                            <dd class="mt-1 text-sm font-mono text-gray-900 dark:text-white">{{ $limit->account_number ?? 'CFA-2024-001' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Customer Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $limit->customer_name ?? 'ABC Manufacturing' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Industry</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $limit->industry ?? 'Manufacturing' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Risk Grade</dt>
                            <dd class="mt-1">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                    {{ $limit->risk_grade ?? 'B+' }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Account Manager</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $limit->account_manager ?? 'John Smith' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Customer Since</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($limit->customer_since ?? '2021-06-15')->format('M j, Y') }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Credit Limit Information -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Credit Limit Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Credit Limit</dt>
                            <dd class="mt-1 text-sm font-mono text-gray-900 dark:text-white">{{ number_format($limit->credit_limit ?? 500000, 0) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Currency</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $limit->currency ?? 'USD' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Effective Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($limit->effective_date ?? '2024-01-15')->format('M j, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Expiry Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($limit->expiry_date ?? '2025-01-15')->format('M j, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Purpose</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $limit->purpose ?? 'working_capital')) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Review</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($limit->last_review ?? '2024-12-15')->format('M j, Y') }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Utilization History -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Utilization History</h3>
                    <div class="space-y-4">
                        @php
                            $utilizationHistory = [
                                ['month' => 'Jul 2025', 'outstanding' => 425000, 'utilization' => 85],
                                ['month' => 'Jun 2025', 'outstanding' => 390000, 'utilization' => 78],
                                ['month' => 'May 2025', 'outstanding' => 375000, 'utilization' => 75],
                                ['month' => 'Apr 2025', 'outstanding' => 350000, 'utilization' => 70],
                                ['month' => 'Mar 2025', 'outstanding' => 325000, 'utilization' => 65],
                                ['month' => 'Feb 2025', 'outstanding' => 300000, 'utilization' => 60],
                            ];
                        @endphp

                        @foreach($utilizationHistory as $history)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center space-x-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $history['month'] }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">{{ number_format($history['outstanding'], 0) }}</div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-24 bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                    <div class="h-2 rounded-full {{ $history['utilization'] >= 80 ? 'bg-red-500' : ($history['utilization'] >= 60 ? 'bg-yellow-500' : 'bg-green-500') }}" 
                                         style="width: {{ $history['utilization'] }}%"></div>
                                </div>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $history['utilization'] }}%</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Transaction Activity -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Recent Transaction Activity</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                                    <th class="py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Type</th>
                                    <th class="py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Amount</th>
                                    <th class="py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Balance</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @php
                                    $transactions = [
                                        ['date' => '2025-07-28', 'type' => 'Advance', 'amount' => 15000, 'balance' => 425000],
                                        ['date' => '2025-07-25', 'type' => 'Payment', 'amount' => -25000, 'balance' => 410000],
                                        ['date' => '2025-07-20', 'type' => 'Advance', 'amount' => 35000, 'balance' => 435000],
                                        ['date' => '2025-07-15', 'type' => 'Payment', 'amount' => -15000, 'balance' => 400000],
                                        ['date' => '2025-07-10', 'type' => 'Advance', 'amount' => 25000, 'balance' => 415000],
                                    ];
                                @endphp

                                @foreach($transactions as $transaction)
                                <tr>
                                    <td class="py-2 text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($transaction['date'])->format('M j, Y') }}</td>
                                    <td class="py-2 text-sm text-gray-900 dark:text-white">{{ $transaction['type'] }}</td>
                                    <td class="py-2 text-right text-sm font-medium {{ $transaction['amount'] > 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                        {{ $transaction['amount'] > 0 ? '+' : '' }}{{ number_format($transaction['amount'], 0) }}
                                    </td>
                                    <td class="py-2 text-right text-sm text-gray-900 dark:text-white">{{ number_format($transaction['balance'], 0) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Limit Status -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Limit Status</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 dark:text-gray-400">Status:</span>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                {{ ucfirst($limit->status ?? 'Active') }}
                            </span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 dark:text-gray-400">Days to Expiry:</span>
                            <span class="text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($limit->expiry_date ?? '2025-01-15')->diffInDays(now()) }} days</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 dark:text-gray-400">Next Review:</span>
                            <span class="text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($limit->next_review ?? '2025-09-15')->format('M j, Y') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 dark:text-gray-400">Last Modified:</span>
                            <span class="text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($limit->updated_at ?? now())->format('M j, Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Risk Assessment -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Risk Assessment</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 dark:text-gray-400">Payment History:</span>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                Excellent
                            </span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 dark:text-gray-400">DSCR:</span>
                            <span class="text-gray-900 dark:text-white">1.45</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 dark:text-gray-400">Current Ratio:</span>
                            <span class="text-gray-900 dark:text-white">2.1</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 dark:text-gray-400">Credit Score:</span>
                            <span class="text-green-600 dark:text-green-400">785</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Changes -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Recent Changes</h4>
                    <div class="space-y-3">
                        @php
                            $changes = [
                                ['date' => '2024-12-15', 'change' => 'Annual Review Completed', 'user' => 'Sarah Johnson'],
                                ['date' => '2024-06-01', 'change' => 'Limit Increased to $500K', 'user' => 'John Smith'],
                                ['date' => '2024-01-15', 'change' => 'Initial Limit Established', 'user' => 'Mike Davis'],
                            ];
                        @endphp

                        @foreach($changes as $change)
                        <div class="border-b border-gray-200 dark:border-gray-600 pb-3 last:border-b-0">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $change['change'] }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $change['user'] }} • {{ \Carbon\Carbon::parse($change['date'])->format('M j, Y') }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Alerts -->
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-6">
                    <h4 class="text-lg font-medium text-red-900 dark:text-red-100 mb-4">Alerts</h4>
                    <div class="space-y-3">
                        <div class="flex items-start space-x-2">
                            <div class="flex-shrink-0">
                                <svg class="w-4 h-4 text-red-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-red-900 dark:text-red-100">High Utilization</div>
                                <div class="text-xs text-red-700 dark:text-red-300">85% of credit limit utilized</div>
                            </div>
                        </div>
                        <div class="flex items-start space-x-2">
                            <div class="flex-shrink-0">
                                <svg class="w-4 h-4 text-yellow-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-yellow-900 dark:text-yellow-100">Review Due Soon</div>
                                <div class="text-xs text-yellow-700 dark:text-yellow-300">Next review scheduled for Sep 15, 2025</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6">
                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Quick Actions</h4>
                    <div class="space-y-3">
                        <button class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Schedule Review
                        </button>
                        <button class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                            </svg>
                            Request Increase
                        </button>
                        <button class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Download Statement
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection