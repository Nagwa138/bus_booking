<?php

namespace App\Interfaces\Services;

interface IAuthService
{
    /**
     * @param array $data
     * @return array
     */
    public function login(array $data): array;

    /**
     * @param array $data
     * @return array
     */
    public function register(array $data): array;

    /**
     * @return array
     */
    public function logout(): array;
}
