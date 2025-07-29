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
                                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">Credit Review</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl">
                    Credit Review Dashboard
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Monitor and manage periodic credit reviews and risk assessments
                </p>
            </div>
            <div class="mt-4 flex space-x-3 sm:mt-0">
                <a href="{{ route('credit-financing.review.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-full hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Schedule Review
                </a>
            </div>
        </div>

        <!-- Review Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @php
                $stats = [
                    ['label' => 'Due This Month', 'value' => 23, 'color' => 'red', 'icon' => 'exclamation'],
                    ['label' => 'In Progress', 'value' => 18, 'color' => 'yellow', 'icon' => 'clock'],
                    ['label' => 'Completed This Month', 'value' => 45, 'color' => 'green', 'icon' => 'check'],
                    ['label' => 'Avg Review Time', 'value' => '5.2 days', 'color' => 'blue', 'icon' => 'chart'],
                ];
            @endphp

            @foreach($stats as $stat)
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-{{ $stat['color'] }}-100 dark:bg-{{ $stat['color'] }}-900/30 rounded-lg flex items-center justify-center">
                            @if($stat['icon'] === 'exclamation')
                                <svg class="w-5 h-5 text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @elseif($stat['icon'] === 'clock')
                                <svg class="w-5 h-5 text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @elseif($stat['icon'] === 'check')
                                <svg class="w-5 h-5 text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            @endif
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">{{ $stat['label'] }}</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stat['value'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Priority Reviews Alert -->
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                        Overdue Reviews
                    </h3>
                    <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                        <p>7 credit reviews are overdue and require immediate attention. <a href="#overdue" class="font-medium underline">View overdue reviews</a></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Review Filters -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-6 gap-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">All Status</option>
                        <option value="scheduled">Scheduled</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="overdue">Overdue</option>
                    </select>
                </div>
                
                <div>
                    <label for="review_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Review Type</label>
                    <select name="review_type" id="review_type" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">All Types</option>
                        <option value="annual">Annual Review</option>
                        <option value="quarterly">Quarterly Review</option>
                        <option value="triggered">Risk Triggered</option>
                        <option value="regulatory">Regulatory</option>
                    </select>
                </div>
                
                <div>
                    <label for="risk_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Risk Level</label>
                    <select name="risk_level" id="risk_level" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">All Levels</option>
                        <option value="low">Low Risk</option>
                        <option value="medium">Medium Risk</option>
                        <option value="high">High Risk</option>
                        <option value="critical">Critical</option>
                    </select>
                </div>
                
                <div>
                    <label for="assigned_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Assigned To</label>
                    <select name="assigned_to" id="assigned_to" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">All Reviewers</option>
                        <option value="john_smith">John Smith</option>
                        <option value="sarah_johnson">Sarah Johnson</option>
                        <option value="mike_davis">Mike Davis</option>
                        <option value="lisa_brown">Lisa Brown</option>
                    </select>
                </div>
                
                <div>
                    <label for="due_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Due Date</label>
                    <select name="due_date" id="due_date" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">All Dates</option>
                        <option value="overdue">Overdue</option>
                        <option value="this_week">This Week</option>
                        <option value="this_month">This Month</option>
                        <option value="next_month">Next Month</option>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>

        <!-- Review Calendar Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Upcoming Reviews -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Upcoming Reviews (Next 7 Days)</h3>
                <div class="space-y-4">
                    @php
                        $upcomingReviews = [
                            ['date' => '2025-07-29', 'customer' => 'ABC Manufacturing', 'type' => 'Annual Review', 'reviewer' => 'John Smith', 'risk' => 'medium'],
                            ['date' => '2025-07-30', 'customer' => 'XYZ Corporation', 'type' => 'Quarterly Review', 'reviewer' => 'Sarah Johnson', 'risk' => 'low'],
                            ['date' => '2025-07-31', 'customer' => 'Global Enterprises', 'type' => 'Risk Triggered', 'reviewer' => 'Mike Davis', 'risk' => 'high'],
                            ['date' => '2025-08-01', 'customer' => 'Tech Solutions Inc', 'type' => 'Annual Review', 'reviewer' => 'Lisa Brown', 'risk' => 'medium'],
                            ['date' => '2025-08-02', 'customer' => 'Local Business LLC', 'type' => 'Quarterly Review', 'reviewer' => 'John Smith', 'risk' => 'low'],
                        ];
                    @endphp

                    @foreach($upcomingReviews as $review)
                    <div class="flex items-center space-x-4 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="flex-shrink-0">
                            <div class="text-center">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($review['date'])->format('M') }}</div>
                                <div class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ \Carbon\Carbon::parse($review['date'])->format('d') }}</div>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $review['customer'] }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $review['type'] }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Assigned to {{ $review['reviewer'] }}</div>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                {{ $review['risk'] === 'high' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : '' }}
                                {{ $review['risk'] === 'medium' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                                {{ $review['risk'] === 'low' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}">
                                {{ ucfirst($review['risk']) }} Risk
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Review Workload Distribution -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Review Workload by Reviewer</h3>
                <div class="space-y-4">
                    @php
                        $workload = [
                            ['reviewer' => 'John Smith', 'active' => 8, 'due_this_week' => 3, 'overdue' => 1],
                            ['reviewer' => 'Sarah Johnson', 'active' => 6, 'due_this_week' => 2, 'overdue' => 0],
                            ['reviewer' => 'Mike Davis', 'active' => 9, 'due_this_week' => 4, 'overdue' => 2],
                            ['reviewer' => 'Lisa Brown', 'active' => 5, 'due_this_week' => 1, 'overdue' => 1],
                        ];
                    @endphp

                    @foreach($workload as $load)
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div>
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $load['reviewer'] }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $load['active'] }} active reviews</div>
                        </div>
                        <div class="flex items-center space-x-4 text-xs">
                            <div class="text-center">
                                <div class="font-medium text-yellow-600 dark:text-yellow-400">{{ $load['due_this_week'] }}</div>
                                <div class="text-gray-500 dark:text-gray-400">Due This Week</div>
                            </div>
                            @if($load['overdue'] > 0)
                            <div class="text-center">
                                <div class="font-medium text-red-600 dark:text-red-400">{{ $load['overdue'] }}</div>
                                <div class="text-gray-500 dark:text-gray-400">Overdue</div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Reviews Table -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700" id="overdue">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Credit Reviews</h3>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500 dark:text-gray-400">86 total reviews</span>
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Account</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Review Type</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Risk Level</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Due Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Assigned To</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @php
                            $reviews = [
                                ['account' => 'CFA-2024-001', 'customer' => 'ABC Manufacturing', 'type' => 'Annual Review', 'risk' => 'medium', 'due_date' => '2025-07-25', 'assigned_to' => 'John Smith', 'status' => 'overdue'],
                                ['account' => 'CFA-2024-089', 'customer' => 'XYZ Corporation', 'type' => 'Quarterly Review', 'risk' => 'low', 'due_date' => '2025-07-30', 'assigned_to' => 'Sarah Johnson', 'status' => 'scheduled'],
                                ['account' => 'CFA-2024-156', 'customer' => 'Global Enterprises', 'type' => 'Risk Triggered', 'risk' => 'high', 'due_date' => '2025-07-28', 'assigned_to' => 'Mike Davis', 'status' => 'in_progress'],
                                ['account' => 'CFA-2024-203', 'customer' => 'Local Business LLC', 'type' => 'Annual Review', 'risk' => 'medium', 'due_date' => '2025-08-01', 'assigned_to' => 'Lisa Brown', 'status' => 'scheduled'],
                                ['account' => 'CFA-2024-241', 'customer' => 'Tech Solutions Inc', 'type' => 'Quarterly Review', 'risk' => 'low', 'due_date' => '2025-07-22', 'assigned_to' => 'John Smith', 'status' => 'overdue'],
                                ['account' => 'CFA-2024-298', 'customer' => 'Service Providers', 'type' => 'Regulatory', 'risk' => 'critical', 'due_date' => '2025-07-29', 'assigned_to' => 'Mike Davis', 'status' => 'in_progress'],
                            ];
                        @endphp

                        @foreach($reviews as $review)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900 dark:text-white">
                                {{ $review['account'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                {{ $review['customer'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                    {{ $review['type'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $review['risk'] === 'critical' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : '' }}
                                    {{ $review['risk'] === 'high' ? 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400' : '' }}
                                    {{ $review['risk'] === 'medium' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                                    {{ $review['risk'] === 'low' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}">
                                    {{ ucfirst($review['risk']) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm {{ \Carbon\Carbon::parse($review['due_date'])->isPast() ? 'text-red-600 dark:text-red-400 font-medium' : 'text-gray-900 dark:text-white' }}">
                                {{ \Carbon\Carbon::parse($review['due_date'])->format('M j, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $review['assigned_to'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $review['status'] === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                    {{ $review['status'] === 'in_progress' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : '' }}
                                    {{ $review['status'] === 'scheduled' ? 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400' : '' }}
                                    {{ $review['status'] === 'overdue' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : '' }}">
                                    {{ ucfirst(str_replace('_', ' ', $review['status'])) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex items-center justify-center space-x-2">
                                    @if($review['status'] === 'overdue' || $review['status'] === 'scheduled')
                                        <button class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                                            Start Review
                                        </button>
                                    @elseif($review['status'] === 'in_progress')
                                        <button class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300">
                                            Continue
                                        </button>
                                    @else
                                        <button class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                                            View
                                        </button>
                                    @endif
                                    <span class="text-gray-300 dark:text-gray-600">|</span>
                                    <button class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                        Details
                                    </button>
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
                        Showing 1 to 6 of 86 reviews
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

        <!-- Bulk Actions -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
            <h4 class="text-lg font-medium text-blue-900 dark:text-blue-100 mb-4">Bulk Review Actions</h4>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <button class="flex items-center justify-center px-4 py-3 bg-white dark:bg-gray-800 border border-blue-300 dark:border-blue-600 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-colors">
                    <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">Reschedule Overdue</span>
                </button>
                
                <button class="flex items-center justify-center px-4 py-3 bg-white dark:bg-gray-800 border border-blue-300 dark:border-blue-600 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-colors">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">Reassign Reviews</span>
                </button>
                
                <button class="flex items-center justify-center px-4 py-3 bg-white dark:bg-gray-800 border border-blue-300 dark:border-blue-600 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-colors">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">Generate Report</span>
                </button>
                
                <button class="flex items-center justify-center px-4 py-3 bg-white dark:bg-gray-800 border border-blue-300 dark:border-blue-600 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-colors">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">Batch Schedule</span>
                </button>
            </div>
        </div>
    </div>
@endsection