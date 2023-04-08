<?php

namespace App\Injectors;

use App\Interfaces\Repositories\IUserRepository;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoriesInjector extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(IUserRepository::class, function ($app){
            return new UserRepository(new User());
        });
    }
}
