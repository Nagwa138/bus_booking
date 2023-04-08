<?php

namespace App\Injectors;

use App\Interfaces\Services\IAuthService;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use Illuminate\Support\ServiceProvider;

class ServicesInjector extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(IAuthService::class, function ($app) {
            return new AuthService(new UserRepository(new User()));
        });
    }
}
