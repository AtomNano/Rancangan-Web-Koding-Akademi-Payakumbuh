<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('guru.pertemuan.index', $kelas->id) }}" class="text-indigo-500 hover:text-indigo-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h2 class="ml-3 font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Input Absen: ') . $pertemuan->judul_pertemuan }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Pertemuan Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $pertemuan->judul_pertemuan }}</h3>
                            @if($pertemuan->deskripsi)
                                <p class="text-sm text-gray-600 mt-1">{{ $pertemuan->deskripsi }}</p>
                            @endif
                            <div class="mt-2 flex items-center space-x-4 text-sm text-gray-500">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $pertemuan->tanggal_pertemuan->format('d M Y') }}
                                </span>
                                @if($pertemuan->waktu_mulai)
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $pertemuan->waktu_mulai }}
                                        @if($pertemuan->waktu_selesai)
                                            - {{ $pertemuan->waktu_selesai }}
                                        @endif
                                    </span>
                                @endif
                                @if($pertemuan->materi)
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        Materi: {{ $pertemuan->materi->judul }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('guru.pertemuan.edit', ['kelas' => $kelas->id, 'pertemuan' => $pertemuan->id]) }}" 
                               class="inline-flex items-center px-3 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Edit Pertemuan
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Absen Form -->
            @if($siswa->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Input Absen Siswa</h3>
                        
                        <form action="{{ route('guru.pertemuan.absen', ['kelas' => $kelas->id, 'pertemuan' => $pertemuan->id]) }}" method="POST" id="absenForm">
                            @csrf
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Kehadiran</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($siswa as $index => $s)
                                            @php
                                                $existingPresensi = $presensi->get($s->id);
                                            @endphp
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $index + 1 }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">{{ $s->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $s->email }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input type="hidden" name="absen[{{ $index }}][user_id]" value="{{ $s->id }}">
                                                    <select name="absen[{{ $index }}][status_kehadiran]" 
                                                            class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                                        <option value="hadir" {{ ($existingPresensi && $existingPresensi->status_kehadiran === 'hadir') ? 'selected' : '' }}>Hadir</option>
                                                        <option value="izin" {{ ($existingPresensi && $existingPresensi->status_kehadiran === 'izin') ? 'selected' : '' }}>Izin</option>
                                                        <option value="sakit" {{ ($existingPresensi && $existingPresensi->status_kehadiran === 'sakit') ? 'selected' : '' }}>Sakit</option>
                                                        <option value="alpha" {{ ($existingPresensi && $existingPresensi->status_kehadiran === 'alpha') ? 'selected' : '' }}>Alpha</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-6 flex items-center justify-end">
                                <x-primary-button>
                                    Simpan Absen
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <p class="text-gray-500">Belum ada siswa terdaftar di kelas ini.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

