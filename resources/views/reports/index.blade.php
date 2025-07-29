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
                                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">Credit Reports</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl">
                    Credit Financing Reports
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Access comprehensive credit financing analytics and reporting tools
                </p>
            </div>
        </div>

        <!-- Report Categories -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Applications Report -->
            <a href="{{ route('credit-financing.reports.applications') }}" class="group">
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center group-hover:bg-blue-200 dark:group-hover:bg-blue-900/50 transition-colors">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                Applications Report
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Track application volumes, approval rates, and processing times
                            </p>
                            <div class="mt-2 flex items-center text-sm text-blue-600 dark:text-blue-400">
                                <span>View Report</span>
                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Performance Report -->
            <a href="{{ route('credit-financing.reports.performance') }}" class="group">
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center group-hover:bg-green-200 dark:group-hover:bg-green-900/50 transition-colors">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">
                                Performance Report
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Monitor portfolio performance, defaults, and profitability
                            </p>
                            <div class="mt-2 flex items-center text-sm text-green-600 dark:text-green-400">
                                <span>View Report</span>
                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Risk Analysis -->
            <a href="{{ route('credit-financing.reports.risk-analysis') }}" class="group">
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center group-hover:bg-red-200 dark:group-hover:bg-red-900/50 transition-colors">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors">
                                Risk Analysis
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Analyze credit risk, exposure, and loss provisions
                            </p>
                            <div class="mt-2 flex items-center text-sm text-red-600 dark:text-red-400">
                                <span>View Report</span>
                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Portfolio Report -->
            <a href="{{ route('credit-financing.reports.portfolio') }}" class="group">
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center group-hover:bg-purple-200 dark:group-hover:bg-purple-900/50 transition-colors">
                                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                                Portfolio Report
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Overview of loan portfolio composition and trends
                            </p>
                            <div class="mt-2 flex items-center text-sm text-purple-600 dark:text-purple-400">
                                <span>View Report</span>
                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Aging Report -->
            <a href="{{ route('credit-financing.reports.aging') }}" class="group">
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center group-hover:bg-yellow-200 dark:group-hover:bg-yellow-900/50 transition-colors">
                                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white group-hover:text-yellow-600 dark:group-hover:text-yellow-400 transition-colors">
                                Aging Report
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Track overdue accounts and payment aging buckets
                            </p>
                            <div class="mt-2 flex items-center text-sm text-yellow-600 dark:text-yellow-400">
                                <span>View Report</span>
                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Custom Reports -->
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 shadow-sm rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 p-6">
                <div class="text-center">
                    <div class="w-12 h-12 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                        Custom Reports
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                        Create custom reports tailored to your specific needs
                    </p>
                    <button class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        Create Report
                    </button>
                </div>
            </div>
        </div>

        <!-- Recent Reports -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Recent Reports</h3>
                    <button class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 text-sm font-medium">
                        View All
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/20">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Report Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Generated</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @php
                            $recentReports = [
                                ['name' => 'Monthly Portfolio Summary', 'type' => 'Portfolio', 'date' => '2024-12-08 09:30', 'status' => 'completed'],
                                ['name' => 'Q4 Risk Analysis', 'type' => 'Risk Analysis', 'date' => '2024-12-07 14:15', 'status' => 'completed'],
                                ['name' => 'Application Performance Nov', 'type' => 'Applications', 'date' => '2024-12-06 11:45', 'status' => 'completed'],
                                ['name' => 'Aging Analysis Current', 'type' => 'Aging', 'date' => '2024-12-05 16:20', 'status' => 'processing'],
                                ['name' => 'Weekly Performance Review', 'type' => 'Performance', 'date' => '2024-12-04 08:00', 'status' => 'completed'],
                            ];
                        @endphp

                        @foreach($recentReports as $report)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $report['name'] }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                    {{ $report['type'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($report['date'])->format('M j, Y g:i A') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $report['status'] === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                    {{ $report['status'] === 'processing' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}">
                                    {{ ucfirst($report['status']) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex items-center justify-center space-x-2">
                                    @if($report['status'] === 'completed')
                                        <button class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                                            View
                                        </button>
                                        <span class="text-gray-300 dark:text-gray-600">|</span>
                                        <button class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300">
                                            Download
                                        </button>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500">Processing...</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @php
                $quickStats = [
                    ['label' => 'Active Loans', 'value' => 1247, 'change' => '+12', 'trend' => 'up'],
                    ['label' => 'Total Portfolio', 'value' => 12500000, 'format' => 'currency', 'change' => '+8.5%', 'trend' => 'up'],
                    ['label' => 'Default Rate', 'value' => 2.3, 'format' => 'percent', 'change' => '-0.4%', 'trend' => 'down'],
                    ['label' => 'Monthly Collections', 'value' => 890000, 'format' => 'currency', 'change' => '+15%', 'trend' => 'up'],
                ];
            @endphp

            @foreach($quickStats as $stat)
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">{{ $stat['label'] }}</dt>
                        <dd class="text-lg font-medium text-gray-900 dark:text-white">
                            @if(isset($stat['format']) && $stat['format'] === 'currency')
                                {{ number_format($stat['value'], 0) }}
                            @elseif(isset($stat['format']) && $stat['format'] === 'percent')
                                {{ number_format($stat['value'], 1) }}%
                            @else
                                {{ number_format($stat['value']) }}
                            @endif
                        </dd>
                    </div>
                    <div class="flex items-center">
                        <span class="text-sm font-medium {{ $stat['trend'] === 'up' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                            {{ $stat['change'] }}
                        </span>
                        @if($stat['trend'] === 'up')
                            <svg class="ml-1 w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                        @else
                            <svg class="ml-1 w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 10.293a1 1 0 010 1.414l-6 6a1 1 0 01-1.414 0l-6-6a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l4.293-4.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection