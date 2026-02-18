<?php

namespace App\Repositories\Contracts;

interface EnrollmentRepoistoryInterface extends BaseRepositoryInterface
{
    public function getStudentCourses(int $id, array $filters = []);
}
