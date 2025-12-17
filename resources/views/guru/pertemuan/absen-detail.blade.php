<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('guru.pertemuan.index', $kelas->id) }}" class="text-indigo-500 hover:text-indigo-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h2 class="ml-3 font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Absen: ') . $pertemuan->judul_pertemuan }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Pertemuan Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $pertemuan->judul_pertemuan }}</h1>
                            <p class="text-gray-600 mt-1">{{ $kelas->nama_kelas }}</p>
                        </div>
                        <a href="{{ route('guru.pertemuan.show', ['kelas' => $kelas->id, 'pertemuan' => $pertemuan->id]) }}" 
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Absen
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">Tanggal</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1">{{ $pertemuan->tanggal_pertemuan->format('d M Y') }}</p>
                        </div>
                        @if($pertemuan->waktu_mulai)
                        <div class="bg-green-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">Waktu</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1">
                                {{ $pertemuan->waktu_mulai }}
                                @if($pertemuan->waktu_selesai)
                                    - {{ $pertemuan->waktu_selesai }}
                                @endif
                            </p>
                        </div>
                        @endif
                        @if($pertemuan->materi)
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">Materi</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1">{{ $pertemuan->materi }}</p>
                        </div>
                        @endif
                        <div class="bg-indigo-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">Total Absen</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1">{{ $presensi->count() }} / {{ $siswa->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attendance Summary Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-green-50 border-2 border-green-200 rounded-xl shadow-md p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-600 text-sm font-medium mb-1">Hadir</p>
                            <p class="text-3xl font-bold text-green-900">{{ $hadirList->count() }}</p>
                        </div>
                        <div class="bg-green-100 rounded-lg p-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-yellow-50 border-2 border-yellow-200 rounded-xl shadow-md p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-yellow-600 text-sm font-medium mb-1">Izin</p>
                            <p class="text-3xl font-bold text-yellow-900">{{ $izinList->count() }}</p>
                        </div>
                        <div class="bg-yellow-100 rounded-lg p-3">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 border-2 border-blue-200 rounded-xl shadow-md p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-600 text-sm font-medium mb-1">Sakit</p>
                            <p class="text-3xl font-bold text-blue-900">{{ $sakitList->count() }}</p>
                        </div>
                        <div class="bg-blue-100 rounded-lg p-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-red-50 border-2 border-red-200 rounded-xl shadow-md p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-red-600 text-sm font-medium mb-1">Alpha</p>
                            <p class="text-3xl font-bold text-red-900">{{ $alphaList->count() }}</p>
                        </div>
                        <div class="bg-red-100 rounded-lg p-3">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attendance Lists by Status -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Hadir -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white">Hadir ({{ $hadirList->count() }})</h3>
                    </div>
                    <div class="p-6">
                        @if($hadirList->count() > 0)
                            <div class="space-y-3">
                                @foreach($hadirList as $p)
                                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg border border-green-200">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-green-200 flex items-center justify-center">
                                                    <span class="text-green-700 font-bold text-sm">{{ substr($p->user->name, 0, 2) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">{{ $p->user->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $p->user->email }}</div>
                                            </div>
                                        </div>
                                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Hadir</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c1.105 0 2-1.118 2-2.5S13.105 7 12 7s-2 1.118-2 2.5S10.895 12 12 12z" />
                                </svg>
                                <p class="text-gray-500 text-sm">Tidak ada siswa yang hadir</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Izin -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white">Izin ({{ $izinList->count() }})</h3>
                    </div>
                    <div class="p-6">
                        @if($izinList->count() > 0)
                            <div class="space-y-3">
                                @foreach($izinList as $p)
                                    <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-yellow-200 flex items-center justify-center">
                                                    <span class="text-yellow-700 font-bold text-sm">{{ substr($p->user->name, 0, 2) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">{{ $p->user->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $p->user->email }}</div>
                                            </div>
                                        </div>
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">Izin</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c1.105 0 2-1.118 2-2.5S13.105 7 12 7s-2 1.118-2 2.5S10.895 12 12 12z" />
                                </svg>
                                <p class="text-gray-500 text-sm">Tidak ada siswa yang izin</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Sakit -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white">Sakit ({{ $sakitList->count() }})</h3>
                    </div>
                    <div class="p-6">
                        @if($sakitList->count() > 0)
                            <div class="space-y-3">
                                @foreach($sakitList as $p)
                                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg border border-blue-200">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-blue-200 flex items-center justify-center">
                                                    <span class="text-blue-700 font-bold text-sm">{{ substr($p->user->name, 0, 2) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">{{ $p->user->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $p->user->email }}</div>
                                            </div>
                                        </div>
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">Sakit</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c1.105 0 2-1.118 2-2.5S13.105 7 12 7s-2 1.118-2 2.5S10.895 12 12 12z" />
                                </svg>
                                <p class="text-gray-500 text-sm">Tidak ada siswa yang sakit</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Alpha -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white">Alpha ({{ $alphaList->count() }})</h3>
                    </div>
                    <div class="p-6">
                        @if($alphaList->count() > 0)
                            <div class="space-y-3">
                                @foreach($alphaList as $p)
                                    <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg border border-red-200">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-red-200 flex items-center justify-center">
                                                    <span class="text-red-700 font-bold text-sm">{{ substr($p->user->name, 0, 2) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">{{ $p->user->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $p->user->email }}</div>
                                            </div>
                                        </div>
                                        <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">Alpha</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c1.105 0 2-1.118 2-2.5S13.105 7 12 7s-2 1.118-2 2.5S10.895 12 12 12z" />
                                </svg>
                                <p class="text-gray-500 text-sm">Tidak ada siswa yang alpha</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
