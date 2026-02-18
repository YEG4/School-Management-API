<?php

namespace App\Services\Admin;

use App\Models\Enrollment;
use App\Repositories\Contracts\EnrollmentRepoistoryInterface;

class EnrollmentService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected EnrollmentRepoistoryInterface $enrollmentRepo)
    {
        //
    }

    public function assignStudentToCourse(array $data)
    {
        return $this->enrollmentRepo->create($data);
    }

    public function removeStudentFromCourse(Enrollment $instance)
    {
        $this->enrollmentRepo->delete($instance);
    }
}
