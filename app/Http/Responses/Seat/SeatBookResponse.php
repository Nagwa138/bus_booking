<?php

namespace App\Http\Responses\Seat;

use App\Http\Responses\BaseResponse;
use Illuminate\Http\JsonResponse;

class SeatBookResponse extends BaseResponse
{
    public function success(?array $data): JsonResponse
    {
        return response()->json([
            'message' => 'Seat booked successfully!',
            'data' => $data
        ]);
    }
}
