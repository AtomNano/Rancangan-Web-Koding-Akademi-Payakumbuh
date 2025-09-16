<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materi Online - Platform E-Learning</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .gradient-bg {
            background-image: linear-gradient(to right, #6D28D9, #8B5CF6);
        }
        .hero-bg {
            background-image: url('https://placehold.co/1920x1080/000000/FFFFFF?text=Suasana+Belajar');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Header / Navigasi -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                 <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-lg">M</div>
                 <span class="text-xl font-bold text-gray-800">Materi Online</span>
            </div>
            <div class="hidden md:flex items-center space-x-8">
                <a href="#fitur" class="text-gray-600 hover:text-indigo-600">Fitur</a>
                <a href="#kelas" class="text-gray-600 hover:text-indigo-600">Kelas</a>
                <a href="#alur" class="text-gray-600 hover:text-indigo-600">Alur Kerja</a>
                <a href="#kontak" class="text-gray-600 hover:text-indigo-600">Kontak</a>
            </div>
            <a href="/login" class="hidden md:block bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-300">
                Masuk
            </a>
            <button id="mobile-menu-button" class="md:hidden text-gray-700 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
            </button>
        </nav>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden px-6 pb-4">
            <a href="#fitur" class="block py-2 text-gray-600 hover:text-indigo-600">Fitur</a>
            <a href="#kelas" class="block py-2 text-gray-600 hover:text-indigo-600">Kelas</a>
            <a href="#alur" class="block py-2 text-gray-600 hover:text-indigo-600">Alur Kerja</a>
            <a href="#kontak" class="block py-2 text-gray-600 hover:text-indigo-600">Kontak</a>
             <a href="/login" class="block w-full text-center mt-2 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-300">
                Masuk
            </a>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="hero-bg relative text-white">
            <div class="absolute inset-0 bg-black bg-opacity-60"></div>
            <div class="container mx-auto px-6 py-24 md:py-32 relative z-10 text-center">
                <h1 class="text-4xl md:text-6xl font-extrabold leading-tight">Platform E-Learning <br class="hidden md:block"> <span class="text-yellow-300">Materi Online</span></h1>
                <p class="mt-4 text-lg md:text-xl max-w-3xl mx-auto text-gray-200">Sistem pembelajaran digital yang mendukung Admin, Guru, dan Siswa dengan manajemen kelas, materi pembelajaran, dan pemantauan progres yang terintegrasi.</p>
                <div class="mt-10 flex flex-col md:flex-row justify-center items-center gap-4">
                    <a href="/login-admin" class="w-full md:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-lg transition duration-300 transform hover:scale-105">Login sebagai Admin</a>
                    <a href="/login-guru" class="w-full md:w-auto bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-lg transition duration-300 transform hover:scale-105">Login sebagai Guru</a>
                    <a href="/login-siswa" class="w-full md:w-auto bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-8 rounded-lg transition duration-300 transform hover:scale-105">Login sebagai Siswa</a>
                </div>
            </div>
        </section>

        <!-- Fitur Utama Platform -->
        <section id="fitur" class="py-20 bg-white">
            <div class="container mx-auto px-6 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Fitur Utama Platform</h2>
                <p class="mt-2 text-gray-600 max-w-2xl mx-auto">Sistem yang dirancang khusus untuk mendukung proses pembelajaran digital yang efektif</p>
                <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Panel Admin -->
                    <div class="bg-indigo-50 border-2 border-indigo-100 p-8 rounded-xl shadow-lg transform hover:-translate-y-2 transition-transform duration-300">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-200 text-indigo-600 rounded-lg mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Panel Admin</h3>
                        <ul class="mt-4 text-left space-y-2 text-gray-600">
                            <li class="flex items-start"><svg class="w-5 h-5 text-indigo-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>Manajemen pengguna (Guru & Siswa)</li>
                            <li class="flex items-start"><svg class="w-5 h-5 text-indigo-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>Manajemen kelas dan pendaftaran</li>
                            <li class="flex items-start"><svg class="w-5 h-5 text-indigo-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>Verifikasi materi pembelajaran</li>
                            <li class="flex items-start"><svg class="w-5 h-5 text-indigo-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>Backup data berkala</li>
                        </ul>
                    </div>
                    <!-- Panel Guru -->
                    <div class="bg-green-50 border-2 border-green-100 p-8 rounded-xl shadow-lg transform hover:-translate-y-2 transition-transform duration-300">
                         <div class="inline-flex items-center justify-center w-16 h-16 bg-green-200 text-green-600 rounded-lg mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Panel Guru</h3>
                        <ul class="mt-4 text-left space-y-2 text-gray-600">
                           <li class="flex items-start"><svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>Upload materi pembelajaran</li>
                           <li class="flex items-start"><svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>Modul, video, dan tugas</li>
                           <li class="flex items-start"><svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>Pemantauan progres siswa</li>
                           <li class="flex items-start"><svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>Visualisasi data pembelajaran</li>
                        </ul>
                    </div>
                    <!-- Panel Siswa -->
                    <div class="bg-orange-50 border-2 border-orange-100 p-8 rounded-xl shadow-lg transform hover:-translate-y-2 transition-transform duration-300">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-orange-200 text-orange-600 rounded-lg mb-4">
                           <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Panel Siswa</h3>
                         <ul class="mt-4 text-left space-y-2 text-gray-600">
                           <li class="flex items-start"><svg class="w-5 h-5 text-orange-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>Akses kelas yang terdaftar</li>
                           <li class="flex items-start"><svg class="w-5 h-5 text-orange-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>Materi terverifikasi</li>
                           <li class="flex items-start"><svg class="w-5 h-5 text-orange-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>Progress bar pembelajaran</li>
                           <li class="flex items-start"><svg class="w-5 h-5 text-orange-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>Rekam jejak belajar</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Kelas yang Tersedia -->
        <section id="kelas" class="py-20 bg-gray-50">
            <div class="container mx-auto px-6 text-center">
                 <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Kelas yang Tersedia</h2>
                <p class="mt-2 text-gray-600">Target awal: 1 Admin, 5 Guru, dan 20 Siswa</p>
                <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Kelas Coding -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <img src="https://placehold.co/600x400/3B82F6/FFFFFF?text=Kelas+Coding" alt="Kelas Coding" class="w-full h-48 object-cover">
                        <div class="p-6 text-left">
                            <h3 class="text-xl font-bold text-gray-800">Kelas Coding</h3>
                            <p class="mt-2 text-gray-600">Pembelajaran pemrograman dan pengembangan software.</p>
                            <div class="mt-4 text-sm text-gray-500 flex items-center space-x-4">
                                <span><svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>2 Guru</span>
                                <span><svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>8 Siswa</span>
                            </div>
                        </div>
                    </div>
                     <!-- Kelas Desain -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <img src="https://placehold.co/600x400/10B981/FFFFFF?text=Kelas+Desain" alt="Kelas Desain" class="w-full h-48 object-cover">
                        <div class="p-6 text-left">
                            <h3 class="text-xl font-bold text-gray-800">Kelas Desain</h3>
                            <p class="mt-2 text-gray-600">Pembelajaran desain grafis dan multimedia.</p>
                             <div class="mt-4 text-sm text-gray-500 flex items-center space-x-4">
                                <span><svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>2 Guru</span>
                                <span><svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>8 Siswa</span>
                            </div>
                        </div>
                    </div>
                     <!-- Kelas Robotik -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <img src="https://placehold.co/600x400/EF4444/FFFFFF?text=Kelas+Robotik" alt="Kelas Robotik" class="w-full h-48 object-cover">
                        <div class="p-6 text-left">
                            <h3 class="text-xl font-bold text-gray-800">Kelas Robotik</h3>
                            <p class="mt-2 text-gray-600">Pembelajaran desain dan otomasi.</p>
                             <div class="mt-4 text-sm text-gray-500 flex items-center space-x-4">
                                <span><svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>1 Guru</span>
                                <span><svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>4 Siswa</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Alur Kerja Platform -->
        <section id="alur" class="py-20 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                     <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Alur Kerja Platform</h2>
                     <p class="mt-2 text-gray-600">Proses pembelajaran yang terstruktur dan terintegrasi</p>
                </div>
                <div class="max-w-3xl mx-auto">
                    <div class="relative">
                        <!-- Connecting line -->
                        <div class="hidden md:block absolute left-1/2 h-full w-0.5 bg-gray-200 transform -translate-x-1/2"></div>
                        
                        <!-- Item 1 -->
                        <div class="md:flex items-center w-full mb-8">
                            <div class="md:w-1/2 md:pr-8">
                                <div class="p-6 bg-white rounded-lg shadow-lg">
                                    <div class="flex items-center mb-2">
                                        <div class="w-10 h-10 flex items-center justify-center bg-blue-500 text-white rounded-full font-bold text-lg mr-4">1</div>
                                        <h3 class="text-lg font-bold text-gray-800">Pendaftaran Pengguna</h3>
                                    </div>
                                    <p class="text-gray-600">Admin mendaftarkan Guru dan Siswa, menempatkan siswa pada kelas tertentu.</p>
                                </div>
                            </div>
                            <div class="hidden md:block md:w-1/2 md:pl-8"></div>
                        </div>

                        <!-- Item 2 -->
                         <div class="md:flex flex-row-reverse items-center w-full mb-8">
                            <div class="md:w-1/2 md:pl-8">
                                <div class="p-6 bg-white rounded-lg shadow-lg">
                                    <div class="flex items-center mb-2">
                                        <div class="w-10 h-10 flex items-center justify-center bg-green-500 text-white rounded-full font-bold text-lg mr-4">2</div>
                                        <h3 class="text-lg font-bold text-gray-800">Upload Materi</h3>
                                    </div>
                                    <p class="text-gray-600">Guru mengunggah konten pembelajaran sesuai kelas yang diampu.</p>
                                </div>
                            </div>
                            <div class="hidden md:block md:w-1/2 md:pr-8"></div>
                        </div>

                        <!-- Item 3 -->
                        <div class="md:flex items-center w-full mb-8">
                            <div class="md:w-1/2 md:pr-8">
                                <div class="p-6 bg-white rounded-lg shadow-lg">
                                    <div class="flex items-center mb-2">
                                        <div class="w-10 h-10 flex items-center justify-center bg-yellow-500 text-white rounded-full font-bold text-lg mr-4">3</div>
                                        <h3 class="text-lg font-bold text-gray-800">Verifikasi Admin</h3>
                                    </div>
                                    <p class="text-gray-600">Admin memverifikasi materi agar layak digunakan dalam pembelajaran.</p>
                                </div>
                            </div>
                            <div class="hidden md:block md:w-1/2 md:pl-8"></div>
                        </div>

                        <!-- Item 4 -->
                         <div class="md:flex flex-row-reverse items-center w-full mb-8">
                            <div class="md:w-1/2 md:pl-8">
                                <div class="p-6 bg-white rounded-lg shadow-lg">
                                    <div class="flex items-center mb-2">
                                        <div class="w-10 h-10 flex items-center justify-center bg-orange-500 text-white rounded-full font-bold text-lg mr-4">4</div>
                                        <h3 class="text-lg font-bold text-gray-800">Akses Pembelajaran</h3>
                                    </div>
                                    <p class="text-gray-600">Siswa mengakses kelas, mempelajari materi, dan menyelesaikan unit pembelajaran.</p>
                                </div>
                            </div>
                             <div class="hidden md:block md:w-1/2 md:pr-8"></div>
                        </div>

                        <!-- Item 5 -->
                        <div class="md:flex items-center w-full">
                            <div class="md:w-1/2 md:pr-8">
                               <div class="p-6 bg-white rounded-lg shadow-lg">
                                    <div class="flex items-center mb-2">
                                        <div class="w-10 h-10 flex items-center justify-center bg-purple-500 text-white rounded-full font-bold text-lg mr-4">5</div>
                                        <h3 class="text-lg font-bold text-gray-800">Pemantauan Progres</h3>
                                    </div>
                                    <p class="text-gray-600">Sistem mencatat progres siswa. Guru memantau perkembangan melalui dashboard.</p>
                                </div>
                            </div>
                            <div class="hidden md:block md:w-1/2 md:pl-8"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section class="gradient-bg text-white">
            <div class="container mx-auto px-6 py-20 text-center">
                <h2 class="text-3xl md:text-4xl font-bold">Mulai Pembelajaran Digital Anda</h2>
                <p class="mt-4 text-lg text-indigo-200 max-w-3xl mx-auto">Platform pembelajaran yang aman, terstruktur, dan mendukung pemantauan perkembangan siswa secara efektif.</p>
                <div class="mt-8 flex flex-wrap justify-center gap-4">
                    <a href="/login-guru" class="bg-white text-indigo-600 font-bold py-3 px-8 rounded-lg hover:bg-gray-100 transition duration-300">Masuk ke Dashboard Guru</a>
                    <a href="#kelas" class="border-2 border-white text-white font-bold py-3 px-8 rounded-lg hover:bg-white hover:text-indigo-600 transition duration-300">Pelajari Lebih Lanjut</a>
                </div>
            </div>
        </section>

    </main>
    
    <!-- Footer -->
    <footer id="kontak" class="bg-gray-800 text-white">
        <div class="container mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div>
                 <div class="flex items-center space-x-2 mb-4">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center font-bold text-lg">M</div>
                    <span class="text-xl font-bold">Materi Online</span>
                </div>
                <p class="text-gray-400">Platform e-learning untuk Admin, Guru, dan Siswa dengan sistem manajemen terintegrasi.</p>
            </div>
            <div>
                <h4 class="font-bold text-lg mb-4">Platform</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="#" class="hover:text-white">Panel Admin</a></li>
                    <li><a href="#" class="hover:text-white">Panel Guru</a></li>
                    <li><a href="#" class="hover:text-white">Panel Siswa</a></li>
                </ul>
            </div>
             <div>
                <h4 class="font-bold text-lg mb-4">Kelas</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="#" class="hover:text-white">Coding</a></li>
                    <li><a href="#" class="hover:text-white">Desain</a></li>
                    <li><a href="#" class="hover:text-white">Robotik</a></li>
                </ul>
            </div>
             <div>
                <h4 class="font-bold text-lg mb-4">Bantuan</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="#" class="hover:text-white">Panduan</a></li>
                    <li><a href="#" class="hover:text-white">Kontak</a></li>
                    <li><a href="#" class="hover:text-white">Support</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-700">
            <div class="container mx-auto px-6 py-4 text-center text-gray-500">
                &copy; 2025 Materi Online. Semua hak dilindungi.
            </div>
        </div>
    </footer>

    <script>
        // Script untuk mobile menu
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>

</body>
</html>