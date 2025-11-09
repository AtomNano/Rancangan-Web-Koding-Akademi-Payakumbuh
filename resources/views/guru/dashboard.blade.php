<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dasbor Guru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Materi -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium text-gray-500">Total Materi</h3>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['total_materi'] ?? 0 }}</p>
                    </div>
                </div>
                <!-- Materi Menunggu -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium text-gray-500">Materi Menunggu</h3>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['pending_materi'] ?? 0 }}</p>
                    </div>
                </div>
                <!-- Materi Disetujui -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium text-gray-500">Materi Disetujui</h3>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['approved_materi'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- Kelas yang Diajar -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Kelas yang Saya Ajar</h3>
                    @if(isset($kelas) && $kelas->count() > 0)
                    <a href="{{ route('guru.kelas.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">
                        Lihat Semua →
                    </a>
                    @endif
                </div>
                
                @php
                    // Ensure we have a collection - force check
                    $kelasCollection = isset($kelas) ? $kelas : collect();
                    
                    // Force check if it's a collection
                    if (!($kelasCollection instanceof \Illuminate\Support\Collection)) {
                        $kelasCollection = collect();
                    }
                    
                    // Debug info
                    $totalKelasDb = \App\Models\Kelas::count();
                    $kelasCount = $kelasCollection->count();
                @endphp
                
                {{-- Debug display --}}
                @if(config('app.debug'))
                    <div class="mb-4 p-4 bg-yellow-50 border border-yellow-300 rounded text-sm">
                        <p class="font-semibold text-yellow-800">Debug Info:</p>
                        <p class="text-yellow-700">Total kelas di DB: {{ $totalKelasDb }}</p>
                        <p class="text-yellow-700">Kelas di collection: {{ $kelasCount }}</p>
                        <p class="text-yellow-700">Kelas variable exists: {{ isset($kelas) ? 'Yes' : 'No' }}</p>
                        @if(isset($kelas))
                            <p class="text-yellow-700">Kelas type: {{ get_class($kelas) }}</p>
                        @endif
                    </div>
                @endif
                
                @if($kelasCollection && $kelasCollection->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($kelasCollection as $k)
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow cursor-pointer" onclick="window.location.href='{{ route('guru.kelas.show', $k) }}'">
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <h4 class="text-lg font-medium text-gray-900">{{ $k->nama_kelas ?? 'N/A' }}</h4>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ ($k->bidang ?? 'coding') === 'coding' ? 'bg-blue-100 text-blue-800' : 
                                               (($k->bidang ?? '') === 'desain' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800') }}">
                                            {{ ucfirst($k->bidang ?? 'coding') }}
                                        </span>
                                    </div>
                                    
                                    <p class="text-sm text-gray-600 mb-4">{{ Str::limit($k->deskripsi ?? 'Tidak ada deskripsi', 100) }}</p>
                                    
                                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            {{ $k->students_count ?? 0 }} Siswa
                                        </span>
                                        @if($k->status)
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $k->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ $k->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <a href="{{ route('guru.kelas.show', $k->id) }}" 
                                       class="block w-full bg-indigo-500 text-white text-center py-2 px-4 rounded hover:bg-indigo-600 transition-colors">
                                        Lihat Detail Kelas
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada kelas</h3>
                        <p class="mt-1 text-sm text-gray-500 mb-4">Anda belum ditugaskan ke kelas manapun. Silakan hubungi admin untuk penugasan kelas.</p>
                        
                        <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded text-left text-sm">
                            <p class="font-semibold text-blue-800 mb-2">Informasi Penting:</p>
                            <p class="text-blue-700 mb-2">User ID: {{ auth()->id() }}</p>
                            <p class="text-blue-700 mb-2">Email: {{ auth()->user()->email }}</p>
                            <p class="text-blue-700 mb-4">Role: {{ auth()->user()->role }}</p>
                            
                            <div class="bg-white p-3 rounded border border-blue-300">
                                <p class="font-semibold text-blue-900 mb-2">Cara mendapatkan kelas:</p>
                                <ol class="list-decimal list-inside space-y-1 text-blue-800 text-xs">
                                    <li>Hubungi admin untuk assign kelas ke akun Anda</li>
                                    <li>Admin dapat assign kelas melalui halaman "Edit Kelas" di panel admin</li>
                                    <li>Pastikan admin memilih nama Anda di dropdown "Guru Pengajar" saat membuat/mengedit kelas</li>
                                </ol>
                            </div>
                            
                                <div class="mt-3 p-3 bg-yellow-50 border border-yellow-300 rounded">
                                <p class="font-semibold text-yellow-800 text-xs mb-1">Debug Info:</p>
                                <p class="text-yellow-700 text-xs mb-2">Total kelas di database: {{ \App\Models\Kelas::count() }}</p>
                                <p class="text-yellow-700 text-xs mb-2">Kelas yang diterima: {{ isset($kelas) ? $kelas->count() : 0 }}</p>
                                <p class="text-yellow-700 text-xs">Silakan cek log Laravel (storage/logs/laravel.log) untuk detail lebih lanjut.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>





