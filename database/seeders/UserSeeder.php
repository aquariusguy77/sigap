<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            [
                'name' => 'Administrator SIGAP',
                'email' => 'admin@sigap-rudenim.local',
                'password' => 'Sigap@Admin2026',
                'role' => 'admin',
            ],
            [
                'name' => 'Petugas Pendataan',
                'email' => 'petugas@sigap-rudenim.local',
                'password' => 'Sigap@Petugas2026',
                'role' => 'petugas',
            ],
            [
                'name' => 'Supervisor Shift',
                'email' => 'supervisor@sigap-rudenim.local',
                'password' => 'Sigap@Supervisor2026',
                'role' => 'supervisor',
            ],
        ];

        foreach ($defaults as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => Hash::make($user['password']),
                    'role' => $user['role'],
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
