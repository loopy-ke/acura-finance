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
                                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">Edit Profile</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl">
                    Edit Customer Profile
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Update customer information and credit profile details
                </p>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('credit-financing.customers.update', $customer->id ?? 1) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Basic Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="business_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Business Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="business_name" id="business_name" required
                                       value="{{ $customer->business_name ?? 'ABC Manufacturing LLC' }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label for="legal_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Legal Business Name
                                </label>
                                <input type="text" name="legal_name" id="legal_name"
                                       value="{{ $customer->legal_name ?? 'ABC Manufacturing Limited Liability Company' }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label for="tax_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tax ID (EIN) <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="tax_id" id="tax_id" required
                                       value="{{ $customer->tax_id ?? '12-3456789' }}"
                                       pattern="[0-9]{2}-[0-9]{7}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label for="industry" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Industry <span class="text-red-500">*</span>
                                </label>
                                <select name="industry" id="industry" required
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="manufacturing" {{ ($customer->industry ?? 'manufacturing') === 'manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                                    <option value="retail" {{ ($customer->industry ?? 'manufacturing') === 'retail' ? 'selected' : '' }}>Retail</option>
                                    <option value="services" {{ ($customer->industry ?? 'manufacturing') === 'services' ? 'selected' : '' }}>Services</option>
                                    <option value="construction" {{ ($customer->industry ?? 'manufacturing') === 'construction' ? 'selected' : '' }}>Construction</option>
                                    <option value="technology" {{ ($customer->industry ?? 'manufacturing') === 'technology' ? 'selected' : '' }}>Technology</option>
                                    <option value="healthcare" {{ ($customer->industry ?? 'manufacturing') === 'healthcare' ? 'selected' : '' }}>Healthcare</option>
                                    <option value="hospitality" {{ ($customer->industry ?? 'manufacturing') === 'hospitality' ? 'selected' : '' }}>Hospitality</option>
                                    <option value="real_estate" {{ ($customer->industry ?? 'manufacturing') === 'real_estate' ? 'selected' : '' }}>Real Estate</option>
                                    <option value="other" {{ ($customer->industry ?? 'manufacturing') === 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <div>
                                <label for="business_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Business Type <span class="text-red-500">*</span>
                                </label>
                                <select name="business_type" id="business_type" required
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="llc" {{ ($customer->business_type ?? 'llc') === 'llc' ? 'selected' : '' }}>LLC</option>
                                    <option value="corporation" {{ ($customer->business_type ?? 'llc') === 'corporation' ? 'selected' : '' }}>Corporation</option>
                                    <option value="partnership" {{ ($customer->business_type ?? 'llc') === 'partnership' ? 'selected' : '' }}>Partnership</option>
                                    <option value="sole_proprietorship" {{ ($customer->business_type ?? 'llc') === 'sole_proprietorship' ? 'selected' : '' }}>Sole Proprietorship</option>
                                    <option value="s_corp" {{ ($customer->business_type ?? 'llc') === 's_corp' ? 'selected' : '' }}>S Corporation</option>
                                </select>
                            </div>

                            <div>
                                <label for="years_in_business" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Years in Business <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="years_in_business" id="years_in_business" min="0" max="100" required
                                       value="{{ $customer->years_in_business ?? 15 }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Contact Information</h3>
                        
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Primary Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" name="email" id="email" required
                                           value="{{ $customer->email ?? 'finance@abcmfg.com' }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Primary Phone <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" name="phone" id="phone" required
                                           value="{{ $customer->phone ?? '(555) 123-4567' }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>

                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Business Address <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="address" id="address" required
                                       value="{{ $customer->address ?? '1234 Industrial Drive' }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        City <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="city" id="city" required
                                           value="{{ $customer->city ?? 'Atlanta' }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="state" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        State <span class="text-red-500">*</span>
                                    </label>
                                    <select name="state" id="state" required
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="GA" {{ ($customer->state ?? 'GA') === 'GA' ? 'selected' : '' }}>Georgia</option>
                                        <option value="AL">Alabama</option>
                                        <option value="FL">Florida</option>
                                        <option value="NC">North Carolina</option>
                                        <option value="SC">South Carolina</option>
                                        <option value="TN">Tennessee</option>
                                        <!-- Add more states as needed -->
                                    </select>
                                </div>

                                <div>
                                    <label for="zip_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        ZIP Code <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="zip_code" id="zip_code" required
                                           value="{{ $customer->zip_code ?? '30309' }}"
                                           pattern="[0-9]{5}(-[0-9]{4})?"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Information -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Financial Information</h3>
                        
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="annual_revenue" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Annual Revenue <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="annual_revenue" id="annual_revenue" step="1000" min="0" required
                                           value="{{ $customer->annual_revenue ?? 5200000 }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="employees" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Number of Employees
                                    </label>
                                    <select name="employees" id="employees"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="1-10" {{ ($customer->employees ?? '45-75') === '1-10' ? 'selected' : '' }}>1-10</option>
                                        <option value="11-25" {{ ($customer->employees ?? '45-75') === '11-25' ? 'selected' : '' }}>11-25</option>
                                        <option value="26-50" {{ ($customer->employees ?? '45-75') === '26-50' ? 'selected' : '' }}>26-50</option>
                                        <option value="45-75" {{ ($customer->employees ?? '45-75') === '45-75' ? 'selected' : '' }}>45-75</option>
                                        <option value="76-100" {{ ($customer->employees ?? '45-75') === '76-100' ? 'selected' : '' }}>76-100</option>
                                        <option value="100+" {{ ($customer->employees ?? '45-75') === '100+' ? 'selected' : '' }}>100+</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="bank_account_years" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Banking Relationship (Years)
                                    </label>
                                    <input type="number" name="bank_account_years" id="bank_account_years" min="0" max="50"
                                           value="{{ $customer->bank_account_years ?? 8 }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="primary_bank" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Primary Bank
                                    </label>
                                    <input type="text" name="primary_bank" id="primary_bank"
                                           value="{{ $customer->primary_bank ?? 'First National Bank' }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="monthly_cash_flow" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Average Monthly Cash Flow
                                    </label>
                                    <input type="number" name="monthly_cash_flow" id="monthly_cash_flow" step="1000"
                                           value="{{ $customer->monthly_cash_flow ?? 425000 }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="seasonal_business" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Seasonal Business
                                    </label>
                                    <select name="seasonal_business" id="seasonal_business"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="no" {{ ($customer->seasonal_business ?? 'no') === 'no' ? 'selected' : '' }}>No</option>
                                        <option value="yes" {{ ($customer->seasonal_business ?? 'no') === 'yes' ? 'selected' : '' }}>Yes</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Credit Information -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Credit Information</h3>
                        
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="credit_score" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Business Credit Score
                                    </label>
                                    <input type="number" name="credit_score" id="credit_score" min="300" max="850"
                                           value="{{ $customer->credit_score ?? 785 }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="risk_grade" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Risk Grade
                                    </label>
                                    <select name="risk_grade" id="risk_grade"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="A+" {{ ($customer->risk_grade ?? 'A') === 'A+' ? 'selected' : '' }}>A+</option>
                                        <option value="A" {{ ($customer->risk_grade ?? 'A') === 'A' ? 'selected' : '' }}>A</option>
                                        <option value="A-" {{ ($customer->risk_grade ?? 'A') === 'A-' ? 'selected' : '' }}>A-</option>
                                        <option value="B+" {{ ($customer->risk_grade ?? 'A') === 'B+' ? 'selected' : '' }}>B+</option>
                                        <option value="B" {{ ($customer->risk_grade ?? 'A') === 'B' ? 'selected' : '' }}>B</option>
                                        <option value="B-" {{ ($customer->risk_grade ?? 'A') === 'B-' ? 'selected' : '' }}>B-</option>
                                        <option value="C+" {{ ($customer->risk_grade ?? 'A') === 'C+' ? 'selected' : '' }}>C+</option>
                                        <option value="C" {{ ($customer->risk_grade ?? 'A') === 'C' ? 'selected' : '' }}>C</option>
                                        <option value="C-" {{ ($customer->risk_grade ?? 'A') === 'C-' ? 'selected' : '' }}>C-</option>
                                        <option value="D" {{ ($customer->risk_grade ?? 'A') === 'D' ? 'selected' : '' }}>D</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="dscr" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        DSCR
                                    </label>
                                    <input type="number" name="dscr" id="dscr" step="0.01" min="0"
                                           value="{{ $customer->dscr ?? 1.45 }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="existing_debt" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Total Existing Debt
                                    </label>
                                    <input type="number" name="existing_debt" id="existing_debt" step="1000" min="0"
                                           value="{{ $customer->existing_debt ?? 425000 }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="monthly_debt_payment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Monthly Debt Payment
                                    </label>
                                    <input type="number" name="monthly_debt_payment" id="monthly_debt_payment" step="100" min="0"
                                           value="{{ $customer->monthly_debt_payment ?? 8500 }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>

                            <div>
                                <label for="credit_references" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Credit References
                                </label>
                                <textarea name="credit_references" id="credit_references" rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="List any credit references or trade creditors...">{{ $customer->credit_references ?? 'XYZ Supply Company, Regional Equipment Leasing, Industrial Parts Supplier' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Profile Summary -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Profile Summary</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Account Number:</span>
                                <span class="font-mono text-gray-900 dark:text-white">{{ $customer->account_number ?? 'CFA-2024-001' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Customer Since:</span>
                                <span class="text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($customer->customer_since ?? '2022-03-15')->format('M j, Y') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Last Updated:</span>
                                <span class="text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($customer->updated_at ?? now())->format('M j, Y') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Status:</span>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                    {{ ucfirst($customer->status ?? 'Active') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Credit Score Visualization -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Credit Score</h4>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-gray-900 dark:text-white mb-2" id="credit-score-display">
                                {{ $customer->credit_score ?? 785 }}
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-3 mb-2">
                                <div class="bg-green-500 h-3 rounded-full transition-all duration-300" id="credit-score-bar" style="width: {{ ((($customer->credit_score ?? 785) - 300) / 550) * 100 }}%"></div>
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400" id="credit-score-grade">
                                {{ ($customer->credit_score ?? 785) >= 800 ? 'Excellent' : (($customer->credit_score ?? 785) >= 740 ? 'Very Good' : (($customer->credit_score ?? 785) >= 670 ? 'Good' : (($customer->credit_score ?? 785) >= 580 ? 'Fair' : 'Poor'))) }}
                            </div>
                        </div>
                    </div>

                    <!-- Recent Changes -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Recent Changes</h4>
                        <div class="space-y-3">
                            @php
                                $recentChanges = [
                                    ['field' => 'Credit Score', 'old' => '773', 'new' => '785', 'date' => '2025-07-15'],
                                    ['field' => 'Annual Revenue', 'old' => '$4.8M', 'new' => '$5.2M', 'date' => '2025-06-30'],
                                    ['field' => 'Risk Grade', 'old' => 'A-', 'new' => 'A', 'date' => '2025-06-20'],
                                ];
                            @endphp

                            @foreach($recentChanges as $change)
                            <div class="border-b border-gray-200 dark:border-gray-600 pb-3 last:border-b-0">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $change['field'] }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $change['old'] }} → {{ $change['new'] }}
                                </div>
                                <div class="text-xs text-gray-400 dark:text-gray-500">
                                    {{ \Carbon\Carbon::parse($change['date'])->format('M j, Y') }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border dark:border-gray-700 p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Actions</h4>
                        <div class="space-y-3">
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                Update Profile
                            </button>
                            <a href="{{ route('credit-financing.customers.show', $customer->id ?? 1) }}" class="block w-full px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors text-center">
                                View Profile
                            </a>
                            <a href="{{ route('credit-financing.customers.index') }}" class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors text-center">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- JavaScript for real-time updates -->
    <script>
        // Update credit score visualization in real-time
        document.getElementById('credit_score').addEventListener('input', function() {
            const score = parseInt(this.value) || 300;
            const display = document.getElementById('credit-score-display');
            const bar = document.getElementById('credit-score-bar');
            const grade = document.getElementById('credit-score-grade');
            
            display.textContent = score;
            
            // Update progress bar
            const percentage = ((score - 300) / 550) * 100;
            bar.style.width = Math.max(0, Math.min(100, percentage)) + '%';
            
            // Update color based on score
            if (score >= 740) {
                bar.className = 'bg-green-500 h-3 rounded-full transition-all duration-300';
            } else if (score >= 670) {
                bar.className = 'bg-yellow-500 h-3 rounded-full transition-all duration-300';
            } else {
                bar.className = 'bg-red-500 h-3 rounded-full transition-all duration-300';
            }
            
            // Update grade
            if (score >= 800) {
                grade.textContent = 'Excellent';
            } else if (score >= 740) {
                grade.textContent = 'Very Good';
            } else if (score >= 670) {
                grade.textContent = 'Good';
            } else if (score >= 580) {
                grade.textContent = 'Fair';
            } else {
                grade.textContent = 'Poor';
            }
        });

        // Format phone number
        document.getElementById('phone').addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.length >= 6) {
                value = `(${value.slice(0,3)}) ${value.slice(3,6)}-${value.slice(6,10)}`;
            } else if (value.length >= 3) {
                value = `(${value.slice(0,3)}) ${value.slice(3)}`;
            }
            this.value = value;
        });

        // Format EIN
        document.getElementById('tax_id').addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = `${value.slice(0,2)}-${value.slice(2,9)}`;
            }
            this.value = value;
        });
    </script>
@endsection