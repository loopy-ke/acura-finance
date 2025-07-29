@extends('layouts.app')

@section('title', 'Edit Credit Application ' . $application->application_number)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Edit Application {{ $application->application_number }}</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">{{ $application->customer->company_name }}</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <a href="{{ route('credit.applications.show', $application) }}" 
               class="inline-flex items-center rounded-full bg-gray-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Application
            </a>
        </div>
    </div>

    <!-- Current Status Alert -->
    <div class="bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">Application Status: {{ ucfirst($application->status) }}</h3>
                <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                    <p>This application can be edited because it is in {{ $application->status }} status.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <form method="POST" action="{{ route('credit.applications.update', $application) }}" class="space-y-6 px-4 py-5 sm:p-6">
            @csrf
            @method('PUT')

            <!-- Customer Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Customer *</label>
                @include('credit-financing::components.customer-search', [
                    'name' => 'customer_id',
                    'selected' => $application->customer ? [
                        'id' => $application->customer->id,
                        'name' => $application->customer->company_name,
                        'email' => $application->customer->email,
                        'phone' => $application->customer->phone,
                        'display' => $application->customer->company_name . ' (' . $application->customer->email . ')'
                    ] : null,
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
                               value="{{ old('requested_amount', $application->requested_amount) }}" step="0.01" min="0"
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
                           value="{{ old('requested_term_months', $application->requested_term_months) }}" min="1" max="60"
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
                       value="{{ old('purpose', $application->purpose) }}" maxlength="500"
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
                          placeholder="Detailed justification for this credit request...">{{ old('business_justification', $application->business_justification) }}</textarea>
                @error('business_justification')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('credit.applications.show', $application) }}" 
                   class="inline-flex items-center rounded-full bg-white dark:bg-gray-700 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 shadow-sm border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    Cancel
                </a>
                <button type="submit" 
                        class="inline-flex items-center rounded-full bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    Update Application
                </button>
            </div>
        </form>
    </div>

    <!-- Delete Application -->
    @can('delete', $application)
        @if($application->canBeDeleted())
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Delete Application</h3>
                <div class="mt-2 max-w-xl text-sm text-gray-500 dark:text-gray-400">
                    <p>This will permanently delete the credit application. This action cannot be undone.</p>
                </div>
                <div class="mt-5">
                    <form method="POST" action="{{ route('credit.applications.destroy', $application) }}" 
                          onsubmit="return confirm('Are you sure you want to delete this application? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center rounded-full bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            Delete Application
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif
    @endcan
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