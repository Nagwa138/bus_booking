<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{
    public function __construct(
        public Model $model
    )
    {}

    public function findById(int $id)
    {
        return $this->model->find($id);
    }

    public function update(int $id, array $data): Model
    {
        $model = $this->model->find($id);
        $model->update($data);
        return $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }
}
