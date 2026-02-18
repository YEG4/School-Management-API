<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Course\Admin\StoreCourseRequest;
use App\Http\Requests\Course\Admin\UpdateCourseRequest;
use App\Http\Resources\Admin\CourseResource;
use App\Services\Admin\CourseService;
use Illuminate\Http\JsonResponse;

class AdminCourseController extends Controller
{
    public function __construct(protected CourseService $courseService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $courses = $this->courseService->listAllCourses();

        return $this->success(CourseResource::collection($courses));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request): JsonResponse
    {
        $course = $this->courseService->createCourse($request->validated());

        return $this->success($course->toResource(CourseResource::class), 'Course created successfully.', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $course = $this->courseService->get($id);

        return $this->success($course->toResource(CourseResource::class));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, string $id): JsonResponse
    {
        $course = $this->courseService->get($id);

        $updatedCourse = $this->courseService->update($course, $request->validated());

        return $this->success($updatedCourse->toResource(CourseResource::class), 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $course = $this->courseService->get($id);
        $this->courseService->delete($course);

        return $this->success(message: 'Course was deleted successfully.');
    }
}
