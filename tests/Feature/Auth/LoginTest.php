<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;


class LoginTest extends TestCase
{
    use DatabaseTransactions;
    protected String $email = 'test@example.com';
    protected String $password = 'test1234';
    protected String $url = '/api/v1/login';
    /**
     * A basic feature test example.
     */
    public function user_can_login_succesfully()
    {
        User::factory()->create(['email' => $this->email, 'password' => $this->password]);

        $payload = [
            'email' => $this->email,
            'password' => $this->password
        ];

        $response = $this->postJson($this->url, $payload);

        $response->assertStatus(200);
    }
}
