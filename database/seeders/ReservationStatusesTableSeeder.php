<?php

namespace Database\Seeders;

use App\Models\ReservationStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationStatusesTableSeeder extends Seeder
{
    public function run()
    {
        ReservationStatus::insert([['name' => 'Konfirmasi Jadwal', 'class' => 'badge-warning'],
            ['name' => 'Jadwal Dikonfirmasi', 'class' => 'badge-info'],
            ['name' => 'Berhasil', 'class' => 'badge-success'],
            ['name' => 'Batal', 'class' => 'badge-danger'],
        ]);
    }
}
