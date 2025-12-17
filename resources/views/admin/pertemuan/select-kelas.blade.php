<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="bg-gradient-to-br from-cyan-600 to-blue-600 rounded-lg p-3 mr-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
                        {{ __('Kelola Pertemuan & Absen') }}
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">Pilih kelas terlebih dahulu untuk masuk ke halaman pertemuan</p>
                </div>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($kelasList->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($kelasList as $k)
                        <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-200 group">
                            <!-- Header strip -->
                            <div class="h-2 bg-gradient-to-r from-cyan-500 via-blue-500 to-indigo-500"></div>

                            <div class="p-6">
                                <div class="flex items-start justify-between mb-3">
                                    <h3 class="font-bold text-lg text-gray-900 group-hover:text-indigo-700 transition-colors">
                                        {{ $k->nama_kelas }}
                                    </h3>
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-indigo-50 text-indigo-700">
                                        {{ $k->bidang ?? 'Kelas' }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mb-4 min-h-[42px]">{{ Str::limit($k->deskripsi, 90) }}</p>

                                <div class="grid grid-cols-3 gap-3 mb-4">
                                    <div class="bg-gray-50 rounded-lg p-3 text-center">
                                        <p class="text-[10px] uppercase tracking-wide text-gray-500">Total Pertemuan</p>
                                        <p class="text-lg font-bold text-gray-900">{{ $kelasStats[$k->id]['total_pertemuan'] ?? 0 }}</p>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3 text-center">
                                        <p class="text-[10px] uppercase tracking-wide text-gray-500">Absen Diinput</p>
                                        <p class="text-lg font-bold text-gray-900">{{ $kelasStats[$k->id]['total_absen'] ?? 0 }}</p>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3 text-center">
                                        <p class="text-[10px] uppercase tracking-wide text-gray-500">Rata2/Meet</p>
                                        <p class="text-lg font-bold text-gray-900">{{ $kelasStats[$k->id]['avg_absen'] ?? 0 }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 text-gray-400 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span>Pengajar: {{ $k->guru->name ?? '-' }}</span>
                                    </div>
                                    <a href="{{ route('admin.pertemuan.index', ['kelas' => $k->id]) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg text-sm font-semibold hover:from-indigo-700 hover:to-purple-700 transition">
                                        Kelola Pertemuan
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-xl shadow p-10 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-indigo-50 rounded-full mb-4">
                        <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Kelas</h3>
                    <p class="text-gray-600">Silakan tambahkan kelas terlebih dahulu untuk mengelola pertemuan dan absen.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
