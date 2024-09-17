<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('service_categories')->insert([
            ['name' => 'MCU', 'created_by' => 'Seeder', 'created_at' => now()],
            ['name' => 'Poliklinik', 'created_by' => 'Seeder', 'created_at' => now()],
            ['name' => 'Home Service', 'created_by' => 'Seeder', 'created_at' => now()],
            ['name' => 'Konsultasi', 'created_by' => 'Seeder', 'created_at' => now()],
        ]);
    }
}
