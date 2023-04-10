<?php

namespace App\Interfaces\Repositories;

interface IUserRepository
{
    public function create(array $data);

    public function first(array $conditions = []);
}
