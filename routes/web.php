<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\MateriProgressController;
use App\Http\Controllers\GuruKelasController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

Route::get('/login-siswa', function () {
    return redirect('/login');
});

Route::get('/login-guru', function () {
    return redirect('/login');
});

Route::get('/login-admin', function () {
    return redirect('/login');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/quick-login/admin', function () {
    $admin = App\Models\User::where('role', 'admin')->first();
    if ($admin) {
        auth()->login($admin);
        return redirect('/admin/dashboard');
    }
    return 'No admin user found.';
});

Route::get('/quick-login/guru', function () {
    $guru = App\Models\User::where('role', 'guru')->first();
    if ($guru) {
        auth()->login($guru);
        return redirect('/guru/dashboard');
    }
    return 'No guru user found.';
});

Route::get('/quick-login/siswa', function () {
    $siswa = App\Models\User::where('role', 'siswa')->first();
    if ($siswa) {
        auth()->login($siswa);
        return redirect('/siswa/dashboard');
    }
    return 'No siswa user found.';
});

// Quick login routes for development
Route::middleware(['web'])->group(function () {
    Route::get('/quick-login/{role}', function ($role) {
        if (!app()->environment('local')) {
            return redirect('/login');
        }

        $email = match ($role) {
            'admin' => 'admin@example.com',
            'guru' => 'guru@example.com',
            'siswa' => 'siswa@example.com',
            default => null,
        };

        if (!$email) {
            return redirect('/login');
        }

        $user = App\Models\User::where('email', $email)->where('role', $role)->first();

        if ($user) {
            auth()->login($user);
            return redirect('/' . $role . '/dashboard');
        }

        return 'No ' . $role . ' user found with email ' . $email . '.';


    })->where('role', 'admin|guru|siswa');
});

// Role-based dashboard routing
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.read.all');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Admin routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/analytics', [DashboardController::class, 'analytics'])->name('analytics');
        Route::get('/dashboard', function () {
            // Student status calculation
            $all_siswa = \App\Models\User::where('role', 'siswa')->get();
            [$siswa_aktif, $siswa_tidak_aktif] = $all_siswa->partition(fn ($user) => $user->is_active);

            $stats = [
                'total_pengguna' => \App\Models\User::count(),
                'total_guru' => \App\Models\User::where('role', 'guru')->count(),
                'total_siswa' => $all_siswa->count(),
                'siswa_aktif' => $siswa_aktif->count(),
                'siswa_tidak_aktif' => $siswa_tidak_aktif->count(),
                'total_kelas' => \App\Models\Kelas::count(),
                'pending_materi' => \App\Models\Materi::where('status', 'pending')->count(),
                'materi_aktif' => \App\Models\Materi::where('status', 'approved')->count(),
            ];
            $pending_verifications = \App\Models\Materi::where('status', 'pending')->with(['uploadedBy', 'kelas'])->latest()->take(5)->get();
            
            // Get recent activity logs
            $recent_activities = \App\Models\ActivityLog::with('user')
                ->latest()
                ->take(10)
                ->get();

            return view('admin.dashboard', compact('stats', 'pending_verifications', 'recent_activities'));
        })->name('dashboard');
        
        Route::resource('users', UserController::class);
        Route::post('users/{user}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
        Route::post('users/{user}/activate', [UserController::class, 'activate'])->name('users.activate');
        Route::post('users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
        Route::get('users-deleted', [UserController::class, 'showDeleted'])->name('users.deleted');
        
        Route::resource('kelas', KelasController::class)->parameters([
            'kelas' => 'kelas',
        ]);

        Route::get('kelas/{kelas}/attendance/export', [KelasController::class, 'exportAttendance'])->name('kelas.attendance.export');
        Route::get('kelas/{kelas}/siswa/{user}/log/export', [KelasController::class, 'exportStudentLearningLog'])->name('kelas.student.log.export');
        Route::get('kelas/{kelas}/siswa/{siswa}/progress', [\App\Http\Controllers\Admin\PertemuanController::class, 'studentProgress'])->name('kelas.student.progress');
        
        // Additional class routes
        Route::get('kelas/{kelas}/enroll', [KelasController::class, 'enrollForm'])->name('kelas.enroll');
        Route::post('kelas/{kelas}/enroll', [KelasController::class, 'enroll'])->name('kelas.enroll.store');
        Route::delete('kelas/{kelas}/enroll/{user}', [KelasController::class, 'unenroll'])->name('kelas.unenroll');
        
        // Pertemuan: select kelas entrypoint (shortcut from sidebar)
        Route::get('pertemuan', [\App\Http\Controllers\Admin\PertemuanController::class, 'selectKelas'])->name('pertemuan.select');
        
        // Pertemuan management routes for admin
        Route::get('kelas/{kelas}/pertemuan', [\App\Http\Controllers\Admin\PertemuanController::class, 'index'])->name('pertemuan.index');
        Route::get('kelas/{kelas}/pertemuan/create', [\App\Http\Controllers\Admin\PertemuanController::class, 'create'])->name('pertemuan.create');
        Route::post('kelas/{kelas}/pertemuan', [\App\Http\Controllers\Admin\PertemuanController::class, 'store'])->name('pertemuan.store');
        Route::get('kelas/{kelas}/pertemuan/{pertemuan}', [\App\Http\Controllers\Admin\PertemuanController::class, 'show'])->name('pertemuan.show');
        Route::get('kelas/{kelas}/pertemuan/{pertemuan}/absen-detail', [\App\Http\Controllers\Admin\PertemuanController::class, 'absenDetail'])->name('pertemuan.absen-detail');
        Route::get('kelas/{kelas}/pertemuan/{pertemuan}/edit', [\App\Http\Controllers\Admin\PertemuanController::class, 'edit'])->name('pertemuan.edit');
        Route::put('kelas/{kelas}/pertemuan/{pertemuan}', [\App\Http\Controllers\Admin\PertemuanController::class, 'update'])->name('pertemuan.update');
        Route::delete('kelas/{kelas}/pertemuan/{pertemuan}', [\App\Http\Controllers\Admin\PertemuanController::class, 'destroy'])->name('pertemuan.destroy');
        Route::post('kelas/{kelas}/pertemuan/{pertemuan}/absen', [\App\Http\Controllers\Admin\PertemuanController::class, 'storeAbsen'])->name('pertemuan.absen');
        
        // Material verification routes
        Route::get('materi', [MateriController::class, 'index'])->name('materi.index');
        Route::get('materi/{materi}', [MateriController::class, 'show'])->name('materi.show');
        Route::get('materi/{materi}/download', [MateriController::class, 'download'])->name('materi.download');
        Route::post('materi/{materi}/approve', [MateriController::class, 'approve'])->name('materi.approve');
        Route::post('materi/{materi}/reject', [MateriController::class, 'reject'])->name('materi.reject');
        Route::post('materi/{materi}/remind', [MateriController::class, 'remind'])->name('materi.remind');

        // Backup Routes
        Route::get('backup', [\App\Http\Controllers\Admin\BackupController::class, 'index'])->name('backup.index');
        Route::get('backup/export/users', [\App\Http\Controllers\Admin\BackupController::class, 'exportUsers'])->name('backup.export.users');
        Route::get('backup/export/logs', [\App\Http\Controllers\Admin\BackupController::class, 'exportLogs'])->name('backup.export.logs');
        Route::get('backup/download/materials', [\App\Http\Controllers\Admin\BackupController::class, 'downloadAllMaterials'])->name('backup.download.materials');
        Route::post('backup/database', [\App\Http\Controllers\Admin\BackupController::class, 'backupDatabase'])->name('backup.database');
        
        // Old Spatie Backup Routes (can be removed or kept for CLI)
        Route::get('backup/create', [\App\Http\Controllers\Admin\BackupController::class, 'create'])->name('backup.create')->middleware('obsolete');
        Route::get('backup/download/{filename}', [\App\Http\Controllers\Admin\BackupController::class, 'download'])->name('backup.download')->middleware('obsolete');
        Route::delete('backup/delete/{filename}', [\App\Http\Controllers\Admin\BackupController::class, 'delete'])->name('backup.delete')->middleware('obsolete');
    });

    // Guru routes
    Route::middleware('guru')->prefix('guru')->name('guru.')->group(function () {
        Route::get('/dashboard', function () {
            $user = auth()->user();
            
            // Get classes assigned to this guru via guru_id
            $kelas = \App\Models\Kelas::where('guru_id', $user->id)
                ->withCount('students')
                ->with('guru')
                ->orderBy('created_at', 'desc')
                ->get();
            
            // Also get classes where guru is enrolled (secondary method)
            $enrolledKelasIds = \App\Models\Enrollment::where('user_id', $user->id)
                ->pluck('kelas_id')
                ->toArray();
            
            if (!empty($enrolledKelasIds)) {
                $enrolledKelas = \App\Models\Kelas::whereIn('id', $enrolledKelasIds)
                    ->where('guru_id', '!=', $user->id) // Don't duplicate classes already in $kelas
                    ->withCount('students')
                    ->with('guru')
                    ->orderBy('created_at', 'desc')
                    ->get();
                
                // Merge enrolled classes with assigned classes
                $kelas = $kelas->merge($enrolledKelas)->unique('id');
            }
            
            // Ensure we have a collection
            if (!$kelas || !($kelas instanceof \Illuminate\Support\Collection)) {
                $kelas = collect();
            }
            
            $assignedKelasIds = $kelas->pluck('id')->toArray();
            
            // Calculate stats
            if (empty($assignedKelasIds)) {
                $materi_count = 0;
                $pending_count = 0;
                $approved_count = 0;
            } else {
                $materi_count = \App\Models\Materi::whereIn('kelas_id', $assignedKelasIds)->where('uploaded_by', $user->id)->count();
                $pending_count = \App\Models\Materi::whereIn('kelas_id', $assignedKelasIds)->where('uploaded_by', $user->id)->where('status', 'pending')->count();
                $approved_count = \App\Models\Materi::whereIn('kelas_id', $assignedKelasIds)->where('uploaded_by', $user->id)->where('status', 'approved')->count();
            }
            
            $stats = [
                'total_materi' => $materi_count,
                'pending_materi' => $pending_count,
                'approved_materi' => $approved_count,
            ];
            return view('guru.dashboard', compact('stats', 'kelas'));
        })->name('dashboard');
        
        // Explicit routes for materi to avoid route model binding issues
        Route::get('materi', [MateriController::class, 'index'])->name('materi.index');
        Route::get('materi/create', [MateriController::class, 'create'])->name('materi.create');
        Route::post('materi', [MateriController::class, 'store'])->name('materi.store');
        Route::get('materi/{materi}', [MateriController::class, 'show'])->name('materi.show');
        Route::get('materi/{materi}/download', [MateriController::class, 'download'])->name('materi.download');
        Route::get('materi/{materi}/edit', [MateriController::class, 'edit'])->name('materi.edit');
        Route::put('materi/{materi}', [MateriController::class, 'update'])->name('materi.update');
        Route::delete('materi/{materi}', [MateriController::class, 'destroy'])->name('materi.destroy');
        
        Route::resource('kelas', GuruKelasController::class)->only(['index', 'show']);
        Route::get('kelas/{kelas}/siswa/{user}/log/export', [\App\Http\Controllers\KelasController::class, 'exportStudentLearningLog'])->name('kelas.student.log.export');
        
        // Attendance input flow (simplified)
        Route::get('absen', [\App\Http\Controllers\Guru\PertemuanController::class, 'attendanceIndex'])->name('absen.index');
        Route::get('absen/{kelas}', [\App\Http\Controllers\Guru\PertemuanController::class, 'attendanceSelectPertemuan'])->name('absen.select-pertemuan');
        
        // Pertemuan routes
        Route::get('kelas/{kelas}/pertemuan', [\App\Http\Controllers\Guru\PertemuanController::class, 'index'])->name('pertemuan.index');
        Route::get('kelas/{kelas}/pertemuan/create', [\App\Http\Controllers\Guru\PertemuanController::class, 'create'])->name('pertemuan.create');
        Route::post('kelas/{kelas}/pertemuan', [\App\Http\Controllers\Guru\PertemuanController::class, 'store'])->name('pertemuan.store');
        Route::get('kelas/{kelas}/pertemuan/{pertemuan}', [\App\Http\Controllers\Guru\PertemuanController::class, 'show'])->name('pertemuan.show');
        Route::get('kelas/{kelas}/pertemuan/{pertemuan}/absen-detail', [\App\Http\Controllers\Guru\PertemuanController::class, 'absenDetail'])->name('pertemuan.absen-detail');
        Route::post('kelas/{kelas}/pertemuan/{pertemuan}/absen', [\App\Http\Controllers\Guru\PertemuanController::class, 'storeAbsen'])->name('pertemuan.absen');
        Route::get('kelas/{kelas}/pertemuan/{pertemuan}/edit', [\App\Http\Controllers\Guru\PertemuanController::class, 'edit'])->name('pertemuan.edit');
        Route::put('kelas/{kelas}/pertemuan/{pertemuan}', [\App\Http\Controllers\Guru\PertemuanController::class, 'update'])->name('pertemuan.update');
        Route::delete('kelas/{kelas}/pertemuan/{pertemuan}', [\App\Http\Controllers\Guru\PertemuanController::class, 'destroy'])->name('pertemuan.destroy');
        
        // Student progress routes
        Route::get('kelas/{kelas}/siswa/{siswa}/progress', [\App\Http\Controllers\Guru\PertemuanController::class, 'studentProgress'])->name('siswa.progress');
    });

    // Siswa routes
    Route::middleware('siswa')->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('dashboard');
        Route::get('/kelas/{kelas}', [SiswaController::class, 'showClass'])->name('kelas.show');
        Route::get('/materi/{materi}', [SiswaController::class, 'showMateri'])->name('materi.show');
        Route::get('/materi/{materi}/download', [MateriController::class, 'download'])->name('materi.download');
        Route::post('/materi/{materi}/complete', [SiswaController::class, 'completeMateri'])->name('materi.complete');
        Route::post('/materi/{materi}/absen', [SiswaController::class, 'submitAbsen'])->name('materi.absen');
        Route::get('/progress', [SiswaController::class, 'progress'])->name('progress');
        
        // PDF Progress routes
        Route::post('/materi/{materi}/progress', [MateriProgressController::class, 'updateProgress'])->name('materi.progress.update');
        Route::get('/materi/{materi}/progress', [MateriProgressController::class, 'getProgress'])->name('materi.progress.get');
        Route::post('/materi/{materi}/mark-completed', [MateriProgressController::class, 'markCompleted'])->name('materi.mark-completed');
    });
});

// Helper route to check upload configuration (remove in production)
Route::get('/check-php-config', function () {
    if (!app()->environment('local')) {
        abort(404);
    }
    
    return response()->json([
        'upload_max_filesize' => ini_get('upload_max_filesize'),
        'post_max_size' => ini_get('post_max_size'),
        'max_execution_time' => ini_get('max_execution_time'),
        'max_input_time' => ini_get('max_input_time'),
        'memory_limit' => ini_get('memory_limit'),
        'php_version' => phpversion(),
        'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
        'php_sapi' => php_sapi_name(),
    ]);
})->name('check.php.config');

// Helper route to check Google OAuth configuration (remove in production)
Route::get('/check-google-oauth', function () {
    if (!app()->environment('local')) {
        abort(404);
    }
    
    $clientId = config('services.google.client_id');
    $clientSecret = config('services.google.client_secret');
    $redirectUri = config('services.google.redirect');
    
    return response()->json([
        'google_oauth_configured' => !empty($clientId) && !empty($clientSecret),
        'client_id_set' => !empty($clientId),
        'client_secret_set' => !empty($clientSecret),
        'redirect_uri' => $redirectUri,
        'app_url' => env('APP_URL'),
        'note' => 'Pastikan GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET sudah di-set di .env file',
    ]);
})->name('check.google.oauth');

require __DIR__.'/auth.php';

Route::get('/admin/backup/debug-list-files', [App\Http\Controllers\Admin\BackupController::class, 'debugListFiles']);

// Alias untuk kompatibilitas link sidebar lama: arahkan ke halaman pilih kelas pertemuan
