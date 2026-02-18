<?php

namespace App\Http\Requests\Enrollment\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\Eloquent\EloquentUserRepository;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreEnrollmentRequest extends BaseRequest
{
    public function __construct(protected EloquentUserRepository $userRepo) {}

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
            'student_id' => ['required', 'exists:users,id'],
            'course_id' => ['required', 'exists:courses,id', Rule::unique('course_student')->where('student_id', $this->student_id)],
        ];
    }

    public function messages()
    {
        return [
            'course_id.unique' => 'The student is already enrolled in this course.',
        ];
    }

    public function after()
    {
        return [
            function (Validator $validator) {
                if ($validator->errors()->has('student_id')) {
                    return;
                }

                $user = $this->userRepo->findOrFail($this->student_id);
                if ($user->role === 'admin') {
                    $validator->errors()->add('student_id', 'An admin cannot be assigned to a course.');
                }
            },
        ];
    }
}
