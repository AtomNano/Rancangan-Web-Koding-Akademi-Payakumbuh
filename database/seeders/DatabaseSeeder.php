<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * Production Mode: Hanya membuat akun admin
     */
    public function run(): void
    {
        $now = Carbon::now();
        $defaultPassword = Hash::make('password');

        $createUser = function (array $attributes) use ($defaultPassword, $now) {
            $email = $attributes['email'];
            $role = $attributes['role'];

            $user = User::updateOrCreate(
                ['email' => $email],
                array_merge(
                    [
                        'password' => $defaultPassword,
                        'role' => $role,
                    ],
                    $attributes
                )
            );

            $user->forceFill([
                'email_verified_at' => $user->email_verified_at ?? $now,
                'status' => 'active',
            ])->save();

            return $user->fresh();
        };

        // Seed Admins (Production Mode)
        $adminDefinitions = [
            ['name' => 'Admin Utama', 'email' => 'admin1@example.com', 'role' => 'admin', 'no_telepon' => '0812000001'],
            ['name' => 'Admin Operasional', 'email' => 'admin2@example.com', 'role' => 'admin', 'no_telepon' => '0812000002'],
        ];

        collect($adminDefinitions)->each(function ($admin) use ($createUser, $now) {
            $createUser(array_merge($admin, [
                'alamat' => 'Payakumbuh',
                'tanggal_pendaftaran' => $now->toDateString(),
            ]));
        });

        $this->command->info('✅ Admin accounts created successfully');
        $this->command->info('📧 Email: admin1@example.com | Password: password');
        $this->command->info('📧 Email: admin2@example.com | Password: password');
    }
}