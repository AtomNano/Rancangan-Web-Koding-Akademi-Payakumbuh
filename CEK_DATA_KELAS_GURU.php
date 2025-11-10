<?php
/**
 * Script untuk mengecek data kelas dan guru di database
 * Jalankan: php artisan tinker
 * Lalu copy-paste isi file ini
 */

$kelasId = 1; // Ganti dengan ID kelas yang ingin dicek (1 atau 2)
$guruId = 6; // Ganti dengan ID guru yang login

echo "=== CEK DATA KELAS ID: {$kelasId} DAN GURU ID: {$guruId} ===\n\n";

// 1. Cek Kelas
$kelas = \App\Models\Kelas::find($kelasId);
if ($kelas) {
    echo "✓ Kelas ditemukan:\n";
    echo "  - ID: {$kelas->id}\n";
    echo "  - Nama: {$kelas->nama_kelas}\n";
    echo "  - Guru ID: " . ($kelas->guru_id ?? 'NULL') . "\n";
    echo "  - Status: {$kelas->status}\n";
    if ($kelas->guru_id == $guruId) {
        echo "  - ✓ Kelas sudah diassign ke guru ID {$guruId}\n";
    } else {
        echo "  - ✗ Kelas BELUM diassign ke guru ID {$guruId}\n";
        echo "    → Solusi: UPDATE kelas SET guru_id = {$guruId} WHERE id = {$kelasId};\n";
    }
    echo "\n";
} else {
    echo "✗ Kelas tidak ditemukan!\n\n";
    exit;
}

// 2. Cek Enrollments (Siswa)
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

// 3. Cek Siswa (dari enrollments dengan role = siswa)
$enrollmentIds = \App\Models\Enrollment::where('kelas_id', $kelasId)->pluck('user_id')->toArray();
$siswa = \App\Models\User::whereIn('id', $enrollmentIds)->where('role', 'siswa')->get();
echo "Siswa (role = siswa): {$siswa->count()}\n";
if ($siswa->count() > 0) {
    foreach ($siswa as $s) {
        echo "  - ID: {$s->id} - Nama: {$s->name} - Email: {$s->email}\n";
    }
} else {
    echo "  ✗ Tidak ada siswa dengan role 'siswa' di kelas ini!\n";
    echo "  → Pastikan user yang terdaftar memiliki role = 'siswa'\n";
}
echo "\n";

// 4. Cek Materi (SEMUA materi di kelas ini)
$allMateri = \App\Models\Materi::where('kelas_id', $kelasId)->get();
echo "Semua Materi di Kelas: {$allMateri->count()}\n";
if ($allMateri->count() > 0) {
    foreach ($allMateri as $m) {
        echo "  - ID: {$m->id} - Judul: {$m->judul} - Status: {$m->status} - Uploaded by: {$m->uploaded_by}\n";
    }
} else {
    echo "  ✗ Tidak ada materi untuk kelas ini!\n";
    echo "  → Solusi: Upload materi melalui guru panel\n";
}
echo "\n";

// 5. Cek Materi yang diupload oleh guru ini
$materiGuru = \App\Models\Materi::where('kelas_id', $kelasId)
    ->where('uploaded_by', $guruId)
    ->get();
echo "Materi yang diupload oleh Guru ID {$guruId}: {$materiGuru->count()}\n";
if ($materiGuru->count() > 0) {
    foreach ($materiGuru as $m) {
        echo "  - ID: {$m->id} - Judul: {$m->judul} - Status: {$m->status}\n";
    }
} else {
    echo "  ✗ Tidak ada materi yang diupload oleh guru ID {$guruId} untuk kelas ini!\n";
    echo "  → Solusi: Upload materi melalui guru panel dengan memastikan kelas_id = {$kelasId}\n";
}
echo "\n";

// 6. Cek apakah guru terdaftar di kelas ini (enrollment)
$guruEnrolled = \App\Models\Enrollment::where('user_id', $guruId)
    ->where('kelas_id', $kelasId)
    ->exists();
echo "Guru terdaftar di kelas (enrollment): " . ($guruEnrolled ? 'Ya' : 'Tidak') . "\n";
if (!$guruEnrolled && $kelas->guru_id != $guruId) {
    echo "  → Solusi: Assign kelas ke guru dengan salah satu cara:\n";
    echo "    1. UPDATE kelas SET guru_id = {$guruId} WHERE id = {$kelasId};\n";
    echo "    2. Atau daftarkan guru ke kelas melalui enrollments table\n";
}
echo "\n";

echo "=== KESIMPULAN ===\n";
echo "Untuk menampilkan data di halaman detail kelas:\n";
echo "1. Pastikan kelas diassign ke guru: UPDATE kelas SET guru_id = {$guruId} WHERE id = {$kelasId};\n";
echo "2. Pastikan ada siswa yang terdaftar di kelas (enrollments table)\n";
echo "3. Pastikan ada materi yang diupload oleh guru ID {$guruId} untuk kelas ID {$kelasId}\n";

