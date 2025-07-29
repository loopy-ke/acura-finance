<?php

namespace LoopyLabs\CreditFinancing\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePaymentPlanRequest extends FormRequest
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
            'total_amount' => 'required|numeric|min:0.01',
            'down_payment' => 'nullable|numeric|min:0',
            'installment_amount' => 'required|numeric|min:0.01',
            'number_of_installments' => 'required|integer|min:1|max:120',
            'frequency' => 'required|in:weekly,biweekly,monthly',
            'start_date' => 'required|date|after_or_equal:today',
            'terms_and_conditions' => 'nullable|string|max:2000',
            'plan_notes' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'total_amount.required' => 'Total amount is required.',
            'total_amount.numeric' => 'Total amount must be a valid number.',
            'total_amount.min' => 'Total amount must be greater than 0.',
            'down_payment.numeric' => 'Down payment must be a valid number.',
            'down_payment.min' => 'Down payment cannot be negative.',
            'installment_amount.required' => 'Installment amount is required.',
            'installment_amount.numeric' => 'Installment amount must be a valid number.',
            'installment_amount.min' => 'Installment amount must be greater than 0.',
            'number_of_installments.required' => 'Number of installments is required.',
            'number_of_installments.integer' => 'Number of installments must be a whole number.',
            'number_of_installments.min' => 'Must have at least 1 installment.',
            'number_of_installments.max' => 'Cannot exceed 120 installments.',
            'frequency.required' => 'Payment frequency is required.',
            'frequency.in' => 'Payment frequency must be weekly, biweekly, or monthly.',
            'start_date.required' => 'Start date is required.',
            'start_date.date' => 'Start date must be a valid date.',
            'start_date.after_or_equal' => 'Start date cannot be in the past.',
            'terms_and_conditions.max' => 'Terms and conditions cannot exceed 2000 characters.',
            'plan_notes.max' => 'Plan notes cannot exceed 1000 characters.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $totalAmount = $this->input('total_amount', 0);
            $downPayment = $this->input('down_payment', 0);
            $installmentAmount = $this->input('installment_amount', 0);
            $numberOfInstallments = $this->input('number_of_installments', 1);

            // Validate that down payment doesn't exceed total amount
            if ($downPayment > $totalAmount) {
                $validator->errors()->add('down_payment', 'Down payment cannot exceed total amount.');
            }

            // Validate that installments can cover the remaining balance
            $remainingBalance = $totalAmount - $downPayment;
            $totalInstallments = $installmentAmount * $numberOfInstallments;

            if ($totalInstallments < $remainingBalance) {
                $validator->errors()->add('installment_amount', 'Total installments must cover the remaining balance after down payment.');
            }
        });
    }
}