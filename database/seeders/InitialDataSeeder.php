<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin users
        User::firstOrCreate(
            ['email' => 'admin@academy.local'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin2@academy.local'],
            [
                'name' => 'Administrator 2',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // Create guru users
        User::firstOrCreate(
            ['email' => 'budi@academy.local'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'no_telepon' => '81234567890',
            ]
        );

        User::firstOrCreate(
            ['email' => 'siti@academy.local'],
            [
                'name' => 'Siti Nurhaliza',
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'no_telepon' => '82345678901',
            ]
        );

        User::firstOrCreate(
            ['email' => 'ahmad@academy.local'],
            [
                'name' => 'Ahmad Wijaya',
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'no_telepon' => '83456789012',
            ]
        );

        // Create student users with student_id
        User::firstOrCreate(
            ['email' => 'andi@student.local'],
            [
                'name' => 'Andi Wijaya',
                'password' => Hash::make('password123'),
                'role' => 'siswa',
                'no_telepon' => '85234567890',
                'sekolah' => 'SMA Negeri 1 Payakumbuh',
                'kelas_sekolah' => '11 SMA',
                'tanggal_lahir' => '2006-05-15',
                'jenis_kelamin' => 'laki-laki',
                'student_id' => '001-01-122025',
            ]
        );

        User::firstOrCreate(
            ['email' => 'indah@student.local'],
            [
                'name' => 'Indah Permata',
                'password' => Hash::make('password123'),
                'role' => 'siswa',
                'no_telepon' => '85345678901',
                'sekolah' => 'SMA Negeri 1 Payakumbuh',
                'kelas_sekolah' => '10 SMA',
                'tanggal_lahir' => '2007-03-20',
                'jenis_kelamin' => 'perempuan',
                'student_id' => '002-01-122025',
            ]
        );

        User::firstOrCreate(
            ['email' => 'reza@student.local'],
            [
                'name' => 'Reza Pratama',
                'password' => Hash::make('password123'),
                'role' => 'siswa',
                'no_telepon' => '85456789012',
                'sekolah' => 'SMP Negeri 2 Payakumbuh',
                'kelas_sekolah' => '9 SMP',
                'tanggal_lahir' => '2008-07-10',
                'jenis_kelamin' => 'laki-laki',
                'student_id' => '003-01-122025',
            ]
        );

        $this->command->info('Initial data seeder executed successfully!');    }
}