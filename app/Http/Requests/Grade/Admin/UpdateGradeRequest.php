<?php

namespace App\Http\Requests\Grade\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGradeRequest extends FormRequest
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
            'grade_value' => ['sometimes', 'string', 'max:2', 'min:1'],
            'notes' => ['sometimes', 'string', 'max:300'],
        ];
    }
}
