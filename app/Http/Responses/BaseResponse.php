<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseResponse
{
    /**
     * @param string $message
     * @return JsonResponse
     */
    public function error(string $message = 'Oops, something wrong happened!'): JsonResponse
    {
        return response()->json([
            'message' => $message
        ], status: Response::HTTP_NOT_ACCEPTABLE);
    }

    /**
     * @param array|null $data
     * @return JsonResponse
     */
    abstract public function success(?array $data): JsonResponse;
}
