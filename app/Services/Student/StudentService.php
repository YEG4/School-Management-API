<?php

namespace App\Services\Student;

use App\Repositories\Contracts\UserRepositoryInterface;

class StudentService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected UserRepositoryInterface $userRepo)
    {
        //
    }

    public function getStudentProfile(int $id)
    {
        return $this->userRepo->findOrFail($id);
    }
}
