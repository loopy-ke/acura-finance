@extends('layouts.app')

@section('title', 'New Credit Application')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">New Credit Application</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">Create a new credit application for a customer</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <a href="{{ route('credit.applications.index') }}" 
               class="inline-flex items-center rounded-full bg-gray-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Applications
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <form method="POST" action="{{ route('credit.applications.store') }}" class="space-y-6 px-4 py-5 sm:p-6">
            @csrf

            <!-- Customer Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Customer *</label>
                @include('credit-financing::components.customer-search', [
                    'name' => 'customer_id',
                    'selected' => old('customer_id') ? ['id' => old('customer_id')] : null,
                    'placeholder' => 'Search for a customer by name, email, or phone...',
                    'required' => true
                ])
                @error('customer_id')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Financing Partner -->
            <div>
                    <option value="">Use default financing</option>
                    @foreach($financingPartners as $partner)
                            {{ $partner->partner_name }} ({{ $partner->partner_type }})
                        </option>
                    @endforeach
                </select>
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Amount and Term -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="requested_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Requested Amount *</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 dark:text-gray-400 sm:text-sm">KES</span>
                        </div>
                        <input type="number" name="requested_amount" id="requested_amount" required
                               value="{{ old('requested_amount') }}" step="0.01" min="0"
                               class="pl-12 block w-full rounded-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('requested_amount') border-red-300 @enderror"
                               placeholder="0.00">
                    </div>
                    @error('requested_amount')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="requested_term_months" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Term (Months) *</label>
                    <input type="number" name="requested_term_months" id="requested_term_months" required
                           value="{{ old('requested_term_months') }}" min="1" max="60"
                           class="mt-1 block w-full rounded-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('requested_term_months') border-red-300 @enderror"
                           placeholder="12">
                    @error('requested_term_months')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Purpose -->
            <div>
                <label for="purpose" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Purpose *</label>
                <input type="text" name="purpose" id="purpose" required
                       value="{{ old('purpose') }}" maxlength="500"
                       class="mt-1 block w-full rounded-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('purpose') border-red-300 @enderror"
                       placeholder="Brief description of the credit purpose">
                @error('purpose')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Business Justification -->
            <div>
                <label for="business_justification" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Business Justification *</label>
                <textarea name="business_justification" id="business_justification" rows="4" required
                          maxlength="1000"
                          class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('business_justification') border-red-300 @enderror"
                          placeholder="Detailed justification for this credit request...">{{ old('business_justification') }}</textarea>
                @error('business_justification')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Auto Submit Option -->
            <div class="relative flex items-start">
                <div class="flex items-center h-5">
                    <input id="auto_submit" name="auto_submit" type="checkbox" value="1" {{ old('auto_submit') ? 'checked' : '' }}
                           class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded">
                </div>
                <div class="ml-3 text-sm">
                    <label for="auto_submit" class="font-medium text-gray-700 dark:text-gray-300">Auto-submit for processing</label>
                    <p class="text-gray-500 dark:text-gray-400">Automatically submit this application for credit scoring and decision</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('credit.applications.index') }}" 
                   class="inline-flex items-center rounded-full bg-white dark:bg-gray-700 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 shadow-sm border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    Cancel
                </a>
                <button type="submit" 
                        class="inline-flex items-center rounded-full bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    Create Application
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Format amount input
    const amountInput = document.getElementById('requested_amount');
    amountInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^\d.]/g, '');
        e.target.value = value;
    });
});
</script>
@endsection