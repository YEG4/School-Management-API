<?php

namespace App\Repositories\Eloquent;

use App\Models\Attendance;
use App\Repositories\Contracts\AttendanceRepoistoryInterface;

class EloquentAttendanceRepository extends EloquentBaseRepository implements AttendanceRepoistoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(Attendance $model)
    {
        parent::__construct($model);
    }

    public function getSpecificAttendances(array $filters = [], int $perPage = 10)
    {
        return Attendance::query()->studentId((int) $filters['student_id'] ?? null)->dateRange($filters['start_date'] ?? null, $filters['end_date'] ?? null)->orderBy('date', $filters['direction'] ?? 'desc')->paginate($perPage);
    }

    public function getAllStudentAttendances(int $id, array $filters = [], int $perPage = 10)
    {
        return Attendance::query()->where('student_id', $id)->orderBy('date', $filters['direction'] ?? 'desc')->paginate($perPage);
    }

    public function listStudentAttendance(int $id, array $filters = [], int $perPage = 10)
    {
        return Attendance::query()->studentId($id)->dateRange($filters['start_date'] ?? null, $filters['end_date'] ?? null)->orderBy('date', $filters['direction'] ?? 'desc')->paginate($perPage);
    }

    public function checkInExists(int $id)
    {
        return Attendance::query()->where('student_id', $id)->where('date', now()->toDateString())->exists();
    }

    public function getTodaysAttendance(int $id)
    {
        return Attendance::query()->where('student_id', $id)->where('date', now()->toDateString())->first();
    }
}
