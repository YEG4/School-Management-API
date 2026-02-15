<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Enrollment\Admin\StoreEnrollmentRequest;
use App\Models\Enrollment;
use App\Services\Admin\EnrollmentService;

class AdminEnrollmentController extends Controller
{
    public function __construct(protected EnrollmentService $enrollmentService) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEnrollmentRequest $request)
    {
        $enrollment = $this->enrollmentService->assignStudentToCourse($request->validated());

        return $this->success($enrollment, 'Assgned student to the course successfully.', 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enrollment $enrollment)
    {
        $this->enrollmentService->removeStudentFromCourse($enrollment);

        return $this->success(message: 'Removed student successfully.');
    }
}
