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
                                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">Performance Report</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl">
                    Performance Report
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Monitor portfolio performance, defaults, and profitability metrics
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
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="period" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Period</label>
                    <select name="period" id="period" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="current_month">Current Month</option>
                        <option value="last_month">Last Month</option>
                        <option value="current_quarter">Current Quarter</option>
                        <option value="last_quarter">Last Quarter</option>
                        <option value="year_to_date">Year to Date</option>
                        <option value="last_year">Last Year</option>
                    </select>
                </div>
                
                <div>
                    <label for="product_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Product Type</label>
                    <select name="product_type" id="product_type" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">All Products</option>
                        <option value="business_loan">Business Loan</option>
                        <option value="equipment_financing">Equipment Financing</option>
                        <option value="invoice_factoring">Invoice Factoring</option>
                        <option value="line_of_credit">Line of Credit</option>
                    </select>
                </div>
                
                <div>
                    <label for="risk_grade" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Risk Grade</label>
                    <select name="risk_grade" id="risk_grade" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">All Grades</option>
                        <option value="A">Grade A</option>
                        <option value="B">Grade B</option>
                        <option value="C">Grade C</option>
                        <option value="D">Grade D</option>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        Generate Report
                    </button>
                </div>
            </form>
        </div>

        <!-- Key Performance Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @php
                $kpis = [
                    ['label' => 'Portfolio Value', 'value' => 12500000, 'format' => 'currency', 'change' => '+8.5%', 'trend' => 'up', 'color' => 'blue'],
                    ['label' => 'Default Rate', 'value' => 2.3, 'format' => 'percent', 'change' => '-0.4%', 'trend' => 'down', 'color' => 'green'],
                    ['label' => 'Net Charge-offs', 'value' => 85000, 'format' => 'currency', 'change' => '+12%', 'trend' => 'up', 'color' => 'red'],
                    ['label' => 'ROA', 'value' => 4.8, 'format' => 'percent', 'change' => '+0.3%', 'trend' => 'up', 'color' => 'purple'],
                ];
            @endphp

            @foreach($kpis as $kpi)
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-{{ $kpi['color'] }}-100 dark:bg-{{ $kpi['color'] }}-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-{{ $kpi['color'] }}-600 dark:text-{{ $kpi['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">{{ $kpi['label'] }}</dt>
                            <dd class="flex items-baseline">
                                <div class="text-lg font-medium text-gray-900 dark:text-white">
                                    @if(isset($kpi['format']) && $kpi['format'] === 'percent')
                                        {{ number_format($kpi['value'], 1) }}%
                                    @elseif(isset($kpi['format']) && $kpi['format'] === 'currency')
                                        {{ number_format($kpi['value'], 0) }}
                                    @else
                                        {{ $kpi['value'] }}
                                    @endif
                                </div>
                                <span class="ml-2 text-sm font-medium {{ $kpi['trend'] === 'up' && $kpi['color'] !== 'red' ? 'text-green-600 dark:text-green-400' : ($kpi['trend'] === 'down' && $kpi['color'] !== 'green' ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400') }}">
                                    {{ $kpi['change'] }}
                                </span>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Performance Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Monthly Performance Trend -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Monthly Performance Trend</h3>
                <div class="space-y-4">
                    @php
                        $monthlyData = [
                            ['month' => 'Aug 2024', 'revenue' => 125000, 'defaults' => 8500],
                            ['month' => 'Sep 2024', 'revenue' => 142000, 'defaults' => 9200],
                            ['month' => 'Oct 2024', 'revenue' => 138000, 'defaults' => 7800],
                            ['month' => 'Nov 2024', 'revenue' => 156000, 'defaults' => 11000],
                            ['month' => 'Dec 2024', 'revenue' => 165000, 'defaults' => 9500],
                        ];
                        $maxRevenue = max(array_column($monthlyData, 'revenue'));
                    @endphp

                    @foreach($monthlyData as $data)
                    <div class="flex items-center space-x-4">
                        <div class="w-16 text-sm font-medium text-gray-700 dark:text-gray-300">{{ $data['month'] }}</div>
                        <div class="flex-1 space-y-2">
                            <div class="flex items-center space-x-2">
                                <div class="w-20 text-xs text-green-600 dark:text-green-400">Revenue</div>
                                <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                                    <div class="bg-green-500 h-3 rounded-full flex items-center justify-end pr-2" style="width: {{ ($data['revenue'] / $maxRevenue) * 100 }}%">
                                        <span class="text-xs font-medium text-white">{{ number_format($data['revenue'] / 1000) }}K</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-20 text-xs text-red-600 dark:text-red-400">Defaults</div>
                                <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-red-500 h-2 rounded-full" style="width: {{ ($data['defaults'] / $maxRevenue) * 100 }}%"></div>
                                </div>
                                <div class="text-xs text-gray-600 dark:text-gray-400 w-12">{{ number_format($data['defaults'] / 1000) }}K</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="grid grid-cols-2 gap-4 text-center">
                        <div>
                            <div class="text-lg font-bold text-green-600 dark:text-green-400">{{ number_format(array_sum(array_column($monthlyData, 'revenue')) / 1000) }}K</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Total Revenue</div>
                        </div>
                        <div>
                            <div class="text-lg font-bold text-red-600 dark:text-red-400">{{ number_format(array_sum(array_column($monthlyData, 'defaults')) / 1000) }}K</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Total Defaults</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Default Rate by Product -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Default Rate by Product</h3>
                <div class="space-y-4">
                    @php
                        $productDefaults = [
                            ['product' => 'Business Loan', 'rate' => 1.8, 'color' => 'green'],
                            ['product' => 'Equipment Financing', 'rate' => 2.3, 'color' => 'yellow'],
                            ['product' => 'Invoice Factoring', 'rate' => 1.2, 'color' => 'green'],
                            ['product' => 'Line of Credit', 'rate' => 3.5, 'color' => 'red'],
                        ];
                    @endphp

                    @foreach($productDefaults as $product)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-{{ $product['color'] }}-500 rounded-full"></div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $product['product'] }}</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-24 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-{{ $product['color'] }}-500 h-2 rounded-full" style="width: {{ ($product['rate'] / 5) * 100 }}%"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white w-12">{{ number_format($product['rate'], 1) }}%</span>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="text-center">
                        <div class="text-lg font-bold text-gray-900 dark:text-white">{{ number_format(array_sum(array_column($productDefaults, 'rate')) / count($productDefaults), 1) }}%</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Average Default Rate</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profitability Analysis -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Profitability Analysis</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ number_format(726000) }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Total Revenue</div>
                    <div class="text-xs text-green-600 dark:text-green-400 mt-1">+15.2% vs last period</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ number_format(680000) }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Net Income</div>
                    <div class="text-xs text-green-600 dark:text-green-400 mt-1">+18.3% vs last period</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">93.7%</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Profit Margin</div>
                    <div class="text-xs text-green-600 dark:text-green-400 mt-1">+2.1% vs last period</div>
                </div>
            </div>
        </div>

        <!-- Performance by Risk Grade -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Performance by Risk Grade</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/20">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Risk Grade</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Portfolio Value</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Default Rate</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Avg Interest Rate</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Revenue</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">ROA</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @php
                            $riskGrades = [
                                ['grade' => 'A', 'value' => 4250000, 'default_rate' => 0.8, 'interest_rate' => 8.5, 'revenue' => 361250, 'roa' => 8.5],
                                ['grade' => 'B', 'value' => 3800000, 'default_rate' => 1.5, 'interest_rate' => 12.2, 'revenue' => 463600, 'roa' => 12.2],
                                ['grade' => 'C', 'value' => 2950000, 'default_rate' => 2.8, 'interest_rate' => 16.8, 'revenue' => 495600, 'roa' => 16.8],
                                ['grade' => 'D', 'value' => 1500000, 'default_rate' => 4.2, 'interest_rate' => 22.5, 'revenue' => 337500, 'roa' => 22.5],
                            ];
                        @endphp

                        @foreach($riskGrades as $grade)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    {{ $grade['grade'] === 'A' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                    {{ $grade['grade'] === 'B' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : '' }}
                                    {{ $grade['grade'] === 'C' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                                    {{ $grade['grade'] === 'D' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : '' }}">
                                    Grade {{ $grade['grade'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-900 dark:text-white">
                                {{ number_format($grade['value'], 0) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="text-sm font-medium {{ $grade['default_rate'] <= 1.5 ? 'text-green-600 dark:text-green-400' : ($grade['default_rate'] <= 3.0 ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400') }}">
                                    {{ number_format($grade['default_rate'], 1) }}%
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 dark:text-white">
                                {{ number_format($grade['interest_rate'], 1) }}%
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-900 dark:text-white">
                                {{ number_format($grade['revenue'], 0) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 dark:text-white">
                                {{ number_format($grade['roa'], 1) }}%
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection