<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AttendanceService;
use Illuminate\Http\Request;

class AdminAttendanceController extends Controller
{
    public function __construct(protected AttendanceService $attendanceService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $attendances = $this->attendanceService->listSpecificAttendances($request->query());

        return $this->success($attendances);
    }

    public function listAllStudentAttendances(Request $request, string $id)
    {
        $attendances = $this->attendanceService->getAllStudentAttendance((int) $id, $request->query());

        return $this->success($attendances);
    }
}
