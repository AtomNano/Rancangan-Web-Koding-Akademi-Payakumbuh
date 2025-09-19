<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Enrollment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Guru
        User::create([
            'name' => 'Guru Coding',
            'email' => 'guru@example.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
        ]);

        // Create Siswa
        User::create([
            'name' => 'Siswa 1',
            'email' => 'siswa@example.com',
            'password' => Hash::make('password'),
            'role' => 'siswa',
        ]);

        // Create Kelas
        $kelas1 = Kelas::create([
            'nama_kelas' => 'Pemrograman Web Dasar',
            'deskripsi' => 'Belajar dasar-dasar pemrograman web dengan HTML, CSS, dan JavaScript',
            'bidang' => 'coding',
            'status' => 'active',
        ]);

        $kelas2 = Kelas::create([
            'nama_kelas' => 'UI/UX Design',
            'deskripsi' => 'Belajar desain antarmuka pengguna dan pengalaman pengguna',
            'bidang' => 'desain',
            'status' => 'active',
        ]);

        $kelas3 = Kelas::create([
            'nama_kelas' => 'Robotik Arduino',
            'deskripsi' => 'Belajar dasar-dasar robotik menggunakan Arduino',
            'bidang' => 'robotik',
            'status' => 'active',
        ]);

        // Enroll siswa to classes
        $siswa = User::where('role', 'siswa')->first();
        Enrollment::create([
            'user_id' => $siswa->id,
            'kelas_id' => $kelas1->id,
            'status' => 'active',
        ]);

        Enrollment::create([
            'user_id' => $siswa->id,
            'kelas_id' => $kelas2->id,
            'status' => 'active',
        ]);
    }
}
