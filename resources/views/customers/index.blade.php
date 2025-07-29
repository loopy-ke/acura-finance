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
                                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">Customer Profiles</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl">
                    Customer Credit Profiles
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    View comprehensive credit profiles including application history, approvals, rejections, and ongoing applications
                </p>
            </div>
        </div>

        <!-- Customer Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @php
                $stats = [
                    ['label' => 'Total Customers', 'value' => 1245, 'change' => '+12%', 'color' => 'blue'],
                    ['label' => 'Active Applications', 'value' => 89, 'change' => '+5%', 'color' => 'yellow'],
                    ['label' => 'Approved This Month', 'value' => 156, 'change' => '+8%', 'color' => 'green'],
                    ['label' => 'Average Credit Score', 'value' => 742, 'change' => '+3pts', 'color' => 'purple'],
                ];
            @endphp

            @foreach($stats as $stat)
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-{{ $stat['color'] }}-100 dark:bg-{{ $stat['color'] }}-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">{{ $stat['label'] }}</dt>
                            <dd class="flex items-baseline space-x-2">
                                <div class="text-lg font-medium text-gray-900 dark:text-white">{{ number_format($stat['value']) }}</div>
                                <div class="text-sm text-green-600 dark:text-green-400">{{ $stat['change'] }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Search and Filters -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
            <form method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    <div class="md:col-span-4">
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search Customers</label>
                        <div class="relative">
                            <input type="text" name="search" id="search" 
                                   class="w-full px-3 py-2 pl-10 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Search by name, email, or account number">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="credit_score_range" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Credit Score</label>
                        <select name="credit_score_range" id="credit_score_range" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">All Scores</option>
                            <option value="800+">Excellent (800+)</option>
                            <option value="740-799">Very Good (740-799)</option>
                            <option value="670-739">Good (670-739)</option>
                            <option value="580-669">Fair (580-669)</option>
                            <option value="below-580">Poor (Below 580)</option>
                        </select>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="application_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                        <select name="application_status" id="application_status" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">All Status</option>
                            <option value="approved">Has Approved</option>
                            <option value="pending">Has Pending</option>
                            <option value="rejected">Has Rejected</option>
                            <option value="active_loans">Active Loans</option>
                        </select>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="risk_grade" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Risk Grade</label>
                        <select name="risk_grade" id="risk_grade" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">All Grades</option>
                            <option value="A">A (Low Risk)</option>
                            <option value="B">B (Medium Risk)</option>
                            <option value="C">C (High Risk)</option>
                            <option value="D">D (Very High Risk)</option>
                        </select>
                    </div>
                    
                    <div class="md:col-span-2 flex items-end">
                        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            Search
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Customers Table -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Customer Directory</h3>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500 dark:text-gray-400">1,245 customers</span>
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
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Credit Score</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Risk Grade</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Applications</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Active Loans</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Credit</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Last Activity</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @php
                            $customers = [
                                [
                                    'name' => 'ABC Manufacturing LLC',
                                    'email' => 'finance@abcmfg.com',
                                    'account' => 'CFA-2024-001',
                                    'credit_score' => 785,
                                    'risk_grade' => 'A',
                                    'total_applications' => 5,
                                    'approved' => 4,
                                    'pending' => 1,
                                    'rejected' => 0,
                                    'active_loans' => 2,
                                    'total_credit' => 750000,
                                    'last_activity' => '2025-07-28',
                                    'customer_since' => '2022-03-15'
                                ],
                                [
                                    'name' => 'XYZ Corporation',
                                    'email' => 'accounts@xyzcorp.com',
                                    'account' => 'CFA-2024-089',
                                    'credit_score' => 742,
                                    'risk_grade' => 'B+',
                                    'total_applications' => 3,
                                    'approved' => 2,
                                    'pending' => 0,
                                    'rejected' => 1,
                                    'active_loans' => 1,
                                    'total_credit' => 450000,
                                    'last_activity' => '2025-07-25',
                                    'customer_since' => '2023-01-10'
                                ],
                                [
                                    'name' => 'Global Enterprises Inc',
                                    'email' => 'treasury@globalent.com',
                                    'account' => 'CFA-2024-156',
                                    'credit_score' => 698,
                                    'risk_grade' => 'B',
                                    'total_applications' => 7,
                                    'approved' => 3,
                                    'pending' => 2,
                                    'rejected' => 2,
                                    'active_loans' => 3,
                                    'total_credit' => 1200000,
                                    'last_activity' => '2025-07-27',
                                    'customer_since' => '2021-08-22'
                                ],
                                [
                                    'name' => 'Local Business LLC',
                                    'email' => 'owner@localbiz.com',
                                    'account' => 'CFA-2024-203',
                                    'credit_score' => 821,
                                    'risk_grade' => 'A+',
                                    'total_applications' => 2,
                                    'approved' => 2,
                                    'pending' => 0,
                                    'rejected' => 0,
                                    'active_loans' => 1,
                                    'total_credit' => 250000,
                                    'last_activity' => '2025-07-20',
                                    'customer_since' => '2023-11-05'
                                ],
                                [
                                    'name' => 'Tech Solutions Inc',
                                    'email' => 'cfo@techsol.com',
                                    'account' => 'CFA-2024-241',
                                    'credit_score' => 625,
                                    'risk_grade' => 'C+',
                                    'total_applications' => 4,
                                    'approved' => 1,
                                    'pending' => 1,
                                    'rejected' => 2,
                                    'active_loans' => 1,
                                    'total_credit' => 180000,
                                    'last_activity' => '2025-07-26',
                                    'customer_since' => '2022-12-03'
                                ],
                                [
                                    'name' => 'Service Providers Co',
                                    'email' => 'finance@servicepro.com',
                                    'account' => 'CFA-2024-298',
                                    'credit_score' => 756,
                                    'risk_grade' => 'A-',
                                    'total_applications' => 3,
                                    'approved' => 3,
                                    'pending' => 0,
                                    'rejected' => 0,
                                    'active_loans' => 2,
                                    'total_credit' => 380000,
                                    'last_activity' => '2025-07-24',
                                    'customer_since' => '2023-05-18'
                                ],
                            ];
                        @endphp

                        @foreach($customers as $customer)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                                {{ substr($customer['name'], 0, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $customer['name'] }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $customer['email'] }}</div>
                                        <div class="text-xs text-gray-400 dark:text-gray-500">{{ $customer['account'] }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $customer['credit_score'] }}</div>
                                <div class="text-xs text-{{ $customer['credit_score'] >= 740 ? 'green' : ($customer['credit_score'] >= 670 ? 'yellow' : 'red') }}-600 dark:text-{{ $customer['credit_score'] >= 740 ? 'green' : ($customer['credit_score'] >= 670 ? 'yellow' : 'red') }}-400">
                                    {{ $customer['credit_score'] >= 800 ? 'Excellent' : ($customer['credit_score'] >= 740 ? 'Very Good' : ($customer['credit_score'] >= 670 ? 'Good' : ($customer['credit_score'] >= 580 ? 'Fair' : 'Poor'))) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    {{ in_array(substr($customer['risk_grade'], 0, 1), ['A']) ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                    {{ in_array(substr($customer['risk_grade'], 0, 1), ['B']) ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : '' }}
                                    {{ in_array(substr($customer['risk_grade'], 0, 1), ['C']) ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                                    {{ in_array(substr($customer['risk_grade'], 0, 1), ['D']) ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : '' }}">
                                    {{ $customer['risk_grade'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $customer['total_applications'] }} total</div>
                                <div class="flex items-center justify-center space-x-2 text-xs">
                                    <span class="text-green-600 dark:text-green-400">{{ $customer['approved'] }}A</span>
                                    <span class="text-yellow-600 dark:text-yellow-400">{{ $customer['pending'] }}P</span>
                                    <span class="text-red-600 dark:text-red-400">{{ $customer['rejected'] }}R</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-900 dark:text-white">
                                {{ $customer['active_loans'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900 dark:text-white">
                                {{ number_format($customer['total_credit'], 0) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($customer['last_activity'])->format('M j, Y') }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Customer since {{ \Carbon\Carbon::parse($customer['customer_since'])->format('M Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <a href="{{ route('credit-financing.customers.show', 1) }}" class="inline-flex items-center px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400 text-xs font-medium rounded-full hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors">
                                    View Profile
                                </a>
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
                        Showing 1 to 6 of 1,245 customers
                    </div>
                    <div class="flex space-x-1">
                        <button class="px-3 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-gray-700">Previous</button>
                        <button class="px-3 py-1 text-sm bg-blue-600 text-white rounded">1</button>
                        <button class="px-3 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-gray-700">2</button>
                        <button class="px-3 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-gray-700">3</button>
                        <button class="px-3 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-gray-700">Next</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Insights -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- High Risk Customers -->
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-6">
                <h4 class="text-lg font-medium text-red-900 dark:text-red-100 mb-4">High Risk Customers</h4>
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-red-700 dark:text-red-300">Tech Solutions Inc</span>
                        <span class="font-medium text-red-900 dark:text-red-100">Credit Score: 625</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-red-700 dark:text-red-300">Global Enterprises Inc</span>
                        <span class="font-medium text-red-900 dark:text-red-100">2 Pending Applications</span>
                    </div>
                </div>
                <button class="mt-4 text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 text-sm font-medium">
                    View All High Risk →
                </button>
            </div>

            <!-- Top Customers -->
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-6">
                <h4 class="text-lg font-medium text-green-900 dark:text-green-100 mb-4">Top Customers</h4>
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-green-700 dark:text-green-300">Local Business LLC</span>
                        <span class="font-medium text-green-900 dark:text-green-100">Credit Score: 821</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-green-700 dark:text-green-300">ABC Manufacturing LLC</span>
                        <span class="font-medium text-green-900 dark:text-green-100">$750K Total Credit</span>
                    </div>
                </div>
                <button class="mt-4 text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300 text-sm font-medium">
                    View All Top Customers →
                </button>
            </div>
        </div>
    </div>
@endsection