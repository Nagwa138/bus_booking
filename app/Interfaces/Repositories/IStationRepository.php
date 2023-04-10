<?php

namespace App\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface IStationRepository
{
    public function findById(int $id);

    public function all(): Collection;
}
