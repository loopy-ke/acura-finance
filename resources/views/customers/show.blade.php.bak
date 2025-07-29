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
                                <a href="{{ route('credit-financing.customers.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400 hover:text-blue-600 dark:hover:text-white">
                                    Customer Profiles
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">Customer Profile</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <div class="flex items-center space-x-4">
                    <div class="h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                        <span class="text-lg font-medium text-blue-600 dark:text-blue-400">
                            {{ substr($customer->name ?? 'ABC Manufacturing LLC', 0, 2) }}
                        </span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl">
                            {{ $customer->name ?? 'ABC Manufacturing LLC' }}
                        </h1>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ $customer->email ?? 'finance@abcmfg.com' }} • Account: {{ $customer->account_number ?? 'CFA-2024-001' }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="mt-4 flex space-x-3 sm:mt-0">
                <button type="button" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-full hover:bg-green-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    New Application
                </button>
                <button type="button" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-full hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Generate Report
                </button>
            </div>
        </div>

        <!-- Customer Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
            @php
                $overview = [
                    ['label' => 'Credit Score', 'value' => 785, 'trend' => '+12', 'color' => 'green'],
                    ['label' => 'Risk Grade', 'value' => 'A', 'trend' => 'Stable', 'color' => 'green'],
                    ['label' => 'Total Applications', 'value' => 5, 'trend' => '+1', 'color' => 'blue'],
                    ['label' => 'Active Loans', 'value' => 2, 'trend' => 'Stable', 'color' => 'purple'],
                    ['label' => 'Total Credit Limit', 'value' => '750K', 'trend' => '+50K', 'color' => 'yellow'],
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
                            <dd class="flex items-baseline space-x-2">
                                <div class="text-lg font-medium text-gray-900 dark:text-white">{{ $item['value'] }}</div>
                                <div class="text-sm text-green-600 dark:text-green-400">{{ $item['trend'] }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Application History -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Application History</h3>
                        <div class="flex space-x-2">
                            <button class="px-3 py-1 text-xs bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors" onclick="filterApplications('all')">
                                All (5)
                            </button>
                            <button class="px-3 py-1 text-xs bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-full hover:bg-green-200 dark:hover:bg-green-900/50 transition-colors" onclick="filterApplications('approved')">
                                Approved (4)
                            </button>
                            <button class="px-3 py-1 text-xs bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 rounded-full hover:bg-yellow-200 dark:hover:bg-yellow-900/50 transition-colors" onclick="filterApplications('pending')">
                                Pending (1)
                            </button>
                            <button class="px-3 py-1 text-xs bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 rounded-full hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors" onclick="filterApplications('rejected')">
                                Rejected (0)
                            </button>
                        </div>
                    </div>

                    <div class="space-y-4" id="applications-list">
                        @php
                            $applications = [
                                [
                                    'id' => 'APP-2025-078',
                                    'type' => 'Working Capital Loan',
                                    'amount' => 200000,
                                    'status' => 'pending',
                                    'applied_date' => '2025-07-28',
                                    'decision_date' => null,
                                    'loan_officer' => 'John Smith',
                                    'purpose' => 'Inventory expansion for Q4',
                                    'term' => '24 months',
                                    'rate' => '12.5%'
                                ],
                                [
                                    'id' => 'APP-2025-012',
                                    'type' => 'Equipment Financing',
                                    'amount' => 150000,
                                    'status' => 'approved',
                                    'applied_date' => '2025-03-15',
                                    'decision_date' => '2025-03-22',
                                    'loan_officer' => 'Sarah Johnson',
                                    'purpose' => 'New manufacturing equipment',
                                    'term' => '36 months',
                                    'rate' => '11.8%'
                                ],
                                [
                                    'id' => 'APP-2024-189',
                                    'type' => 'Business Line of Credit',
                                    'amount' => 300000,
                                    'status' => 'approved',
                                    'applied_date' => '2024-11-10',
                                    'decision_date' => '2024-11-18',
                                    'loan_officer' => 'Mike Davis',
                                    'purpose' => 'General business operations',
                                    'term' => 'Revolving',
                                    'rate' => '13.2%'
                                ],
                                [
                                    'id' => 'APP-2024-045',
                                    'type' => 'Commercial Real Estate',
                                    'amount' => 500000,
                                    'status' => 'approved',
                                    'applied_date' => '2024-05-20',
                                    'decision_date' => '2024-06-02',
                                    'loan_officer' => 'Lisa Brown',
                                    'purpose' => 'Purchase warehouse facility',
                                    'term' => '180 months',
                                    'rate' => '9.5%'
                                ],
                                [
                                    'id' => 'APP-2023-234',
                                    'type' => 'SBA Loan',
                                    'amount' => 75000,
                                    'status' => 'approved',
                                    'applied_date' => '2023-08-12',
                                    'decision_date' => '2023-09-28',
                                    'loan_officer' => 'John Smith',
                                    'purpose' => 'Business startup capital',
                                    'term' => '84 months',
                                    'rate' => '8.9%'
                                ]
                            ];
                        @endphp

                        @foreach($applications as $app)
                        <div class="application-item border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors" data-status="{{ $app['status'] }}">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">{{ $app['id'] }}</h4>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            {{ $app['status'] === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                            {{ $app['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                                            {{ $app['status'] === 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : '' }}">
                                            {{ ucfirst($app['status']) }}
                                        </span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($app['applied_date'])->format('M j, Y') }}</span>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <div class="text-gray-900 dark:text-white font-medium">{{ $app['type'] }}</div>
                                            <div class="text-gray-600 dark:text-gray-400">{{ $app['purpose'] }}</div>
                                        </div>
                                        <div>
                                            <div class="text-gray-900 dark:text-white font-medium">{{ number_format($app['amount'], 0) }}</div>
                                            <div class="text-gray-600 dark:text-gray-400">{{ $app['term'] }} • {{ $app['rate'] }}</div>
                                        </div>
                                    </div>

                                    <div class="mt-3 flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                        <div>Loan Officer: {{ $app['loan_officer'] }}</div>
                                        @if($app['decision_date'])
                                            <div>Decision: {{ \Carbon\Carbon::parse($app['decision_date'])->format('M j, Y') }}</div>
                                        @else
                                            <div>Under Review</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="ml-4 flex space-x-2">
                                    <button class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 text-sm font-medium">
                                        View
                                    </button>
                                    @if($app['status'] === 'approved')
                                        <button class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300 text-sm font-medium">
                                            Documents
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Active Loans -->
                <div class="mt-6 bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Active Loans</h3>
                    
                    <div class="space-y-4">
                        @php
                            $activeLoans = [
                                [
                                    'loan_number' => 'LOAN-2024-156',
                                    'type' => 'Business Line of Credit',
                                    'original_amount' => 300000,
                                    'current_balance' => 185000,
                                    'payment_status' => 'current',
                                    'next_payment' => '2025-08-15',
                                    'payment_amount' => 2850,
                                    'rate' => '13.2%',
                                    'maturity' => '2027-11-18'
                                ],
                                [
                                    'loan_number' => 'LOAN-2024-089',
                                    'type' => 'Equipment Financing',
                                    'original_amount' => 150000,
                                    'current_balance' => 127500,
                                    'payment_status' => 'current',
                                    'next_payment' => '2025-08-10',
                                    'payment_amount' => 4250,
                                    'rate' => '11.8%',
                                    'maturity' => '2028-03-22'
                                ]
                            ];
                        @endphp

                        @foreach($activeLoans as $loan)
                        <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-white">{{ $loan['loan_number'] }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $loan['type'] }}</p>
                                </div>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                    {{ ucfirst($loan['payment_status']) }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                <div>
                                    <div class="text-gray-500 dark:text-gray-400">Current Balance</div>
                                    <div class="font-medium text-gray-900 dark:text-white">{{ number_format($loan['current_balance'], 0) }}</div>
                                </div>
                                <div>
                                    <div class="text-gray-500 dark:text-gray-400">Next Payment</div>
                                    <div class="font-medium text-gray-900 dark:text-white">{{ number_format($loan['payment_amount'], 0) }} on {{ \Carbon\Carbon::parse($loan['next_payment'])->format('M j, Y') }}</div>
                                </div>
                                <div>
                                    <div class="text-gray-500 dark:text-gray-400">Rate • Maturity</div>
                                    <div class="font-medium text-gray-900 dark:text-white">{{ $loan['rate'] }} • {{ \Carbon\Carbon::parse($loan['maturity'])->format('M Y') }}</div>
                                </div>
                            </div>

                            <div class="mt-3 flex justify-end space-x-3">
                                <button class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 text-sm font-medium">
                                    Payment History
                                </button>
                                <button class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300 text-sm font-medium">
                                    Make Payment
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Customer Information -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Customer Information</h4>
                    <div class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Business Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $customer->name ?? 'ABC Manufacturing LLC' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Industry</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $customer->industry ?? 'Manufacturing' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Years in Business</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $customer->years_in_business ?? '15 years' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Annual Revenue</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ number_format($customer->annual_revenue ?? 5200000, 0) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Employees</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $customer->employees ?? '45-75' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Customer Since</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($customer->customer_since ?? '2022-03-15')->format('M j, Y') }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Credit Profile -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Credit Profile</h4>
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-500 dark:text-gray-400">Credit Score</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $customer->credit_score ?? 785 }}</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: {{ (($customer->credit_score ?? 785) - 300) / 550 * 100 }}%"></div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <div class="text-gray-500 dark:text-gray-400">Risk Grade</div>
                                <div class="font-medium text-gray-900 dark:text-white">{{ $customer->risk_grade ?? 'A' }}</div>
                            </div>
                            <div>
                                <div class="text-gray-500 dark:text-gray-400">DSCR</div>
                                <div class="font-medium text-gray-900 dark:text-white">{{ $customer->dscr ?? '1.45' }}</div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 dark:border-gray-600 pt-3">
                            <div class="text-sm text-gray-500 dark:text-gray-400 mb-2">Credit Utilization</div>
                            <div class="flex justify-between text-sm mb-1">
                                <span>{{ number_format($customer->total_utilized ?? 312500, 0) }} of {{ number_format($customer->total_credit_limit ?? 750000, 0) }}</span>
                                <span class="font-medium">{{ round((($customer->total_utilized ?? 312500) / ($customer->total_credit_limit ?? 750000)) * 100, 1) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ round((($customer->total_utilized ?? 312500) / ($customer->total_credit_limit ?? 750000)) * 100, 1) }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Recent Activity</h4>
                    <div class="space-y-3">
                        @php
                            $recentActivity = [
                                ['action' => 'New application submitted', 'date' => '2025-07-28', 'type' => 'application'],
                                ['action' => 'Payment received', 'date' => '2025-07-15', 'type' => 'payment'],
                                ['action' => 'Credit limit increased', 'date' => '2025-06-20', 'type' => 'limit'],
                                ['action' => 'Annual review completed', 'date' => '2025-03-15', 'type' => 'review'],
                            ];
                        @endphp

                        @foreach($recentActivity as $activity)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="h-6 w-6 rounded-full {{ $activity['type'] === 'application' ? 'bg-blue-100 dark:bg-blue-900/30' : ($activity['type'] === 'payment' ? 'bg-green-100 dark:bg-green-900/30' : 'bg-purple-100 dark:bg-purple-900/30') }} flex items-center justify-center">
                                    <svg class="h-3 w-3 {{ $activity['type'] === 'application' ? 'text-blue-600 dark:text-blue-400' : ($activity['type'] === 'payment' ? 'text-green-600 dark:text-green-400' : 'text-purple-600 dark:text-purple-400') }}" fill="currentColor" viewBox="0 0 20 20">
                                        <circle cx="10" cy="10" r="3"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $activity['action'] }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($activity['date'])->format('M j, Y') }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6">
                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Quick Actions</h4>
                    <div class="space-y-3">
                        <button class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Request Documents
                        </button>
                        <button class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Send Message
                        </button>
                        <button class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Schedule Review
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for filtering applications -->
    <script>
        function filterApplications(status) {
            const applications = document.querySelectorAll('.application-item');
            
            applications.forEach(app => {
                if (status === 'all' || app.dataset.status === status) {
                    app.style.display = 'block';
                } else {
                    app.style.display = 'none';
                }
            });
        }
    </script>
@endsection