<?php

namespace Database\Factories;

use App\Models\EmailVerification;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmailVerificationFactory extends Factory
{
    protected $model = EmailVerification::class;

    public function definition(): array
    {
        return [
            'email' => $this->faker->safeEmail(),
            'otp' => rand(100000, 999999),
            'created_at' => now(),
        ];
    }
}
