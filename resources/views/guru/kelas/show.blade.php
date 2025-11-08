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
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $kelas->bidang === 'coding' ? 'bg-blue-100 text-blue-800' : 
                               ($kelas->bidang === 'desain' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800') }}">
                            {{ ucfirst($kelas->bidang) }}
                        </span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Total Siswa</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $siswa->count() }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Total Materi</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $materi->count() }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Materi Disetujui</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $materi->where('status', 'approved')->count() }}</p>
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
                            Daftar Siswa ({{ $siswa->count() }})
                        </button>
                        <button @click="openTab = 'materi'" 
                                :class="{ 'border-indigo-500 text-indigo-600': openTab === 'materi', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': openTab !== 'materi' }" 
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Materi ({{ $materi->count() }})
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
                    @if($siswa->count() > 0)
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
                                    @foreach($siswa as $s)
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
                                                <span class="text-sm font-medium text-gray-900">{{ $completedCount }} / {{ $materi->count() }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm font-medium text-gray-900">{{ $presensiCount }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $s->pivot->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $s->pivot->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
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
                    @if($materi->count() > 0)
                        <div class="space-y-4">
                            @foreach($materi as $m)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <h4 class="text-lg font-medium text-gray-900">{{ $m->judul }}</h4>
                                            <p class="text-sm text-gray-600 mt-1">{{ Str::limit($m->deskripsi, 100) }}</p>
                                            <div class="flex items-center space-x-4 mt-2">
                                                <span class="text-xs text-gray-500">Tipe: {{ $m->file_type }}</span>
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                    {{ $m->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                                       ($m->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                    {{ ucfirst($m->status) }}
                                                </span>
                                            </div>
                                            @php
                                                $accessInfo = $materiAccess[$m->id] ?? null;
                                                $accessedCount = $accessInfo['accessed_by']->count() ?? 0;
                                                $completedCount = $accessInfo['completed_by']->count() ?? 0;
                                            @endphp
                                            <div class="mt-3 flex items-center space-x-6 text-sm text-gray-600">
                                                <span>Diakses oleh: <strong>{{ $accessedCount }}</strong> siswa</span>
                                                <span>Selesai: <strong>{{ $completedCount }}</strong> siswa</span>
                                            </div>
                                        </div>
                                        <div class="ml-4 flex space-x-2">
                                            <a href="{{ route('guru.materi.show', $m) }}" class="px-3 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 text-sm">
                                                Lihat
                                            </a>
                                            @if($m->status === 'approved')
                                                <a href="{{ route('guru.materi.edit', $m) }}" class="px-3 py-1 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 text-sm">
                                                    Edit
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">Belum ada materi untuk kelas ini.</p>
                    @endif
                </div>

                <!-- Tab: Progress Siswa -->
                <div x-show="openTab === 'progress'" class="p-6">
                    @if($siswa->count() > 0 && $materi->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                        @foreach($materi->where('status', 'approved') as $m)
                                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{ Str::limit($m->judul, 20) }}
                                            </th>
                                        @endforeach
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Progress Total</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($siswa as $s)
                                        @php
                                            $progressInfo = $progressData[$s->id] ?? null;
                                            $progresses = $progressInfo['progress'] ?? collect();
                                            $progressMap = $progresses->keyBy('materi_id');
                                            $totalProgress = 0;
                                            $totalMateri = $materi->where('status', 'approved')->count();
                                        @endphp
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $s->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $s->email }}</div>
                                            </td>
                                            @foreach($materi->where('status', 'approved') as $m)
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
                                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $p->user->name }}</td>
                                                            <td class="px-4 py-2 text-sm text-gray-500">{{ $p->tanggal_akses->format('d M Y H:i') }}</td>
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

