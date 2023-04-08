<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase,
        WithFaker;

    public function testRegisterSuccess()
    {

        $data = User::factory()->raw();

        $response = $this->json('post', '/api/register', $data);
        dd($response->json());
    }
}
