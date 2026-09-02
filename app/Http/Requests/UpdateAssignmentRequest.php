<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;


class UpdateAssignmentRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'volunteer_id' => 'required|exists:volunteers,id',
            'work_location_id' => 'required|exists:work_locations,id',
            'task_id' => 'required|exists:tasks,id',
            'notes' => 'nullable|string',
        ];
    }
}
