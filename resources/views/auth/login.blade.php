@extends('layouts.landing-layout')

 @section('title', 'Login & Registrasi - Materi Online')

 @section('body-class', 'login-page')

 @section('styles')
    <style>
        /* Memberikan background gradien yang lembut pada seluruh halaman */
        .login-page {
            background: linear-gradient(to right, #f2f2f2, #e6e6e6);
        }

        .login-page nav {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        

        .form-container {
            position: absolute;
            top: 0;
            height: 100%;
            transition: all 0.6s ease-in-out;
        }

        .sign-in-container {
            left: 0;
            width: 50%;
            z-index: 2;
        }

        .container.right-panel-active .sign-in-container {
            transform: translateX(100%);
            opacity: 0;
        }

        .sign-up-container {
            left: 0;
            width: 50%;
            opacity: 0;
            z-index: 1;
        }

        .container.right-panel-active .sign-up-container {
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
            animation: show 0.6s;
        }

        @keyframes show {
            0%, 49.99% {
                opacity: 0;
                z-index: 1;
            }
            50%, 100% {
                opacity: 1;
                z-index: 5;
            }
        }

        .overlay-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: transform 0.6s ease-in-out;
            z-index: 40;
        }

        .container.right-panel-active .overlay-container{
            transform: translateX(-100%);
        }

        .overlay {
            background: #6D28D9;
            background: linear-gradient(to right, #8B5CF6, #6D28D9);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: 0 0;
            color: #FFFFFF;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }

        .container.right-panel-active .overlay {
            transform: translateX(50%);
        }

        .overlay-panel {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 40px;
            text-align: center;
            top: 0;
            height: 100%;
            width: 50%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }

        .overlay-left {
            transform: translateX(-20%);
        }

        .container.right-panel-active .overlay-left {
            transform: translateX(0);
        }

        .overlay-right {
            right: 0;
            transform: translateX(0);
        }

        .container.right-panel-active .overlay-right {
            transform: translateX(20%);
        }

        .ghost {
            background-color: transparent;
            border-color: #FFFFFF;
        }
    </style>
 @endsection @section('content')
    <div class="flex justify-center items-center min-h-screen px-4 sm:px-6 lg:px-8 py-12">
        {{--
            [PERBAIKAN KUNCI]
            Mengecek apakah ada error validasi yang spesifik untuk form registrasi.
            Jika ada (misalnya error pada field 'name' atau 'password_confirmation'),
            maka class 'right-panel-active' akan ditambahkan saat halaman dimuat ulang,
            sehingga pengguna tetap berada di panel registrasi.
        --}}
        <div class="container relative w-full max-w-4xl rounded-2xl shadow-2xl overflow-hidden {{ $errors->has('name') || $errors->has('password_confirmation') ? 'right-panel-active' : '' }}" id="container" style="min-height: 340px;">
            <!-- Form Registrasi -->
            <div class="form-container sign-up-container">
                <form method="POST" action="{{ route('register') }}" class="bg-white flex items-center justify-center flex-col px-12 h-full text-center">
                    @csrf
                    <h1 class="font-bold text-3xl mb-4">Buat Akun Baru</h1>
                    <div class="w-full mb-3">
                        <label for="name" class="sr-only">Nama Lengkap</label>
                        <input type="text" id="name" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" class="bg-gray-100 border border-gray-200 w-full p-3 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-left" />
                    </div>
                    <div class="w-full mb-3">
                        <label for="email-register" class="sr-only">Email</label>
                        <input type="email" id="email-register" name="email" placeholder="Email" value="{{ old('email') }}" class="bg-gray-100 border border-gray-200 w-full p-3 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required autocomplete="email" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-left" />
                    </div>
                    <div class="w-full mb-3">
                        <label for="password-register" class="sr-only">Password</label>
                        <input type="password" id="password-register" name="password" placeholder="Password" class="bg-gray-100 border border-gray-200 w-full p-3 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-left" />
                    </div>
                    <div class="w-full mb-4">
                        <label for="password_confirmation" class="sr-only">Ulangi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi Password" class="bg-gray-100 border border-gray-200 w-full p-3 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required autocomplete="new-password" />
                         <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-left" />
                    </div>
                    <button type="submit" class="rounded-full bg-indigo-600 text-white text-sm font-bold py-3 px-12 uppercase tracking-wider transform transition-transform duration-75 hover:scale-105">Register</button>
                </form>
            </div>

            <!-- Form Login -->
            <div class="form-container sign-in-container">
                <form method="POST" action="{{ route('login') }}" class="bg-white flex items-center justify-center flex-col px-12 h-full text-center">
                    @csrf
                    <h1 class="font-bold text-3xl mb-4">Login ke Akun Anda</h1>
                    <div class="w-full mb-3">
                        <label for="email-login" class="sr-only">Email</label>
                        <input type="email" id="email-login" name="email" placeholder="Email" value="{{ old('email') }}" class="bg-gray-100 border border-gray-200 w-full p-3 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required autofocus autocomplete="email" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-left" />
                    </div>
                    <div class="w-full mb-4">
                        <label for="password-login" class="sr-only">Password</label>
                        <input type="password" id="password-login" name="password" placeholder="Password" class="bg-gray-100 border border-gray-200 w-full p-3 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-left" />
                    </div>
                    <div class="flex justify-between items-center w-full text-sm mb-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                            <span class="ml-2 text-gray-600">Ingat saya</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-gray-500 hover:text-indigo-600">Lupa password?</a>
                        @endif
                    </div>
                    <button type="submit" class="rounded-full bg-indigo-600 text-white text-sm font-bold py-3 px-12 uppercase tracking-wider transform transition-transform duration-75 hover:scale-105">Login</button>
                </form>
            </div>

            <!-- Overlay / Tampilan Geser -->
            <div class="overlay-container">
                <div class="overlay">
                    <!-- Overlay untuk panel Register (Kiri) -->
                    <div class="overlay-panel overlay-left">
                        <h1 class="font-bold text-3xl">Selamat Datang Kembali!</h1>
                        <p class="text-sm font-light mt-2 mb-6 px-8">Untuk tetap terhubung dengan kami, silakan login dengan akun yang sudah Anda miliki</p>
                        <button class="ghost rounded-full border border-white text-white text-sm font-bold py-3 px-12 uppercase tracking-wider transform transition-transform duration-75 hover:scale-105" id="signIn">Login</button>
                    </div>
                    <!-- Overlay untuk panel Login (Kanan) -->
                    <div class="overlay-panel overlay-right">
                        <h1 class="font-bold text-3xl">Halo, Pengguna Baru!</h1>
                        <p class="text-sm font-light mt-2 mb-6 px-8">Masukkan data diri Anda dan mulailah perjalanan belajar bersama kami</p>
                        <button class="ghost rounded-full border border-white text-white text-sm font-bold py-3 px-12 uppercase tracking-wider transform transition-transform duration-75 hover:scale-105" id="signUp">Register</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
 @endsection @section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const signUpButton = document.getElementById('signUp');
            const signInButton = document.getElementById('signIn');
            const container = document.getElementById('container');

            if(signUpButton) {
                signUpButton.addEventListener('click', () => {
                    container.classList.add("right-panel-active");
                });
            }

            if(signInButton) {
                signInButton.addEventListener('click', () => {
                    container.classList.remove("right-panel-active");
                });
            }
        });
    </script>
 @endsection
