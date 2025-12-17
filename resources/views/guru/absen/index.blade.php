<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg p-3 mr-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-3xl bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        {{ __('Input Absen') }}
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Kelola kehadiran siswa dengan mudah</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @if($kelas->count() > 0)
                <!-- Header Section -->
                <div class="mb-10">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Pilih Kelas</h3>
                    <p class="text-gray-600">Pilih kelas untuk mulai input absen dan kelola kehadiran siswa</p>
                </div>

                <!-- Grid Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($kelas as $k)
                        <a href="{{ route('guru.pertemuan.index', $k->id) }}" 
                           class="group relative bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-200 hover:border-indigo-400">
                            
                            <!-- Background Gradient -->
                            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-indigo-100 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            <!-- Content -->
                            <div class="relative p-6 h-full flex flex-col">
                                <!-- Icon & Title Section -->
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <h3 class="font-bold text-lg text-gray-900 group-hover:text-indigo-600 transition-colors">
                                            {{ $k->nama_kelas }}
                                        </h3>
                                        <p class="text-sm text-gray-600 mt-2 leading-relaxed">
                                            {{ $k->deskripsi }}
                                        </p>
                                    </div>
                                    <div class="ml-3 flex-shrink-0">
                                        <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg p-3 group-hover:scale-110 transition-transform duration-300">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Stats Section -->
                                <div class="mt-auto pt-4 border-t border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-sm font-semibold text-gray-900">
                                                {{ $k->pertemuan_count }}
                                            </span>
                                            <span class="text-xs text-gray-600 ml-1">Pertemuan</span>
                                        </div>
                                        <div class="bg-indigo-50 px-3 py-1 rounded-full">
                                            <span class="text-xs font-semibold text-indigo-700">
                                                {{ $k->pertemuan_count > 0 ? 'Aktif' : 'Belum Mulai' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Hover Arrow -->
                                <div class="absolute right-6 bottom-6 text-indigo-600 opacity-0 group-hover:opacity-100 transform translate-x-2 group-hover:translate-x-0 transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="px-6 py-16 text-center">
                        <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full mb-6">
                            <svg class="w-12 h-12 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Kelas</h3>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">
                            Anda belum terdaftar di kelas manapun. Hubungi administrator untuk mendapatkan akses ke kelas.
                        </p>
                        <a href="{{ route('guru.kelas.index') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
