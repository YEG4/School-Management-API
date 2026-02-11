<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    public function find(int $id): Model;

    public function all(): Collection;

    public function update(Model $model): bool;

    public function delete(Model $model): bool;
}
