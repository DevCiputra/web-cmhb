<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'admin_user',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'), // Ganti dengan password yang aman
                'role' => 'Admin',
                'whatsapp' => '628123456789',
                'profile_picture' => null, // Profile picture dikosongkan
            ],
            [
                'username' => 'hbd_user',
                'email' => 'hbd@example.com',
                'password' => Hash::make('password123'), // Ganti dengan password yang aman
                'role' => 'HBD',
                'whatsapp' => '628987654321',
                'profile_picture' => null, // Profile picture dikosongkan
            ],
            [
                'username' => 'pasien1',
                'email' => 'px1@example.com',
                'password' => Hash::make('password123'), // Ganti dengan password yang aman
                'role' => 'Pasien',
                'whatsapp' => '08673612731',
                'profile_picture' => null, // Profile picture dikosongkan
            ],
            [
                'username' => 'pasien2',
                'email' => 'px2@example.com',
                'password' => Hash::make('password123'), // Ganti dengan password yang aman
                'role' => 'Pasien',
                'whatsapp' => '08673612732',
                'profile_picture' => null, // Profile picture dikosongkan
            ],
        ]);
    }
}
