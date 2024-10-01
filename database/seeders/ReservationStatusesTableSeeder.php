<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationStatusesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('reservation_statuses')->insert([
            ['name' => 'Pending'],
            ['name' => 'Approved'],
            ['name' => 'Rejected'],
            ['name' => 'Completed'],
        ]);
    }
}
