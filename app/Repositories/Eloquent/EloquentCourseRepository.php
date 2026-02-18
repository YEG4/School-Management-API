<?php

namespace App\Repositories\Eloquent;

use App\Models\Course;
use App\Repositories\Contracts\CourseRepositoryInterface;

class EloquentCourseRepository extends EloquentBaseRepository implements CourseRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(Course $model)
    {
        parent::__construct($model);
    }
}
