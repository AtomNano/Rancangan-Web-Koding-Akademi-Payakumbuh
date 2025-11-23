<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\MateriProgressController;
use App\Http\Controllers\GuruKelasController;
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
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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
        
        Route::resource('kelas', KelasController::class)->parameters([
            'kelas' => 'kelas',
        ]);
        
        // Additional class routes
        Route::get('kelas/{kelas}/enroll', [KelasController::class, 'enrollForm'])->name('kelas.enroll');
        Route::post('kelas/{kelas}/enroll', [KelasController::class, 'enroll'])->name('kelas.enroll.store');
        Route::delete('kelas/{kelas}/enroll/{user}', [KelasController::class, 'unenroll'])->name('kelas.unenroll');
        
        // Material verification routes
        Route::get('materi', [MateriController::class, 'index'])->name('materi.index');
        Route::get('materi/{materi}', [MateriController::class, 'show'])->name('materi.show');
        Route::get('materi/{materi}/download', [MateriController::class, 'download'])->name('materi.download');
        Route::post('materi/{materi}/approve', [MateriController::class, 'approve'])->name('materi.approve');
        Route::post('materi/{materi}/reject', [MateriController::class, 'reject'])->name('materi.reject');

        // Backup Routes
        Route::get('backup', [\App\Http\Controllers\Admin\BackupController::class, 'index'])->name('backup.index');
        Route::get('backup/create', [\App\Http\Controllers\Admin\BackupController::class, 'create'])->name('backup.create');
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

require __DIR__.'/auth.php';
