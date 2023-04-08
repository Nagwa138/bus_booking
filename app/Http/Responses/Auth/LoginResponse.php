<?php

namespace App\Http\Responses\Auth;

use App\Http\Responses\BaseResponse;
use Illuminate\Http\JsonResponse;

class LoginResponse extends BaseResponse
{

    public function success(?array $data): JsonResponse
    {
        return response()->json($data);
    }
}
