@extends('layouts.landing-layout')

@section('title', 'Masuk - Materi Online')

@section('body-class', 'login-page')

@section('styles')
<style>
    .login-page {
        background: linear-gradient(to right, #f2f2f2, #e6e6e6);
    }

    .login-page nav {
        padding-top: 1.5rem;
        padding-bottom: 1.5rem;
    }
</style>
@endsection 

@section('content')
<div class="flex justify-center items-center min-h-screen px-4 sm:px-6 lg:px-8 py-12">
    <div class="w-full max-w-md">
        <div class="bg-white shadow-2xl rounded-lg p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Masuk ke Akun Anda</h1>
                <p class="mt-2 text-sm text-gray-600">Silakan masuk menggunakan akun yang telah dibuat oleh admin</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Surel</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" 
                        class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 
                        focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                        required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                    <input type="password" id="password" name="password" 
                        class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 
                        focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                        required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" 
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                            Ingat saya
                        </label>
                    </div>
                </div>

                <div>
                    <button type="submit" 
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium 
                        text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Masuk
                    </button>
                </div>
                
                @if (app()->environment('local'))
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <p class="text-sm text-gray-500 text-center mb-3">Masuk Cepat (Hanya untuk Pengembangan)</p>
                    <div class="grid grid-cols-3 gap-3">
                        <a href="{{ url('/quick-login/admin') }}" class="col-span-1 inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-indigo-500 transition-all">Admin</a>
                        <a href="{{ url('/quick-login/guru') }}" class="col-span-1 inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-indigo-500 transition-all">Guru</a>
                        <a href="{{ url('/quick-login/siswa') }}" class="col-span-1 inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-indigo-500 transition-all">Siswa</a>
                    </div>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
