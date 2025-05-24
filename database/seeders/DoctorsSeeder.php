<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class DoctorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // id_user dari 16-25 (10 user doctor)
        foreach (range(16, 25) as $userId) {
            Doctor::create([
                'user_id' => $userId,
                'name' => $faker->name,
                'specialization_name' => 'Spesialis ' . $faker->word,
                'doctor_polyclinic_id' => rand(1, 15), // 1-15 poli, acak, bisa sama
                'address' => $faker->address,
                'consultation_fee' => rand(100000, 500000),
                'email' => $faker->unique()->safeEmail,
                'is_published' => true,
                'is_open_reservation' => true,
                'is_open_consultation' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
