<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Services\Student\CourseService;
use Illuminate\Http\Request;

class StudentCourseController extends Controller
{
    public function __construct(protected CourseService $courseService) {}

    public function index(Request $request)
    {
        $courses = $this->courseService->getAllStudentCourses($request->user()->id, $request->query());

        return $this->success($courses);
    }
}
