<?php

namespace App\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface ITripRepository
{
    public function findById(int $id);

    public function all(): Collection;
}
