<?php

namespace App\Services;

class CourseService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function listAllCourses()
    {
        return $this->courseRepo->all();
    }
}
