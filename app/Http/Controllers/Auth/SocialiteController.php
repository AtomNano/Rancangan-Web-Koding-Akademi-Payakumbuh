<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Get HTTP client configuration for Socialite
     * Handles SSL certificate verification issues (especially on Windows)
     */
    private function getHttpClient()
    {
        // Untuk production, selalu verify SSL
        if (app()->environment('production')) {
            return new Client(['verify' => true]);
        }
        
        // Untuk development, cek environment variable
        $verifySSL = env('CURL_VERIFY_SSL', 'true');
        
        // Jika CURL_VERIFY_SSL = false, disable SSL verification (hanya untuk development)
        if ($verifySSL === 'false' || $verifySSL === false) {
            \Log::warning('SSL verification disabled for Google OAuth (development only)');
            return new Client(['verify' => false]);
        }
        
        // Coba gunakan CA bundle jika ada
        $caBundle = storage_path('cacert.pem');
        if (file_exists($caBundle)) {
            return new Client(['verify' => $caBundle]);
        }
        
        // Default: verify SSL
        return new Client(['verify' => true]);
    }

    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        try {
            // Cek apakah Google OAuth credentials sudah di-setup
            if (empty(config('services.google.client_id')) || empty(config('services.google.client_secret'))) {
                \Log::error('Google OAuth credentials not configured', [
                    'client_id' => !empty(config('services.google.client_id')),
                    'client_secret' => !empty(config('services.google.client_secret')),
                ]);
                
                return redirect()->route('login')
                    ->with('error', 'Login dengan Google belum dikonfigurasi. Silakan hubungi administrator atau gunakan login manual.');
            }
            
            return Socialite::driver('google')
                ->setHttpClient($this->getHttpClient())
                ->redirect();
        } catch (\Exception $e) {
            \Log::error('Error redirecting to Google OAuth', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->route('login')
                ->with('error', 'Terjadi kesalahan saat mengarahkan ke Google. Silakan coba lagi atau gunakan login manual.');
        }
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')
                ->setHttpClient($this->getHttpClient())
                ->user();
            
            // Validasi data dari Google
            if (empty($googleUser->getEmail())) {
                \Log::error('Google OAuth returned user without email');
                return redirect()->route('login')
                    ->with('error', 'Google tidak mengembalikan email. Pastikan Anda memberikan izin akses email.');
            }
            
            // Cek apakah user sudah ada berdasarkan email
            $user = User::where('email', $googleUser->getEmail())->first();
            
            if ($user) {
                // User sudah ada, langsung login
                // Cek apakah user aktif (untuk siswa)
                if ($user->role === 'siswa' && !$user->is_active) {
                    return redirect()->route('login')
                        ->with('error', 'Akun Anda tidak aktif. Silakan hubungi admin untuk mengaktifkan kembali.');
                }
                
                Auth::login($user, true);
                
                // Redirect berdasarkan role
                return $this->redirectToDashboard($user);
            } else {
                // User belum terdaftar - jangan buat otomatis, minta admin daftarkan
                return redirect()->route('login')
                    ->with('error', 'Akun Google Anda belum terdaftar. Silakan hubungi admin untuk ditambahkan sebagai siswa sebelum menggunakan login Google.');
            }
        } catch (\Exception $e) {
            } else {
                // User belum terdaftar - jangan buat otomatis, minta admin daftarkan
                return redirect()->route('login')
                    ->with('error', 'Akun Google Anda belum terdaftar. Silakan hubungi admin untuk ditambahkan sebagai siswa sebelum menggunakan login Google.');
            }
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            \Log::error('Google OAuth InvalidStateException', [
                'error' => $e->getMessage(),
            ]);
            
            return redirect()->route('login')
                ->with('error', 'Sesi login dengan Google telah berakhir. Silakan coba lagi.');
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            \Log::error('Google OAuth HTTP Client Exception', [
                'error' => $e->getMessage(),
                'response' => $e->getResponse() ? $e->getResponse()->getBody()->getContents() : null,
            ]);
            
            return redirect()->route('login')
                ->with('error', 'Terjadi kesalahan saat berkomunikasi dengan Google. Pastikan credentials OAuth sudah benar.');
        } catch (\Exception $e) {
            \Log::error('Google OAuth callback error', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            // Jika di development, tampilkan error detail
            if (app()->environment('local')) {
                return redirect()->route('login')
                    ->with('error', 'Terjadi kesalahan: ' . $e->getMessage() . '. Silakan cek log untuk detail lebih lanjut.');
            }
            
            return redirect()->route('login')
                ->with('error', 'Terjadi kesalahan saat login dengan Google. Silakan coba lagi atau gunakan login manual.');
        }
    }

    /**
     * Redirect to dashboard based on user role
     */
    private function redirectToDashboard($user)
    {
        return match($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'guru' => redirect()->route('guru.dashboard'),
            'siswa' => redirect()->route('siswa.dashboard'),
            default => redirect()->route('dashboard'),
        };
    }
}
