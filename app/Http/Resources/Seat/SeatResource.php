<?php

namespace App\Http\Resources\Seat;

use App\Http\Resources\StationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'start_station' => new StationResource($this->startStation),
            'end_station' => new StationResource($this->endStation),
        ];
    }

    public function with(Request $request): array
    {
        return [
            'message' => 'Seat booked successfully!'
        ];
    }
}
