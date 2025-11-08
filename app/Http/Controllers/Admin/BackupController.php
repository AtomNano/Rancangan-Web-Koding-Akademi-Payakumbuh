<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;
use Spatie\Backup\BackupDestination\BackupDestination;
use Illuminate\Support\Facades\Artisan;

class BackupController extends Controller
{
    public function index()
    {
        $disk = config('backup.backup.destination.disks')[0];
        $backupDestination = BackupDestination::create($disk, config('backup.backup.name'));

        $backups = $backupDestination->backups()->map(function ($backup) {
            return [
                'path' => $backup->path(),
                'date' => $backup->date(),
                'size' => $this->formatSize($backup->size()),
            ];
        })->reverse();

        $stats = [
            'berhasil' => $backups->count(),
            'gagal' => 0, // This would require a more complex logging system
            'total_ukuran' => $this->formatSize($backupDestination->usedStorage()),
        ];

        return view('admin.backup.index', compact('backups', 'stats'));
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
            Artisan::call('backup:run', ['--only-db' => false, '--only-files' => false]);
            
            // Log activity
            ActivityLogger::logBackupCreated();
            
            return redirect()->back()->with('success', 'Proses backup manual berhasil dimulai.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memulai backup: ' . $e->getMessage());
        }
    }

    // Methods for download/delete would go here
}