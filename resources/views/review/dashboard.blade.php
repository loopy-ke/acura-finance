@extends('layouts.app')

@section('title', 'Credit Review Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Credit Review Dashboard</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">Review and approve credit applications assigned to you</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <a href="{{ route('credit.applications.index') }}" 
               class="inline-flex items-center rounded-full bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                All Applications
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Pending Review</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ number_format($stats['pending_review']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Assigned to Me</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ number_format($stats['assigned_to_me']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Overdue</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ number_format($stats['overdue']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Escalated</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ number_format($stats['escalated']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form method="GET" class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
                <div>
                    <label for="review_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Review Level</label>
                    <select name="review_level" id="review_level" class="mt-1 block w-full rounded-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="">All Levels</option>
                        <option value="1" {{ request('review_level') === '1' ? 'selected' : '' }}>Level 1</option>
                        <option value="2" {{ request('review_level') === '2' ? 'selected' : '' }}>Level 2</option>
                        <option value="3" {{ request('review_level') === '3' ? 'selected' : '' }}>Level 3</option>
                        <option value="4" {{ request('review_level') === '4' ? 'selected' : '' }}>Executive</option>
                    </select>
                </div>

                <div>
                    <label for="amount_min" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Min Amount</label>
                    <input type="number" name="amount_min" id="amount_min" value="{{ request('amount_min') }}" step="1000"
                           class="mt-1 block w-full rounded-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                           placeholder="0">
                </div>

                <div>
                    <label for="amount_max" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Max Amount</label>
                    <input type="number" name="amount_max" id="amount_max" value="{{ request('amount_max') }}" step="1000"
                           class="mt-1 block w-full rounded-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                           placeholder="1000000">
                </div>

                <div class="flex items-center">
                    <input id="overdue" name="overdue" type="checkbox" value="1" {{ request('overdue') ? 'checked' : '' }}
                           class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded">
                    <label for="overdue" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                        Show overdue only
                    </label>
                </div>

                <div class="flex items-end">
                    <button type="submit" class="w-full inline-flex justify-center items-center rounded-full bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                        Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Applications for Review -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Applications for Review</h3>
                <div class="flow-root">
                    @forelse($applicationsForReview as $application)
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-4 last:border-b-0 last:pb-0 last:mb-0">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $application->application_number }}</p>
                                    @php
                                        $statusColors = [
                                            'submitted' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                            'under_review' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                            'escalated' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300',
                                        ];
                                    @endphp
                                    <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $statusColors[$application->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                        {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $application->customer->company_name }}</p>
                                <div class="flex items-center justify-between mt-2">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">KES {{ number_format($application->requested_amount, 2) }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $application->created_at->diffForHumans() }}</p>
                                </div>
                                @if($application->creditProduct)
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $application->creditProduct->name }}</p>
                                @endif
                            </div>
                            <div class="ml-4">
                                <a href="{{ route('credit.review.show', $application) }}" 
                                   class="inline-flex items-center rounded-full bg-blue-600 px-3 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Review
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-6">
                        <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No applications for review</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">All applications have been processed or you don't have any assigned.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Decisions -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Recent Decisions</h3>
                <div class="flow-root">
                    @forelse($recentDecisions as $decision)
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-4 last:border-b-0 last:pb-0 last:mb-0">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $decision->application_number }}</p>
                                    @php
                                        $decisionColors = [
                                            'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                            'denied' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                        ];
                                    @endphp
                                    <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $decisionColors[$decision->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                        {{ ucfirst($decision->status) }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $decision->customer->company_name }}</p>
                                <div class="flex items-center justify-between mt-2">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        KES {{ number_format($decision->status === 'approved' ? $decision->approved_amount : $decision->requested_amount, 2) }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $decision->decision_date->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="ml-4">
                                <a href="{{ route('credit.applications.show', $decision) }}" 
                                   class="inline-flex items-center rounded-full bg-gray-600 px-3 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-6">
                        <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No recent decisions</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">You haven't made any credit decisions recently.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection