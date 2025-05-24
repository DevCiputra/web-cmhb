<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DoctorEducationsSeeder extends Seeder
{
    public function run()
    {
        $educations = [
            'Universitas Indonesia - Fakultas Kedokteran',
            'Universitas Gadjah Mada - Fakultas Kedokteran',
            'Universitas Airlangga - Fakultas Kedokteran',
            'Universitas Padjadjaran - Fakultas Kedokteran',
            'Universitas Diponegoro - Fakultas Kedokteran',
            'Universitas Brawijaya - Fakultas Kedokteran',
            'Universitas Hasanuddin - Fakultas Kedokteran',
            'Universitas Andalas - Fakultas Kedokteran',
            'Universitas Sebelas Maret - Fakultas Kedokteran',
            'Universitas Sriwijaya - Fakultas Kedokteran',
        ];

        $now = Carbon::now();

        foreach (range(11, 20) as $index => $doctorId) {
            DB::table('doctor_educations')->insert([
                'doctor_id'   => $doctorId,
                'name'        => $educations[$index],
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
        }
    }
}
