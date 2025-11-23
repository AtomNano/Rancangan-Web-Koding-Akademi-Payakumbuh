<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
                    {{ __('Dashboard Guru') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Selamat datang kembali, {{ auth()->user()->name }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('guru.materi.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-lg shadow-md hover:from-indigo-700 hover:to-purple-700 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Upload Materi
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Total Materi -->
                <div class="bg-blue-50 border-2 border-blue-200 rounded-xl shadow-md p-6 transform hover:shadow-lg transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-600 text-sm font-semibold mb-1">Total Materi</p>
                            <p class="text-3xl font-bold text-blue-900">{{ $stats['total_materi'] ?? 0 }}</p>
                        </div>
                        <div class="bg-blue-100 rounded-lg p-3">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Materi Menunggu -->
                <div class="bg-yellow-50 border-2 border-yellow-200 rounded-xl shadow-md p-6 transform hover:shadow-lg transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-yellow-700 text-sm font-semibold mb-1">Menunggu Verifikasi</p>
                            <p class="text-3xl font-bold text-yellow-900">{{ $stats['pending_materi'] ?? 0 }}</p>
                        </div>
                        <div class="bg-yellow-100 rounded-lg p-3">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Materi Disetujui -->
                <div class="bg-green-50 border-2 border-green-200 rounded-xl shadow-md p-6 transform hover:shadow-lg transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-700 text-sm font-semibold mb-1">Materi Disetujui</p>
                            <p class="text-3xl font-bold text-green-900">{{ $stats['approved_materi'] ?? 0 }}</p>
                        </div>
                        <div class="bg-green-100 rounded-lg p-3">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Kelas -->
                <div class="bg-purple-50 border-2 border-purple-200 rounded-xl shadow-md p-6 transform hover:shadow-lg transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-700 text-sm font-semibold mb-1">Kelas Aktif</p>
                            <p class="text-3xl font-bold text-purple-900">{{ isset($kelas) && $kelas ? $kelas->count() : 0 }}</p>
                        </div>
                        <div class="bg-purple-100 rounded-lg p-3">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('guru.materi.create') }}" 
                       class="flex items-center p-4 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow border-l-4 border-indigo-500">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-semibold text-gray-900">Upload Materi Baru</h4>
                            <p class="text-xs text-gray-500 mt-1">Tambahkan materi pembelajaran baru</p>
                        </div>
                    </a>

                    <a href="{{ route('guru.kelas.index') }}" 
                       class="flex items-center p-4 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow border-l-4 border-green-500">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-semibold text-gray-900">Kelola Kelas</h4>
                            <p class="text-xs text-gray-500 mt-1">Lihat dan kelola kelas Anda</p>
                        </div>
                    </a>

                    <a href="{{ route('guru.materi.index') }}" 
                       class="flex items-center p-4 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow border-l-4 border-purple-500">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-semibold text-gray-900">Manajemen Materi</h4>
                            <p class="text-xs text-gray-500 mt-1">Lihat semua materi Anda</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Kelas yang Diajar -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Kelas yang Saya Ajar</h3>
                        <p class="text-sm text-gray-600 mt-1">Kelas yang sedang Anda ajar</p>
                    </div>
                    @if(isset($kelas) && $kelas->count() > 0)
                    <a href="{{ route('guru.kelas.index') }}" 
                       class="text-indigo-600 hover:text-indigo-800 font-medium text-sm flex items-center">
                        Lihat Semua
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    @endif
                </div>
                
                @php
                    $kelasCollection = isset($kelas) ? $kelas : collect();
                    if (!($kelasCollection instanceof \Illuminate\Support\Collection)) {
                        $kelasCollection = collect();
                    }
                @endphp
                
                @if($kelasCollection && $kelasCollection->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($kelasCollection as $k)
                            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 group cursor-pointer" 
                                 onclick="window.location.href='{{ route('guru.kelas.show', $k) }}'">
                                <!-- Header dengan gradient -->
                                <div class="h-2 {{ $k->bidang === 'coding' ? 'bg-gradient-to-r from-blue-500 to-blue-600' : 
                                                      ($k->bidang === 'desain' ? 'bg-gradient-to-r from-purple-500 to-pink-500' : 
                                                      'bg-gradient-to-r from-green-500 to-emerald-500') }}"></div>
                                
                                <div class="p-6">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex-1">
                                            <h4 class="text-lg font-bold text-gray-900 mb-1 group-hover:text-indigo-600 transition-colors">
                                                {{ $k->nama_kelas ?? 'N/A' }}
                                            </h4>
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                                {{ $k->bidang === 'coding' ? 'bg-blue-100 text-blue-800' : 
                                                   ($k->bidang === 'desain' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800') }}">
                                                {{ ucfirst($k->bidang ?? 'coding') }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ Str::limit($k->deskripsi ?? 'Tidak ada deskripsi', 80) }}</p>
                                    
                                    <div class="flex items-center justify-between text-sm mb-4 pb-4 border-b border-gray-200">
                                        <div class="flex items-center text-gray-600">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <span class="font-medium">{{ $k->students_count ?? 0 }}</span>
                                            <span class="ml-1">Siswa</span>
                                        </div>
                                        @if($k->status)
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $k->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ $k->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <a href="{{ route('guru.kelas.show', $k->id) }}" 
                                       class="block w-full text-center py-2.5 px-4 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors">
                                        Kelola Kelas
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-xl shadow-md p-12 text-center">
                        <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Kelas</h3>
                        <p class="text-gray-600 mb-6 max-w-md mx-auto">
                            Anda belum ditugaskan ke kelas manapun. Silakan hubungi admin untuk penugasan kelas.
                        </p>
                        
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-left max-w-2xl mx-auto">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <p class="font-semibold text-blue-900 mb-2">Informasi Akun</p>
                                    <div class="space-y-1 text-sm text-blue-800 mb-4">
                                        <p><strong>User ID:</strong> {{ auth()->id() }}</p>
                                        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                                        <p><strong>Role:</strong> {{ auth()->user()->role }}</p>
                                    </div>
                                    
                                    <div class="bg-white p-4 rounded border border-blue-300">
                                        <p class="font-semibold text-blue-900 mb-2 text-sm">Cara Mendapatkan Kelas:</p>
                                        <ol class="list-decimal list-inside space-y-1 text-blue-800 text-xs">
                                            <li>Hubungi admin untuk assign kelas ke akun Anda</li>
                                            <li>Admin dapat assign kelas melalui halaman "Edit Kelas" di panel admin</li>
                                            <li>Pastikan admin memilih nama Anda di dropdown "Guru Pengajar" saat membuat/mengedit kelas</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
