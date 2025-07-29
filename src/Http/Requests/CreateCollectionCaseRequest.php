<?php

namespace LoopyLabs\CreditFinancing\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCollectionCaseRequest extends FormRequest
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
            'credit_disbursement_id' => 'required|exists:credit_disbursements,id',
            'priority' => 'nullable|in:low,medium,high,urgent',
            'assigned_to' => 'nullable|exists:users,id',
            'case_notes' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'credit_disbursement_id.required' => 'Please select a disbursement to create collection case for.',
            'credit_disbursement_id.exists' => 'The selected disbursement is invalid.',
            'priority.in' => 'Priority must be one of: low, medium, high, urgent.',
            'assigned_to.exists' => 'The selected user does not exist.',
            'case_notes.max' => 'Case notes cannot exceed 1000 characters.',
        ];
    }
}