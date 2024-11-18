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
                'username' => 'AuthWebHMC',
                'email' => 'auth@ciputramitrahospital.id',
                'password' => Hash::make('Pqwerasd4321'), // Ganti dengan password yang aman
                'role' => 'Admin',
                'whatsapp' => '081298765431',
                'profile_picture' => null, // Profile picture dikosongkan
            ]
        ]);
    }
}
