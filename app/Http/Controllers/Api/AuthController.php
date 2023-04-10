<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Responses\Auth\LoginResponse;
use App\Http\Responses\Auth\LogoutResponse;
use App\Http\Responses\Auth\RegisterResponse;
use App\Interfaces\Services\IAuthService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * @param IAuthService $authService
     */
    public function __construct(
        public IAuthService $authService
    )
    {}

    /**
     * @param LoginRequest $request
     * @param LoginResponse $response
     * @return JsonResponse
     */
    public function login(LoginRequest $request, LoginResponse $response): JsonResponse
    {
        try {
            $data = $this->authService->login($request->all());
        } catch (\Exception $exception) {
            return $response->error(message: $exception->getMessage(), status: $exception->getCode());
        }

        return $response->success($data);
    }

    /**
     * @param RegisterRequest $request
     * @param RegisterResponse $response
     * @return JsonResponse
     */
    public function register(RegisterRequest $request, RegisterResponse $response): JsonResponse
    {
        try {
            $data = $this->authService->register($request->validated());
        } catch (\Exception $exception) {
            return $response->error($exception->getMessage());
        }
        return $response->success($data, status: Response::HTTP_CREATED);
    }

    /**
     * @param LogoutResponse $response
     * @return JsonResponse
     */
    public function logout(LogoutResponse $response): JsonResponse
    {
        try {
            $data = $this->authService->logout();
        } catch (\Exception $exception) {
            return $response->error($exception->getMessage());
        }
        return $response->success($data);
    }
}
