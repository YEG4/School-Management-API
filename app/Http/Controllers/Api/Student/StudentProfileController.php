<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\Student\StudentResource;
use App\Services\Student\StudentService;
use Illuminate\Http\Request;

class StudentProfileController extends Controller
{
    public function __construct(protected StudentService $studentService) {}

    public function show(Request $request)
    {
        $user = $this->studentService->getStudentProfile($request->user()->id);

        return $this->success($user->toResource(StudentResource::class));
    }
}
