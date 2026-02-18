<?php

namespace App\Providers;

use App\Helpers\ErrorResponse;
use App\Repositories\Contracts\AttendanceRepoistoryInterface;
use App\Repositories\Contracts\CourseRepositoryInterface;
use App\Repositories\Contracts\EnrollmentRepoistoryInterface;
use App\Repositories\Contracts\GradeRepoistoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\EloquentAttendanceRepository;
use App\Repositories\Eloquent\EloquentCourseRepository;
use App\Repositories\Eloquent\EloquentEnrollmentRepository;
use App\Repositories\Eloquent\EloquentGradeRepository;
use App\Repositories\Eloquent\EloquentUserRepository;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CourseRepositoryInterface::class, EloquentCourseRepository::class);
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->app->bind(EnrollmentRepoistoryInterface::class, EloquentEnrollmentRepository::class);
        $this->app->bind(GradeRepoistoryInterface::class, EloquentGradeRepository::class);
        $this->app->bind(AttendanceRepoistoryInterface::class, EloquentAttendanceRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            if ($request->user()->role === 'admin') {
                return Limit::perMinute(10)->by($request->user()->id)->response(function (Request $request, array $headers) {
                    return new ErrorResponse()->error("Too many requests. Try again in {$headers['Retry-After']}s", 429);
                });
            }

            return Limit::perMinute(5)->by($request->user()->id)->response(function (Request $request, array $headers) {

                return new ErrorResponse()->error("Too many requests. Try again in {$headers['Retry-After']}s", 429);
            });
        });
    }
}
