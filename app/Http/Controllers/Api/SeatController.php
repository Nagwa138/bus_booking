<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seat\BookSeatRequest;
use App\Http\Requests\Seat\ListAvailableTripSeatsRequest;
use App\Http\Resources\Seat\SeatResource;
use App\Http\Responses\Seat\ListAvailableSeatsResponse;
use App\Http\Responses\Seat\SeatBookResponse;
use App\Interfaces\Services\ISeatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SeatController extends Controller
{

    public function __construct(
        public ISeatService $seatService
    )
    {}

    public function listAvailableSeats(ListAvailableTripSeatsRequest $request, ListAvailableSeatsResponse $response): JsonResponse|AnonymousResourceCollection
    {
        try {
            $seats = $this->seatService->listAvailable($request['trip_id'], $request['start_station_id'], $request['end_station_id']);
        } catch (\Exception $exception) {
            return $response->error($exception->getMessage(), $exception->getCode());
        }

        return $response->success($seats);
    }

    public function book(BookSeatRequest $request, SeatBookResponse $response): JsonResponse|SeatResource
    {
        try {
            $seat = $this->seatService->book($request['seat_id'], $request['start_station_id'], $request['end_station_id']);
        } catch (\Exception $exception) {
            return $response->error($exception->getMessage(), $exception->getCode());
        }

        return new SeatResource($seat);
    }
}
