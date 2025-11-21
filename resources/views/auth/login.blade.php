@extends('layouts.landing-layout')

@section('title', 'Login - Coding Academy Payakumbuh')

@section('body-class', 'login-page')

@section('styles')
<style>
    .login-page {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
    }

    .login-page::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: pulse 15s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 0.8; }
    }

    .login-page nav {
        padding-top: 1.5rem;
        padding-bottom: 1.5rem;
    }

    .login-card {
        backdrop-filter: blur(20px);
        background: rgba(255, 255, 255, 0.95);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    .input-field {
        transition: all 0.3s ease;
    }

    .input-field:focus {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.2);
    }

    .input-icon {
        transition: all 0.3s ease;
    }

    .input-field:focus + .input-icon-wrapper .input-icon {
        color: #667eea;
        transform: scale(1.1);
    }
</style>
@endsection 

@section('content')
<div class="relative flex min-h-screen items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
    <!-- Background decorative elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 h-80 w-80 rounded-full bg-white/10 blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 h-80 w-80 rounded-full bg-white/10 blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 h-96 w-96 -translate-x-1/2 -translate-y-1/2 rounded-full bg-white/5 blur-3xl"></div>
    </div>

    <div class="relative w-full max-w-md">
        <!-- Login Card -->
        <div class="login-card rounded-2xl p-8 sm:p-10">
            <!-- Header -->
            <div class="mb-8 text-center">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 shadow-lg">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900">Selamat Datang</h1>
                <p class="mt-2 text-sm text-gray-600">Masuk ke akun Anda untuk melanjutkan</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6" id="loginForm">
                @csrf
                
                <!-- Email Field -->
                <div>
                    <label for="email" class="mb-2 block text-sm font-semibold text-gray-700">Email</label>
                    <div class="relative">
                        <div class="input-icon-wrapper pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                            <svg class="input-icon h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </div>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            placeholder="nama@email.com"
                            class="input-field block w-full rounded-xl border border-gray-300 bg-white py-3 pl-12 pr-4 text-black placeholder-gray-400 
                            transition-all duration-300 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 sm:text-sm" 
                            required 
                            autofocus 
                        />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="mb-2 block text-sm font-semibold text-gray-700">Password</label>
                    <div class="relative">
                        <div class="input-icon-wrapper pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                            <svg class="input-icon h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Masukkan password Anda"
                            class="input-field block w-full rounded-xl border border-gray-300 bg-white py-3 pl-12 pr-4 text-black placeholder-gray-400 
                            transition-all duration-300 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 sm:text-sm" 
                            required 
                        />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input 
                            id="remember_me" 
                            name="remember" 
                            type="checkbox" 
                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        >
                        <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                            Ingat saya
                        </label>
                    </div>
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors">
                        Lupa password?
                    </a>
                    @endif
                </div>

                <!-- Cloudflare Turnstile Widget -->
                <div class="flex justify-center" id="cloudflare-widget">
                    <!-- Cloudflare Turnstile widget akan dimuat di sini -->
                    <!-- Pastikan untuk menambahkan script Cloudflare Turnstile di bagian head atau sebelum closing body tag -->
                </div>

                <!-- Submit Button -->
                <div>
                    <button 
                        type="submit" 
                        id="submitBtn"
                        class="group relative w-full overflow-hidden rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 py-3.5 px-4 
                        text-sm font-semibold text-white shadow-lg shadow-indigo-500/50 transition-all duration-300 
                        hover:from-indigo-700 hover:to-purple-700 hover:shadow-xl hover:shadow-indigo-500/50 
                        focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 
                        disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span class="relative z-10 flex items-center justify-center">
                            <span>Masuk</span>
                            <svg class="ml-2 h-5 w-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
                    </button>
                </div>
            </form>

            <!-- Quick Login (Development Only) -->
            @if (app()->environment('local'))
            <div class="mt-6 border-t border-gray-200 pt-6">
                <p class="mb-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500">Quick Login (Development Only)</p>
                <div class="grid grid-cols-3 gap-3">
                    <a href="{{ url('/quick-login/admin') }}" 
                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs font-medium text-gray-700 
                        transition-all hover:border-indigo-500 hover:bg-indigo-50 hover:text-indigo-600">
                        Admin
                    </a>
                    <a href="{{ url('/quick-login/guru') }}" 
                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs font-medium text-gray-700 
                        transition-all hover:border-indigo-500 hover:bg-indigo-50 hover:text-indigo-600">
                        Guru
                    </a>
                    <a href="{{ url('/quick-login/siswa') }}" 
                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs font-medium text-gray-700 
                        transition-all hover:border-indigo-500 hover:bg-indigo-50 hover:text-indigo-600">
                        Siswa
                    </a>
                </div>
            </div>
            @endif

            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-xs text-gray-500">
                    © {{ date('Y') }} Coding Academy Payakumbuh. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Cloudflare Turnstile Script -->
<!-- Uncomment dan isi dengan Site Key Anda saat siap menggunakan Cloudflare Turnstile -->
{{-- 
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
<script>
    window.addEventListener('DOMContentLoaded', function() {
        const widgetContainer = document.getElementById('cloudflare-widget');
        const form = document.getElementById('loginForm');
        const submitBtn = document.getElementById('submitBtn');
        
        // Render Cloudflare Turnstile widget
        turnstile.render(widgetContainer, {
            sitekey: 'YOUR_SITE_KEY_HERE', // Ganti dengan Site Key dari Cloudflare
            theme: 'light',
            size: 'normal',
            callback: function(token) {
                // Widget berhasil divalidasi
                submitBtn.disabled = false;
            },
            'error-callback': function() {
                // Error saat validasi
                submitBtn.disabled = true;
            }
        });

        // Disable submit button sampai Turnstile divalidasi
        submitBtn.disabled = true;
        
        // Validasi form sebelum submit
        form.addEventListener('submit', function(e) {
            const turnstileResponse = document.querySelector('[name="cf-turnstile-response"]');
            if (!turnstileResponse || !turnstileResponse.value) {
                e.preventDefault();
                alert('Harap selesaikan verifikasi keamanan terlebih dahulu.');
                return false;
            }
        });
    });
</script>
--}}

@endsection
