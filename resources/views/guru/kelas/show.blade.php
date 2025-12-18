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
                            <table class="w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-gray-100 to-gray-50 border-b-2 border-gray-200">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID Siswa</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Nama</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Materi Selesai</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Total Kehadiran</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($siswaCollection as $s)
                                        @php
                                            $progressInfo = $progressData[$s->id] ?? null;
                                            $completedCount = $progressInfo['completed_materi'] ?? 0;
                                            $presensiCount = $progressInfo['presensi_count'] ?? 0;
                                        @endphp
                                        <tr class="hover:bg-indigo-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    @php $displayId = $s->student_id ?? $s->id_siswa; @endphp
                                                    @if($displayId)
                                                        <div class="flex flex-col">
                                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-indigo-100 text-indigo-800 text-xs font-mono font-bold">
                                                                {{ $displayId }}
                                                            </span>
                                                        </div>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-gray-100 text-gray-500 text-xs italic">
                                                            Belum diisi
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center shadow">
                                                            <span class="text-white font-bold text-sm">{{ substr($s->name, 0, 2) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-semibold text-gray-900">{{ $s->name }}</div>
                                                        @php $displayId = $s->student_id ?? $s->id_siswa; @endphp
                                                        <div class="text-xs text-gray-500 mt-0.5">
                                                            @if($displayId)
                                                                ID: <span class="font-semibold text-indigo-600">{{ $displayId }}</span>
                                                            @else
                                                                <span class="italic">ID belum diisi</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $s->email }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $totalApprovedMateri = $progressInfo['total_materi'] ?? $materiCollection->where('status', 'approved')->count();
                                                @endphp
                                                <div class="flex items-center">
                                                    <span class="text-sm font-bold text-gray-900 mr-2">{{ $completedCount }} / {{ $totalApprovedMateri }}</span>
                                                    @php
                                                        $percentage = $totalApprovedMateri > 0 ? round(($completedCount / $totalApprovedMateri) * 100) : 0;
                                                    @endphp
                                                    <div class="w-12 h-2 bg-gray-200 rounded-full overflow-hidden">
                                                        <div class="h-full bg-gradient-to-r from-green-400 to-green-600 rounded-full transition-all" style="width: {{ $percentage }}%"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                                        @if($presensiCount >= 3)
                                                            bg-green-100 text-green-800
                                                        @elseif($presensiCount >= 1)
                                                            bg-yellow-100 text-yellow-800
                                                        @else
                                                            bg-gray-100 text-gray-800
                                                        @endif
                                                    ">
                                                        {{ $presensiCount }}
                                                    </div>
                                                    <span class="text-xs text-gray-500 ml-2">pertemuan</span>
                                                </div>
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
                                                <div class="inline-flex items-center">
                                                    @if($enrollmentStatus === 'active')
                                                        <div class="flex items-center">
                                                            <div class="h-2 w-2 bg-green-500 rounded-full mr-2"></div>
                                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">Aktif</span>
                                                        </div>
                                                    @else
                                                        <div class="flex items-center">
                                                            <div class="h-2 w-2 bg-red-500 rounded-full mr-2"></div>
                                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">Tidak Aktif</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('guru.siswa.progress', [$kelas->id, $s->id]) }}" 
                                                   class="inline-flex items-center px-4 py-2 text-indigo-600 hover:text-white bg-indigo-50 hover:bg-indigo-600 rounded-lg transition-all duration-200 font-semibold text-xs">
                                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                                    </svg>
                                                    Lihat Progress
                                                </a>
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
<!-- Tab: Kehadiran -->
                <div x-show="openTab === 'kehadiran'" class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-yellow-50 border-2 border-yellow-200 rounded-xl shadow-md p-5">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-yellow-600 text-sm font-medium mb-1">Rata-rata Kehadiran</p>
                                    <p class="text-3xl font-bold text-yellow-900">
                                        @php
                                            $totalKehadiran = $totalHadir + $totalIzin + $totalSakit + $totalAlpha;
                                            $rataKehadiran = $totalKehadiran > 0 ? round(($totalHadir / $totalKehadiran) * 100, 1) : 0;
                                        @endphp
                                        {{ $rataKehadiran }}%
                                    </p>
                                </div>
                                <div class="bg-yellow-100 rounded-lg p-3">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-purple-50 border-2 border-purple-200 rounded-xl shadow-md p-5">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-purple-600 text-sm font-medium mb-1">Total Pertemuan</p>
                                    <p class="text-3xl font-bold text-purple-900">{{ $materiCollection->count() + count($pertemuanIds) }}</p>
                                </div>
                                <div class="bg-purple-100 rounded-lg p-3">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-green-100 rounded-lg p-4 text-center">
                            <p class="text-green-600 text-sm font-medium mb-1">Hadir</p>
                            <p class="text-3xl font-bold text-green-800">{{ $totalHadir }}</p>
                        </div>
                        <div class="bg-yellow-100 rounded-lg p-4 text-center">
                            <p class="text-yellow-600 text-sm font-medium mb-1">Izin</p>
                            <p class="text-3xl font-bold text-yellow-800">{{ $totalIzin }}</p>
                        </div>
                        <div class="bg-blue-100 rounded-lg p-4 text-center">
                            <p class="text-blue-600 text-sm font-medium mb-1">Sakit</p>
                            <p class="text-3xl font-bold text-blue-800">{{ $totalSakit }}</p>
                        </div>
                        <div class="bg-red-100 rounded-lg p-4 text-center">
                            <p class="text-red-600 text-sm font-medium mb-1">Alpha</p>
                            <p class="text-3xl font-bold text-red-800">{{ $totalAlpha }}</p>
                        </div>
                    </div>

                    @if($siswaCollection->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Hadir</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Izin</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Sakit</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Alpha</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($siswaCollection as $s)
                                        @php
                                            $siswaMateriPresensi = \App\Models\Presensi::where('user_id', $s->id)
                                                ->whereIn('materi_id', $materiCollection->pluck('id'))
                                                ->get();

                                            $siswaPertemuanPresensi = \App\Models\Presensi::where('user_id', $s->id)
                                                ->whereIn('pertemuan_id', $pertemuanIds)
                                                ->get();

                                            $siswaPresensi = $siswaMateriPresensi->merge($siswaPertemuanPresensi);

                                            $hadirCount = $siswaPresensi->where('status_kehadiran', 'hadir')->count();
                                            $izinCount = $siswaPresensi->where('status_kehadiran', 'izin')->count();
                                            $sakitCount = $siswaPresensi->where('status_kehadiran', 'sakit')->count();
                                            $alphaCount = $siswaPresensi->where('status_kehadiran', 'alpha')->count();
                                            $totalPersensi = $hadirCount + $izinCount + $sakitCount + $alphaCount;
                                        @endphp
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <div class="h-10 w-10 rounded-full bg-indigo-200 flex items-center justify-center">
                                                            <span class="text-indigo-700 font-bold text-sm">{{ substr($s->name, 0, 2) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $s->name }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $s->email }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ $hadirCount }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    {{ $izinCount }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    {{ $sakitCount }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    {{ $alphaCount }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <span class="text-sm font-medium text-gray-900">{{ $totalPersensi }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="bg-white rounded-xl shadow-md p-12 text-center">
                            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Data Kehadiran</h3>
                            <p class="text-gray-600">Belum ada data kehadiran untuk ditampilkan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

