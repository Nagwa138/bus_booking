<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase,
        WithFaker;

    public function testLoginSuccess()
    {
        $password = Str::password(8);
        $user = User::factory()->create(['password' => bcrypt($password)]);
        $response = $this->json('post', '/api/login', [
            'email' => $user->email,
            'password' => $password
        ]);

        $response->assertOk();
        $this->assertEquals('Logged in successfully!', $response->json()['message']);
        $this->assertEquals($user->name, $response->json()['data']['name']);

        $response->assertJsonStructure([
            'message', 'data' => ['name', 'token']
        ]);
    }

    public function testEmailRequired()
    {
        $this->validateInput('email', []);
    }

    public function testEmailShouldExist()
    {
        $data = [
            'email' => $this->faker->email
        ];
        $this->validateInput('email', $data);
    }

    public function testEmailMax191()
    {
        $data = [
            'email' => Str::random(200)
        ];
        $this->validateInput('email', $data);
    }

    public function testPasswordRequired()
    {
        $user = User::factory()->create();
        $data = [
            'email' => $user->email
        ];
        $this->validateInput('password', $data);
    }

    public function testPasswordMax191()
    {
        $user = User::factory()->create();
        $data = [
            'email' => $user->email,
            'password' => Str::password(200)
        ];
        $this->validateInput('password', $data);
    }

    public function testPasswordShouldBeRelatedToUser()
    {
        $user = User::factory()->create();
        $data = [
            'email' => $user->email,
            'password' => $this->faker->password
        ];

        $response = $this->json('post', '/api/login', $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals('Password is not correct', $response->json()['message']);
        $response->assertJsonStructure([
            'message'
        ]);
    }

    private function validateInput($input, $data)
    {
        $response = $this->json('post', '/api/login', $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors($input);
    }

}
