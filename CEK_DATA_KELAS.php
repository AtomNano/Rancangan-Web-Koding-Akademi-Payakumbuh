<?php
/**
 * Script untuk mengecek data kelas di database
 * Jalankan: php artisan tinker
 * Lalu copy-paste isi file ini
 */

$kelasId = 2; // Ganti dengan ID kelas yang ingin dicek

echo "=== CEK DATA KELAS ID: {$kelasId} ===\n\n";

// 1. Cek Kelas
$kelas = \App\Models\Kelas::find($kelasId);
if ($kelas) {
    echo "✓ Kelas ditemukan:\n";
    echo "  - ID: {$kelas->id}\n";
    echo "  - Nama: {$kelas->nama_kelas}\n";
    echo "  - Guru ID: " . ($kelas->guru_id ?? 'NULL') . "\n";
    echo "  - Status: {$kelas->status}\n\n";
} else {
    echo "✗ Kelas tidak ditemukan!\n\n";
    exit;
}

// 2. Cek Enrollments
$enrollments = \App\Models\Enrollment::where('kelas_id', $kelasId)->get();
echo "Enrollments: {$enrollments->count()}\n";
if ($enrollments->count() > 0) {
    foreach ($enrollments as $e) {
        $user = \App\Models\User::find($e->user_id);
        echo "  - User ID: {$e->user_id} ({$user->name ?? 'N/A'}) - Role: {$user->role ?? 'N/A'} - Status: {$e->status}\n";
    }
} else {
    echo "  ✗ Tidak ada enrollment untuk kelas ini!\n";
    echo "  → Solusi: Daftarkan siswa ke kelas melalui admin panel\n";
}
echo "\n";

// 3. Cek Materi
$materi = \App\Models\Materi::where('kelas_id', $kelasId)->get();
echo "Materi: {$materi->count()}\n";
if ($materi->count() > 0) {
    foreach ($materi as $m) {
        echo "  - ID: {$m->id} - Judul: {$m->judul} - Status: {$m->status} - Uploaded by: {$m->uploaded_by}\n";
    }
} else {
    echo "  ✗ Tidak ada materi untuk kelas ini!\n";
    echo "  → Solusi: Upload materi melalui guru panel\n";
}
echo "\n";

// 4. Cek Siswa (dari enrollments)
$enrollmentIds = \App\Models\Enrollment::where('kelas_id', $kelasId)->pluck('user_id')->toArray();
$siswa = \App\Models\User::whereIn('id', $enrollmentIds)->where('role', 'siswa')->get();
echo "Siswa: {$siswa->count()}\n";
if ($siswa->count() > 0) {
    foreach ($siswa as $s) {
        echo "  - ID: {$s->id} - Nama: {$s->name} - Email: {$s->email}\n";
    }
} else {
    echo "  ✗ Tidak ada siswa untuk kelas ini!\n";
}
echo "\n";

// 5. Summary
echo "=== SUMMARY ===\n";
echo "Kelas: " . ($kelas ? "✓" : "✗") . "\n";
echo "Enrollments: {$enrollments->count()}\n";
echo "Materi: {$materi->count()}\n";
echo "Siswa: {$siswa->count()}\n";



