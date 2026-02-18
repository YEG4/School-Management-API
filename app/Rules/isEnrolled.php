<?php

namespace App\Rules;

use App\Models\Enrollment;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class isEnrolled implements ValidationRule
{
    public function __construct(protected ?int $student_id) {}

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $this->student_id) {
            return;
        }

        $isEnrolled = Enrollment::query()->where('student_id', $this->student_id)->where('course_id', $value)->exists();

        if (! $isEnrolled) {
            $fail('The student is not enrolled in the course.');
        }
    }
}
