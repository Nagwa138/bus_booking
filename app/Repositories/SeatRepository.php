<?php

namespace App\Repositories;

use App\Interfaces\Repositories\ISeatRepository;
use App\Interfaces\Repositories\IStationRepository;
use App\Interfaces\Repositories\ITripRepository;

class SeatRepository extends AbstractRepository implements ISeatRepository
{
    public function listAvailable(int $tripId, int $startStationId, int $endStationId): array
    {
        $trip = app(ITripRepository::class)->findById($tripId);
        $startStation = app(IStationRepository::class)->findById($startStationId);
        $endStation = app(IStationRepository::class)->findById($endStationId);

        $seatQuery = $this->model->query();

        $seatQuery->whereNull('user_id')->where('bus_id', $trip->bus_id);

        $seatQuery->orWhereHas('endStation', function ($query) use ($startStation){
            $query->where('order', '<=', $startStation->order);
        });

        $seatQuery->orWhereHas('startStation', function ($query) use ($endStation){
            $query->where('order', '>=', $endStation->order);
        });

        return $seatQuery->select('id')->get()->toArray();
    }
}
