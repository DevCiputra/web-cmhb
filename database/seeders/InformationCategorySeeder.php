<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InformationCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('information_categories')->insert([
            ['name' => 'Promosi','created_at' => now()],
            ['name' => 'Artikel','created_at' => now()],
            ['name' => 'Health Tips', 'created_at' => now()],
            ['name' => 'Event', 'created_at' => now()],
        ]);
    }
}
