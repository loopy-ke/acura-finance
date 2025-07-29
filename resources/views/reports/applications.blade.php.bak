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
                                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">Applications Report</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl">
                    Applications Report
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Track application volumes, approval rates, and processing performance
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

        <!-- Report Filters -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label for="date_range" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Date Range</label>
                    <select name="date_range" id="date_range" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="last_30_days">Last 30 Days</option>
                        <option value="last_90_days">Last 90 Days</option>
                        <option value="current_quarter">Current Quarter</option>
                        <option value="last_quarter">Last Quarter</option>
                        <option value="year_to_date">Year to Date</option>
                        <option value="custom">Custom Range</option>
                    </select>
                </div>
                
                <div>
                    <label for="application_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Application Type</label>
                    <select name="application_type" id="application_type" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">All Types</option>
                        <option value="business_loan">Business Loan</option>
                        <option value="equipment_financing">Equipment Financing</option>
                        <option value="invoice_factoring">Invoice Factoring</option>
                        <option value="line_of_credit">Line of Credit</option>
                    </select>
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                        <option value="withdrawn">Withdrawn</option>
                    </select>
                </div>
                
                <div>
                    <label for="amount_range" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Amount Range</label>
                    <select name="amount_range" id="amount_range" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">All Amounts</option>
                        <option value="0-10000">Up to 10,000</option>
                        <option value="10000-50000">10,000 - 50,000</option>
                        <option value="50000-100000">50,000 - 100,000</option>
                        <option value="100000+">Over 100,000</option>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        Generate Report
                    </button>
                </div>
            </form>
        </div>

        <!-- Key Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @php
                $metrics = [
                    ['label' => 'Total Applications', 'value' => 245, 'change' => '+18%', 'trend' => 'up', 'color' => 'blue'],
                    ['label' => 'Approval Rate', 'value' => 68.5, 'format' => 'percent', 'change' => '+2.3%', 'trend' => 'up', 'color' => 'green'],
                    ['label' => 'Avg Processing Time', 'value' => '3.2 days', 'change' => '-0.8 days', 'trend' => 'down', 'color' => 'purple'],
                    ['label' => 'Total Amount', 'value' => 12500000, 'format' => 'currency', 'change' => '+25%', 'trend' => 'up', 'color' => 'yellow'],
                ];
            @endphp

            @foreach($metrics as $metric)
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-{{ $metric['color'] }}-100 dark:bg-{{ $metric['color'] }}-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-{{ $metric['color'] }}-600 dark:text-{{ $metric['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">{{ $metric['label'] }}</dt>
                            <dd class="flex items-baseline">
                                <div class="text-lg font-medium text-gray-900 dark:text-white">
                                    @if(isset($metric['format']) && $metric['format'] === 'percent')
                                        {{ number_format($metric['value'], 1) }}%
                                    @elseif(isset($metric['format']) && $metric['format'] === 'currency')
                                        {{ number_format($metric['value'], 0) }}
                                    @else
                                        {{ $metric['value'] }}
                                    @endif
                                </div>
                                <span class="ml-2 text-sm font-medium {{ $metric['trend'] === 'up' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $metric['change'] }}
                                </span>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Application Volume Trend -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Application Volume Trend</h3>
                <div class="space-y-4">
                    @php
                        $volumeData = [
                            ['month' => 'Aug 2024', 'applications' => 185, 'approved' => 125, 'rejected' => 60],
                            ['month' => 'Sep 2024', 'applications' => 210, 'approved' => 143, 'rejected' => 67],
                            ['month' => 'Oct 2024', 'applications' => 195, 'approved' => 138, 'rejected' => 57],
                            ['month' => 'Nov 2024', 'applications' => 230, 'approved' => 162, 'rejected' => 68],
                            ['month' => 'Dec 2024', 'applications' => 245, 'approved' => 168, 'rejected' => 77],
                        ];
                        $maxApps = max(array_column($volumeData, 'applications'));
                    @endphp

                    @foreach($volumeData as $data)
                    <div class="flex items-center space-x-4">
                        <div class="w-16 text-sm font-medium text-gray-700 dark:text-gray-300">{{ $data['month'] }}</div>
                        <div class="flex-1 space-y-1">
                            <div class="flex items-center space-x-2">
                                <div class="w-20 text-xs text-blue-600 dark:text-blue-400">Total</div>
                                <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                                    <div class="bg-blue-500 h-3 rounded-full flex items-center justify-end pr-2" style="width: {{ ($data['applications'] / $maxApps) * 100 }}%">
                                        <span class="text-xs font-medium text-white">{{ $data['applications'] }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-20 text-xs text-green-600 dark:text-green-400">Approved</div>
                                <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ ($data['approved'] / $maxApps) * 100 }}%"></div>
                                </div>
                                <div class="text-xs text-gray-600 dark:text-gray-400 w-8">{{ $data['approved'] }}</div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-20 text-xs text-red-600 dark:text-red-400">Rejected</div>
                                <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-red-500 h-2 rounded-full" style="width: {{ ($data['rejected'] / $maxApps) * 100 }}%"></div>
                                </div>
                                <div class="text-xs text-gray-600 dark:text-gray-400 w-8">{{ $data['rejected'] }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Application Status Distribution -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Current Status Distribution</h3>
                <div class="space-y-4">
                    @php
                        $statusData = [
                            ['status' => 'Approved', 'count' => 168, 'percentage' => 68.5, 'color' => 'green'],
                            ['status' => 'Rejected', 'count' => 52, 'percentage' => 21.2, 'color' => 'red'],
                            ['status' => 'Pending Review', 'count' => 18, 'percentage' => 7.3, 'color' => 'yellow'],
                            ['status' => 'Withdrawn', 'count' => 7, 'percentage' => 2.9, 'color' => 'gray'],
                        ];
                    @endphp

                    @foreach($statusData as $status)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-{{ $status['color'] }}-500 rounded-full"></div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $status['status'] }}</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $status['count'] }}</span>
                            <div class="w-20 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-{{ $status['color'] }}-500 h-2 rounded-full" style="width: {{ $status['percentage'] }}%"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white w-12">{{ number_format($status['percentage'], 1) }}%</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Processing Time Analysis -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Processing Time Analysis</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">3.2 days</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Average Processing Time</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400">1.8 days</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Fastest Processing</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-red-600 dark:text-red-400">7.5 days</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Slowest Processing</div>
                </div>
            </div>
        </div>

        <!-- Application Type Performance -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Performance by Application Type</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/20">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Application Type</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Applications</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Approved</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Approval Rate</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Avg Amount</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Processing Time</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @php
                            $typePerformance = [
                                ['type' => 'Business Loan', 'total' => 89, 'approved' => 58, 'rate' => 65.2, 'amount' => 75000, 'time' => '4.1 days'],
                                ['type' => 'Equipment Financing', 'total' => 67, 'approved' => 48, 'rate' => 71.6, 'amount' => 45000, 'time' => '3.8 days'],
                                ['type' => 'Invoice Factoring', 'total' => 52, 'approved' => 38, 'rate' => 73.1, 'amount' => 35000, 'time' => '2.2 days'],
                                ['type' => 'Line of Credit', 'total' => 37, 'approved' => 24, 'rate' => 64.9, 'amount' => 25000, 'time' => '2.8 days'],
                            ];
                        @endphp

                        @foreach($typePerformance as $performance)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                {{ $performance['type'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 dark:text-white">
                                {{ $performance['total'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 dark:text-white">
                                {{ $performance['approved'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $performance['rate'] >= 70 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : ($performance['rate'] >= 65 ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400') }}">
                                    {{ number_format($performance['rate'], 1) }}%
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 dark:text-white">
                                {{ number_format($performance['amount'], 0) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 dark:text-white">
                                {{ $performance['time'] }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection