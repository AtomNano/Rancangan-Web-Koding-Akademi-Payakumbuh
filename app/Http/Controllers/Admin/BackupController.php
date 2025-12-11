<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;
use Spatie\Backup\BackupDestination\BackupDestination;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Exception;

class BackupController extends Controller
{
    public function index()
    {
        try {
            // Validasi config backup
            $backupDisks = config('backup.backup.destination.disks', []);
            if (empty($backupDisks)) {
                throw new Exception('Konfigurasi backup disk tidak ditemukan. Pastikan file config/backup.php sudah dikonfigurasi dengan benar.');
            }

            $disk = $backupDisks[0];
            $backupName = config('backup.backup.name', env('APP_NAME', 'laravel-backup'));

            // Pastikan disk ada di filesystem config
            if (!array_key_exists($disk, config('filesystems.disks', []))) {
                throw new Exception("Disk '{$disk}' tidak ditemukan di konfigurasi filesystem.");
            }

            // Buat backup destination dengan error handling
            try {
                $backupDestination = BackupDestination::create($disk, $backupName);
            } catch (Exception $e) {
                throw new Exception('Gagal membuat backup destination: ' . $e->getMessage());
            }

            // Pastikan folder backup ada dan bisa diakses
            // Backup disimpan di disk yang dikonfigurasi
            $backupRootPath = config('filesystems.disks.' . $disk . '.root', storage_path('app'));
            if (!is_dir($backupRootPath)) {
                if (!mkdir($backupRootPath, 0755, true) && !is_dir($backupRootPath)) {
                    throw new Exception("Tidak dapat membuat folder root backup: {$backupRootPath}");
                }
            }

            // Cek permission folder root
            if (!is_writable($backupRootPath)) {
                throw new Exception("Folder backup tidak dapat ditulis: {$backupRootPath}. Pastikan permission folder sudah benar. Jalankan: chmod -R 775 " . dirname($backupRootPath));
            }

            // Ambil daftar backup dengan error handling
            try {
                $backupCollection = $backupDestination->backups();

                if ($backupCollection) {
                    $backups = $backupCollection->map(function ($backup) {
                        try {
                            $path = $backup->path();
                            $filename = basename($path);
                            
                            // Pastikan filename tidak kosong
                            if (empty($filename)) {
                                // Jika basename kosong, gunakan path sebagai fallback
                                $filename = $path;
                            }
                            
                            return [
                                'path' => $path,
                                'filename' => $filename,
                                'date' => $backup->date(),
                                'size' => $this->formatSize($backup->sizeInBytes()),
                            ];
                        } catch (Exception $e) {
                            // Skip backup yang corrupt
                            \Log::warning('Skipping corrupt backup: ' . $e->getMessage());
                            return null;
                        }
                    })->filter()->reverse()->values();
                } else {
                    $backups = collect([]);
                }
            } catch (Exception $e) {
                // Jika tidak bisa membaca backup, set empty collection
                $backups = collect([]);
            }

            // Hitung stats dengan error handling
            try {
                $totalSize = $backupDestination->usedStorage();
            } catch (Exception $e) {
                $totalSize = 0;
            }

            $stats = [
                'berhasil' => $backups->count(),
                'gagal' => 0, // This would require a more complex logging system
                'total_ukuran' => $this->formatSize($totalSize),
            ];

            return view('admin.backup.index', compact('backups', 'stats'));

        } catch (Exception $e) {
            // Log error untuk debugging
            \Log::error('Backup Controller Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            // Return view dengan error message
            $backups = collect([]);
            $stats = [
                'berhasil' => 0,
                'gagal' => 0,
                'total_ukuran' => '0 B',
            ];

            return view('admin.backup.index', compact('backups', 'stats'))
                ->with('error', 'Terjadi kesalahan saat memuat data backup: ' . $e->getMessage());
        }
    }

    private function formatSize($sizeInBytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        if ($sizeInBytes == 0) {
            return '0 B';
        }
        $i = floor(log($sizeInBytes, 1024));
        return round($sizeInBytes / (1024 ** $i), 2) . ' ' . $units[$i];
    }

    public function create()
    {
        try {
            // Validasi config backup
            $backupDisks = config('backup.backup.destination.disks', []);
            if (empty($backupDisks)) {
                throw new Exception('Konfigurasi backup disk tidak ditemukan.');
            }

            $disk = $backupDisks[0];
            if (!array_key_exists($disk, config('filesystems.disks', []))) {
                throw new Exception("Disk '{$disk}' tidak ditemukan di konfigurasi filesystem.");
            }

            // Pastikan folder temporary backup ada
            $tempDir = config('backup.backup.temporary_directory', storage_path('app/backup-temp'));
            if (!is_dir($tempDir)) {
                if (!mkdir($tempDir, 0755, true) && !is_dir($tempDir)) {
                    throw new Exception("Tidak dapat membuat folder temporary backup: {$tempDir}");
                }
            }

            // Pastikan folder backup destination ada
            // Backup disimpan di disk 'local' yang root-nya adalah storage/app/private
            $backupRootPath = config('filesystems.disks.' . $disk . '.root', storage_path('app'));
            if (!is_dir($backupRootPath)) {
                if (!mkdir($backupRootPath, 0755, true) && !is_dir($backupRootPath)) {
                    throw new Exception("Tidak dapat membuat folder root backup: {$backupRootPath}");
                }
            }

            // Cek permission folder root
            if (!is_writable($backupRootPath)) {
                throw new Exception("Folder backup tidak dapat ditulis: {$backupRootPath}. Pastikan permission folder sudah benar.");
            }

            // Hitung jumlah backup sebelum
            $backupName = config('backup.backup.name', env('APP_NAME', 'laravel-backup'));
            $backupDestination = BackupDestination::create($disk, $backupName);
            $backupsBefore = $backupDestination->backups()->count();
            
            // Jalankan backup command dan tangkap output
            try {
                $exitCode = Artisan::call('backup:run', [
                    '--only-db' => false, 
                    '--only-files' => false
                ]);
                
                $output = Artisan::output();
                
                // Log output untuk debugging
                \Log::info('Backup command executed', [
                    'exit_code' => $exitCode,
                    'output' => $output
                ]);
                
            } catch (Exception $e) {
                \Log::error('Backup command exception: ' . $e->getMessage());
                throw new Exception('Gagal menjalankan backup command: ' . $e->getMessage());
            }
            
            // Jika exit code bukan 0, berarti ada error
            if ($exitCode !== 0) {
                $errorMsg = 'Backup command gagal. ';
                if (!empty($output)) {
                    $errorMsg .= 'Output: ' . $output;
                } else {
                    $errorMsg .= 'Cek log Laravel untuk detail error.';
                }
                throw new Exception($errorMsg);
            }
            
            // Tunggu beberapa detik untuk memastikan file backup sudah dibuat
            // (karena backup bisa memakan waktu)
            $maxWait = 10; // maksimal 10 detik
            $waited = 0;
            $backupCreated = false;
            
            while ($waited < $maxWait) {
                sleep(1);
                $waited++;
                
                // Refresh backup destination
                $backupDestination = BackupDestination::create($disk, $backupName);
                $backupsAfter = $backupDestination->backups()->count();
                
                if ($backupsAfter > $backupsBefore) {
                    $backupCreated = true;
                    break;
                }
            }
            
            // Jika masih belum ada backup baru, cek folder langsung
            if (!$backupCreated) {
                $backupRootPath = config('filesystems.disks.' . $disk . '.root', storage_path('app'));
                $backupFolder = $backupRootPath . '/' . $backupName;
                
                // Cek apakah folder ada dan ada file zip
                if (is_dir($backupFolder)) {
                    $zipFiles = glob($backupFolder . '/*.zip');
                    if (count($zipFiles) > 0) {
                        // File ada, mungkin hanya masalah refresh
                        $backupCreated = true;
                    }
                }
            }
            
            if (!$backupCreated) {
                // Cek apakah ada error di log Laravel
                $logFile = storage_path('logs/laravel.log');
                $recentErrors = '';
                if (file_exists($logFile)) {
                    $lines = file($logFile);
                    $recentLines = array_slice($lines, -20); // 20 baris terakhir
                    $recentErrors = implode('', $recentLines);
                }
                
                throw new Exception('Backup tidak berhasil dibuat setelah ' . $maxWait . ' detik. ' . 
                    'Pastikan: 1) Database connection berfungsi, 2) Folder backup dapat ditulis, ' .
                    '3) Cek storage/logs/laravel.log untuk detail error. ' .
                    'Output command: ' . ($output ?: 'Tidak ada output'));
            }
            
            // Log activity
            try {
                ActivityLogger::logBackupCreated();
            } catch (Exception $e) {
                // Log activity error tidak critical, lanjutkan
                \Log::warning('Failed to log backup activity: ' . $e->getMessage());
            }
            
            return redirect()->back()->with('success', 'Backup berhasil dibuat! File backup sudah tersedia di riwayat cadangan.');
            
        } catch (Exception $e) {
            \Log::error('Backup Creation Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()->with('error', 'Gagal memulai backup: ' . $e->getMessage());
        }
    }

    public function download($filename)
    {
        try {
            $backupDisks = config('backup.backup.destination.disks', []);
            if (empty($backupDisks)) {
                throw new Exception('Konfigurasi backup disk tidak ditemukan.');
            }

            $disk = $backupDisks[0];
            $backupName = config('backup.backup.name', env('APP_NAME', 'laravel-backup'));
            $backupDestination = BackupDestination::create($disk, $backupName);

            // Cari backup berdasarkan filename
            $backup = $backupDestination->backups()->first(function ($backup) use ($filename) {
                return basename($backup->path()) === $filename;
            });

            if (!$backup) {
                return redirect()->back()->with('error', 'File backup tidak ditemukan.');
            }

            // Spatie Backup menyimpan file di disk dengan path: {backup_name}/{filename}
                    // Path relatif dari disk root
                            $backupPath = $backupName . '/' . $backup->path();
                            
                            // Cek apakah file ada di Storage
                            if (Storage::disk($disk)->exists($backupPath)) {
                // Log activity
                try {
                    ActivityLogger::log('backup_downloaded', 'Mengunduh file backup: ' . $filename);
                } catch (Exception $e) {
                    \Log::warning('Failed to log backup download activity: ' . $e->getMessage());
                }

                // Return file download menggunakan Storage
                return Storage::disk($disk)->download($backupPath, $filename);
            }

            // Fallback: coba dengan path absolut
            $diskRoot = config('filesystems.disks.' . $disk . '.root', storage_path('app'));
            $fullPath = $diskRoot . '/' . $backupPath;
            
            if (file_exists($fullPath)) {
                // Log activity
                try {
                    ActivityLogger::log('backup_downloaded', 'Mengunduh file backup: ' . $filename);
                } catch (Exception $e) {
                    \Log::warning('Failed to log backup download activity: ' . $e->getMessage());
                }

                return response()->download($fullPath, $filename, [
                    'Content-Type' => 'application/zip',
                ]);
            }

            return redirect()->back()->with('error', 'File backup tidak ditemukan di server.');

        } catch (Exception $e) {
            \Log::error('Backup Download Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'filename' => $filename
            ]);

            return redirect()->back()->with('error', 'Gagal mengunduh backup: ' . $e->getMessage());
        }
    }

    public function delete($filename)
    {
        try {
            $backupDisks = config('backup.backup.destination.disks', []);
            if (empty($backupDisks)) {
                throw new Exception('Konfigurasi backup disk tidak ditemukan.');
            }

            $disk = $backupDisks[0];
            $backupName = config('backup.backup.name', env('APP_NAME', 'laravel-backup'));
            $backupDestination = BackupDestination::create($disk, $backupName);

            // Cari backup berdasarkan filename
            $backup = $backupDestination->backups()->first(function ($backup) use ($filename) {
                return basename($backup->path()) === $filename;
            });

            if (!$backup) {
                return redirect()->back()->with('error', 'File backup tidak ditemukan.');
            }

            // Hapus backup menggunakan method delete dari BackupDestination
            $backup->delete();

            // Log activity
            try {
                ActivityLogger::log('backup_deleted', 'Menghapus file backup: ' . $filename);
            } catch (Exception $e) {
                \Log::warning('Failed to log backup delete activity: ' . $e->getMessage());
            }

            return redirect()->back()->with('success', 'File backup berhasil dihapus.');

        } catch (Exception $e) {
            \Log::error('Backup Delete Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'filename' => $filename
            ]);

            return redirect()->back()->with('error', 'Gagal menghapus backup: ' . $e->getMessage());
        }
    }

    public function debugListFiles()
    {
        $backupDisks = config('backup.backup.destination.disks', []);
        $disk = $backupDisks[0];
        $backupName = config('backup.backup.name', env('APP_NAME', 'laravel-backup'));
        
        $files = Storage::disk($disk)->allFiles($backupName);
        
        dd($files);
    }
}