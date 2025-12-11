<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use App\Exports\UsersExport;
use App\Exports\LogsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use ZipStream\ZipStream; // Use ZipStream
use Exception;

class BackupController extends Controller
{
    /**
     * Display the backup options page.
     */
    public function index()
    {
        return view('admin.backup.index');
    }

    /**
     * Export users to an Excel file based on their role.
     */
    public function exportUsers(Request $request)
    {
        $request->validate(['role' => 'required|in:admin,guru,siswa']);
        $role = $request->role;
        $filename = 'data-' . $role . '-' . now()->format('Y-m-d-His') . '.xlsx';

        return Excel::download(new UsersExport($role), $filename);
    }

    /**
     * Export activity logs to an Excel file.
     */
    public function exportLogs()
    {
        $filename = 'data-log-aktivitas-' . now()->format('Y-m-d-His') . '.xlsx';
        return Excel::download(new LogsExport(), $filename);
    }

    /**
     * Trigger a database-only backup.
     */
    public function backupDatabase()
    {
        try {
            Artisan::call('backup:run', ['--only-db' => true, '--disable-notifications' => true]);
            return redirect()->back()->with('success', 'Backup database berhasil dimulai. File akan segera tersedia di server utama penyedia hosting Anda.');
        } catch (Exception $e) {
            report($e);
            return redirect()->back()->with('error', 'Gagal memulai backup database: ' . $e->getMessage());
        }
    }

    /**
     * Download all files in the 'public/materi' directory as a zip file.
     */
    public function downloadAllMaterials()
    {
        $files = Storage::disk('public')->allFiles('materi');

        if (empty($files)) {
            return redirect()->back()->with('error', 'Tidak ada file materi yang ditemukan untuk di-backup.');
        }

        // Create a temporary path for the zip file in the storage/app directory
        $zipFileName = 'semua-materi-' . now()->format('Y-m-d-His') . '.zip';
        $tempZipPath = storage_path('app/' . $zipFileName);

        try {
            // Check if the zip extension is loaded
            if (!extension_loaded('zip')) {
                throw new Exception('PHP extension "zip" tidak aktif. Harap aktifkan di panel hosting Anda.');
            }

            $zip = new \ZipArchive();

            if ($zip->open($tempZipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== TRUE) {
                throw new Exception('Tidak dapat membuat atau menimpa file zip sementara.');
            }

            foreach ($files as $file) {
                if (Storage::disk('public')->exists($file)) {
                    $filePath = Storage::disk('public')->path($file);
                    $filenameInZip = basename($file);
                    
                    if (is_readable($filePath)) {
                        $zip->addFile($filePath, $filenameInZip);
                    } else {
                        // Log a warning if a file is not readable
                        \Log::warning('File materi tidak dapat dibaca dan dilewati saat backup: ' . $filePath);
                    }
                }
            }

            $zip->close();

            // If the file was created successfully, return it for download and delete it after sending.
            return response()->download($tempZipPath)->deleteFileAfterSend(true);

        } catch (Exception $e) {
            \Log::error('Gagal membuat file zip materi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat file zip: ' . $e->getMessage());
        }
    }
}