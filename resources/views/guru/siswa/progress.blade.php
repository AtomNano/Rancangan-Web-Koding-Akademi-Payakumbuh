<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('guru.kelas.show', $kelas) }}" class="text-indigo-600 hover:text-indigo-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h2 class="font-semibold text-2xl text-gray-900 leading-tight">Progress Siswa</h2>
                    <p class="text-sm text-gray-600">{{ $kelas->nama_kelas }} · {{ $siswa->name }}</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-6">
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            <div class="h-14 w-14 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg">
                                {{ strtoupper(substr($siswa->name, 0, 1)) }}
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-800">{{ $siswa->name }}</h1>
                                <p class="text-gray-600">ID: {{ $siswa->student_id ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="border-l-4 border-indigo-500 pl-4">
                            <p class="text-gray-600 text-sm font-medium">Kelas</p>
                            <p class="text-gray-800 font-semibold">{{ $kelas->nama_kelas }}</p>
                        </div>
                        <div class="border-l-4 border-purple-500 pl-4">
                            <p class="text-gray-600 text-sm font-medium">Tanggal Bergabung</p>
                            <p class="text-gray-800 font-semibold">{{ \Carbon\Carbon::parse($enrollment->created_at)->format('d/m/Y') }}</p>
                        </div>
                        <div class="border-l-4 border-pink-500 pl-4">
                            <p class="text-gray-600 text-sm font-medium">Mentor</p>
                            <p class="text-gray-800 font-semibold">{{ $kelas->guru->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            @php
                $totalPertemuan = count($learningLog);
                $hadirCount = collect($learningLog)->where('status_kehadiran', 'hadir')->count();
                $izinCount = collect($learningLog)->where('status_kehadiran', 'izin')->count();
                $sakitCount = collect($learningLog)->where('status_kehadiran', 'sakit')->count();
                $alphaCount = collect($learningLog)->where('status_kehadiran', 'alpha')->count();
                $percentageKehadiran = $totalPertemuan > 0 ? round(($hadirCount / $totalPertemuan) * 100, 1) : 0;
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-lg shadow-md p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Total Pertemuan</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $totalPertemuan }}</p>
                        </div>
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Hadir</p>
                            <p class="text-2xl font-bold text-green-600">{{ $hadirCount }}</p>
                        </div>
                        <svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"></path>
                        </svg>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Izin/Sakit</p>
                            <p class="text-2xl font-bold text-yellow-600">{{ $izinCount + $sakitCount }}</p>
                        </div>
                        <svg class="w-8 h-8 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"></path>
                        </svg>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Kehadiran</p>
                            <p class="text-2xl font-bold text-indigo-600">{{ $percentageKehadiran }}%</p>
                        </div>
                        <svg class="w-8 h-8 text-indigo-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5.04-6.71l-2.75 3.54-1.3-1.54L7 15h10l-3.04-4.71z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Learning Log Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Riwayat Pembelajaran</h2>
            </div>

            @if(count($learningLog) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pertemuan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Belajar</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Mentor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Materi</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($learningLog as $log)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-700">
                                        {{ $log['number'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                        {{ $log['pertemuan']->judul_pertemuan }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($log['tanggal_belajar'])->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $log['nama_mentor'] }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        <span class="inline-block max-w-xs truncate">{{ $log['materi'] ?? '-' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($log['status_kehadiran'])
                                            @switch($log['status_kehadiran'])
                                                @case('hadir')
                                                    <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                                        Hadir
                                                    </span>
                                                    @break
                                                @case('izin')
                                                    <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                                        Izin
                                                    </span>
                                                    @break
                                                @case('sakit')
                                                    <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                                        Sakit
                                                    </span>
                                                    @break
                                                @case('alpha')
                                                    <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                                        Alpha
                                                    </span>
                                                    @break
                                            @endswitch
                                        @else
                                            <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                                Belum Input
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                        <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <p class="text-sm font-medium">Belum ada data pertemuan</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Summary Stats at Bottom -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="grid grid-cols-4 gap-4 text-center">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Hadir</p>
                            <p class="text-lg font-bold text-green-600">{{ $hadirCount }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Izin</p>
                            <p class="text-lg font-bold text-yellow-600">{{ $izinCount }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Sakit</p>
                            <p class="text-lg font-bold text-blue-600">{{ $sakitCount }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Alpha</p>
                            <p class="text-lg font-bold text-red-600">{{ $alphaCount }}</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-gray-500 font-medium">Belum ada pertemuan untuk kelas ini</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
