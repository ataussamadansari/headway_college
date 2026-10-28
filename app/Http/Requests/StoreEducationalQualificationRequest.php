<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEducationalQualificationRequest extends FormRequest
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
            'qualifications' => 'required|array|min:1',
            'qualifications.*.qualification_type' => 'required|in:highschool,intermediate,ug',
            'qualifications.*.board_university' => 'required|string|max:255',
            'qualifications.*.stream' => 'required|string|max:100',
            'qualifications.*.year_of_completion' => 'required|integer|min:1950|max:' . date('Y'),
            'qualifications.*.roll_number' => 'required|string|max:100',
            'qualifications.*.max_marks' => 'required|integer|min:1',
            'qualifications.*.obtained_marks' => 'required|integer|min:0',
            'qualifications.*.percentage' => 'required|numeric|min:0|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'qualifications.required' => 'At least one qualification is required',
            'qualifications.min' => 'Please add at least one qualification',
            'qualifications.*.qualification_type.required' => 'Qualification type is required',
            'qualifications.*.board_university.required' => 'Board/University is required',
            'qualifications.*.stream.required' => 'Stream is required',
            'qualifications.*.year_of_completion.required' => 'Year of completion is required',
            'qualifications.*.roll_number.required' => 'Roll number is required',
            'qualifications.*.max_marks.required' => 'Max marks is required',
            'qualifications.*.obtained_marks.required' => 'Obtained marks is required',
            'qualifications.*.percentage.required' => 'Percentage is required',
        ];
    }
}
