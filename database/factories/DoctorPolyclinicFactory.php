<?php

namespace Database\Factories;

use App\Models\DoctorPolyclinic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DoctorPolyclinic>
 */
class DoctorPolyclinicFactory extends Factory
{
    protected $model = DoctorPolyclinic::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'icon' => 'dummy-icon.svg',
        ];
    }
}
