<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.kelas.show', $kelas) }}" class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-white hover:bg-gray-100 text-indigo-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h2 class="font-bold text-3xl bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Progress Siswa</h2>
                    <p class="text-sm text-gray-500 mt-1">{{ $kelas->nama_kelas }} · {{ $siswa->name }}</p>
                </div>
            </div>
            <a href="{{ route('admin.kelas.student.log.export', ['kelas' => $kelas->id, 'user' => $siswa->id]) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Export Log Belajar
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8 border border-gray-200">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center space-x-4">
                        <div class="h-16 w-16 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                            {{ strtoupper(substr($siswa->name, 0, 1)) }}
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">{{ $siswa->name }}</h1>
                            @php $displayId = $siswa->student_id ?? $siswa->id_siswa; @endphp
                            <p class="text-sm text-gray-500 mt-1">
                                ID:
                                @if($displayId)
                                    <span class="font-semibold text-gray-700">{{ $displayId }}</span>
                                @else
                                    <span class="italic text-gray-400">Belum diisi</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                    <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-lg p-4 border-l-4 border-indigo-500">
                        <p class="text-gray-600 text-xs font-semibold uppercase tracking-wide">Kelas</p>
                        <p class="text-gray-900 font-bold text-lg mt-1">{{ $kelas->nama_kelas }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border-l-4 border-purple-500">
                        <p class="text-gray-600 text-xs font-semibold uppercase tracking-wide">Tanggal Bergabung</p>
                        <p class="text-gray-900 font-bold text-lg mt-1">{{ \Carbon\Carbon::parse($enrollment->created_at)->format('d/m/Y') }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-lg p-4 border-l-4 border-pink-500">
                        <p class="text-gray-600 text-xs font-semibold uppercase tracking-wide">Mentor Utama</p>
                        <p class="text-gray-900 font-bold text-lg mt-1">{{ $kelas->guru->name ?? 'N/A' }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border-l-4 border-green-500">
                        <p class="text-gray-600 text-xs font-semibold uppercase tracking-wide">Total Pertemuan</p>
                        <p class="text-gray-900 font-bold text-lg mt-1">{{ count($learningLog) }}</p>
                    </div>
                </div>
            </div>

            @php
                $totalPertemuan = count($learningLog);
                $hadirCount = collect($learningLog)->where('status_kehadiran', 'hadir')->count();
                $izinCount = collect($learningLog)->where('status_kehadiran', 'izin')->count();
                $sakitCount = collect($learningLog)->where('status_kehadiran', 'sakit')->count();
                $alphaCount = collect($learningLog)->where('status_kehadiran', 'alpha')->count();
                $percentageKehadiran = $totalPertemuan > 0 ? round(($hadirCount / $totalPertemuan) * 100, 1) : 0;
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-xl shadow-md p-5 border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-xs font-semibold uppercase tracking-wider">Total Pertemuan</p>
                            <p class="text-3xl font-bold text-blue-600 mt-2">{{ $totalPertemuan }}</p>
                        </div>
                        <div class="bg-blue-100 rounded-lg p-3">
                            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-5 border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-xs font-semibold uppercase tracking-wider">Hadir</p>
                            <p class="text-3xl font-bold text-green-600 mt-2">{{ $hadirCount }}</p>
                        </div>
                        <div class="bg-green-100 rounded-lg p-3">
                            <svg class="w-7 h-7 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-5 border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-xs font-semibold uppercase tracking-wider">Izin/Sakit</p>
                            <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $izinCount + $sakitCount }}</p>
                        </div>
                        <div class="bg-yellow-100 rounded-lg p-3">
                            <svg class="w-7 h-7 text-yellow-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-5 border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-xs font-semibold uppercase tracking-wider">Kehadiran</p>
                            <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $percentageKehadiran }}%</p>
                        </div>
                        <div class="bg-indigo-100 rounded-lg p-3">
                            <svg class="w-7 h-7 text-indigo-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5.04-6.71l-2.75 3.54-1.3-1.54L7 15h10l-3.04-4.71z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                    <h2 class="text-lg font-bold text-gray-900">Riwayat Pembelajaran</h2>
                    <p class="text-sm text-gray-600 mt-1">Rincian pertemuan, mentor, dan kehadiran siswa</p>
                </div>

                @if(count($learningLog) > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gradient-to-r from-gray-100 to-gray-50 border-b-2 border-gray-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Pertemuan</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal Belajar</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Nama Mentor</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Materi</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($learningLog as $log)
                                    <tr class="hover:bg-indigo-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-700">
                                            {{ $log['number'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                            {{ $log['pertemuan']->judul_pertemuan }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ \Carbon\Carbon::parse($log['tanggal_belajar'])->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center mr-2">
                                                    <span class="text-xs font-bold text-indigo-600">{{ strtoupper(substr($log['nama_mentor'] ?? '-', 0, 1)) }}</span>
                                                </div>
                                                <span class="font-medium">{{ $log['nama_mentor'] ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            @if($log['materi'])
                                                <span class="inline-block max-w-xs truncate px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-medium">
                                                    {{ $log['materi'] }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 italic">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @if($log['status_kehadiran'])
                                                @switch($log['status_kehadiran'])
                                                    @case('hadir')
                                                        <span class="inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-full bg-green-100 text-green-800">
                                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"></path></svg>
                                                            Hadir
                                                        </span>
                                                        @break
                                                    @case('izin')
                                                        <span class="inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-full bg-yellow-100 text-yellow-800">
                                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"></path></svg>
                                                            Izin
                                                        </span>
                                                        @break
                                                    @case('sakit')
                                                        <span class="inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-full bg-blue-100 text-blue-800">
                                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path></svg>
                                                            Sakit
                                                        </span>
                                                        @break
                                                    @case('alpha')
                                                        <span class="inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-full bg-red-100 text-red-800">
                                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path></svg>
                                                            Alpha
                                                        </span>
                                                        @break
                                                @endswitch
                                            @else
                                                <span class="inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-full bg-gray-100 text-gray-800">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="px-6 py-5 bg-gradient-to-r from-gray-50 to-gray-100 border-t border-gray-200">
                        <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-4">Ringkasan Kehadiran</p>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="bg-white rounded-lg p-4 border border-green-200">
                                <p class="text-gray-600 text-xs font-semibold uppercase">Hadir</p>
                                <p class="text-2xl font-bold text-green-600 mt-1">{{ $hadirCount }}</p>
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-yellow-200">
                                <p class="text-gray-600 text-xs font-semibold uppercase">Izin</p>
                                <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $izinCount }}</p>
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-blue-200">
                                <p class="text-gray-600 text-xs font-semibold uppercase">Sakit</p>
                                <p class="text-2xl font-bold text-blue-600 mt-1">{{ $sakitCount }}</p>
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-red-200">
                                <p class="text-gray-600 text-xs font-semibold uppercase">Alpha</p>
                                <p class="text-2xl font-bold text-red-600 mt-1">{{ $alphaCount }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="px-6 py-16 text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-600 font-medium text-sm">Belum ada pertemuan untuk kelas ini</p>
                        <p class="text-gray-500 text-xs mt-2">Pertemuan akan muncul di sini setelah dibuat oleh mentor</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
