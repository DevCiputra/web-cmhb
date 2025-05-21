<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterTest extends TestCase
{
    use DatabaseTransactions;


    /** @test */
    public function user_can_register_successfully()
    {
        $payload = [
            'username'              => 'johndoe',
            'email'                 => 'johndoe@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'whatsapp'              => '08123456789',
            'role'                  => 'user',
            'gender'                => 'Laki-laki',
            'fcm'                   => 'dummy_fcm_token',
        ];

        $response = $this->postJson('/api/v1/register', $payload);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'meta' => [
                    'code',
                    'status',
                    'message',
                ],
                'data' => [
                    'access_token',
                    'token_type',
                    'user' => [
                        'id',
                        'username',
                        'email',
                        'gender',
                        'role',
                    ],
                ]
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'johndoe@example.com'
        ]);
    }

    /** @test */
    public function registration_fails_if_fields_missing()
    {
        $response = $this->postJson('/api/v1/register', []);

        $response->assertStatus(400)
            ->assertJson(["meta" => ['status' => 'error']]);
    }

    /** @test */
    public function registration_fails_if_email_already_exists()
    {
        User::factory()->create(['email' => 'duplicate@example.com']);

        $response = $this->postJson('/api/v1/register', [
            'username'              => 'anotheruser',
            'email'                 => 'duplicate@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'gender'                => 'Laki-laki',
        ]);

        $response->assertStatus(400)
            ->assertJson(["meta" => ['status' => 'error']]);
    }
}
