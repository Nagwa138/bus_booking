<?php

namespace App\Services;

use App\Interfaces\Repositories\IUserRepository;
use App\Interfaces\Services\IAuthService;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthService implements IAuthService
{
    /**
     * @param IUserRepository $userRepository
     */
    public function __construct(
        public IUserRepository $userRepository
    )
    {}

    /**
     * @throws \Exception
     * @throws \Throwable
     */
    public function login(array $data): array
    {
        $user = $this->userRepository->first(['email' => $data['email']]);

        throw_unless($user, new \Exception('User not found', code: Response::HTTP_NOT_FOUND));
        throw_unless(Hash::check($data['password'], $user->password), new \Exception('Password is not correct', code: Response::HTTP_UNPROCESSABLE_ENTITY));

        $token = $user->createToken('auth');
        return [
            'message' => 'Logged in successfully!',
            'data' => [
                'name' => $user->name,
                'token' => $token->plainTextToken
            ]
        ];

    }

    /**
     * @param array $data
     * @return array
     */
    public function register(array $data): array
    {
        $data['password'] = bcrypt($data['password']);
        $user = $this->userRepository->create($data);
        $token = $user->createToken('auth');
        return [
            'message' => 'Registered successfully!',
            'data' => [
                'name' => $user->name,
                'token' => $token->plainTextToken
            ]
        ];
    }

    /**
     * @return string[]
     */
    public function logout(): array
    {
        auth()->user()->currentAccessToken()->delete();
        return [
            'message' => 'Logout success!'
        ];
    }
}
