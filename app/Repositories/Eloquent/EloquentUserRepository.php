<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class EloquentUserRepository extends EloquentBaseRepository implements UserRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function findByEmail(string $email): User
    {
        return User::where('email', $email)->first();
    }

    public function getAllStudents(array $filters = [], int $perPage = 10)
    {
        return User::query()->students()->search($filters['search'] ?? null)->status($filters['status'] ?? null)->paginate($perPage);
    }
}
