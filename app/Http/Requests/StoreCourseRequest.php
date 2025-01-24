<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->hasAnyRole(['owner', 'teacher']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:21',
            'path_trailer' => 'required|string|max:255',
            'about' => 'required|string',
            'category_ids' => 'required|array',  // Mengubah menjadi array
            'category_ids.*' => 'exists:categories,id',  // Pastikan setiap ID kategori valid
            'thumbnail' => 'required|image',
            'course_keypoints.*' => 'required|string|max:255',
            'resource' => 'required|string|unique:courses,resource,' . $this->route('course'),  // Cegah duplikasi saat update
        ];
    }

}
