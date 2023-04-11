<?php

namespace App\Services;

use App\Interfaces\Repositories\ISeatRepository;
use App\Interfaces\Services\ISeatService;
use App\Models\Seat;
use Symfony\Component\HttpFoundation\Response;

class SeatService implements ISeatService
{
    public function __construct(public ISeatRepository $seatRepository){}

    /**
     * @throws \Throwable
     */
    public function listAvailable(int $tripId, int $startStationId, int $endStationId): array
    {
        return $this->seatRepository->listAvailable($tripId, $startStationId, $endStationId);
    }

    /**
     * @param int $seatId
     * @param int $startStationId
     * @param int $endStationId
     * @return Seat
     * @throws \Throwable
     */
    public function book(int $seatId, int $startStationId, int $endStationId): Seat
    {
        $seat = $this->seatRepository->update($seatId, [
            'user_id' => auth()->user()->id,
            'start_station_id' => $startStationId,
            'end_station_id' => $endStationId
        ]);

        throw_unless($seat, new \Exception('Seat not booked!', Response::HTTP_INTERNAL_SERVER_ERROR));

        return $seat;
    }
}
