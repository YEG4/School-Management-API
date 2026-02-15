<?php

namespace App\Http\Requests\Course\Admin;

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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'code' => ['required', 'string', 'unique:courses,code', 'min:4', 'max:10'],
            'description' => ['required', 'string', 'max:1024'],
            'hours' => ['required', 'decimal:0,2', 'max:300'],
        ];
    }
}
