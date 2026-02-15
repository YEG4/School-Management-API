<?php

namespace App\Services\Student;

use App\Repositories\Contracts\GradeRepoistoryInterface;

class GradeService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected GradeRepoistoryInterface $gradeRepo) {}

    public function getAllGrades(int $id, array $filters)
    {
        $perPage = (int) ($filters['per_page'] ?? 10);

        $perPage = min($perPage, 100);

        return $this->gradeRepo->getStudentGrades($id, $filters, $perPage);
    }
}
