<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Grade\Admin\StoreGradeRequest;
use App\Http\Requests\Grade\Admin\UpdateGradeRequest;
use App\Models\Grade;
use App\Services\Admin\GradeService;
use Illuminate\Http\Request;

class AdminGradeController extends Controller
{
    public function __construct(protected GradeService $gradeService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $grades = $this->gradeService->getAllGrades($request->query());

        return $this->success($grades);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGradeRequest $request)
    {
        $grade = $this->gradeService->createGrade($request->validated());

        return $this->success($grade, 'Grade was created successfully.', 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGradeRequest $request, string $id)
    {
        $grade = $this->gradeService->getGrade($id);
        $updatedGrade = $this->gradeService->updateGrade($grade, $request->validated());

        return $this->success($updatedGrade, 'Grade was updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        $this->gradeService->deleteGrade($grade);

        return $this->success(message: 'Grade was successfuly deleted.');
    }
}
