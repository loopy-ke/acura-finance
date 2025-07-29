<?php

namespace LoopyLabs\CreditFinancing\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecordActivityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'activity_type' => 'required|in:phone_call,email,sms,letter,visit,legal_notice,payment_plan,settlement_offer,field_visit,court_action,other',
            'outcome' => 'required|in:contact_made,no_contact,promise_to_pay,payment_received,dispute_raised,hardship_claimed,refusal_to_pay,contact_updated,legal_action_initiated,case_escalated,other',
            'activity_notes' => 'required|string|max:2000',
            'activity_date' => 'required|date|before_or_equal:now',
            'follow_up_date' => 'nullable|date|after:activity_date',
            'payment_promise_amount' => 'nullable|numeric|min:0.01',
            'payment_promise_date' => 'nullable|date|after:activity_date',
            'contact_method' => 'nullable|string|max:100',
            'contact_person' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'email_address' => 'nullable|email|max:255',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'activity_type.required' => 'Activity type is required.',
            'activity_type.in' => 'Please select a valid activity type.',
            'outcome.required' => 'Activity outcome is required.',
            'outcome.in' => 'Please select a valid outcome.',
            'activity_notes.required' => 'Activity notes are required.',
            'activity_notes.max' => 'Activity notes cannot exceed 2000 characters.',
            'activity_date.required' => 'Activity date is required.',
            'activity_date.date' => 'Activity date must be a valid date.',
            'activity_date.before_or_equal' => 'Activity date cannot be in the future.',
            'follow_up_date.date' => 'Follow-up date must be a valid date.',
            'follow_up_date.after' => 'Follow-up date must be after the activity date.',
            'payment_promise_amount.numeric' => 'Promise amount must be a valid number.',
            'payment_promise_amount.min' => 'Promise amount must be greater than 0.',
            'payment_promise_date.date' => 'Promise date must be a valid date.',
            'payment_promise_date.after' => 'Promise date must be after the activity date.',
            'contact_method.max' => 'Contact method cannot exceed 100 characters.',
            'contact_person.max' => 'Contact person name cannot exceed 255 characters.',
            'phone_number.max' => 'Phone number cannot exceed 20 characters.',
            'email_address.email' => 'Please provide a valid email address.',
            'email_address.max' => 'Email address cannot exceed 255 characters.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $outcome = $this->input('outcome');
            $paymentPromiseAmount = $this->input('payment_promise_amount');
            $paymentPromiseDate = $this->input('payment_promise_date');

            // If outcome is promise_to_pay, require promise details
            if ($outcome === 'promise_to_pay') {
                if (empty($paymentPromiseAmount)) {
                    $validator->errors()->add('payment_promise_amount', 'Promise amount is required when outcome is "promise to pay".');
                }
                if (empty($paymentPromiseDate)) {
                    $validator->errors()->add('payment_promise_date', 'Promise date is required when outcome is "promise to pay".');
                }
            }
        });
    }
}