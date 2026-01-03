<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Models\Kelas;
use App\Models\Pertemuan;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Scoped route model binding to ensure pertemuan belongs to kelas
        Route::bind('pertemuan', function ($value, $route) {
            $kelasId = $route->parameter('kelas');
            
            if ($kelasId instanceof Kelas) {
                $kelasId = $kelasId->id;
            }
            
            if ($kelasId) {
                return Pertemuan::where('id', $value)
                    ->where('kelas_id', $kelasId)
                    ->firstOrFail();
            }
            
            return Pertemuan::findOrFail($value);
        });
    }
}
