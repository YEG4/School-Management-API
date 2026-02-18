<?php

namespace App\Repositories\Eloquent;

use App\Models\Course;
use App\Models\Enrollment;
use App\Repositories\Contracts\EnrollmentRepoistoryInterface;

class EloquentEnrollmentRepository extends EloquentBaseRepository implements EnrollmentRepoistoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(Enrollment $model)
    {
        parent::__construct($model);
    }

    public function getStudentCourses(int $id, array $filters = [])
    {
        return Course::whereHas('students', function ($query) use ($id) {
            $query->where('course_student.student_id', $id);
        })->orderBy('title', $filters['direction'] ?? 'asc')->get();
    }
}
