<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Admin\StoreStudentRequest;
use App\Http\Requests\User\Admin\UpdateStudentRequest;
use App\Models\User;
use App\Services\Admin\StudentService;
use Illuminate\Http\Request;

class AdminStudentController extends Controller
{
    public function __construct(protected StudentService $studentService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $students = $this->studentService->getAllStudents($request->query());

        return $this->success($students);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        $student = $this->studentService->createStudent($request->validated());

        return $this->success($student, 'Student created successfully.', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = $this->studentService->getStudent((int) $id);

        return $this->success($student);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, string $id)
    {
        $student = $this->studentService->getStudent((int) $id);
        $updatedStudent = $this->studentService->updateStudent($student, $request->validated());

        return $this->success($updatedStudent, 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $student)
    {
        $this->studentService->deleteStudent($student);

        return $this->success(message: 'Deleted student successfully.');
    }
}
