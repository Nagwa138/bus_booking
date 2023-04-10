<?php

namespace App\Injectors;

use App\Interfaces\Repositories\ISeatRepository;
use App\Interfaces\Repositories\IStationRepository;
use App\Interfaces\Repositories\ITripRepository;
use App\Interfaces\Repositories\IUserRepository;
use App\Models\Seat;
use App\Models\Station;
use App\Models\Trip;
use App\Models\User;
use App\Repositories\SeatRepository;
use App\Repositories\StationRepository;
use App\Repositories\TripRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoriesInjector extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(IUserRepository::class, function ($app){
            return new UserRepository(new User());
        });
        $this->app->singleton(ISeatRepository::class, function ($app){
            return new SeatRepository(new Seat());
        });
        $this->app->singleton(ITripRepository::class, function ($app){
            return new TripRepository(new Trip());
        });
        $this->app->singleton(IStationRepository::class, function ($app){
            return new StationRepository(new Station());
        });
    }
}
