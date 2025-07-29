<?php

namespace LoopyLabs\CreditFinancing\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LoopyLabs\CreditFinancing\Models\CreditApplication;

class StoreCreditApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', CreditApplication::class);
    }

    public function rules(): array
    {
        $config = config('credit-financing');
        
        return [
            'customer_id' => [
                'required',
                'exists:customers,id',
                function ($attribute, $value, $fail) {
                    $customer = \App\Models\Customer::find($value);
                    if (!$customer || !$customer->financing_enabled) {
                        $fail('Selected customer is not eligible for financing.');
                    }
                    
                    // Check for duplicate active applications
                    $hasActiveApplication = CreditApplication::where('customer_id', $value)
                        ->whereIn('status', ['submitted', 'under_review'])
                        ->exists();
                        
                    if ($hasActiveApplication) {
                        $fail('Customer already has an active credit application.');
                    }
                },
            ],
            'credit_product_id' => 'nullable|exists:credit_products,id',
            'requested_amount' => [
                'required',
                'numeric',
                'min:' . ($config['limits']['min_application_amount'] ?? 10000),
                'max:' . ($config['limits']['max_single_application'] ?? 1000000),
            ],
            'requested_term_months' => [
                'required',
                'integer',
                'min:1',
                'max:' . ($config['limits']['max_term_months'] ?? 60),
            ],
            'purpose' => 'required|string|max:500',
            'business_justification' => 'required|string|max:1000',
            'auto_submit' => 'boolean',
        ];
    }

    public function messages(): array
    {
        $config = config('credit-financing');
        
        return [
            'customer_id.required' => 'Please select a customer.',
            'customer_id.exists' => 'Selected customer does not exist.',
            'requested_amount.required' => 'Please enter the requested amount.',
            'requested_amount.min' => 'Minimum application amount is ' . number_format($config['limits']['min_application_amount'] ?? 10000, 2),
            'requested_amount.max' => 'Maximum application amount is ' . number_format($config['limits']['max_single_application'] ?? 1000000, 2),
            'requested_term_months.required' => 'Please specify the repayment term.',
            'requested_term_months.max' => 'Maximum term is ' . ($config['limits']['max_term_months'] ?? 60) . ' months.',
            'purpose.required' => 'Please describe the purpose of this credit application.',
            'business_justification.required' => 'Please provide business justification for this credit request.',
        ];
    }

    public function attributes(): array
    {
        return [
            'customer_id' => 'customer',
            'credit_product_id' => 'credit product',
            'requested_amount' => 'requested amount',
            'requested_term_months' => 'term (months)',
            'purpose' => 'purpose',
            'business_justification' => 'business justification',
        ];
    }
}