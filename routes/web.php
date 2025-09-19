<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MateriController;

Route::get('/', function () {
    return view('welcome');
});

// Role-based dashboard routing
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isGuru()) {
        return redirect()->route('guru.dashboard');
    } elseif ($user->isSiswa()) {
        return redirect()->route('siswa.dashboard');
    }
    
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Admin routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            $stats = [
                'total_guru' => \App\Models\User::where('role', 'guru')->count(),
                'total_siswa' => \App\Models\User::where('role', 'siswa')->count(),
                'total_kelas' => \App\Models\Kelas::count(),
                'pending_materi' => \App\Models\Materi::where('status', 'pending')->count(),
            ];
            return view('admin.dashboard', compact('stats'));
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
    });

    // Guru routes
    Route::middleware('guru')->prefix('guru')->name('guru.')->group(function () {
        Route::get('/dashboard', function () {
            $user = auth()->user();
            $materi_count = \App\Models\Materi::where('uploaded_by', $user->id)->count();
            $pending_count = \App\Models\Materi::where('uploaded_by', $user->id)->where('status', 'pending')->count();
            $approved_count = \App\Models\Materi::where('uploaded_by', $user->id)->where('status', 'approved')->count();
            
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
