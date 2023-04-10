<?php

namespace App\Http\Responses\Seat;

use App\Http\Responses\BaseResponse;
use Illuminate\Http\JsonResponse;

class ListAvailableSeatsResponse extends BaseResponse
{
    public function success(?array $data): JsonResponse
    {
        return response()->json([
            'message' => 'List available seats success!',
            'data' => $data
        ]);
    }
}
