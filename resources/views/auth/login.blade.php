@extends('layouts.landing-layout')

@section('title', 'Login - Coding Academy Payakumbuh')

@php
    $turnstileEnabled = config('services.turnstile.enabled') && config('services.turnstile.site_key');
@endphp

@section('body-class', 'login-page')

@section('styles')
<style>
    /* Fix: Hide footer on login page */
    .login-page ~ footer,
    body.login-page footer {
        display: none !important;
    }

    /* Allow scrolling */
    html, body {
        overflow: auto !important;
        height: auto !important;
    }

    .login-page {
        background: linear-gradient(135deg, #080d1a 0%, #111827 25%, #1e3a8a 50%, #312e81 75%, #4c1d95 100%);
        background-size: 400% 400%;
        animation: gradientShift 20s ease infinite;
        position: relative;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        overflow-x: hidden;
    }

    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .login-page::before {
        content: '';
        position: fixed;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.05) 0%, transparent 70%);
        animation: pulse 15s ease-in-out infinite;
        pointer-events: none;
        z-index: 0;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.4; }
        50% { transform: scale(1.1); opacity: 0.6; }
    }

    .login-page nav {
        padding-top: 1rem;
        padding-bottom: 1rem;
        flex-shrink: 0;
        position: relative;
        z-index: 10;
    }

    /* Main content area */
    .login-page main {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
        min-height: 0;
        position: relative;
        z-index: 10;
    }

    .login-card {
        backdrop-filter: blur(20px);
        background: rgba(255, 255, 255, 0.15);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3), 0 2px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 28rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .input-field {
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.95) !important;
    }

    .input-field:focus {
        border-color: #667eea !important;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
        background: rgba(255, 255, 255, 1) !important;
    }

    .input-icon {
        transition: all 0.3s ease;
    }

    .input-field:focus ~ .input-icon-wrapper .input-icon {
        color: #667eea;
        transform: scale(1.1);
    }

    .toggle-password {
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .toggle-password:hover {
        color: #5568d3;
    }

    .toggle-password svg {
        width: 1.25rem;
        height: 1.25rem;
    }

    /* ===== MOBILE RESPONSIVE STYLES ===== */
    @media (max-width: 768px) {
        /* Hide navbar on mobile for cleaner login */
        .login-page nav,
        .login-page header,
        .login-page + footer,
        .login-page ~ footer {
            display: none !important;
        }

        .login-page {
            padding: 0;
            min-height: 100vh;
        }

        .login-page main {
            padding: 2rem 1rem;
            align-items: flex-start;
            padding-top: 3rem;
            padding-bottom: 3rem;
        }

        .login-card {
            border-radius: 1.25rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
            margin: 0 auto;
        }

        /* Smaller icon on mobile */
        .login-card .header-icon {
            width: 3rem;
            height: 3rem;
        }

        .login-card .header-icon svg {
            width: 1.5rem;
            height: 1.5rem;
        }
    }

    /* Extra small devices */
    @media (max-width: 380px) {
        .login-page main {
            padding: 1.5rem 0.75rem;
            padding-top: 2rem;
        }

        .login-card {
            border-radius: 1rem;
        }
    }

    /* Landscape mobile - no special handling needed, let it scroll */
    @media (max-height: 600px) and (orientation: landscape) {
        .login-page main {
            align-items: flex-start;
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
    }
</style>
<script>
    // Add class to html element for login page specific styles
    document.documentElement.classList.add('login-page-html');
</script>
@endsection 

@section('content')
<div class="relative flex items-center justify-center px-4 py-8 sm:px-6 lg:px-8" style="position: relative; z-index: 10;">
    <!-- Alert Messages -->
    @if (session('error'))
        <div class="fixed top-4 left-1/2 z-50 -translate-x-1/2 transform">
            <div class="rounded-lg bg-red-100 border border-red-400 text-red-700 px-4 py-3 shadow-lg max-w-md">
                <div class="flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        </div>
    @endif

    @if (session('info'))
        <div class="fixed top-4 left-1/2 z-50 -translate-x-1/2 transform">
            <div class="rounded-lg bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 shadow-lg max-w-md">
                <div class="flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ session('info') }}</span>
                </div>
            </div>
        </div>
    @endif

    <div class="relative w-full max-w-md" style="position: relative; z-index: 10;">
        <!-- Login Card -->
        <div class="login-card rounded-2xl p-8 sm:p-10">
            <!-- Header -->
            <div class="mb-8 text-center">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 shadow-lg">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white">Selamat Datang</h1>
                <p class="mt-2 text-sm text-gray-200">Masuk ke akun Anda untuk melanjutkan</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5" id="loginForm">
                @csrf
                
                <!-- Email / Phone Field -->
                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-white">Email atau Nomor Telepon</label>
                    <div class="relative">
                        <div class="input-icon-wrapper pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                            <svg class="input-icon h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            placeholder="nama@email.com atau 081234567890"
                            class="input-field block w-full rounded-xl border-2 border-gray-300 bg-white py-3.5 pl-12 pr-4 text-gray-900 placeholder-gray-400 
                            transition-all duration-300 focus:border-blue-500 focus:outline-none sm:text-sm" 
                            required 
                            autofocus 
                            autocomplete="username"
                        />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="mb-2 block text-sm font-medium text-white">Password</label>
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
                            class="input-field block w-full rounded-xl border-2 border-gray-300 bg-white py-3.5 pl-12 pr-12 text-gray-900 placeholder-gray-400 
                            transition-all duration-300 focus:border-blue-500 focus:outline-none sm:text-sm" 
                            required 
                        />
                        <button type="button" class="toggle-password absolute inset-y-0 right-0 px-3 text-blue-600 hover:text-blue-800 flex items-center" data-password-target="password">
                            <svg class="eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg class="eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input 
                        id="remember_me" 
                        name="remember" 
                        type="checkbox" 
                        class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                    >
                    <label for="remember_me" class="ml-2 block text-sm text-white">
                        Ingat saya
                    </label>
                </div>

                <!-- Cloudflare Turnstile Widget -->
                @if ($turnstileEnabled)
                    <div class="flex justify-center" id="cloudflare-widget"></div>
                @endif

                <!-- Submit Button -->
                <div>
                    <button 
                        type="submit" 
                        id="submitBtn"
                        class="group relative w-full overflow-hidden rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 py-3.5 px-4 
                        text-sm font-semibold text-white shadow-lg shadow-blue-500/50 transition-all duration-300 
                        hover:from-blue-700 hover:to-purple-700 hover:shadow-xl hover:shadow-blue-500/50 
                        focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 
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

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-white/30"></div>
                </div>
                <div class="relative flex justify-center text-xs">
                    <span class="bg-transparent px-3 text-gray-200 font-medium">atau</span>
                </div>
            </div>

            <!-- Google Login Button -->
            <div>
                <a href="{{ route('auth.google') }}" 
                    class="group relative flex w-full items-center justify-center gap-3 rounded-xl border-2 border-gray-300 bg-white py-3.5 px-4 
                    text-sm font-semibold text-gray-700 shadow-sm transition-all duration-300 
                    hover:border-gray-400 hover:bg-gray-50 hover:shadow-md 
                    focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                >
                    <svg class="h-5 w-5" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    <span>Masuk dengan Google</span>
                </a>
                <p class="mt-2 text-center text-xs text-gray-500">
                    Login cepat tanpa password. Data lengkap dapat dilengkapi setelah login.
                </p>
            </div>

            <!-- Quick Login (Development Only) -->
            @if (app()->environment('local'))
            <div class="mt-4 border-t border-gray-200 pt-4">
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
            <div class="mt-6 text-center">
                <p class="text-xs text-gray-300">
                    © {{ date('Y') }} Coding Academy Payakumbuh. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</div>

@if ($turnstileEnabled)
    @section('scripts')
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const widgetContainer = document.getElementById('cloudflare-widget');
                const form = document.getElementById('loginForm');
                const submitBtn = document.getElementById('submitBtn');
                const siteKey = "{{ config('services.turnstile.site_key') }}";

                if (!widgetContainer || !window.turnstile) {
                    // Re-check until Turnstile script is ready
                    let retries = 0;
                    const interval = setInterval(() => {
                        if (window.turnstile && widgetContainer) {
                            clearInterval(interval);
                            renderWidget();
                        } else if (retries > 10) {
                            clearInterval(interval);
                            console.error('Turnstile gagal dimuat.');
                        }
                        retries++;
                    }, 300);
                } else {
                    renderWidget();
                }

                function renderWidget() {
                    if (!widgetContainer || widgetContainer.dataset.initialized === 'true') {
                        return;
                    }

                    widgetContainer.dataset.initialized = 'true';
                    if (submitBtn) {
                        submitBtn.disabled = true;
                    }

                    window.turnstile.render(widgetContainer, {
                        sitekey: siteKey,
                        theme: 'light',
                        callback: function () {
                            if (submitBtn) {
                                submitBtn.disabled = false;
                            }
                        },
                        'error-callback': function () {
                            if (submitBtn) {
                                submitBtn.disabled = true;
                            }
                        },
                        'expired-callback': function () {
                            if (submitBtn) {
                                submitBtn.disabled = true;
                            }
                        }
                    });
                }

                if (form) {
                    form.addEventListener('submit', function (e) {
                        const turnstileResponse = document.querySelector('[name="cf-turnstile-response"]');
                        if (!turnstileResponse || !turnstileResponse.value) {
                            e.preventDefault();
                            alert('Harap selesaikan verifikasi keamanan terlebih dahulu.');
                        }
                    });
                }
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const toggles = document.querySelectorAll('[data-password-target]');
                toggles.forEach(button => {
                    const targetId = button.getAttribute('data-password-target');
                    const input = document.getElementById(targetId);
                    if (!input) return;

                    const eyeOpen = button.querySelector('.eye-open');
                    const eyeClosed = button.querySelector('.eye-closed');

                    button.addEventListener('click', () => {
                        const isHidden = input.getAttribute('type') === 'password';
                        input.setAttribute('type', isHidden ? 'text' : 'password');
                        
                        if (isHidden) {
                            eyeOpen.classList.add('hidden');
                            eyeClosed.classList.remove('hidden');
                        } else {
                            eyeOpen.classList.remove('hidden');
                            eyeClosed.classList.add('hidden');
                        }
                    });
                });
            });
        </script>
    @endsection
@endif
@endsection
