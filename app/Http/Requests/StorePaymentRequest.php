<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Set true jika tidak ada otorisasi khusus
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'bank_name' => 'required|string|max:255',
            'number' => 'required|numeric|digits_between:1,20|unique:payments,number',
            'account_name' => 'required|string|max:255',
        ];
    }

    /**
     * Custom error messages for validation.
     */
    public function messages(): array
    {
        return [
            'bank_name.required' => '',
            'number.required' => 'Account number is required.',
            'number.numeric' => 'Account number must be a numeric value.',
            'number.digits_between' => 'Account number must be between 1 to 20 digits.',
            'number.unique' => 'Account number is already taken.',
            'account_name.required' => 'Account name is required.',
        ];
    }
}
