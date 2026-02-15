<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\Student\StudentAttendanceResource;
use App\Services\Student\AttendanceService;
use Illuminate\Http\Request;

class StudentAttendanceController extends Controller
{
    public function __construct(protected AttendanceService $attendanceService) {}

    public function index(Request $request)
    {
        $attendance = $this->attendanceService->listStudentAttendance($request->user()->id, $request->query());

        return $this->success($attendance->toResourceCollection(StudentAttendanceResource::class));
    }

    public function store(Request $request)
    {
        $this->attendanceService->checkStudentIn($request->user()->id);

        return $this->success(message: 'Successfully checked in.', code: 201);
    }

    public function update(Request $request)
    {
        $this->attendanceService->checkStudentOut($request->user()->id);

        return $this->success(message: 'Successfully checked out.');
    }
}
