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
                                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">Portfolio Report</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl">
                    Portfolio Report
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Comprehensive overview of loan portfolio composition, trends, and performance
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

        <!-- Portfolio Summary -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @php
                $portfolioSummary = [
                    ['label' => 'Total Portfolio Value', 'value' => 12500000, 'format' => 'currency', 'change' => '+8.5%', 'trend' => 'up', 'color' => 'blue'],
                    ['label' => 'Active Loans', 'value' => 1247, 'change' => '+45', 'trend' => 'up', 'color' => 'green'],
                    ['label' => 'Avg Loan Size', 'value' => 10026, 'format' => 'currency', 'change' => '-2.1%', 'trend' => 'down', 'color' => 'purple'],
                    ['label' => 'Portfolio Yield', 'value' => 12.8, 'format' => 'percent', 'change' => '+0.3%', 'trend' => 'up', 'color' => 'yellow'],
                ];
            @endphp

            @foreach($portfolioSummary as $summary)
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-{{ $summary['color'] }}-100 dark:bg-{{ $summary['color'] }}-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-{{ $summary['color'] }}-600 dark:text-{{ $summary['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">{{ $summary['label'] }}</dt>
                            <dd class="flex items-baseline">
                                <div class="text-lg font-medium text-gray-900 dark:text-white">
                                    @if(isset($summary['format']) && $summary['format'] === 'percent')
                                        {{ number_format($summary['value'], 1) }}%
                                    @elseif(isset($summary['format']) && $summary['format'] === 'currency')
                                        {{ number_format($summary['value'], 0) }}
                                    @else
                                        {{ number_format($summary['value']) }}
                                    @endif
                                </div>
                                <span class="ml-2 text-sm font-medium {{ $summary['trend'] === 'up' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $summary['change'] }}
                                </span>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Portfolio Composition -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- By Product Type -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Composition by Product Type</h3>
                <div class="space-y-4">
                    @php
                        $productComposition = [
                            ['product' => 'Business Loan', 'value' => 4200000, 'percentage' => 33.6, 'count' => 342, 'color' => 'blue'],
                            ['product' => 'Equipment Financing', 'value' => 3800000, 'percentage' => 30.4, 'count' => 289, 'color' => 'green'],
                            ['product' => 'Invoice Factoring', 'value' => 2900000, 'percentage' => 23.2, 'count' => 398, 'color' => 'purple'],
                            ['product' => 'Line of Credit', 'value' => 1600000, 'percentage' => 12.8, 'count' => 218, 'color' => 'yellow'],
                        ];
                    @endphp

                    @foreach($productComposition as $product)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-{{ $product['color'] }}-500 rounded-full"></div>
                            <div>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $product['product'] }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $product['count'] }} loans</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="text-right">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ number_format($product['value'] / 1000000, 1) }}M</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ number_format($product['percentage'], 1) }}%</div>
                            </div>
                            <div class="w-20 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-{{ $product['color'] }}-500 h-2 rounded-full" style="width: {{ $product['percentage'] }}%"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- By Industry Sector -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Composition by Industry</h3>
                <div class="space-y-4">
                    @php
                        $industryComposition = [
                            ['industry' => 'Manufacturing', 'value' => 3750000, 'percentage' => 30.0, 'count' => 285, 'color' => 'indigo'],
                            ['industry' => 'Technology', 'value' => 3125000, 'percentage' => 25.0, 'count' => 198, 'color' => 'blue'],
                            ['industry' => 'Retail', 'value' => 2500000, 'percentage' => 20.0, 'count' => 347, 'color' => 'green'],
                            ['industry' => 'Healthcare', 'value' => 1875000, 'percentage' => 15.0, 'count' => 156, 'color' => 'red'],
                            ['industry' => 'Other', 'value' => 1250000, 'percentage' => 10.0, 'count' => 261, 'color' => 'gray'],
                        ];
                    @endphp

                    @foreach($industryComposition as $industry)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-{{ $industry['color'] }}-500 rounded-full"></div>
                            <div>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $industry['industry'] }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $industry['count'] }} loans</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="text-right">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ number_format($industry['value'] / 1000000, 1) }}M</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ number_format($industry['percentage'], 1) }}%</div>
                            </div>
                            <div class="w-20 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-{{ $industry['color'] }}-500 h-2 rounded-full" style="width: {{ $industry['percentage'] }}%"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Portfolio Growth Trend -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Portfolio Growth Trend</h3>
            <div class="space-y-4">
                @php
                    $growthData = [
                        ['period' => 'Q1 2024', 'value' => 9200000, 'loans' => 892, 'growth_rate' => 12.5],
                        ['period' => 'Q2 2024', 'value' => 10400000, 'loans' => 987, 'growth_rate' => 13.0],
                        ['period' => 'Q3 2024', 'value' => 11600000, 'loans' => 1089, 'growth_rate' => 11.5],
                        ['period' => 'Q4 2024', 'value' => 12500000, 'loans' => 1247, 'growth_rate' => 7.8],
                    ];
                    $maxValue = max(array_column($growthData, 'value'));
                @endphp

                @foreach($growthData as $data)
                <div class="flex items-center space-x-4">
                    <div class="w-16 text-sm font-medium text-gray-700 dark:text-gray-300">{{ $data['period'] }}</div>
                    <div class="flex-1 space-y-2">
                        <div class="flex items-center space-x-2">
                            <div class="w-20 text-xs text-blue-600 dark:text-blue-400">Portfolio Value</div>
                            <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-4">
                                <div class="bg-blue-500 h-4 rounded-full flex items-center justify-between px-2" style="width: {{ ($data['value'] / $maxValue) * 100 }}%">
                                    <span class="text-xs font-medium text-white">{{ number_format($data['value'] / 1000000, 1) }}M</span>
                                    <span class="text-xs text-blue-100">{{ $data['loans'] }} loans</span>
                                </div>
                            </div>
                            <div class="text-xs font-medium w-12 {{ $data['growth_rate'] > 10 ? 'text-green-600 dark:text-green-400' : 'text-yellow-600 dark:text-yellow-400' }}">
                                +{{ number_format($data['growth_rate'], 1) }}%
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div>
                        <div class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ number_format((12500000 - 9200000) / 9200000 * 100, 1) }}%</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">YTD Growth</div>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-green-600 dark:text-green-400">{{ number_format((1247 - 892) / 892 * 100, 1) }}%</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Loan Count Growth</div>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-purple-600 dark:text-purple-400">{{ number_format(array_sum(array_column($growthData, 'growth_rate')) / count($growthData), 1) }}%</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Avg Quarterly Growth</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loan Size Distribution -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Size Buckets -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Loan Size Distribution</h3>
                <div class="space-y-4">
                    @php
                        $sizeDistribution = [
                            ['range' => 'Under 5K', 'count' => 387, 'value' => 1240000, 'percentage' => 31.0],
                            ['range' => '5K - 15K', 'count' => 425, 'value' => 4250000, 'percentage' => 34.1],
                            ['range' => '15K - 50K', 'count' => 298, 'value' => 5960000, 'percentage' => 23.9],
                            ['range' => '50K - 100K', 'count' => 89, 'value' => 6230000, 'percentage' => 7.1],
                            ['range' => 'Over 100K', 'count' => 48, 'value' => 9820000, 'percentage' => 3.8],
                        ];
                    @endphp

                    @foreach($sizeDistribution as $size)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="text-sm font-medium text-gray-900 dark:text-white w-20">{{ $size['range'] }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $size['count'] }} loans</div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ number_format($size['value'] / 1000000, 1) }}M</div>
                            <div class="w-20 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $size['percentage'] }}%"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white w-12">{{ number_format($size['percentage'], 1) }}%</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Term Distribution -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Loan Term Distribution</h3>
                <div class="space-y-4">
                    @php
                        $termDistribution = [
                            ['term' => '6 months', 'count' => 298, 'percentage' => 23.9, 'color' => 'red'],
                            ['term' => '12 months', 'count' => 425, 'percentage' => 34.1, 'color' => 'yellow'],
                            ['term' => '24 months', 'count' => 312, 'percentage' => 25.0, 'color' => 'green'],
                            ['term' => '36 months', 'count' => 149, 'percentage' => 11.9, 'color' => 'blue'],
                            ['term' => '60+ months', 'count' => 63, 'percentage' => 5.1, 'color' => 'purple'],
                        ];
                    @endphp

                    @foreach($termDistribution as $term)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-{{ $term['color'] }}-500 rounded-full"></div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $term['term'] }}</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $term['count'] }}</span>
                            <div class="w-20 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-{{ $term['color'] }}-500 h-2 rounded-full" style="width: {{ $term['percentage'] }}%"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white w-12">{{ number_format($term['percentage'], 1) }}%</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Top Performing Loans -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Top Performing Accounts</h3>
                    <span class="text-sm text-gray-500 dark:text-gray-400">By revenue contribution</span>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/20">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Account</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Loan Amount</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Interest Rate</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Monthly Revenue</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @php
                            $topLoans = [
                                ['account' => 'CFA-2024-001', 'customer' => 'Tech Solutions Inc', 'product' => 'Equipment Financing', 'amount' => 450000, 'rate' => 14.5, 'revenue' => 5437, 'status' => 'current'],
                                ['account' => 'CFA-2024-089', 'customer' => 'Manufacturing Corp', 'product' => 'Business Loan', 'amount' => 380000, 'rate' => 16.8, 'revenue' => 5320, 'status' => 'current'],
                                ['account' => 'CFA-2024-156', 'customer' => 'Global Enterprises', 'product' => 'Line of Credit', 'amount' => 320000, 'rate' => 18.2, 'revenue' => 4853, 'status' => 'current'],
                                ['account' => 'CFA-2024-203', 'customer' => 'Healthcare Systems', 'product' => 'Equipment Financing', 'amount' => 295000, 'rate' => 15.9, 'revenue' => 3910, 'status' => 'current'],
                                ['account' => 'CFA-2024-267', 'customer' => 'Retail Solutions', 'product' => 'Invoice Factoring', 'amount' => 275000, 'rate' => 12.3, 'revenue' => 2819, 'status' => 'current'],
                            ];
                        @endphp

                        @foreach($topLoans as $loan)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900 dark:text-white">
                                {{ $loan['account'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                {{ $loan['customer'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                    {{ $loan['product'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900 dark:text-white">
                                {{ number_format($loan['amount'], 0) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 dark:text-white">
                                {{ number_format($loan['rate'], 1) }}%
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-green-600 dark:text-green-400">
                                {{ number_format($loan['revenue'], 0) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                    {{ ucfirst($loan['status']) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Portfolio Health Indicators -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
            <h4 class="text-lg font-medium text-blue-900 dark:text-blue-100 mb-4">Portfolio Health Summary</h4>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400">97.7%</div>
                    <div class="text-sm text-blue-800 dark:text-blue-200">Current Loans</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">2.3%</div>
                    <div class="text-sm text-blue-800 dark:text-blue-200">Default Rate</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">14.2%</div>
                    <div class="text-sm text-blue-800 dark:text-blue-200">Avg Interest Rate</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">18 months</div>
                    <div class="text-sm text-blue-800 dark:text-blue-200">Avg Term</div>
                </div>
            </div>
        </div>
    </div>
@endsection