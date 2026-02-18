<?php

namespace App\Services\Student;

use App\Enums\AttendanceStatus;
use App\Repositories\Contracts\AttendanceRepoistoryInterface;
use Exception;

class AttendanceService
{
    protected $lateTime = '9:00';

    /**
     * Create a new class instance.
     */
    public function __construct(protected AttendanceRepoistoryInterface $attendanceRepo) {}

    public function listStudentAttendance(int $id, array $filters)
    {

        $perPage = (int) ($filters['per_page'] ?? 10);

        $perPage = min($perPage, 100);

        return $this->attendanceRepo->listStudentAttendance($id, $filters, $perPage);
    }

    public function checkStudentIn(int $id)
    {
        if ($this->attendanceRepo->checkInExists($id)) {
            throw new Exception('Student already checked in.');
        }

        $now = now();

        $todayDate = now()->toDateString();
        $checkInTime = now()->format('H:i');

        $status = $checkInTime > $this->lateTime ? AttendanceStatus::LATE->value : AttendanceStatus::PRESENT->value;

        $this->attendanceRepo->create([
            'student_id' => $id,
            'date' => $todayDate,
            'status' => $status,
            'check_in_at' => $now,
        ]);
    }

    public function checkStudentOut(int $id)
    {
        $attendance = $this->attendanceRepo->getTodaysAttendance($id);

        if (! $attendance) {
            throw new Exception("You didn't check in yet.");
        } else {
            $isAfter = $attendance->date->isToday() === now()->isToday() ? true : false;
            $isCheckoutAfter = $attendance->check_in_at < now() ? true : false;
            if (! $isAfter) {
                throw new Exception('Checking out must be on the same day as checking in.');
            }
            if (! $isCheckoutAfter) {
                throw new Exception("You can't check out before checking in.");
            }
            if ($attendance->check_out_at != null) {
                throw new Exception('You can only check out once.');
            }
        }

        $attendance->update([
            'check_out_at' => now(),
        ]);

        return $attendance->fresh();
    }
}
