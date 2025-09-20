<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MateriController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

// Quick login routes for development
Route::get('/login-admin', function () {
    if (app()->environment('local')) {
        Auth::login(User::where('email', 'admin@example.com')->firstOrFail());
        return redirect('/dashboard');
    }
    return redirect('/login');
});

Route::get('/login-guru', function () {
    if (app()->environment('local')) {
        Auth::login(User::where('email', 'guru@example.com')->firstOrFail());
        return redirect('/dashboard');
    }
    return redirect('/login');
});

Route::get('/login-siswa', function () {
    if (app()->environment('local')) {
        Auth::login(User::where('email', 'siswa@example.com')->firstOrFail());
        return redirect('/dashboard');
    }
    return redirect('/login');
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

            return view('admin.dashboard', compact('stats', 'pending_verifications'));
        })->name('dashboard');
        
        Route::resource('users', UserController::class);
        
        Route::resource('kelas', KelasController::class);
        
        // Additional class routes
        Route::get('kelas/{kelas}/enroll', [KelasController::class, 'enrollForm'])->name('kelas.enroll');
        Route::post('kelas/{kelas}/enroll', [KelasController::class, 'enroll'])->name('kelas.enroll.store');
        
        // Material verification routes
        Route::get('materi', [MateriController::class, 'index'])->name('materi.index');
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
            $assignedKelasIds = $user->enrolledClasses->pluck('id')->toArray(); // Get IDs of assigned classes

            $materi_count = \App\Models\Materi::whereIn('kelas_id', $assignedKelasIds)->where('uploaded_by', $user->id)->count();
            $pending_count = \App\Models\Materi::whereIn('kelas_id', $assignedKelasIds)->where('uploaded_by', $user->id)->where('status', 'pending')->count();
            $approved_count = \App\Models\Materi::whereIn('kelas_id', $assignedKelasIds)->where('uploaded_by', $user->id)->where('status', 'approved')->count();
            
            $stats = [
                'total_materi' => $materi_count,
                'pending_materi' => $pending_count,
                'approved_materi' => $approved_count,
            ];
            return view('guru.dashboard', compact('stats'));
        })->name('dashboard');
        
        Route::resource('materi', MateriController::class);
    });

    // Siswa routes
    Route::middleware('siswa')->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('dashboard');
        Route::get('/kelas/{kelas}', [SiswaController::class, 'showClass'])->name('kelas.show');
        Route::get('/materi/{materi}', [SiswaController::class, 'showMateri'])->name('materi.show');
        Route::post('/materi/{materi}/complete', [SiswaController::class, 'completeMateri'])->name('materi.complete');
        Route::get('/progress', [SiswaController::class, 'progress'])->name('progress');
    });
});

require __DIR__.'/auth.php';
