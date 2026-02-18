<?php

use App\Http\Controllers\Api\Admin\AdminAttendanceController;
use App\Http\Controllers\Api\Admin\AdminCourseController;
use App\Http\Controllers\Api\Admin\AdminEnrollmentController;
use App\Http\Controllers\Api\Admin\AdminGradeController;
use App\Http\Controllers\Api\Admin\AdminStudentController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Student\StudentAttendanceController;
use App\Http\Controllers\Api\Student\StudentCourseController;
use App\Http\Controllers\Api\Student\StudentGradeController;
use App\Http\Controllers\Api\Student\StudentProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'store']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    });

    // Admin
    Route::middleware(['auth:sanctum', 'role:admin', 'throttle:api'])->prefix('admin')->group(function () {

        // Courses
        Route::get('/courses', [AdminCourseController::class, 'index']);
        Route::post('/courses', [AdminCourseController::class, 'store']);
        Route::get('/courses/{id}', [AdminCourseController::class, 'show']);
        Route::match(['put', 'patch'], '/courses/{id}', [AdminCourseController::class, 'update']);
        Route::delete('/courses/{id}', [AdminCourseController::class, 'destroy']);

        // Students
        Route::get('/students', [AdminStudentController::class, 'index']);
        Route::post('/students', [AdminStudentController::class, 'store']);
        Route::get('/students/{id}', [AdminStudentController::class, 'show']);
        Route::match(['put', 'patch'], '/students/{id}', [AdminStudentController::class, 'update']);
        Route::delete('/students/{student}', [AdminStudentController::class, 'destroy']);

        // Enrollments
        Route::post('/enrollments', [AdminEnrollmentController::class, 'store']);
        Route::delete('/enrollments/{enrollment}', [AdminEnrollmentController::class, 'destroy']);

        // Grades
        Route::get('/grades', [AdminGradeController::class, 'index']);
        Route::post('/grades', [AdminGradeController::class, 'store']);
        Route::match(['put', 'patch'], '/grades/{id}', [AdminGradeController::class, 'update']);
        Route::delete('/grades/{grade}', [AdminGradeController::class, 'destroy']);

        // Attendance
        Route::get('/attendance', [AdminAttendanceController::class, 'index']);
        Route::get('/students/{id}/attendance', [AdminAttendanceController::class, 'listAllStudentAttendances']);

    });

    // Students
    Route::middleware(['auth:sanctum', 'role:student', 'throttle:api'])->prefix('student')->group(function () {
        // Profile & Courses
        Route::get('/me', [StudentProfileController::class, 'show']);
        Route::get('/courses', [StudentCourseController::class, 'index']);

        // Attendance
        Route::get('/attendance', [StudentAttendanceController::class, 'index']);
        Route::post('/attendance/check-in', [StudentAttendanceController::class, 'store']);
        Route::post('/attendance/check-out', [StudentAttendanceController::class, 'update']);

        // Grades
        Route::get('/grades', [StudentGradeController::class, 'index']);
    });
});
