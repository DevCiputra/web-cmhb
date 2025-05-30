<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder lainnya di sini
        $this->call(ServiceCategorySeeder::class);

        $this->call([
            DoctorPolyclinicSeeder::class,
            RolesTableSeeder::class,
            UsersTableSeeder::class,
            ReservationStatusesTableSeeder::class,
            ZoomAccountSeeder::class,
            ScreeningSeeder::class,
            ScreeningClassificationSeeder::class
        ]);
        // Anda juga bisa menambahkan seeder lain di sini jika ada
        // $this->call(SeederLainnya::class);
    }
}
