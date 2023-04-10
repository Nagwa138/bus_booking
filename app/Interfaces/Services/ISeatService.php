<?php

namespace App\Interfaces\Services;

use App\Models\Seat;

interface ISeatService
{
    /**
     * @param int $tripId
     * @param int $startStationId
     * @param int $endStationId
     * @return array
     */
    public function listAvailable(int $tripId, int $startStationId, int $endStationId): array;

    /**
     * @param int $seatId
     * @param int $startStationId
     * @param int $endStationId
     * @return array
     */
    public function book(int $seatId, int $startStationId, int $endStationId): array;
}
