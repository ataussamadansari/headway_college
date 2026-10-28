<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
            'college_register_no' => 'required|string|unique:students,college_register_no,' . $this->student?->id,
            'control_no' => 'required|string|unique:students,control_no,' . $this->student?->id,
            'registration_date' => 'required|date',
            'course_id' => 'required|exists:courses,id',
            'session_id' => 'required|exists:academic_sessions,id',
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'religion' => 'nullable|string|max:100',
            'category' => 'nullable|string|max:100',
            'domicile_up' => 'boolean',
            'is_handicap' => 'boolean',
            'dob' => 'required|date|before:today',
            'mobile' => 'required|regex:/^[0-9]{10}$/|unique:students,mobile,' . $this->student?->id,
            'address' => 'required|string|max:500',
            'pincode' => 'required|string|size:6|regex:/^[0-9]{6}$/',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'college_register_no.required' => 'College register number is required',
            'college_register_no.unique' => 'This college register number already exists',
            'control_no.required' => 'Control number is required',
            'control_no.unique' => 'This control number already exists',
            'registration_date.required' => 'Registration date is required',
            'course_id.required' => 'Course is required',
            'course_id.exists' => 'Selected course does not exist',
            'session_id.required' => 'Session is required',
            'session_id.exists' => 'Selected session does not exist',
            'name.required' => 'Student name is required',
            'father_name.required' => 'Father name is required',
            'mother_name.required' => 'Mother name is required',
            'gender.required' => 'Gender is required',
            'dob.required' => 'Date of birth is required',
            'dob.before' => 'Date of birth must be in the past',
            'mobile.required' => 'Mobile number is required',
            'mobile.regex' => 'Mobile number must be exactly 10 digits',
            'mobile.unique' => 'This mobile number is already registered',
            'address.required' => 'Address is required',
            'pincode.required' => 'Pincode is required',
            'pincode.size' => 'Pincode must be exactly 6 digits',
            'pincode.regex' => 'Pincode must contain only numbers',
            'photo.image' => 'Photo must be a valid image file',
            'photo.mimes' => 'Photo must be JPEG, PNG, JPG or GIF format',
            'photo.max' => 'Photo size should not exceed 2MB',
            'signature.image' => 'Signature must be a valid image file',
            'signature.mimes' => 'Signature must be JPEG, PNG, JPG or GIF format',
            'signature.max' => 'Signature size should not exceed 2MB',
        ];
    }
}
