<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentBaseRepository implements BaseRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected Model $model) {}

    public function findOrFail(int $id): Model
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function all($perPage = 10): LengthAwarePaginator
    {
        return $this->model->newQuery()->latest()->paginate($perPage);
    }

    public function update(Model $model, array $data): Model
    {
        $model->update($data);

        return $model->fresh();
    }

    public function delete(Model $model): bool
    {
        $model->delete();

        return true;
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }
}
