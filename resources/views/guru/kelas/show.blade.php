<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('guru.kelas.index') }}" class="text-indigo-500 hover:text-indigo-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h2 class="ml-3 font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Kelas: ') . $kelas->nama_kelas }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $kelas->nama_kelas }}</h1>
                            <p class="text-gray-600 mt-1">{{ $kelas->deskripsi }}</p>
                            @if(isset($isGuruAssigned) && !$isGuruAssigned && isset($isGuruEnrolled) && !$isGuruEnrolled)
                                <div class="mt-2 p-3 bg-yellow-50 border border-yellow-300 rounded-lg">
                                    <p class="text-sm text-yellow-800">
                                        <strong>Perhatian:</strong> Kelas ini belum diassign ke akun Anda. 
                                        Silakan hubungi admin untuk mengassign kelas ini ke akun guru Anda.
                                    </p>
                                    <p class="text-xs text-yellow-700 mt-1">
                                        Kelas ID: {{ $kelas->id }} | 
                                        Guru ID di kelas: {{ $kelas->guru_id ?? 'Belum diassign' }} | 
                                        Guru ID Anda: {{ auth()->id() }}
                                    </p>
                                </div>
                            @elseif(isset($isGuruEnrolled) && $isGuruEnrolled && isset($isGuruAssigned) && !$isGuruAssigned)
                                <div class="mt-2 p-3 bg-blue-50 border border-blue-300 rounded-lg">
                                    <p class="text-sm text-blue-800">
                                        <strong>Info:</strong> Anda terdaftar di kelas ini melalui enrollment, 
                                        namun kelas ini belum diassign ke akun Anda sebagai guru utama.
                                    </p>
                                </div>
                            @endif
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $kelas->bidang === 'coding' ? 'bg-blue-100 text-blue-800' : 
                               ($kelas->bidang === 'desain' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800') }}">
                            {{ ucfirst($kelas->bidang) }}
                        </span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Total Siswa yang Diajar</p>
                            <p class="text-2xl font-bold text-gray-900">
                                @php
                                    $siswaCount = isset($siswa) && $siswa ? $siswa->count() : 0;
                                @endphp
                                {{ $siswaCount }}
                            </p>
                            <p class="text-xs text-gray-400 mt-1">Siswa di kelas ini</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Total Materi Saya</p>
                            <p class="text-2xl font-bold text-gray-900">
                                @php
                                    $materiCount = isset($materi) && $materi ? $materi->count() : 0;
                                @endphp
                                {{ $materiCount }}
                            </p>
                            <p class="text-xs text-gray-400 mt-1">Materi yang Anda upload</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Materi Disetujui</p>
                            <p class="text-2xl font-bold text-gray-900">
                                @php
                                    $approvedCount = isset($materi) && $materi ? $materi->where('status', 'approved')->count() : 0;
                                @endphp
                                {{ $approvedCount }}
                            </p>
                            <p class="text-xs text-gray-400 mt-1">Dari materi Anda</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabbed View -->
            <div x-data="{ openTab: 'siswa' }" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                        <button @click="openTab = 'siswa'" 
                                :class="{ 'border-indigo-500 text-indigo-600': openTab === 'siswa', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': openTab !== 'siswa' }" 
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Daftar Siswa ({{ isset($siswa) && $siswa ? $siswa->count() : 0 }})
                        </button>
                        <button @click="openTab = 'materi'" 
                                :class="{ 'border-indigo-500 text-indigo-600': openTab === 'materi', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': openTab !== 'materi' }" 
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Materi ({{ isset($materi) && $materi ? $materi->count() : 0 }})
                        </button>
                        <button @click="openTab = 'progress'" 
                                :class="{ 'border-indigo-500 text-indigo-600': openTab === 'progress', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': openTab !== 'progress' }" 
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Progress & Absen Siswa
                        </button>
                        <button @click="openTab = 'kehadiran'" 
                                :class="{ 'border-indigo-500 text-indigo-600': openTab === 'kehadiran', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': openTab !== 'kehadiran' }" 
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Log Kehadiran
                        </button>
                    </nav>
                </div>

                <!-- Tab: Daftar Siswa -->
                <div x-show="openTab === 'siswa'" class="p-6">
                    @php
                        $siswaCollection = isset($siswa) && $siswa ? $siswa : collect();
                        $materiCollection = isset($materi) && $materi ? $materi : collect();
                    @endphp
                    
                    @if(isset($isGuruAssigned) && !$isGuruAssigned && isset($isGuruEnrolled) && !$isGuruEnrolled)
                        <div class="mb-4 p-4 bg-yellow-50 border border-yellow-300 rounded-lg">
                            <p class="text-yellow-800 font-medium mb-2">Kelas Belum Diassign</p>
                            <p class="text-sm text-yellow-700 mb-2">
                                Kelas ini belum diassign ke akun Anda. Data siswa mungkin tidak muncul jika kelas belum diassign.
                            </p>
                            <p class="text-xs text-yellow-600">
                                <strong>Solusi:</strong> Hubungi admin untuk mengassign kelas ID {{ $kelas->id }} ke guru ID {{ auth()->id() }}.
                                Atau jalankan: <code>UPDATE kelas SET guru_id = {{ auth()->id() }} WHERE id = {{ $kelas->id }};</code>
                            </p>
                        </div>
                    @endif
                    
                    @if($siswaCollection->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Materi Selesai</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Kehadiran</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($siswaCollection as $s)
                                        @php
                                            $progressInfo = $progressData[$s->id] ?? null;
                                            $completedCount = $progressInfo['completed_materi'] ?? 0;
                                            $presensiCount = $progressInfo['presensi_count'] ?? 0;
                                        @endphp
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <div class="h-10 w-10 rounded-full bg-indigo-200 flex items-center justify-center">
                                                            <span class="text-indigo-700 font-bold">{{ substr($s->name, 0, 2) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $s->name }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $s->email }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $totalApprovedMateri = $progressInfo['total_materi'] ?? $materiCollection->where('status', 'approved')->count();
                                                @endphp
                                                <span class="text-sm font-medium text-gray-900">{{ $completedCount }} / {{ $totalApprovedMateri }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm font-medium text-gray-900">{{ $presensiCount }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    // Get enrollment status - check if pivot exists, otherwise query enrollment
                                                    $enrollmentStatus = null;
                                                    if (isset($s->pivot) && $s->pivot) {
                                                        $enrollmentStatus = $s->pivot->status;
                                                    } else {
                                                        $enrollment = \App\Models\Enrollment::where('user_id', $s->id)
                                                            ->where('kelas_id', $kelas->id)
                                                            ->first();
                                                        $enrollmentStatus = $enrollment ? $enrollment->status : 'active';
                                                    }
                                                @endphp
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $enrollmentStatus === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $enrollmentStatus === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">Belum ada siswa terdaftar di kelas ini.</p>
                    @endif
                </div>

                <!-- Tab: Materi -->
                <div x-show="openTab === 'materi'" class="p-6">
                    <div class="mb-4 flex items-center space-x-2">
                        <a href="{{ route('guru.pertemuan.index', $kelas->id) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Pertemuan & Absen
                        </a>
                        <a href="{{ route('guru.materi.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Upload Materi Baru
                        </a>
                    </div>
                    @if($materiCollection->count() > 0)
                        <div class="space-y-4">
                            @foreach($materiCollection as $m)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-2 mb-2">
                                                <h4 class="text-lg font-medium text-gray-900">{{ $m->judul }}</h4>
                                                @if($m->uploadedBy)
                                                    <span class="text-xs text-gray-500">oleh {{ $m->uploadedBy->name }}</span>
                                                @endif
                                            </div>
                                            <p class="text-sm text-gray-600 mt-1">{{ Str::limit($m->deskripsi ?? '', 100) }}</p>
                                            <div class="flex items-center space-x-4 mt-2">
                                                <span class="text-xs text-gray-500">Tipe: {{ $m->file_type ?? 'N/A' }}</span>
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                    {{ $m->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                                       ($m->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                    {{ ucfirst($m->status ?? 'pending') }}
                                                </span>
                                                <span class="text-xs text-gray-500">Upload: {{ $m->created_at->format('d M Y') }}</span>
                                            </div>
                                            @php
                                                $accessInfo = $materiAccess[$m->id] ?? null;
                                                $accessedStudents = $accessInfo ? $accessInfo['accessed_by'] : collect();
                                                $completedStudents = $accessInfo ? $accessInfo['completed_by'] : collect();
                                                $accessedCount = $accessedStudents->count();
                                                $completedCount = $completedStudents->count();
                                            @endphp
                                            <div class="mt-3 space-y-2">
                                                <div class="flex items-center space-x-6 text-sm text-gray-600">
                                                    <span>Diakses oleh: <strong>{{ $accessedCount }}</strong> siswa</span>
                                                    <span>Selesai: <strong>{{ $completedCount }}</strong> siswa</span>
                                                </div>
                                                @if($accessedCount > 0)
                                                    <div class="mt-2">
                                                        <details class="cursor-pointer">
                                                            <summary class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                                                                Lihat Daftar Siswa ({{ $accessedCount }})
                                                            </summary>
                                                            <div class="mt-2 pl-4 border-l-2 border-indigo-200">
                                                                <div class="space-y-1">
                                                                    <p class="text-xs font-semibold text-gray-700 mb-1">Siswa yang Mengakses:</p>
                                                                    @foreach($accessedStudents as $student)
                                                                        <div class="flex items-center justify-between text-xs text-gray-600 py-1">
                                                                            <span>{{ $student->name }}</span>
                                                                            @if($completedStudents->contains('id', $student->id))
                                                                                <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-xs">Selesai</span>
                                                                            @else
                                                                                <span class="px-2 py-0.5 bg-yellow-100 text-yellow-700 rounded text-xs">Dalam Proses</span>
                                                                            @endif
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </details>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="ml-4 flex flex-col space-y-2">
                                            <a href="{{ route('guru.materi.show', $m) }}" class="px-3 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 text-sm text-center">
                                                Lihat
                                            </a>
                                            @if($m->uploaded_by === auth()->id() && $m->status !== 'approved')
                                                <a href="{{ route('guru.materi.edit', $m) }}" class="px-3 py-1 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 text-sm text-center">
                                                    Edit
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            @if(isset($isGuruAssigned) && !$isGuruAssigned && isset($isGuruEnrolled) && !$isGuruEnrolled)
                                <div class="mb-4 p-4 bg-yellow-50 border border-yellow-300 rounded-lg">
                                    <p class="text-yellow-800 font-medium mb-2">Kelas Belum Diassign</p>
                                    <p class="text-sm text-yellow-700">
                                        Kelas ini belum diassign ke akun Anda. Setelah kelas diassign, 
                                        Anda dapat mengupload materi untuk kelas ini.
                                    </p>
                                </div>
                            @endif
                            <p class="text-gray-500 mb-4">Belum ada materi yang Anda upload untuk kelas ini.</p>
                            <a href="{{ route('guru.materi.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Upload Materi Pertama
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Tab: Progress Siswa -->
                <div x-data="{ expandedStudents: {} }" x-show="openTab === 'progress'" class="p-6">
                    @if($siswaCollection->count() > 0 && $materiCollection->count() > 0)
                        <!-- Summary Stats -->
                        <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-indigo-50 border-2 border-indigo-200 rounded-xl shadow-md p-5">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-indigo-600 text-sm font-medium mb-1">Total Siswa</p>
                                        <p class="text-3xl font-bold text-indigo-900">{{ $siswaCollection->count() }}</p>
                                    </div>
                                    <div class="bg-indigo-100 rounded-lg p-3">
                                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-green-50 border-2 border-green-200 rounded-xl shadow-md p-5">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-green-600 text-sm font-medium mb-1">Siswa Aktif</p>
                                        <p class="text-3xl font-bold text-green-900">
                                            @php
                                                $activeReaders = 0;
                                                foreach($progressData as $pd) {
                                                    if(($pd['completed_materi'] ?? 0) > 0 || ($pd['presensi_count'] ?? 0) > 0) {
                                                        $activeReaders++;
                                                    }
                                                }
                                            @endphp
                                            {{ $activeReaders }}
                                        </p>
                                    </div>
                                    <div class="bg-green-100 rounded-lg p-3">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-blue-50 border-2 border-blue-200 rounded-xl shadow-md p-5">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-blue-600 text-sm font-medium mb-1">Rata-rata Progress</p>
                                        <p class="text-3xl font-bold text-blue-900">
                                            @php
                                                $totalAvg = 0;
                                                $count = 0;
                                                foreach($progressData as $pd) {
                                                    if(($pd['total_materi'] ?? 0) > 0) {
                                                        $avg = (($pd['completed_materi'] ?? 0) / $pd['total_materi']) * 100;
                                                        $totalAvg += $avg;
                                                        $count++;
                                                    }
                                                }
                                                $overallAvg = $count > 0 ? round($totalAvg / $count, 1) : 0;
                                            @endphp
                                            {{ $overallAvg }}%
                                        </p>
                                    </div>
                                    <div class="bg-blue-100 rounded-lg p-3">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Student Cards with Expandable Details -->
                        <div class="space-y-4">
                            @foreach($siswaCollection as $s)
                                @php
                                    $progressInfo = $progressData[$s->id] ?? null;
                                    $progresses = $progressInfo['progress'] ?? collect();
                                    $progressMap = $progresses->keyBy('materi_id');
                                    $totalProgress = 0;
                                    $totalMateri = $materiCollection->where('status', 'approved')->count();
                                    
                                    // Get attendance stats for this student
                                    $siswaPresensi = \App\Models\Presensi::where('user_id', $s->id)
                                        ->whereIn('materi_id', $materiCollection->pluck('id'))
                                        ->get();
                                    $hadirCount = $siswaPresensi->where('status_kehadiran', 'hadir')->count();
                                    $izinCount = $siswaPresensi->where('status_kehadiran', 'izin')->count();
                                    $sakitCount = $siswaPresensi->where('status_kehadiran', 'sakit')->count();
                                    $alphaCount = $siswaPresensi->where('status_kehadiran', 'alpha')->count();
                                    
                                    $avgProgress = $totalMateri > 0 ? ($progressInfo['completed_materi'] ?? 0) / $totalMateri * 100 : 0;
                                @endphp
                                
                                <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                                    <!-- Student Header (Clickable) -->
                                    <button @click="expandedStudents[{{ $s->id }}] = !expandedStudents[{{ $s->id }}]" 
                                            class="w-full p-5 text-left hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-inset">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center flex-1">
                                                <!-- Avatar -->
                                                <div class="flex-shrink-0 h-12 w-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg mr-4">
                                                    {{ strtoupper(substr($s->name, 0, 2)) }}
                                                </div>
                                                
                                                <!-- Student Info -->
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center space-x-3">
                                                        <h3 class="text-lg font-semibold text-gray-900">{{ $s->name }}</h3>
                                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                                            {{ $s->email }}
                                                        </span>
                                                    </div>
                                                    <div class="mt-2 flex items-center space-x-6">
                                                        <!-- Overall Progress -->
                                                        <div class="flex items-center space-x-2">
                                                            <span class="text-sm text-gray-600">Progress:</span>
                                                            <div class="flex items-center space-x-2">
                                                                <div class="w-32 bg-gray-200 rounded-full h-2.5">
                                                                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2.5 rounded-full transition-all duration-300" 
                                                                         style="width: {{ $avgProgress }}%"></div>
                                                                </div>
                                                                <span class="text-sm font-semibold text-gray-900">{{ number_format($avgProgress, 0) }}%</span>
                                                                <span class="text-xs text-gray-500">({{ $progressInfo['completed_materi'] ?? 0 }}/{{ $totalMateri }})</span>
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Attendance Summary -->
                                                        <div class="flex items-center space-x-2">
                                                            <span class="text-sm text-gray-600">Absen:</span>
                                                            <div class="flex items-center space-x-1.5">
                                                                <span class="px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">{{ $hadirCount }}H</span>
                                                                <span class="px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">{{ $izinCount }}I</span>
                                                                <span class="px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">{{ $sakitCount }}S</span>
                                                                <span class="px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">{{ $alphaCount }}A</span>
                                                                <span class="text-xs text-gray-500 ml-1">Total: {{ $siswaPresensi->count() }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Expand Icon -->
                                            <div class="flex-shrink-0 ml-4">
                                                <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" 
                                                     :class="{ 'rotate-180': expandedStudents[{{ $s->id }}] }"
                                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </div>
                                        </div>
                                    </button>
                                    
                                    <!-- Expanded Content (Materi Details) -->
                                    <div x-show="expandedStudents[{{ $s->id }}]"
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                                         x-transition:enter-end="opacity-100 transform translate-y-0"
                                         x-transition:leave="transition ease-in duration-150"
                                         x-transition:leave-start="opacity-100 transform translate-y-0"
                                         x-transition:leave-end="opacity-0 transform -translate-y-2"
                                         class="border-t border-gray-200 bg-gray-50"
                                         style="display: none;">
                                        <div class="p-5">
                                            <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                Detail Materi & Absen
                                            </h4>
                                            
                                            <div class="space-y-3">
                                                @foreach($materiCollection->where('status', 'approved') as $m)
                                                    @php
                                                        $progress = $progressMap->get($m->id);
                                                        $percentage = $progress ? $progress->progress_percentage : 0;
                                                        
                                                        // Get all presensi for this material
                                                        $materiPresensi = $siswaPresensi->where('materi_id', $m->id)->sortByDesc('tanggal_akses');
                                                        $lastPresensi = $materiPresensi->first();
                                                    @endphp
                                                    
                                                    <div class="bg-white rounded-lg border border-gray-200 p-4 hover:shadow-sm transition-shadow">
                                                        <div class="flex items-start justify-between">
                                                            <!-- Materi Info -->
                                                            <div class="flex-1">
                                                                <div class="flex items-center space-x-2 mb-2">
                                                                    <h5 class="font-semibold text-gray-900">{{ $m->judul }}</h5>
                                                                    @if($progress && $progress->is_completed)
                                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                                            </svg>
                                                                            Selesai
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                
                                                                <!-- Progress Bar -->
                                                                <div class="mb-3">
                                                                    <div class="flex items-center justify-between mb-1">
                                                                        <span class="text-xs text-gray-600">Progress Pembelajaran</span>
                                                                        <span class="text-xs font-semibold text-gray-900">{{ number_format($percentage, 0) }}%</span>
                                                                    </div>
                                                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                                        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2.5 rounded-full transition-all duration-300" 
                                                                             style="width: {{ $percentage }}%"></div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <!-- Absen Kehadiran -->
                                                                <div class="mt-3 pt-3 border-t border-gray-200">
                                                                    <div class="flex items-center justify-between">
                                                                        <span class="text-xs font-medium text-gray-700">Kehadiran:</span>
                                                                        @if($materiPresensi->count() > 0)
                                                                            <button @click="$dispatch('toggle-presensi-{{ $s->id }}-{{ $m->id }}')" 
                                                                                    class="text-xs text-indigo-600 hover:text-indigo-800 font-medium flex items-center">
                                                                                Lihat Detail
                                                                                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                                                </svg>
                                                                            </button>
                                                                        @endif
                                                                    </div>
                                                                    
                                                                    @if($lastPresensi)
                                                                        <div class="mt-2 flex items-center space-x-2">
                                                                            <span class="px-2.5 py-1 rounded-full text-xs font-medium
                                                                                {{ $lastPresensi->status_kehadiran === 'hadir' ? 'bg-green-100 text-green-800' : 
                                                                                   ($lastPresensi->status_kehadiran === 'izin' ? 'bg-yellow-100 text-yellow-800' : 
                                                                                   ($lastPresensi->status_kehadiran === 'sakit' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                                                                {{ ucfirst($lastPresensi->status_kehadiran) }}
                                                                            </span>
                                                                            <span class="text-xs text-gray-500">
                                                                                {{ $lastPresensi->tanggal_akses->format('d M Y H:i') }}
                                                                            </span>
                                                                            @if($materiPresensi->count() > 1)
                                                                                <span class="text-xs text-gray-400">({{ $materiPresensi->count() }}x akses)</span>
                                                                            @endif
                                                                        </div>
                                                                    @else
                                                                        <p class="text-xs text-gray-400 mt-1">Belum ada kehadiran</p>
                                                                    @endif
                                                                    
                                                                    <!-- Detail Absen (Collapsible) -->
                                                                    <div x-data="{ showDetail: false }" 
                                                                         @toggle-presensi-{{ $s->id }}-{{ $m->id }}.window="showDetail = !showDetail"
                                                                         x-show="showDetail"
                                                                         x-transition:enter="transition ease-out duration-200"
                                                                         x-transition:enter-start="opacity-0"
                                                                         x-transition:enter-end="opacity-100"
                                                                         x-transition:leave="transition ease-in duration-150"
                                                                         x-transition:leave-start="opacity-100"
                                                                         x-transition:leave-end="opacity-0"
                                                                         class="mt-3 pt-3 border-t border-gray-200"
                                                                         style="display: none;">
                                                                        <div class="space-y-2">
                                                                            <p class="text-xs font-semibold text-gray-700 mb-2">Riwayat Kehadiran:</p>
                                                                            @foreach($materiPresensi as $pres)
                                                                                <div class="flex items-center justify-between p-2 bg-gray-50 rounded text-xs">
                                                                                    <div class="flex items-center space-x-2">
                                                                                        <span class="px-2 py-0.5 rounded text-xs font-medium
                                                                                            {{ $pres->status_kehadiran === 'hadir' ? 'bg-green-100 text-green-800' : 
                                                                                               ($pres->status_kehadiran === 'izin' ? 'bg-yellow-100 text-yellow-800' : 
                                                                                               ($pres->status_kehadiran === 'sakit' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                                                                            {{ ucfirst($pres->status_kehadiran) }}
                                                                                        </span>
                                                                                        <span class="text-gray-600">{{ $pres->tanggal_akses->format('d M Y, H:i') }}</span>
                                                                                    </div>
                                                                                    @if($pres->pertemuan)
                                                                                        <span class="text-gray-500">Pertemuan: {{ $pres->pertemuan->judul_pertemuan }}</span>
                                                                                    @endif
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Status Icon -->
                                                            <div class="ml-4 flex-shrink-0">
                                                                @if($progress && $progress->is_completed)
                                                                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                                                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                                        </svg>
                                                                    </div>
                                                                @elseif($percentage > 0)
                                                                    <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                                                                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                        </svg>
                                                                    </div>
                                                                @else
                                                                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                                        </svg>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white rounded-xl shadow-md p-12 text-center">
                            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Data Progress</h3>
                            <p class="text-gray-600">Belum ada data progress untuk ditampilkan.</p>
                        </div>
                    @endif
                </div>

                <!-- Tab: Kehadiran -->
                <div x-show="openTab === 'kehadiran'" class="p-6">
                    @if($presensi->count() > 0)
                        <div class="space-y-4">
                            @foreach($presensi as $materiId => $presensiRecords)
                                @php
                                    $currentMateri = $materi->firstWhere('id', $materiId);
                                @endphp
                                @if($currentMateri)
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <h4 class="font-medium text-gray-900 mb-3">{{ $currentMateri->judul }}</h4>
                                        <div class="overflow-x-auto">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama Siswa</th>
                                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Akses</th>
                                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    @foreach($presensiRecords as $p)
                                                        <tr>
                                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $p->user->name ?? 'N/A' }}</td>
                                                            <td class="px-4 py-2 text-sm text-gray-500">
                                                                @php
                                                                    // Handle both Carbon instance and string
                                                                    $tanggalAkses = $p->tanggal_akses;
                                                                    if (is_string($tanggalAkses)) {
                                                                        $tanggalAkses = \Carbon\Carbon::parse($tanggalAkses);
                                                                    }
                                                                @endphp
                                                                {{ $tanggalAkses ? $tanggalAkses->format('d M Y H:i') : 'N/A' }}
                                                            </td>
                                                            <td class="px-4 py-2">
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                                    {{ $p->status_kehadiran === 'hadir' ? 'bg-green-100 text-green-800' : 
                                                                       ($p->status_kehadiran === 'izin' ? 'bg-yellow-100 text-yellow-800' : 
                                                                       ($p->status_kehadiran === 'sakit' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                                                    {{ ucfirst($p->status_kehadiran) }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">Belum ada data kehadiran untuk ditampilkan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

