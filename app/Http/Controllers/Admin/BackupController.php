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

        try {
            $zipFileName = 'semua-materi-' . now()->format('Y-m-d-His') . '.zip';

            // Set headers for direct streaming
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . $zipFileName . '"');
            header('Pragma: no-cache');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('X-Accel-Buffering: no'); // For Nginx

            // Ensure no output buffering is active
            while (ob_get_level()) {
                ob_end_clean();
            }

            $zip = new ZipStream($zipFileName, ['send_http_headers' => false]);
            
            foreach ($files as $file) {
                if (Storage::disk('public')->exists($file)) {
                    // Use an in-memory approach to get contents
                    $contents = Storage::disk('public')->get($file);
                    // Use basename() to get just the filename. This is the critical fix.
                    $filenameInZip = basename($file);
                    $zip->addFile($filenameInZip, $contents);
                }
            }

            $zip->finish();

        } catch (Exception $e) {
            \Log::error('Error creating zip stream for material download: ' . $e->getMessage());
        } finally {
            exit();
        }
    }
}