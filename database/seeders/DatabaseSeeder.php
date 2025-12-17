<?php

namespace Database\Seeders;

use App\Models\Enrollment;
use App\Models\Kelas;
use App\Models\User;
use App\Models\Materi;
use App\Models\Pertemuan;
use App\Models\ActivityLog;
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
        // Siswa seeding dinonaktifkan, biar tambah sendiri
        // if ($kelasCollection->isNotEmpty()) {
        //     $kelasCount = $kelasCollection->count();
        //     foreach ($siswaUsers as $index => $siswa) {
        //         $kelas = $kelasCollection[$index % $kelasCount];
        //         Enrollment::updateOrCreate(
        //             [
        //                 'user_id' => $siswa->id,
        //                 'kelas_id' => $kelas->id,
        //             ],
        //             [
        //                 'status' => 'active',
        //             ]
        //         );
        //     }
        // }

        // Seed Materi for each class
        $materiByBidang = [
            'coding' => [
                ['judul' => 'Pengenalan Algoritma', 'deskripsi' => 'Dasar-dasar algoritma pemrograman'],
                ['judul' => 'Variabel dan Tipe Data', 'deskripsi' => 'Memahami variabel dan tipe data dalam pemrograman'],
            ],
            'desain' => [
                ['judul' => 'Prinsip Desain Grafis', 'deskripsi' => 'Dasar teori dan prinsip desain grafis modern'],
                ['judul' => 'Tools Adobe Creative', 'deskripsi' => 'Penggunaan software Adobe untuk desain'],
            ],
            'robotik' => [
                ['judul' => 'Dasar Robotik', 'deskripsi' => 'Pengenalan komponen dan sensor robot'],
                ['judul' => 'Pemrograman Robot', 'deskripsi' => 'Membuat program untuk mengontrol robot'],
            ],
        ];

        foreach ($kelasCollection as $kelas) {
            $bidang = $kelas->bidang;
            if (isset($materiByBidang[$bidang])) {
                foreach ($materiByBidang[$bidang] as $index => $materi) {
                    Materi::updateOrCreate(
                        ['judul' => $materi['judul'], 'kelas_id' => $kelas->id],
                        [
                            'deskripsi' => $materi['deskripsi'],
                            'file_path' => 'materials/materi-' . $kelas->id . '-' . $index . '.pdf',
                            'uploaded_by' => $kelas->guru_id,
                            'status' => 'approved',
                            'created_at' => $now->copy()->subDays(rand(30, 90)),
                        ]
                    );
                }
            }
        }

        // Seed Pertemuan for each class
        foreach ($kelasCollection as $index => $kelas) {
            for ($p = 1; $p <= 5; $p++) {
                Pertemuan::updateOrCreate(
                    ['kelas_id' => $kelas->id, 'judul_pertemuan' => "Pertemuan $p"],
                    [
                        'deskripsi' => "Materi pembelajaran pertemuan ke-$p untuk kelas {$kelas->nama_kelas}",
                        'tanggal_pertemuan' => $now->copy()->addDays($p * 7)->toDateString(),
                        'waktu_mulai' => '14:00',
                        'waktu_selesai' => '15:30',
                        'guru_id' => $kelas->guru_id,
                        'created_at' => $now->copy()->subDays(rand(20, 60)),
                    ]
                );
            }
        }

        // Seed Activity Logs
        $activities = [
            ['action' => 'login', 'description' => 'User login ke sistem'],
            ['action' => 'create', 'description' => 'Membuat kelas baru'],
            ['action' => 'update', 'description' => 'Mengubah data kelas'],
            ['action' => 'delete', 'description' => 'Menghapus data'],
            ['action' => 'upload', 'description' => 'Upload materi atau file'],
            ['action' => 'download', 'description' => 'Download data atau report'],
            ['action' => 'approve', 'description' => 'Approve materi atau permintaan'],
            ['action' => 'reject', 'description' => 'Reject materi atau permintaan'],
        ];

        $allUsers = User::all();
        foreach ($allUsers->take(6) as $user) {
            for ($i = 0; $i < rand(5, 15); $i++) {
                $activity = $activities[array_rand($activities)];
                ActivityLog::create([
                    'user_id' => $user->id,
                    'action' => $activity['action'],
                    'model_type' => 'App\\Models\\Kelas',
                    'model_id' => $kelasCollection->random()->id,
                    'description' => $activity['description'],
                    'ip_address' => '127.0.0.' . rand(1, 255),
                    'user_agent' => 'Mozilla/5.0',
                    'created_at' => $now->copy()->subDays(rand(1, 30)),
                ]);
            }
        }
    }
}