<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase,
        WithFaker;

    public function testRegisterSuccess()
    {
        $password = Str::password(8);
        $data = User::factory()->raw([
            'password' => $password,
            'password_confirmation' => $password,
        ]);
        $response = $this->json('post', '/api/register', $data);
        $response->assertCreated();
        $response->assertJsonStructure([
            'message', 'data' => [
                'name', 'token'
            ]
        ]);
        $this->assertEquals('Registered successfully!', $response->json()['message']);
        $this->assertEquals($data['name'], $response->json()['data']['name']);
        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }

    public function testNameRequired()
    {
        $data = [];
        $this->validateInput('name', $data);
    }

    public function testNameShouldBeString()
    {
        $data = ['name' => []];
        $this->validateInput('name', $data);
    }

    public function testNameMin4()
    {
        $data = ['name' => Str::random(2)];
        $this->validateInput('name', $data);
    }

    public function testNameMax191()
    {
        $data = ['name' => Str::random(200)];
        $this->validateInput('name', $data);
    }

    public function testEmailRequired()
    {
        $data = ['name' => Str::random(10)];
        $this->validateInput('email', $data);
    }

    public function testEmailShouldBeFormattedLikeEmail()
    {
        $data = [
            'name' => Str::random(10),
            'email' => Str::random(10)
        ];
        $this->validateInput('email', $data);
    }

    public function testEmailMax191()
    {
        $data = [
            'name' => Str::random(10),
            'email' => Str::random(200)
        ];
        $this->validateInput('email', $data);
    }

    public function testEmailUnique()
    {
        $user = User::factory()->create();
        $data = [
            'name' => Str::random(10),
            'email' => $user->email
        ];
        $this->validateInput('email', $data);
    }

    public function testPasswordRequired()
    {
        $data = [
            'name' => Str::random(10),
            'email' => $this->faker->email
        ];
        $this->validateInput('password', $data);
    }

    public function testPasswordShouldBeString()
    {
        $data = [
            'name' => Str::random(10),
            'email' => $this->faker->email,
            'password' => []
        ];
        $this->validateInput('password', $data);
    }

    public function testPasswordMin8()
    {
        $data = [
            'name' => Str::random(10),
            'email' => $this->faker->email,
            'password' => Str::random(5)
        ];
        $this->validateInput('password', $data);
    }

    public function testPasswordMax191()
    {
        $data = [
            'name' => Str::random(10),
            'email' => $this->faker->email,
            'password' => Str::random(200)
        ];
        $this->validateInput('password', $data);
    }

    public function testPasswordShouldBeConfirmed()
    {
        $data = [
            'name' => Str::random(10),
            'email' => $this->faker->email,
            'password' => Str::random(10)
        ];
        $this->validateInput('password', $data);
    }

    private function validateInput($input, $data)
    {
        $response = $this->json('post', '/api/register', $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors($input);
    }
}
