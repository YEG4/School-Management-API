<?php

namespace App\Services\Admin;

use App\Repositories\Contracts\GradeRepoistoryInterface;
use Illuminate\Database\Eloquent\Model;

class GradeService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected GradeRepoistoryInterface $gradeRepo) {}

    public function getAllGrades(array $filters = [])
    {
        $perPage = (int) ($filters['per_page'] ?? 10);

        $perPage = min($perPage, 100);

        return $this->gradeRepo->getAllGrades($filters, $perPage);
    }

    public function getGrade(int $id)
    {
        return $this->gradeRepo->findOrFail($id);
    }

    public function updateGrade(Model $model, array $data)
    {
        return $this->gradeRepo->update($model, $data);
    }

    public function createGrade(array $data)
    {
        return $this->gradeRepo->create($data);
    }

    public function deleteGrade(Model $model)
    {
        $this->gradeRepo->delete($model);
    }
}
