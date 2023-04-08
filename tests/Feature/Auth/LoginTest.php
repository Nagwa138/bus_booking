<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testLoginSuccess()
    {
        $response = $this->json('post', '/api/login', []);

        dd($response->json());
    }
}
