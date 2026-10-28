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
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'code' => 'required|string|unique:courses,code,' . $this->course?->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'nullable|string|max:100',
            'total_seats' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Course code is required',
            'code.unique' => 'This course code already exists',
            'name.required' => 'Course name is required',
            'total_seats.required' => 'Total seats is required',
            'total_seats.min' => 'Total seats must be at least 1',
        ];
    }
}
