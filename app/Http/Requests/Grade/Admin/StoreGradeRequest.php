<?php

namespace App\Http\Requests\Grade\Admin;

use App\Http\Requests\BaseRequest;
use App\Rules\isEnrolled;
use Illuminate\Validation\Rule;

class StoreGradeRequest extends BaseRequest
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
    public function rules(): array
    {
        return [
            'student_id' => ['bail', 'required', 'exists:users,id', Rule::unique('grades')->where('course_id', $this->course_id)],
            'course_id' => ['bail', 'required', 'exists:courses,id', new isEnrolled($this->student_id)],
            'grade_value' => ['required', 'string', 'max:2', 'min:1'],
            'notes' => ['nullable', 'string', 'max:300'],
        ];
    }
}
