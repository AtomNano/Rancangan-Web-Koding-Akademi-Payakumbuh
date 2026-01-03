<?php
/**
 * Debug script to check pertemuan-kelas relationship
 * Run: php debug_pertemuan.php
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Pertemuan;
use App\Models\Kelas;

echo "=== DEBUG PERTEMUAN & KELAS RELATIONSHIP ===\n\n";

// Check specific pertemuan
$pertemuanId = 7;
$kelasId = 2;

$pertemuan = Pertemuan::find($pertemuanId);
if ($pertemuan) {
    echo "Pertemuan ID: {$pertemuan->id}\n";
    echo "Judul: {$pertemuan->judul_pertemuan}\n";
    echo "Kelas ID: {$pertemuan->kelas_id}\n";
    echo "Guru ID: {$pertemuan->guru_id}\n\n";
    
    $actualKelas = Kelas::find($pertemuan->kelas_id);
    if ($actualKelas) {
        echo "Actual Kelas: {$actualKelas->nama_kelas} (ID: {$actualKelas->id})\n";
    }
} else {
    echo "Pertemuan ID {$pertemuanId} NOT FOUND\n";
}

echo "\n";

$requestedKelas = Kelas::find($kelasId);
if ($requestedKelas) {
    echo "Requested Kelas ID: {$requestedKelas->id}\n";
    echo "Requested Kelas Name: {$requestedKelas->nama_kelas}\n\n";
    
    echo "All Pertemuan for Kelas ID {$kelasId}:\n";
    $pertemuanList = Pertemuan::where('kelas_id', $kelasId)->get();
    foreach ($pertemuanList as $p) {
        echo "  - ID: {$p->id}, Judul: {$p->judul_pertemuan}\n";
    }
} else {
    echo "Kelas ID {$kelasId} NOT FOUND\n";
}

echo "\n";
echo "Match: " . ($pertemuan && $pertemuan->kelas_id == $kelasId ? "YES ✓" : "NO ✗") . "\n";
echo "\n=== END DEBUG ===\n";
