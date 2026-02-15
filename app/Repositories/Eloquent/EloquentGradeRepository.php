<?php

namespace App\Repositories\Eloquent;

use App\Models\Grade;
use App\Repositories\Contracts\GradeRepoistoryInterface;

class EloquentGradeRepository extends EloquentBaseRepository implements GradeRepoistoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(Grade $model)
    {
        parent::__construct($model);
    }

    public function getAllGrades(array $filters = [], int $perPage = 10)
    {
        return Grade::query()->student($filters['student_id'] ?? null)->course($filters['course_id'] ?? null)->paginate($perPage);
    }

    public function getStudentGrades(int $id, array $filters = [], int $perPage = 10)
    {
        return Grade::where('student_id', $id)->courseTitle($filters['title'] ?? null)->paginate($perPage);
    }
}
