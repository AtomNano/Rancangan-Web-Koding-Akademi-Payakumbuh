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
                    
                    @if(config('app.debug') || !isset($kelas) || !$kelas || !$kelas->id)
                        <div class="mt-4 p-4 bg-red-50 border border-red-300 rounded text-sm">
                            <p class="font-semibold text-red-800 mb-2">⚠️ Error: Kelas Tidak Ditemukan!</p>
                            @if(!isset($kelas) || !$kelas || !$kelas->id)
                                <p class="text-red-700 mb-2">
                                    <strong>Masalah:</strong> Kelas tidak ter-load dengan benar. Kemungkinan:
                                </p>
                                <ul class="list-disc list-inside text-red-700 mb-2 space-y-1">
                                    <li>Kelas ID tidak valid di URL</li>
                                    <li>Kelas tidak ditemukan di database</li>
                                    <li>Route model binding tidak bekerja</li>
                                </ul>
                                <p class="text-red-700 mb-2">
                                    <strong>Solusi:</strong>
                                </p>
                                <ol class="list-decimal list-inside text-red-700 space-y-1">
                                    <li>Pastikan URL benar: <code>/guru/kelas/{id}</code> (ganti {id} dengan ID kelas yang valid)</li>
                                    <li>Cek di admin panel apakah kelas ada dan sudah di-assign ke guru ID {{ auth()->id() }}</li>
                                    <li>Jalankan query: <code>SELECT * FROM kelas WHERE id = {id_dari_url};</code></li>
                                    <li>Jika kelas ada tapi tidak di-assign, jalankan: <code>UPDATE kelas SET guru_id = {{ auth()->id() }} WHERE id = {id_dari_url};</code></li>
                                </ol>
                            @endif
                            
                            @if(config('app.debug'))
                                <div class="mt-4 p-3 bg-yellow-50 border border-yellow-300 rounded">
                                    <p class="font-semibold text-yellow-800 mb-2">Debug Info:</p>
                                    <p class="text-yellow-700">Kelas ID: {{ $kelas->id ?? 'NULL' }}</p>
                                    <p class="text-yellow-700">Kelas Nama: {{ $kelas->nama_kelas ?? 'NULL' }}</p>
                                    <p class="text-yellow-700">Kelas Guru ID: {{ $kelas->guru_id ?? 'NULL' }}</p>
                                    <p class="text-yellow-700">Guru ID Anda: {{ auth()->id() }}</p>
                                    <p class="text-yellow-700">Siswa variable exists: {{ isset($siswa) ? 'Yes' : 'No' }}</p>
                                    <p class="text-yellow-700">Materi variable exists: {{ isset($materi) ? 'Yes' : 'No' }}</p>
                                    <p class="text-yellow-700">Siswa count: {{ isset($siswa) && $siswa ? $siswa->count() : 0 }}</p>
                                    <p class="text-yellow-700">Materi count: {{ isset($materi) && $materi ? $materi->count() : 0 }}</p>
                                    <p class="text-yellow-700">Is Guru Assigned: {{ isset($isGuruAssigned) && $isGuruAssigned ? 'Yes' : 'No' }}</p>
                                    <p class="text-yellow-700">Is Guru Enrolled: {{ isset($isGuruEnrolled) && $isGuruEnrolled ? 'Yes' : 'No' }}</p>
                                    <p class="text-yellow-700 mt-2">Cek log Laravel untuk detail lebih lanjut.</p>
                                </div>
                            @endif
                        </div>
                    @endif
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
                            Progress Siswa
                        </button>
                        <button @click="openTab = 'kehadiran'" 
                                :class="{ 'border-indigo-500 text-indigo-600': openTab === 'kehadiran', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': openTab !== 'kehadiran' }" 
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Kehadiran
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
                    <div class="mb-4">
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
                <div x-show="openTab === 'progress'" class="p-6">
                    @if($siswaCollection->count() > 0 && $materiCollection->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                        @foreach($materiCollection->where('status', 'approved') as $m)
                                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{ Str::limit($m->judul, 20) }}
                                            </th>
                                        @endforeach
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Progress Total</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($siswaCollection as $s)
                                        @php
                                            $progressInfo = $progressData[$s->id] ?? null;
                                            $progresses = $progressInfo['progress'] ?? collect();
                                            $progressMap = $progresses->keyBy('materi_id');
                                            $totalProgress = 0;
                                            $totalMateri = $materiCollection->where('status', 'approved')->count();
                                        @endphp
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $s->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $s->email }}</div>
                                            </td>
                                            @foreach($materiCollection->where('status', 'approved') as $m)
                                                @php
                                                    $progress = $progressMap->get($m->id);
                                                    $percentage = $progress ? $progress->progress_percentage : 0;
                                                    if($progress && $progress->is_completed) {
                                                        $totalProgress++;
                                                    }
                                                @endphp
                                                <td class="px-4 py-4 text-center">
                                                    @if($progress)
                                                        <div class="inline-block">
                                                            <div class="w-16 bg-gray-200 rounded-full h-2">
                                                                <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                                            </div>
                                                            <span class="text-xs text-gray-600 block mt-1">{{ number_format($percentage, 0) }}%</span>
                                                        </div>
                                                        @if($progress->is_completed)
                                                            <svg class="w-5 h-5 text-green-500 mx-auto mt-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                            </svg>
                                                        @endif
                                                    @else
                                                        <span class="text-xs text-gray-400">-</span>
                                                    @endif
                                                </td>
                                            @endforeach
                                            <td class="px-6 py-4 text-center">
                                                @php
                                                    $avgProgress = $totalMateri > 0 ? ($totalProgress / $totalMateri) * 100 : 0;
                                                @endphp
                                                <div class="inline-block">
                                                    <div class="w-24 bg-gray-200 rounded-full h-3">
                                                        <div class="bg-indigo-600 h-3 rounded-full" style="width: {{ $avgProgress }}%"></div>
                                                    </div>
                                                    <span class="text-xs font-medium text-gray-900 block mt-1">{{ number_format($avgProgress, 0) }}%</span>
                                                    <span class="text-xs text-gray-500">{{ $totalProgress }}/{{ $totalMateri }} selesai</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">Belum ada data progress untuk ditampilkan.</p>
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
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                    Hadir
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

