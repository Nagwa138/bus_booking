<?php

namespace App\Interfaces\Repositories;

use App\Models\Seat;
use Illuminate\Database\Eloquent\Model;

interface ISeatRepository
{
    /**
     * @param int $tripId
     * @param int $startStationId
     * @param int $endStationId
     * @return array
     */
    public function listAvailable(int $tripId, int $startStationId, int $endStationId): array;

    /**
     * @param int $id
     * @param array $data
     * @return Seat|Model
     */
    public function update(int $id, array $data): Seat|Model;
}
