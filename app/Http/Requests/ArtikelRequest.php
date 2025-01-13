<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArtikelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $rules = [
            'title' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s\-_,\.;:()?!$@"]+$/|min:10',
            'content' => 'required|string|min:15',
            'tumbnail' => 'nullable|image|mimes:jpeg,png,jpg,svg,gif,webp|max:10240|dimensions:min_width=300,min_height=300',
        ];

        if ($this->isMethod('post')) {
            $rules['tumbnail'] = 'required|image|mimes:jpeg,png,jpg,svg,gif,webp|max:10240|dimensions:min_width=300,min_height=300';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => 'Judul wajib diisi.',
            'title.string' => 'Judul harus berupa teks.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'title.regex' => 'Judul hanya boleh mengandung huruf, angka, spasi, dan beberapa karakter khusus (-_,.;:()).',
            'title.min' => 'Judul harus memiliki minimal 10 karakter.',
            'content.required' => 'Konten wajib diisi.',
            'content.string' => 'Konten harus berupa teks.',
            'content.min' => 'Konten harus memiliki minimal 15 karakter.',
            'tumbnail.image' => 'Hanya gambar yang diperbolehkan.',
            'tumbnail.mimes' => 'Gambar harus berupa file jpeg, png, jpg, svg, gif, atau webp.',
            'tumbnail.max' => 'Gambar tidak boleh lebih besar dari 10MB.',
            'tumbnail.dimensions' => 'Dimensi gambar minimal adalah 300x300 piksel.',
            'tumbnail.required' => 'Thumbnail wajib diunggah saat menambahkan data.',
        ];
    }
}
