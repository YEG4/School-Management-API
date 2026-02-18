<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\Student\StudentGradeResource;
use App\Services\Student\GradeService;
use Illuminate\Http\Request;

class StudentGradeController extends Controller
{
    public function __construct(protected GradeService $gradeService) {}

    public function index(Request $request)
    {
        $grades = $this->gradeService->getAllGrades($request->user()->id, $request->query());

        return $this->success($grades->toResourceCollection(StudentGradeResource::class));
    }
}
