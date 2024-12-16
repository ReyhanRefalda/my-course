<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePackageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->hasAnyRole(['owner']);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

     protected function prepareForValidation()
    {
        $this->merge([
            'harga' => str_replace('.', '', $this->input('harga')),
        ]);
    }
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'harga' => 'required|integer|min:0',
            'tipe' => 'required|in:daily,monthly,yearly,weekly,',
            'package_benefits' => 'required|array|min:1',
            'package_benefits.*' => 'nullable|string|max:255', // Elemen boleh kosong
        ];
    }

    public function messages(): array
    {
        return [
          'harga.required' => 'The price field is required.',
        ];
    }
    
    
}
