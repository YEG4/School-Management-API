<?php

namespace App\Repositories\Contracts;

interface GradeRepoistoryInterface extends BaseRepositoryInterface
{
    public function getAllGrades(array $filters = [], int $perPage = 10);

    public function getStudentGrades(int $id);
}
