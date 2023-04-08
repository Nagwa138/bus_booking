<?php

namespace App\Services;

use App\Interfaces\Repositories\IUserRepository;
use App\Interfaces\Services\IAuthService;

class AuthService implements IAuthService
{


    public function __construct(
        public IUserRepository $userRepository
    )
    {
    }

    public function login(array $data): array
    {
//        return $this->model->all()->toArray();
        return  [];
    }

    public function register(array $data): array
    {
        return $this->userRepository->create($data)->toArray();
    }

    public function logout(): array
    {
        // TODO: Implement logout() method.
        return  [];
    }
}
