<?php

namespace Database\Seeders;

use App\Models\Enrollment;
use App\Models\Kelas;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
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

        // Seed Admins
        $adminDefinitions = [
            ['name' => 'Admin Utama', 'email' => 'admin1@example.com', 'role' => 'admin', 'no_telepon' => '0812000001'],
            ['name' => 'Admin Operasional', 'email' => 'admin2@example.com', 'role' => 'admin', 'no_telepon' => '0812000002'],
        ];

        collect($adminDefinitions)->each(function ($admin) use ($createUser, $now) {
            $createUser(array_merge($admin, [
                'alamat' => 'Jl. Merdeka No. ' . rand(1, 50) . ', Payakumbuh',
                'tanggal_pendaftaran' => $now->copy()->subMonths(3)->toDateString(),
            ]));
        });

        // Seed Gurus
        $guruDefinitions = collect([
            ['key' => 'guru_coding', 'name' => 'Raihan Putra', 'email' => 'guru1@example.com', 'bidang_ajar' => 'coding', 'hari_belajar' => ['Senin', 'Rabu']],
            ['key' => 'guru_desain', 'name' => 'Salsa Nabila', 'email' => 'guru2@example.com', 'bidang_ajar' => 'desain', 'hari_belajar' => ['Selasa', 'Kamis']],
            ['key' => 'guru_robotik', 'name' => 'Andi Saputra', 'email' => 'guru3@example.com', 'bidang_ajar' => 'robotik', 'hari_belajar' => ['Rabu', 'Jumat']],
            ['key' => 'guru_tambahan', 'name' => 'Mira Santika', 'email' => 'guru4@example.com', 'bidang_ajar' => 'coding', 'hari_belajar' => ['Sabtu']],
        ]);

        $guruUsers = $guruDefinitions->mapWithKeys(function ($guru, $index) use ($createUser, $now) {
            $user = $createUser([
                'name' => $guru['name'],
                'email' => $guru['email'],
                'role' => 'guru',
                'bidang_ajar' => $guru['bidang_ajar'],
                'hari_belajar' => $guru['hari_belajar'],
                'tanggal_pendaftaran' => $now->copy()->subMonths(6 - $index)->toDateString(),
                'alamat' => 'Jl. Guru No. ' . ($index + 1) . ', Payakumbuh',
                'no_telepon' => '081230000' . ($index + 1),
                'durasi' => '12 Bulan',
            ]);

            return [$guru['key'] => $user];
        });

        // Seed Students
        $siswaUsers = collect();
        for ($i = 1; $i <= 10; $i++) {
            $siswaUsers->push($createUser([
                'name' => 'Siswa ' . str_pad((string) $i, 2, '0', STR_PAD_LEFT),
                'email' => 'siswa' . $i . '@example.com',
                'role' => 'siswa',
                'sekolah' => 'SMP Negeri ' . (($i % 3) + 1) . ' Payakumbuh',
                'tanggal_pendaftaran' => $now->copy()->subDays($i * 5)->toDateString(),
                'durasi' => $i % 2 === 0 ? '6 Bulan' : '3 Bulan',
                'hari_belajar' => ['Sabtu'],
                'no_telepon' => '081240000' . str_pad((string) $i, 2, '0', STR_PAD_LEFT),
                'alamat' => 'Perumahan Harmoni Blok ' . chr(64 + $i) . ', Payakumbuh',
                'tanggal_lahir' => $now->copy()->subYears(13 + $i)->toDateString(),
            ]));
        }

        // Seed Classes
        $kelasDefinitions = [
            [
                'nama_kelas' => 'Kelas Coding Dasar',
                'deskripsi' => 'Belajar logika dasar pemrograman dan bahasa pemrograman pertama.',
                'bidang' => 'coding',
                'guru_key' => 'guru_coding',
            ],
            [
                'nama_kelas' => 'Kelas Desain Kreatif',
                'deskripsi' => 'Mengenal desain grafis modern menggunakan tools populer.',
                'bidang' => 'desain',
                'guru_key' => 'guru_desain',
            ],
            [
                'nama_kelas' => 'Kelas Robotik Pemula',
                'deskripsi' => 'Merakit dan memprogram robot sederhana untuk kompetisi.',
                'bidang' => 'robotik',
                'guru_key' => 'guru_robotik',
            ],
        ];

        $kelasCollection = collect();
        foreach ($kelasDefinitions as $definition) {
            $guru = $guruUsers->get($definition['guru_key']);

            $kelas = Kelas::updateOrCreate(
                ['nama_kelas' => $definition['nama_kelas']],
                [
                    'deskripsi' => $definition['deskripsi'],
                    'bidang' => $definition['bidang'],
                    'status' => 'active',
                    'guru_id' => $guru?->id,
                ]
            );

            $kelasCollection->push($kelas);
        }

        // Enroll students evenly across classes
        if ($kelasCollection->isNotEmpty()) {
            $kelasCount = $kelasCollection->count();
            foreach ($siswaUsers as $index => $siswa) {
                $kelas = $kelasCollection[$index % $kelasCount];
                Enrollment::updateOrCreate(
                    [
                        'user_id' => $siswa->id,
                        'kelas_id' => $kelas->id,
                    ],
                    [
                        'status' => 'active',
                    ]
                );
            }
        }
    }
}