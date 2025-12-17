<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Kelas;

class VerifySiswaIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure there is at least one class
        $kelas = Kelas::first();
        if (!$kelas) {
            $kelas = Kelas::create([
                'nama_kelas' => 'Kelas Uji Coba',
                'deskripsi' => 'Kelas untuk verifikasi ID siswa',
            ]);
        }

        // Create a unique test student
        $email = 'test.siswa.' . Str::random(6) . '@example.com';
        $user = User::create([
            'name' => 'Siswa Verifikasi ' . Str::upper(Str::random(4)),
            'email' => $email,
            'password' => Hash::make('password123'),
            'role' => 'siswa',
            'sekolah' => 'Sekolah Uji Coba',
        ]);

        // Create enrollment
        $durationMonths = 3;
        $monthlyQuota = 4;
        $target = $durationMonths * $monthlyQuota;

        $user->enrollments()->create([
            'kelas_id' => $kelas->id,
            'status' => 'active',
            'start_date' => now()->toDateString(),
            'duration_months' => $durationMonths,
            'monthly_quota' => $monthlyQuota,
            'target_sessions' => $target,
            'sessions_attended' => 0,
        ]);

        // Generate id_siswa using new numeric class code format
        $idSiswa = User::generateIdSiswa($kelas->id);
        $user->update(['id_siswa' => $idSiswa]);

        $this->command->info('Created test siswa: ' . $user->email . ' | ID: ' . $user->id_siswa . ' | Kelas ID: ' . $kelas->id);
    }
}
