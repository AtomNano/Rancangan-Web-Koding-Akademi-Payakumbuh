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
     */
    public function run(): void
    {
        // Clear existing users
        User::where('role', '!=', null)->delete();

        // Admin Users
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
            $user = User::create([
                'name' => $admin['name'],
                'email' => $admin['email'],
                'password' => Hash::make($admin['password']),
                'role' => $admin['role'],
            ]);
            // Generate kode admin
            $user->update(['kode_admin' => User::generateKodeAdmin()]);
        }

        // Guru Users
        $gurus = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@academy.local',
                'password' => 'password123',
                'role' => 'guru',
                'no_telepon' => '81234567890',
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti@academy.local',
                'password' => 'password123',
                'role' => 'guru',
                'no_telepon' => '82345678901',
            ],
            [
                'name' => 'Ahmad Wijaya',
                'email' => 'ahmad@academy.local',
                'password' => 'password123',
                'role' => 'guru',
                'no_telepon' => '83456789012',
            ],
        ];

        foreach ($gurus as $guru) {
            $user = User::create([
                'name' => $guru['name'],
                'email' => $guru['email'],
                'password' => Hash::make($guru['password']),
                'role' => $guru['role'],
                'no_telepon' => $guru['no_telepon'],
            ]);
            // Generate kode guru
            $user->update(['kode_guru' => User::generateKodeGuru()]);
        }

        // Siswa Users (Sample)
        $students = [
            [
                'name' => 'Andi Wijaya',
                'email' => 'andi@student.local',
                'password' => 'password123',
                'role' => 'siswa',
                'no_telepon' => '85234567890',
                'sekolah' => 'SMA Negeri 1 Payakumbuh',
                'kelas_sekolah' => '11 SMA',
                'tanggal_lahir' => '2006-05-15',
                'jenis_kelamin' => 'laki-laki',
                'student_id' => '001-01-122025',
            ],
            [
                'name' => 'Indah Permata',
                'email' => 'indah@student.local',
                'password' => 'password123',
                'role' => 'siswa',
                'no_telepon' => '85345678901',
                'sekolah' => 'SMA Negeri 1 Payakumbuh',
                'kelas_sekolah' => '10 SMA',
                'tanggal_lahir' => '2007-03-20',
                'jenis_kelamin' => 'perempuan',
                'student_id' => '002-01-122025',
            ],
            [
                'name' => 'Reza Pratama',
                'email' => 'reza@student.local',
                'password' => 'password123',
                'role' => 'siswa',
                'no_telepon' => '85456789012',
                'sekolah' => 'SMP Negeri 2 Payakumbuh',
                'kelas_sekolah' => '9 SMP',
                'tanggal_lahir' => '2008-07-10',
                'jenis_kelamin' => 'laki-laki',
                'student_id' => '003-01-122025',
            ],
        ];

        foreach ($students as $student) {
            User::create([
                'name' => $student['name'],
                'email' => $student['email'],
                'password' => Hash::make($student['password']),
                'role' => $student['role'],
                'no_telepon' => $student['no_telepon'],
                'sekolah' => $student['sekolah'],
                'tanggal_lahir' => $student['tanggal_lahir'],
                'jenis_kelamin' => $student['jenis_kelamin'],
                'student_id' => $student['student_id'],
            ]);
        }

        $this->command->info('User seeder executed successfully!');
    }
}
