<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MateriController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Rute khusus Admin
    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('kelas', KelasController::class);
    });

    // Rute khusus Guru
    Route::middleware('guru')->prefix('guru')->group(function () {
        Route::resource('materi', MateriController::class);
    });
});

require __DIR__.'/auth.php';
