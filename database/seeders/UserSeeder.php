<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Production Mode: Hanya membuat akun admin
     */
    public function run(): void
    {
        // Admin Users Only (Production Mode)
        $admins = [
            [
                'name' => 'Super Admin',
                'email' => 'admin@academy.local',
                'password' => 'password123',
                'role' => 'admin',
            ],
            [
                'name' => 'Administrator 2',
                'email' => 'admin2@academy.local',
                'password' => 'password123',
                'role' => 'admin',
            ],
        ];

        foreach ($admins as $admin) {
            $user = User::updateOrCreate(
                ['email' => $admin['email']],
                [
                    'name' => $admin['name'],
                    'password' => Hash::make($admin['password']),
                    'role' => $admin['role'],
                    'email_verified_at' => now(),
                    'status' => 'active',
                ]
            );
            // Generate kode admin
            if (!$user->kode_admin) {
                $user->update(['kode_admin' => User::generateKodeAdmin()]);
            }
        }

        $this->command->info('✅ Admin accounts created successfully');
        $this->command->info('📧 Email: admin@academy.local | Password: password123');
        $this->command->info('📧 Email: admin2@academy.local | Password: password123');
    }
}

