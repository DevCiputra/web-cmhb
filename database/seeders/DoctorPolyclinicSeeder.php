<?php

namespace Database\Seeders;

use App\Models\DoctorPolyclinic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorPolyclinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data poliklinik
        $polyclinics = [
            ['name' => 'Umum'],
            ['name' => 'Anak'],
            ['name' => 'Gigi'],
            ['name' => 'Jantung'],
            ['name' => 'Saraf'],
            ['name' => 'Mata'],
            ['name' => 'THT'],
            ['name' => 'Kulit dan Kelamin'],
            ['name' => 'Orthopedi'],
            ['name' => 'Andrologi'],
        ];

        // Insert data ke tabel doctor_polyclinics
        foreach ($polyclinics as $polyclinic) {
            DoctorPolyclinic::create($polyclinic);
        }
    }
}
