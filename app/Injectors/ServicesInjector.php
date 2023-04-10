<?php

namespace App\Injectors;

use App\Interfaces\Services\IAuthService;
use App\Interfaces\Services\ISeatService;
use App\Models\Seat;
use App\Models\User;
use App\Repositories\SeatRepository;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\SeatService;
use Illuminate\Support\ServiceProvider;

class ServicesInjector extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(IAuthService::class, function ($app) {
            return new AuthService(new UserRepository(new User()));
        });

        $this->app->singleton(ISeatService::class, function ($app) {
            return new SeatService(new SeatRepository(new Seat()));
        });
    }
}
