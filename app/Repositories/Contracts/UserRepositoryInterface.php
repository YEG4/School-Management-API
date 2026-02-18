<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function getAllStudents(array $filters = [], int $perPage = 10);
}
