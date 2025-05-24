<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Jalankan seeder user.
     */
    public function run(): void
    {
        $users = [
        [
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // mudah untuk testing
            'role' => 'Admin',
            'whatsapp' => '081234567890',
            'profile_picture' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        
        [
            'username' => 'patient1',
            'email' => 'patient@example.com',
            'password' => Hash::make('password'),
            'role' => 'Patient',
            'whatsapp' => '081234567892',
            'profile_picture' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]
    ];
        for ($i = 1; $i <= 10; $i++) {
            $users[] = [
                'username' => "doctor{$i}",
                'email' => "doctor{$i}@example.com",
                'password' => Hash::make('password'), // Mudah diingat untuk testing
                'role' => 'Doctor',
                'whatsapp' => "0812345678{$i}",
                'profile_picture' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('users')->insert($users);
    }
}


