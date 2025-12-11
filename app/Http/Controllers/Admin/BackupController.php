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
use Symfony\Component\HttpFoundation\StreamedResponse;
use ZipStream\ZipStream;
use ZipStream\Option\Archive as ArchiveOptions;
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
        $zipFileName = 'semua-materi-' . now()->format('Y-m-d-His') . '.zip';

        $options = new ArchiveOptions();
        $options->setSendHttpHeaders(true);

        return new StreamedResponse(function () use ($zipFileName) {
            $zip = new ZipStream($zipFileName, new ArchiveOptions());
            
            $files = Storage::disk('public')->allFiles('materi');

            foreach ($files as $file) {
                if (Storage::disk('public')->exists($file)) {
                    $zip->addFileFromStream($file, Storage::disk('public')->readStream($file));
                }
            }

            $zip->finish();
        }, 200, [
            'Content-Type' => 'application/zip',
            'Content-Disposition' => 'attachment; filename="' . $zipFileName . '"',
        ]);
    }
}