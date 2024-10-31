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
            ]
        ]);
    }
}
