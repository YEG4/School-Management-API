<?php

namespace App\Services\Admin;

use App\Repositories\Contracts\AttendanceRepoistoryInterface;

class AttendanceService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected AttendanceRepoistoryInterface $attendanceRepo) {}

    public function listSpecificAttendances(array $filters)
    {
        $perPage = (int) ($filters['per_page'] ?? 10);

        $perPage = min($perPage, 100);

        return $this->attendanceRepo->getSpecificAttendances($filters, $perPage);
    }

    public function getAllStudentAttendance(int $id, array $filters)
    {
        $filters['direction'] = strtolower($filters['direction'] ?? 'desc') === 'desc' ? 'desc' : 'asc';

        return $this->attendanceRepo->getAllStudentAttendances($id, $filters);
    }

    private function isDirectionAllowed(?string $direction)
    {
        $allowedDirections = ['asc', 'desc'];
        $direction = strtolower($direction);

        if (! in_array($direction ?? 'desc', $allowedDirections)) {
            return 'desc';
        }
    }
}
