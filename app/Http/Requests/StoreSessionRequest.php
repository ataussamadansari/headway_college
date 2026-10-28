<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSessionRequest extends FormRequest
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
        $sessionId = $this->route('session')?->id;

        return [
            'name' => ['required', 'string', Rule::unique('academic_sessions', 'name')->ignore($sessionId)],
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'remarks' => 'nullable|string',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Session name is required',
            'name.unique' => 'This session name already exists',
            'start_date.required' => 'Start date is required',
            'end_date.required' => 'End date is required',
            'end_date.after' => 'End date must be after start date',
        ];
    }
}
