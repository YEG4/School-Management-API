<?php

namespace App\Services\Student;

use App\Repositories\Contracts\EnrollmentRepoistoryInterface;

class CourseService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected EnrollmentRepoistoryInterface $enrollmentRepo) {}

    public function getAllStudentCourses(int $id, array $filters)
    {
        $filters['direction'] = strtolower($filters['direction'] ?? 'asc') === 'desc' ? 'desc' : 'asc';

        return $this->enrollmentRepo->getStudentCourses($id, $filters);
    }
}
