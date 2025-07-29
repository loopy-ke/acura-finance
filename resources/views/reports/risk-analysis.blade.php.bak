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
                                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">Risk Analysis</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl">
                    Risk Analysis Report
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Analyze credit risk, exposure levels, and loss provisions across the portfolio
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

        <!-- Alert Banner -->
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                        High Risk Alert
                    </h3>
                    <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                        <p>3 accounts have exceeded maximum exposure limits and require immediate attention.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Risk Filters -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label for="risk_period" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Analysis Period</label>
                    <select name="risk_period" id="risk_period" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="current_month">Current Month</option>
                        <option value="last_3_months">Last 3 Months</option>
                        <option value="last_6_months">Last 6 Months</option>
                        <option value="last_12_months">Last 12 Months</option>
                    </select>
                </div>
                
                <div>
                    <label for="risk_threshold" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Risk Threshold</label>
                    <select name="risk_threshold" id="risk_threshold" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="all">All Levels</option>
                        <option value="low">Low Risk Only</option>
                        <option value="medium">Medium Risk+</option>
                        <option value="high">High Risk Only</option>
                    </select>
                </div>
                
                <div>
                    <label for="industry_sector" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Industry Sector</label>
                    <select name="industry_sector" id="industry_sector" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">All Industries</option>
                        <option value="manufacturing">Manufacturing</option>
                        <option value="technology">Technology</option>
                        <option value="retail">Retail</option>
                        <option value="healthcare">Healthcare</option>
                    </select>
                </div>
                
                <div>
                    <label for="exposure_limit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Exposure Limit</label>
                    <select name="exposure_limit" id="exposure_limit" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">All Exposures</option>
                        <option value="under_limit">Under Limit</option>
                        <option value="near_limit">Near Limit (80%+)</option>
                        <option value="over_limit">Over Limit</option>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        Analyze Risk
                    </button>
                </div>
            </form>
        </div>

        <!-- Risk Overview Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @php
                $riskMetrics = [
                    ['label' => 'Total Exposure', 'value' => 12500000, 'format' => 'currency', 'limit' => 15000000, 'color' => 'blue'],
                    ['label' => 'High Risk Accounts', 'value' => 23, 'change' => '+3', 'trend' => 'up', 'color' => 'red'],
                    ['label' => 'Provision Coverage', 'value' => 3.8, 'format' => 'percent', 'target' => 4.5, 'color' => 'yellow'],
                    ['label' => 'Stress Test Result', 'value' => 89.2, 'format' => 'percent', 'benchmark' => 85.0, 'color' => 'green'],
                ];
            @endphp

            @foreach($riskMetrics as $metric)
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-{{ $metric['color'] }}-100 dark:bg-{{ $metric['color'] }}-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-{{ $metric['color'] }}-600 dark:text-{{ $metric['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">{{ $metric['label'] }}</dt>
                            <dd class="flex items-baseline space-y-0">
                                <div class="text-lg font-medium text-gray-900 dark:text-white">
                                    @if(isset($metric['format']) && $metric['format'] === 'percent')
                                        {{ number_format($metric['value'], 1) }}%
                                    @elseif(isset($metric['format']) && $metric['format'] === 'currency')
                                        {{ number_format($metric['value'], 0) }}
                                    @else
                                        {{ number_format($metric['value']) }}
                                    @endif
                                </div>
                                @if(isset($metric['change']))
                                    <span class="ml-2 text-sm font-medium {{ $metric['trend'] === 'up' ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                        {{ $metric['change'] }}
                                    </span>
                                @endif
                            </dd>
                            @if(isset($metric['limit']))
                                <dd class="text-xs text-gray-500 dark:text-gray-400">
                                    Limit: {{ number_format($metric['limit'], 0) }}
                                </dd>
                            @elseif(isset($metric['target']))
                                <dd class="text-xs text-gray-500 dark:text-gray-400">
                                    Target: {{ number_format($metric['target'], 1) }}%
                                </dd>
                            @elseif(isset($metric['benchmark']))
                                <dd class="text-xs text-gray-500 dark:text-gray-400">
                                    Benchmark: {{ number_format($metric['benchmark'], 1) }}%
                                </dd>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Risk Distribution Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Risk Grade Distribution -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Risk Grade Distribution</h3>
                <div class="space-y-4">
                    @php
                        $riskDistribution = [
                            ['grade' => 'A (Low Risk)', 'count' => 145, 'percentage' => 42.5, 'color' => 'green'],
                            ['grade' => 'B (Medium Risk)', 'count' => 128, 'percentage' => 37.5, 'color' => 'blue'],
                            ['grade' => 'C (High Risk)', 'count' => 52, 'percentage' => 15.2, 'color' => 'yellow'],
                            ['grade' => 'D (Critical Risk)', 'count' => 16, 'percentage' => 4.7, 'color' => 'red'],
                        ];
                    @endphp

                    @foreach($riskDistribution as $risk)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-{{ $risk['color'] }}-500 rounded-full"></div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $risk['grade'] }}</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $risk['count'] }}</span>
                            <div class="w-24 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-{{ $risk['color'] }}-500 h-2 rounded-full" style="width: {{ $risk['percentage'] }}%"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white w-12">{{ number_format($risk['percentage'], 1) }}%</span>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Total Accounts:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ array_sum(array_column($riskDistribution, 'count')) }}</span>
                    </div>
                </div>
            </div>

            <!-- Industry Risk Exposure -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Industry Risk Exposure</h3>
                <div class="space-y-4">
                    @php
                        $industryRisk = [
                            ['industry' => 'Manufacturing', 'exposure' => 4200000, 'risk_score' => 7.2, 'color' => 'yellow'],
                            ['industry' => 'Technology', 'exposure' => 3800000, 'risk_score' => 5.8, 'color' => 'green'],
                            ['industry' => 'Retail', 'exposure' => 2900000, 'risk_score' => 8.5, 'color' => 'red'],
                            ['industry' => 'Healthcare', 'exposure' => 1600000, 'risk_score' => 4.2, 'color' => 'green'],
                        ];
                        $maxExposure = max(array_column($industryRisk, 'exposure'));
                    @endphp

                    @foreach($industryRisk as $industry)
                    <div class="flex items-center space-x-4">
                        <div class="w-20 text-sm font-medium text-gray-700 dark:text-gray-300">{{ $industry['industry'] }}</div>
                        <div class="flex-1 space-y-1">
                            <div class="flex items-center space-x-2">
                                <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                                    <div class="bg-blue-500 h-3 rounded-full flex items-center justify-end pr-2" style="width: {{ ($industry['exposure'] / $maxExposure) * 100 }}%">
                                        <span class="text-xs font-medium text-white">{{ number_format($industry['exposure'] / 1000000, 1) }}M</span>
                                    </div>
                                </div>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $industry['color'] === 'green' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                    {{ $industry['color'] === 'yellow' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                                    {{ $industry['color'] === 'red' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : '' }}">
                                    {{ $industry['risk_score'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- High Risk Accounts -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">High Risk Accounts</h3>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                        Requires Attention
                    </span>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/20">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Account</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Exposure</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Risk Grade</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Risk Score</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Days Overdue</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @php
                            $highRiskAccounts = [
                                ['account' => 'CFA-2024-089', 'customer' => 'Retail Corp', 'exposure' => 450000, 'risk_grade' => 'D', 'risk_score' => 9.2, 'days_overdue' => 87],
                                ['account' => 'CFA-2024-156', 'customer' => 'Manufacturing Inc', 'exposure' => 380000, 'risk_grade' => 'C', 'risk_score' => 8.5, 'days_overdue' => 45],
                                ['account' => 'CFA-2024-203', 'customer' => 'Service Solutions', 'exposure' => 320000, 'risk_grade' => 'D', 'risk_score' => 9.8, 'days_overdue' => 112],
                                ['account' => 'CFA-2024-241', 'customer' => 'Global Trading', 'exposure' => 295000, 'risk_grade' => 'C', 'risk_score' => 7.9, 'days_overdue' => 28],
                            ];
                        @endphp

                        @foreach($highRiskAccounts as $account)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900 dark:text-white">
                                {{ $account['account'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                {{ $account['customer'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-900 dark:text-white">
                                {{ number_format($account['exposure'], 0) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $account['risk_grade'] === 'D' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' }}">
                                    Grade {{ $account['risk_grade'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="text-sm font-medium {{ $account['risk_score'] >= 9.0 ? 'text-red-600 dark:text-red-400' : 'text-yellow-600 dark:text-yellow-400' }}">
                                    {{ number_format($account['risk_score'], 1) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="text-sm font-medium {{ $account['days_overdue'] >= 90 ? 'text-red-600 dark:text-red-400' : ($account['days_overdue'] >= 60 ? 'text-orange-600 dark:text-orange-400' : 'text-yellow-600 dark:text-yellow-400') }}">
                                    {{ $account['days_overdue'] }} days
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex items-center justify-center space-x-2">
                                    <button class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                                        Review
                                    </button>
                                    <span class="text-gray-300 dark:text-gray-600">|</span>
                                    <button class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">
                                        Escalate
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Risk Mitigation Recommendations -->
        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-6">
            <h4 class="text-lg font-medium text-yellow-900 dark:text-yellow-100 mb-4">Risk Mitigation Recommendations</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h5 class="font-medium text-yellow-900 dark:text-yellow-100 mb-2">Immediate Actions</h5>
                    <ul class="space-y-2 text-sm text-yellow-800 dark:text-yellow-200">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Review and update exposure limits for retail sector
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Implement enhanced monitoring for Grade D accounts
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Increase provision coverage to meet 4.5% target
                        </li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-medium text-yellow-900 dark:text-yellow-100 mb-2">Strategic Recommendations</h5>
                    <ul class="space-y-2 text-sm text-yellow-800 dark:text-yellow-200">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Diversify portfolio to reduce industry concentration
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Strengthen credit underwriting criteria
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Implement early warning system for deteriorating accounts
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection