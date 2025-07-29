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
                                <a href="{{ route('credit-financing.reports.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400 hover:text-blue-600 dark:hover:text-white">
                                    Credit Reports
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">Aging Report</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl">
                    Aging Report
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Track overdue accounts and payment aging across different time buckets
                </p>
            </div>
            <div class="mt-4 flex space-x-3 sm:mt-0">
                <button type="button" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-full hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export Report
                </button>
            </div>
        </div>

        <!-- Aging Summary -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
            @php
                $agingSummary = [
                    ['label' => 'Current', 'count' => 1198, 'value' => 11850000, 'percentage' => 94.8, 'color' => 'green'],
                    ['label' => '1-30 Days', 'count' => 28, 'value' => 385000, 'percentage' => 2.2, 'color' => 'yellow'],
                    ['label' => '31-60 Days', 'count' => 12, 'value' => 195000, 'percentage' => 1.6, 'color' => 'orange'],
                    ['label' => '61-90 Days', 'count' => 6, 'value' => 105000, 'percentage' => 0.8, 'color' => 'red'],
                    ['label' => '90+ Days', 'count' => 3, 'value' => 65000, 'percentage' => 0.5, 'color' => 'red'],
                ];
            @endphp

            @foreach($agingSummary as $bucket)
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-{{ $bucket['color'] }}-100 dark:bg-{{ $bucket['color'] }}-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-{{ $bucket['color'] }}-600 dark:text-{{ $bucket['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">{{ $bucket['label'] }}</dt>
                            <dd class="flex items-baseline">
                                <div class="text-lg font-medium text-gray-900 dark:text-white">
                                    {{ number_format($bucket['count']) }}
                                </div>
                                <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">
                                    ({{ number_format($bucket['percentage'], 1) }}%)
                                </span>
                            </dd>
                            <dd class="text-xs text-gray-500 dark:text-gray-400">
                                {{ number_format($bucket['value'], 0) }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Aging Trend and Distribution -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Aging Trend Over Time -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Aging Trend (Last 6 Months)</h3>
                <div class="space-y-4">
                    @php
                        $agingTrend = [
                            ['month' => 'Jul 2024', 'current' => 95.2, 'past_due' => 4.8],
                            ['month' => 'Aug 2024', 'current' => 94.8, 'past_due' => 5.2],
                            ['month' => 'Sep 2024', 'current' => 95.5, 'past_due' => 4.5],
                            ['month' => 'Oct 2024', 'current' => 94.1, 'past_due' => 5.9],
                            ['month' => 'Nov 2024', 'current' => 95.0, 'past_due' => 5.0],
                            ['month' => 'Dec 2024', 'current' => 94.8, 'past_due' => 5.2],
                        ];
                    @endphp

                    @foreach($agingTrend as $trend)
                    <div class="flex items-center space-x-4">
                        <div class="w-16 text-sm font-medium text-gray-700 dark:text-gray-300">{{ $trend['month'] }}</div>
                        <div class="flex-1 space-y-1">
                            <div class="flex items-center space-x-2">
                                <div class="w-16 text-xs text-green-600 dark:text-green-400">Current</div>
                                <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                                    <div class="bg-green-500 h-3 rounded-full flex items-center justify-end pr-2" style="width: {{ $trend['current'] }}%">
                                        <span class="text-xs font-medium text-white">{{ number_format($trend['current'], 1) }}%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-16 text-xs text-red-600 dark:text-red-400">Past Due</div>
                                <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-red-500 h-2 rounded-full" style="width: {{ ($trend['past_due'] / 10) * 100 }}%"></div>
                                </div>
                                <div class="text-xs text-gray-600 dark:text-gray-400 w-8">{{ number_format($trend['past_due'], 1) }}%</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="grid grid-cols-2 gap-4 text-center">
                        <div>
                            <div class="text-lg font-bold text-green-600 dark:text-green-400">{{ number_format(array_sum(array_column($agingTrend, 'current')) / count($agingTrend), 1) }}%</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Avg Current Rate</div>
                        </div>
                        <div>
                            <div class="text-lg font-bold text-red-600 dark:text-red-400">{{ number_format(array_sum(array_column($agingTrend, 'past_due')) / count($agingTrend), 1) }}%</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Avg Past Due Rate</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aging by Product Type -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Aging by Product Type</h3>
                <div class="space-y-4">
                    @php
                        $productAging = [
                            ['product' => 'Business Loan', 'current' => 342, 'past_due' => 18, 'past_due_rate' => 5.0, 'color' => 'blue'],
                            ['product' => 'Equipment Financing', 'current' => 276, 'past_due' => 13, 'past_due_rate' => 4.5, 'color' => 'green'],
                            ['product' => 'Invoice Factoring', 'current' => 385, 'past_due' => 13, 'past_due_rate' => 3.3, 'color' => 'purple'],
                            ['product' => 'Line of Credit', 'current' => 195, 'past_due' => 5, 'past_due_rate' => 2.5, 'color' => 'yellow'],
                        ];
                    @endphp

                    @foreach($productAging as $product)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-{{ $product['color'] }}-500 rounded-full"></div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $product['product'] }}</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="text-right">
                                <div class="text-sm text-gray-600 dark:text-gray-400">{{ $product['current'] }} current</div>
                                <div class="text-sm font-medium {{ $product['past_due_rate'] > 4.0 ? 'text-red-600 dark:text-red-400' : 'text-yellow-600 dark:text-yellow-400' }}">
                                    {{ $product['past_due'] }} overdue ({{ number_format($product['past_due_rate'], 1) }}%)
                                </div>
                            </div>
                            <div class="w-20 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-{{ $product['past_due_rate'] > 4.0 ? 'red' : 'yellow' }}-500 h-2 rounded-full" style="width: {{ ($product['past_due_rate'] / 6) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Detailed Aging Report -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Detailed Aging Analysis</h3>
                    <div class="flex items-center space-x-3">
                        <select class="px-3 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option>All Products</option>
                            <option>Business Loan</option>
                            <option>Equipment Financing</option>
                            <option>Invoice Factoring</option>
                            <option>Line of Credit</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/20">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Account</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Balance</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Days Overdue</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aging Bucket</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Last Payment</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @php
                            $agingAccounts = [
                                ['account' => 'CFA-2024-089', 'customer' => 'ABC Manufacturing', 'product' => 'Business Loan', 'balance' => 45000, 'days_overdue' => 87, 'bucket' => '61-90 Days', 'last_payment' => '2024-09-15'],
                                ['account' => 'CFA-2024-156', 'customer' => 'XYZ Corporation', 'product' => 'Equipment Financing', 'balance' => 32000, 'days_overdue' => 45, 'bucket' => '31-60 Days', 'last_payment' => '2024-10-20'],
                                ['account' => 'CFA-2024-203', 'customer' => 'Global Enterprises', 'product' => 'Invoice Factoring', 'balance' => 28000, 'days_overdue' => 112, 'bucket' => '90+ Days', 'last_payment' => '2024-08-25'],
                                ['account' => 'CFA-2024-241', 'customer' => 'Local Business LLC', 'product' => 'Line of Credit', 'balance' => 15000, 'days_overdue' => 23, 'bucket' => '1-30 Days', 'last_payment' => '2024-11-10'],
                                ['account' => 'CFA-2024-298', 'customer' => 'Tech Solutions Inc', 'product' => 'Business Loan', 'balance' => 52000, 'days_overdue' => 67, 'bucket' => '61-90 Days', 'last_payment' => '2024-09-28'],
                                ['account' => 'CFA-2024-312', 'customer' => 'Service Providers', 'product' => 'Equipment Financing', 'balance' => 38000, 'days_overdue' => 38, 'bucket' => '31-60 Days', 'last_payment' => '2024-10-15'],
                                ['account' => 'CFA-2024-345', 'customer' => 'Retail Corp', 'product' => 'Invoice Factoring', 'balance' => 22000, 'days_overdue' => 125, 'bucket' => '90+ Days', 'last_payment' => '2024-08-10'],
                                ['account' => 'CFA-2024-389', 'customer' => 'Manufacturing Inc', 'product' => 'Business Loan', 'balance' => 41000, 'days_overdue' => 19, 'bucket' => '1-30 Days', 'last_payment' => '2024-11-18'],
                            ];
                        @endphp

                        @foreach($agingAccounts as $account)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900 dark:text-white">
                                {{ $account['account'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                {{ $account['customer'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                    {{ $account['product'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900 dark:text-white">
                                {{ number_format($account['balance'], 0) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="text-sm font-medium {{ $account['days_overdue'] >= 90 ? 'text-red-600 dark:text-red-400' : ($account['days_overdue'] >= 60 ? 'text-orange-600 dark:text-orange-400' : ($account['days_overdue'] >= 30 ? 'text-yellow-600 dark:text-yellow-400' : 'text-blue-600 dark:text-blue-400')) }}">
                                    {{ $account['days_overdue'] }} days
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $account['bucket'] === '90+ Days' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : '' }}
                                    {{ $account['bucket'] === '61-90 Days' ? 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400' : '' }}
                                    {{ $account['bucket'] === '31-60 Days' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                                    {{ $account['bucket'] === '1-30 Days' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : '' }}">
                                    {{ $account['bucket'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($account['last_payment'])->format('M j, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                @if($account['days_overdue'] >= 90)
                                    <button class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">
                                        Legal Action
                                    </button>
                                @elseif($account['days_overdue'] >= 60)
                                    <button class="text-orange-600 dark:text-orange-400 hover:text-orange-900 dark:hover:text-orange-300">
                                        Escalate
                                    </button>
                                @else
                                    <button class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                                        Contact
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700 dark:text-gray-300">
                        Showing 1 to 8 of 49 overdue accounts
                    </div>
                    <div class="flex space-x-1">
                        <button class="px-3 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-gray-700">Previous</button>
                        <button class="px-3 py-1 text-sm bg-blue-600 text-white rounded">1</button>
                        <button class="px-3 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-gray-700">2</button>
                        <button class="px-3 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-gray-700">Next</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Collection Priority -->
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-6">
            <h4 class="text-lg font-medium text-red-900 dark:text-red-100 mb-4">Collection Priority Actions</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-red-600 dark:text-red-400">3</div>
                    <div class="text-sm text-red-800 dark:text-red-200">Accounts 90+ Days</div>
                    <button class="mt-2 px-3 py-1 bg-red-600 text-white text-xs rounded-lg hover:bg-red-700">
                        Review Legal Action
                    </button>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">6</div>
                    <div class="text-sm text-red-800 dark:text-red-200">Accounts 61-90 Days</div>
                    <button class="mt-2 px-3 py-1 bg-orange-600 text-white text-xs rounded-lg hover:bg-orange-700">
                        Escalate Collection
                    </button>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">12</div>
                    <div class="text-sm text-red-800 dark:text-red-200">Accounts 31-60 Days</div>
                    <button class="mt-2 px-3 py-1 bg-yellow-600 text-white text-xs rounded-lg hover:bg-yellow-700">
                        Increase Contact
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection