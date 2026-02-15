<?php

namespace App\Repositories\Contracts;

interface AttendanceRepoistoryInterface extends BaseRepositoryInterface
{
    public function getSpecificAttendances(array $filters = [], int $perPage = 10);

    public function getAllStudentAttendances(int $id, array $filters = [], int $perPage = 10);

    public function listStudentAttendance(int $id, array $filters = [], int $perPage = 10);

    public function checkInExists(int $id);

    public function getTodaysAttendance(int $id);
}
