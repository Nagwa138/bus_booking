<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{
    public function __construct(
        public Model $model
    )
    {}
}
