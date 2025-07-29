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
                                <a href="{{ route('credit-financing.collection.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400 hover:text-blue-600 dark:hover:text-white">
                                    Collections
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">Case Details</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <div class="flex items-center space-x-4">
                    <h1 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl">
                        {{ $case->customer_name ?? 'ABC Manufacturing' }}
                    </h1>
                    <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full {{ ($case->status ?? 'in_progress') === 'resolved' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : (($case->status ?? 'in_progress') === 'in_progress' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400') }}">
                        {{ ucfirst(str_replace('_', ' ', $case->status ?? 'In Progress')) }}
                    </span>
                </div>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Account: {{ $case->account_number ?? 'CFA-2024-001' }} | {{ $case->days_overdue ?? 45 }} days overdue
                </p>
            </div>
            <div class="mt-4 flex space-x-3 sm:mt-0">
                <button type="button" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-full hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    Contact Customer
                </button>
                <button type="button" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-full hover:bg-green-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add Note
                </button>
            </div>
        </div>

        <!-- Case Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @php
                $overview = [
                    ['label' => 'Outstanding Amount', 'value' => 15000, 'format' => 'currency', 'color' => 'red'],
                    ['label' => 'Original Amount', 'value' => 18500, 'format' => 'currency', 'color' => 'gray'],
                    ['label' => 'Payments Received', 'value' => 3500, 'format' => 'currency', 'color' => 'green'],
                    ['label' => 'Days Overdue', 'value' => 45, 'format' => 'days', 'color' => 'orange'],
                ];
            @endphp

            @foreach($overview as $item)
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-{{ $item['color'] }}-100 dark:bg-{{ $item['color'] }}-900/30 rounded-lg flex items-center justify-center">
                            @if($item['format'] === 'currency')
                                <svg class="w-5 h-5 text-{{ $item['color'] }}-600 dark:text-{{ $item['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-{{ $item['color'] }}-600 dark:text-{{ $item['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @endif
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">{{ $item['label'] }}</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                @if($item['format'] === 'currency')
                                    {{ number_format($item['value'], 2) }}
                                @elseif($item['format'] === 'days')
                                    {{ $item['value'] }} days
                                @else
                                    {{ number_format($item['value']) }}
                                @endif
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Customer Information -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Customer Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Company Name</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $case->customer_name ?? 'ABC Manufacturing' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Contact Person</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $case->contact_person ?? 'John Doe' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $case->phone ?? '+1 (555) 123-4567' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $case->email ?? 'john.doe@abcmanufacturing.com' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Address</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $case->address ?? '123 Industrial Way, Business City, BC 12345' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Credit Limit</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ number_format($case->credit_limit ?? 50000, 2) }}</dd>
                </div>
            </div>
        </div>

        <!-- Collection Activities -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Activity Log -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Collection Activity</h3>
                </div>
                <div class="p-6">
                    <div class="flow-root">
                        <ul class="-mb-8">
                            @php
                                $activities = [
                                    ['type' => 'phone_call', 'description' => 'Called customer - No answer, left voicemail', 'user' => 'John Smith', 'date' => '2024-12-07 14:30'],
                                    ['type' => 'email', 'description' => 'Sent payment reminder email', 'user' => 'John Smith', 'date' => '2024-12-05 09:15'],
                                    ['type' => 'note', 'description' => 'Customer promised payment by end of week', 'user' => 'John Smith', 'date' => '2024-12-03 16:45'],
                                    ['type' => 'letter', 'description' => 'Sent formal demand letter', 'user' => 'System', 'date' => '2024-12-01 10:00'],
                                    ['type' => 'assignment', 'description' => 'Case assigned to John Smith', 'user' => 'System', 'date' => '2024-11-28 08:30'],
                                ];
                            @endphp

                            @foreach($activities as $index => $activity)
                            <li>
                                <div class="relative pb-8">
                                    @if($index < count($activities) - 1)
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-600" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white dark:ring-gray-800
                                                {{ $activity['type'] === 'phone_call' ? 'bg-blue-500' : '' }}
                                                {{ $activity['type'] === 'email' ? 'bg-green-500' : '' }}
                                                {{ $activity['type'] === 'note' ? 'bg-yellow-500' : '' }}
                                                {{ $activity['type'] === 'letter' ? 'bg-red-500' : '' }}
                                                {{ $activity['type'] === 'assignment' ? 'bg-gray-500' : '' }}">
                                                @if($activity['type'] === 'phone_call')
                                                    <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                                    </svg>
                                                @elseif($activity['type'] === 'email')
                                                    <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                                    </svg>
                                                @elseif($activity['type'] === 'note')
                                                    <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                                    </svg>
                                                @else
                                                    <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                    </svg>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div>
                                                <div class="text-sm text-gray-900 dark:text-white">
                                                    {{ $activity['description'] }}
                                                </div>
                                                <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $activity['user'] }} • {{ \Carbon\Carbon::parse($activity['date'])->format('M j, Y g:i A') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Payment History -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Payment History</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/20">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Method</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @php
                                $payments = [
                                    ['date' => '2024-11-15', 'amount' => 2000, 'method' => 'Bank Transfer'],
                                    ['date' => '2024-10-20', 'amount' => 1500, 'method' => 'Check'],
                                    ['date' => '2024-09-15', 'amount' => 2500, 'method' => 'Bank Transfer'],
                                ];
                            @endphp

                            @forelse($payments as $payment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($payment['date'])->format('M j, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900 dark:text-white">
                                    {{ number_format($payment['amount'], 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                    {{ $payment['method'] }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                    No payments recorded
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-6">
            <h4 class="text-lg font-medium text-yellow-900 dark:text-yellow-100 mb-4">Quick Actions</h4>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <button class="flex items-center justify-center px-4 py-3 bg-white dark:bg-gray-800 border border-yellow-300 dark:border-yellow-600 rounded-lg hover:bg-yellow-50 dark:hover:bg-yellow-900/30 transition-colors">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">Make Call</span>
                </button>
                
                <button class="flex items-center justify-center px-4 py-3 bg-white dark:bg-gray-800 border border-yellow-300 dark:border-yellow-600 rounded-lg hover:bg-yellow-50 dark:hover:bg-yellow-900/30 transition-colors">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">Send Email</span>
                </button>
                
                <button class="flex items-center justify-center px-4 py-3 bg-white dark:bg-gray-800 border border-yellow-300 dark:border-yellow-600 rounded-lg hover:bg-yellow-50 dark:hover:bg-yellow-900/30 transition-colors">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">Record Payment</span>
                </button>
                
                <button class="flex items-center justify-center px-4 py-3 bg-white dark:bg-gray-800 border border-yellow-300 dark:border-yellow-600 rounded-lg hover:bg-yellow-50 dark:hover:bg-yellow-900/30 transition-colors">
                    <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">Legal Action</span>
                </button>
            </div>
        </div>
    </div>
@endsection