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
            ['name' => 'Poli Umum', 'icon' => 'body.svg'],
            ['name' => 'Poli THT', 'icon' => 'ear.svg'],
            ['name' => 'Poli Mata', 'icon' => 'eye.svg'],
            ['name' => 'Poli Kandungan', 'icon' => 'female_reproductive_system.svg'],
            ['name' => 'Poli Jantung', 'icon' => 'heart_organ.svg'],
            ['name' => 'Poli Orthopedi', 'icon' => 'joints.svg'],
            ['name' => 'Poli Ginjal', 'icon' => 'kidneys.svg'],
            ['name' => 'Poli Paru', 'icon' => 'lungs.svg'],
            ['name' => 'Poli Saraf', 'icon' => 'neurology.svg'],
            ['name' => 'Poli Penyakit Dalam', 'icon' => 'pancreas.svg'],
            ['name' => 'Poli Tulang', 'icon' => 'skeleton.svg'],
            ['name' => 'Poli Pencernaan', 'icon' => 'stomach.svg'],
            ['name' => 'Poli Kulit & Kelamin', 'icon' => 'tissue.svg'],
            ['name' => 'Poli Gigi', 'icon' => 'tooth.svg'],
            ['name' => 'Poli Onkologi', 'icon' => 'tumour.svg'],
        ];

        // Insert data ke tabel doctor_polyclinics
        foreach ($polyclinics as $polyclinic) {
            DoctorPolyclinic::create($polyclinic);
        }
    }
}
