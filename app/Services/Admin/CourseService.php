<?php

namespace App\Services\Admin;

use App\Repositories\Contracts\CourseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class CourseService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected CourseRepositoryInterface $courseRepo)
    {
        //
    }

    public function listAllCourses()
    {
        return $this->courseRepo->all();
    }

    public function createCourse(array $data)
    {
        return $this->courseRepo->create($data);
    }

    public function get(int $id)
    {
        return $this->courseRepo->findOrFail($id);
    }

    public function update(Model $model, array $data)
    {
        return $this->courseRepo->update($model, $data);
    }

    public function delete(Model $model)
    {
        $this->courseRepo->delete($model);
    }
}
