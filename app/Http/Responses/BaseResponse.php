<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseResponse
{
    /**
     * @param string $message
     * @param int $status
     * @return JsonResponse
     */
    public function error(string $message = 'Oops, something wrong happened!', int $status = 406): JsonResponse
    {
        return response()->json([
            'message' => $message
        ], status: !in_array($status, [0,1]) ? $status : Response::HTTP_NOT_ACCEPTABLE);
    }

    /**
     * @param array|null $data
     * @return JsonResponse
     */
    abstract public function success(?array $data): JsonResponse;
}
