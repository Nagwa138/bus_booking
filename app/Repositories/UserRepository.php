<?php

namespace App\Repositories;

use App\Interfaces\Repositories\IUserRepository;

class UserRepository extends AbstractRepository implements IUserRepository
{
    public function create($data)
    {
        return $this->model->create($data);
    }
}
