@extends('layouts.app')

@section('title', 'Credit Application ' . $application->application_number)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Application {{ $application->application_number }}</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">{{ $application->customer->company_name }}</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none space-x-3">
            @can('update', $application)
                @if($application->canBeEdited())
                    <a href="{{ route('credit.applications.edit', $application) }}" 
                       class="inline-flex items-center rounded-full bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                        Edit
                    </a>
                @endif

                @if($application->status === 'draft')
                    <form method="POST" action="{{ route('credit.applications.submit', $application) }}" class="inline">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center rounded-full bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            Submit for Review
                        </button>
                    </form>
                @endif
            @endcan

            <a href="{{ route('credit.applications.index') }}" 
               class="inline-flex items-center rounded-full bg-gray-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                Back to Applications
            </a>
        </div>
    </div>

    <!-- Status and Overview -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Status</h3>
                    @php
                        $statusColors = [
                            'draft' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                            'submitted' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                            'under_review' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                            'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                            'denied' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                        ];
                    @endphp
                    <span class="mt-2 inline-flex rounded-full px-3 py-1 text-sm font-semibold {{ $statusColors[$application->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($application->status) }}
                    </span>
                    @if($application->submission_date)
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Submitted: {{ $application->submission_date->format('M j, Y g:i A') }}</p>
                    @endif
                    @if($application->decision_date)
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Decision: {{ $application->decision_date->format('M j, Y g:i A') }}</p>
                    @endif
                </div>

                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Requested Terms</h3>
                    <p class="mt-2 text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($application->requested_amount, 2) }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $application->requested_term_months }} months</p>
                </div>

                @if($application->approved_amount)
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Approved Terms</h3>
                    <p class="mt-2 text-2xl font-semibold text-green-600 dark:text-green-400">{{ number_format($application->approved_amount, 2) }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $application->approved_term_months }} months @ {{ number_format($application->approved_interest_rate * 100, 2) }}%
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Application Details -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Application Details</h3>
            
            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Customer</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                        {{ $application->customer->company_name }}<br>
                        <span class="text-gray-500 dark:text-gray-400">{{ $application->customer->contact_email }}</span>
                    </dd>
                </div>

                @if($application->financingPartner)
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Financing Partner</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                        {{ $application->financingPartner->partner_name }}<br>
                        <span class="text-gray-500 dark:text-gray-400">{{ ucfirst($application->financingPartner->partner_type) }}</span>
                    </dd>
                </div>
                @endif

                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Purpose</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $application->purpose }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created By</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                        {{ $application->createdBy->name }}<br>
                        <span class="text-gray-500 dark:text-gray-400">{{ $application->created_at->format('M j, Y g:i A') }}</span>
                    </dd>
                </div>

                @if($application->credit_score_at_application)
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Credit Score</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                        <span class="text-lg font-semibold">{{ $application->credit_score_at_application }}</span>/100
                    </dd>
                </div>
                @endif
            </dl>

            <div class="mt-6">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Business Justification</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                    {{ $application->business_justification }}
                </dd>
            </div>
        </div>
    </div>

    <!-- Decision Actions -->
    @can('approve', $application)
        @if($application->canBeApproved() || $application->canBeDenied())
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Credit Decision</h3>
                
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <!-- Approval Form -->
                    @if($application->canBeApproved())
                    <div class="border border-green-200 dark:border-green-700 rounded-lg p-4">
                        <h4 class="text-md font-medium text-green-800 dark:text-green-300 mb-3">Approve Application</h4>
                        <form method="POST" action="{{ route('credit.applications.approve', $application) }}" class="space-y-4">
                            @csrf
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Amount</label>
                                    <input type="number" name="approved_amount" step="0.01" 
                                           value="{{ $application->requested_amount }}" max="{{ $application->requested_amount }}"
                                           class="mt-1 block w-full rounded-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm"
                                           required>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Term (Months)</label>
                                    <input type="number" name="approved_term_months" 
                                           value="{{ $application->requested_term_months }}" min="1" max="60"
                                           class="mt-1 block w-full rounded-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm"
                                           required>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Interest Rate (%)</label>
                                    <input type="number" name="approved_interest_rate" step="0.01" 
                                           value="12.00" min="0" max="100"
                                           class="mt-1 block w-full rounded-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm"
                                           required>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fee (%)</label>
                                    <input type="number" name="approved_fee_percentage" step="0.01" 
                                           value="3.00" min="0" max="100"
                                           class="mt-1 block w-full rounded-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm"
                                           required>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Conditions</label>
                                <textarea name="conditions" rows="3" 
                                          class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm"
                                          placeholder="Optional approval conditions..."></textarea>
                            </div>

                            <button type="submit" 
                                    class="w-full inline-flex justify-center items-center rounded-full bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                Approve Application
                            </button>
                        </form>
                    </div>
                    @endif

                    <!-- Denial Form -->
                    @if($application->canBeDenied())
                    <div class="border border-red-200 dark:border-red-700 rounded-lg p-4">
                        <h4 class="text-md font-medium text-red-800 dark:text-red-300 mb-3">Deny Application</h4>
                        <form method="POST" action="{{ route('credit.applications.deny', $application) }}" class="space-y-4">
                            @csrf
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reason for Denial</label>
                                <textarea name="denial_reason" rows="4" required
                                          class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                          placeholder="Explain why this application is being denied..."></textarea>
                            </div>

                            <button type="submit" 
                                    class="w-full inline-flex justify-center items-center rounded-full bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                Deny Application
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    @endcan

    <!-- Decision History -->
    @if($application->decisions->count() > 0)
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Decision History</h3>
            
            <div class="flow-root">
                <ul class="-mb-8">
                    @foreach($application->decisions as $decision)
                    <li>
                        <div class="relative pb-8">
                            @unless($loop->last)
                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-600" aria-hidden="true"></span>
                            @endunless
                            <div class="relative flex space-x-3">
                                <div>
                                    @if($decision->decision === 'approved')
                                        <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                            <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </span>
                                    @elseif($decision->decision === 'denied')
                                        <span class="h-8 w-8 rounded-full bg-red-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                            <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                            </svg>
                                        </span>
                                    @else
                                        <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                            <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a1 1 0 102 0V3a2 2 0 012 2v6a2 2 0 01-2 2V9a1 1 0 10-2 0v2a2 2 0 01-2-2V5z" clip-rule="evenodd"/>
                                            </svg>
                                        </span>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            <span class="font-medium text-gray-900 dark:text-white">{{ ucfirst($decision->decision) }}</span>
                                            by {{ $decision->decidedBy->name ?? 'System' }}
                                            @if($decision->approved_amount)
                                                - Amount: {{ number_format($decision->approved_amount, 2) }}
                                            @endif
                                        </p>
                                        @if($decision->denial_reason_text)
                                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ $decision->denial_reason_text }}</p>
                                        @endif
                                    </div>
                                    <div class="text-right text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                        {{ $decision->created_at->format('M j, Y g:i A') }}
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
    @endif
</div>
@endsection