<?php

namespace App\Services\Admin;

use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class StudentService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected UserRepositoryInterface $userRepo) {}

    public function getAllStudents(array $filters = [])
    {
        $perPage = (int) ($filters['per_page'] ?? 10);

        $perPage = min($perPage, 100);

        return $this->userRepo->getAllStudents($filters, $perPage);
    }

    public function getStudent(int $id)
    {
        return $this->userRepo->findOrFail($id);
    }

    public function updateStudent(Model $model, array $data)
    {
        return $this->userRepo->update($model, $data);
    }

    public function createStudent(array $data)
    {
        return $this->userRepo->create($data);
    }

    public function deleteStudent(Model $model)
    {
        $this->userRepo->delete($model);
    }
}
