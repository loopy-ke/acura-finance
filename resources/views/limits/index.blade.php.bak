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
                                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">Credit Limits</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl">
                    Credit Limits Management
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Manage customer credit limits, utilization monitoring, and limit adjustments
                </p>
            </div>
            <div class="mt-4 flex space-x-3 sm:mt-0">
                <a href="{{ route('credit-financing.limits.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-full hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    New Limit Request
                </a>
            </div>
        </div>

        <!-- Credit Limits Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @php
                $stats = [
                    ['label' => 'Total Credit Limits', 'value' => 152, 'amount' => 45750000, 'color' => 'blue'],
                    ['label' => 'Pending Reviews', 'value' => 8, 'amount' => 2850000, 'color' => 'yellow'],
                    ['label' => 'Over 80% Utilized', 'value' => 12, 'amount' => 3250000, 'color' => 'red'],
                    ['label' => 'Recent Increases', 'value' => 5, 'amount' => 1240000, 'color' => 'green'],
                ];
            @endphp

            @foreach($stats as $stat)
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-{{ $stat['color'] }}-100 dark:bg-{{ $stat['color'] }}-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">{{ $stat['label'] }}</dt>
                            <dd class="flex items-baseline space-x-2">
                                <div class="text-lg font-medium text-gray-900 dark:text-white">{{ number_format($stat['value']) }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">({{ number_format($stat['amount'], 0) }})</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Filters -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-6 gap-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="suspended">Suspended</option>
                        <option value="under_review">Under Review</option>
                        <option value="expired">Expired</option>
                    </select>
                </div>
                
                <div>
                    <label for="utilization_range" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Utilization</label>
                    <select name="utilization_range" id="utilization_range" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">All Utilization</option>
                        <option value="0-25">0% - 25%</option>
                        <option value="25-50">25% - 50%</option>
                        <option value="50-80">50% - 80%</option>
                        <option value="80-100">80% - 100%</option>
                        <option value="over_limit">Over Limit</option>
                    </select>
                </div>
                
                <div>
                    <label for="limit_range" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Limit Range</label>
                    <select name="limit_range" id="limit_range" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">All Limits</option>
                        <option value="0-50000">Under 50K</option>
                        <option value="50000-250000">50K - 250K</option>
                        <option value="250000-500000">250K - 500K</option>
                        <option value="500000+">Over 500K</option>
                    </select>
                </div>
                
                <div>
                    <label for="risk_grade" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Risk Grade</label>
                    <select name="risk_grade" id="risk_grade" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">All Grades</option>
                        <option value="A">A (Excellent)</option>
                        <option value="B">B (Good)</option>
                        <option value="C">C (Fair)</option>
                        <option value="D">D (Poor)</option>
                    </select>
                </div>
                
                <div>
                    <label for="review_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Review Due</label>
                    <select name="review_date" id="review_date" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">All Dates</option>
                        <option value="overdue">Overdue</option>
                        <option value="this_month">This Month</option>
                        <option value="next_month">Next Month</option>
                        <option value="next_quarter">Next Quarter</option>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>

        <!-- Credit Limits Table -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Active Credit Limits</h3>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500 dark:text-gray-400">152 total limits</span>
                        <button class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 text-sm font-medium">
                            Export
                        </button>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/20">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Account</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Credit Limit</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Outstanding</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Utilization</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Risk Grade</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Next Review</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @php
                            $limits = [
                                ['customer' => 'ABC Manufacturing', 'account' => 'CFA-2024-001', 'limit' => 500000, 'outstanding' => 425000, 'utilization' => 85, 'risk_grade' => 'B+', 'next_review' => '2025-09-15', 'status' => 'active'],
                                ['customer' => 'XYZ Corporation', 'account' => 'CFA-2024-089', 'limit' => 250000, 'outstanding' => 125000, 'utilization' => 50, 'risk_grade' => 'A-', 'next_review' => '2025-08-20', 'status' => 'active'],
                                ['customer' => 'Global Enterprises', 'account' => 'CFA-2024-156', 'limit' => 1000000, 'outstanding' => 875000, 'utilization' => 87.5, 'risk_grade' => 'B', 'next_review' => '2025-07-30', 'status' => 'under_review'],
                                ['customer' => 'Local Business LLC', 'account' => 'CFA-2024-203', 'limit' => 150000, 'outstanding' => 75000, 'utilization' => 50, 'risk_grade' => 'A', 'next_review' => '2025-10-12', 'status' => 'active'],
                                ['customer' => 'Tech Solutions Inc', 'account' => 'CFA-2024-241', 'limit' => 300000, 'outstanding' => 285000, 'utilization' => 95, 'risk_grade' => 'C+', 'next_review' => '2025-07-25', 'status' => 'suspended'],
                                ['customer' => 'Service Providers', 'account' => 'CFA-2024-298', 'limit' => 75000, 'outstanding' => 15000, 'utilization' => 20, 'risk_grade' => 'A', 'next_review' => '2025-11-05', 'status' => 'active'],
                            ];
                        @endphp

                        @foreach($limits as $limit)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                {{ $limit['customer'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900 dark:text-white">
                                {{ $limit['account'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900 dark:text-white">
                                {{ number_format($limit['limit'], 0) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-900 dark:text-white">
                                {{ number_format($limit['outstanding'], 0) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center">
                                    <div class="flex-1 bg-gray-200 dark:bg-gray-600 rounded-full h-2 mr-2">
                                        <div class="h-2 rounded-full {{ $limit['utilization'] >= 90 ? 'bg-red-500' : ($limit['utilization'] >= 80 ? 'bg-yellow-500' : 'bg-green-500') }}" 
                                             style="width: {{ min($limit['utilization'], 100) }}%"></div>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $limit['utilization'] }}%</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    {{ in_array(substr($limit['risk_grade'], 0, 1), ['A']) ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                    {{ in_array(substr($limit['risk_grade'], 0, 1), ['B']) ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : '' }}
                                    {{ in_array(substr($limit['risk_grade'], 0, 1), ['C']) ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                                    {{ in_array(substr($limit['risk_grade'], 0, 1), ['D']) ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : '' }}">
                                    {{ $limit['risk_grade'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ \Carbon\Carbon::parse($limit['next_review'])->format('M j, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $limit['status'] === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                    {{ $limit['status'] === 'under_review' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                                    {{ $limit['status'] === 'suspended' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : '' }}">
                                    {{ ucfirst(str_replace('_', ' ', $limit['status'])) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('credit-financing.limits.show', 1) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                                        View
                                    </a>
                                    <span class="text-gray-300 dark:text-gray-600">|</span>
                                    <a href="{{ route('credit-financing.limits.edit', 1) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                        Edit
                                    </a>
                                </div>
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
                        Showing 1 to 6 of 152 credit limits
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

        <!-- Alert Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- High Utilization Alert -->
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-6">
                <h4 class="text-lg font-medium text-red-900 dark:text-red-100 mb-4">High Utilization Alert</h4>
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-red-700 dark:text-red-300">ABC Manufacturing</span>
                        <span class="font-medium text-red-900 dark:text-red-100">85% utilized</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-red-700 dark:text-red-300">Global Enterprises</span>
                        <span class="font-medium text-red-900 dark:text-red-100">87.5% utilized</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-red-700 dark:text-red-300">Tech Solutions Inc</span>
                        <span class="font-medium text-red-900 dark:text-red-100">95% utilized</span>
                    </div>
                </div>
                <button class="mt-4 text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 text-sm font-medium">
                    View All High Utilization →
                </button>
            </div>

            <!-- Review Due Alert -->
            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-6">
                <h4 class="text-lg font-medium text-yellow-900 dark:text-yellow-100 mb-4">Reviews Due Soon</h4>
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-yellow-700 dark:text-yellow-300">Tech Solutions Inc</span>
                        <span class="font-medium text-yellow-900 dark:text-yellow-100">Jul 25, 2025</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-yellow-700 dark:text-yellow-300">Global Enterprises</span>
                        <span class="font-medium text-yellow-900 dark:text-yellow-100">Jul 30, 2025</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-yellow-700 dark:text-yellow-300">XYZ Corporation</span>
                        <span class="font-medium text-yellow-900 dark:text-yellow-100">Aug 20, 2025</span>
                    </div>
                </div>
                <button class="mt-4 text-yellow-600 dark:text-yellow-400 hover:text-yellow-900 dark:hover:text-yellow-300 text-sm font-medium">
                    Schedule Reviews →
                </button>
            </div>
        </div>
    </div>
@endsection