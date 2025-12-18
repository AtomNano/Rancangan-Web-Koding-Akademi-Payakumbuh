<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('admin.kelas.index') }}" class="text-indigo-500 hover:text-indigo-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="ml-3 font-semibold text-xl text-gray-800 dark:text-gray-800 leading-tight">
                {{ __('Detail Kelas') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative">
                    <!-- Background Image -->
                    <div class="h-56 bg-indigo-600 dark:bg-indigo-600 rounded-t-lg bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1471&q=80');">
                        <div class="h-full w-full bg-black bg-opacity-50 flex items-center justify-center rounded-t-lg">
                            <h1 class="text-4xl font-bold text-white text-center px-4">{{ $kelas->nama_kelas }}</h1>
                        </div>
                    </div>
                    
                    <!-- Main Content -->
                    <div class="p-6 sm:p-8 text-gray-900 dark:text-gray-900">
                        <p class="text-gray-600 dark:text-gray-600 mb-4 text-center max-w-3xl mx-auto">{{ $kelas->deskripsi }}</p>
                        <div class="text-center mb-8">
                            <p class="text-gray-700 dark:text-gray-700"><strong>Guru Pengajar:</strong> {{ $kelas->guru->name ?? 'N/A' }}</p>
                        </div>

                        {{-- Main Statistics --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <div class="bg-white dark:bg-white p-6 rounded-xl shadow-md flex items-center space-x-4">
                                <div class="bg-blue-500 p-3 rounded-full">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-lg text-gray-700 dark:text-gray-700">Jumlah Siswa</h4>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-900">{{ count($studentsProgress) }}</p>
                                </div>
                            </div>
                            <div class="bg-white dark:bg-white p-6 rounded-xl shadow-md flex items-center space-x-4">
                                <div class="bg-green-500 p-3 rounded-full">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-lg text-gray-700 dark:text-gray-700">Jumlah Materi</h4>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-900">{{ $materi->total() }}</p>
                                </div>
                            </div>
                            <div class="bg-white dark:bg-white p-6 rounded-xl shadow-md">
                                <h4 class="font-semibold text-lg text-gray-700 dark:text-gray-700 mb-2">Progress Rata-Rata</h4>
                                <div class="w-full bg-gray-200 rounded-full h-4 dark:bg-gray-200">
                                    <div class="bg-purple-600 h-4 rounded-full" style="width: {{ $classProgress }}%"></div>
                                </div>
                                <p class="text-right text-sm text-gray-600 dark:text-gray-600 mt-1">{{ $classProgress }}% Selesai</p>
                            </div>
                        </div>

                        {{-- Informasi Guru --}}
                        <div class="mt-8">
                            <h4 class="text-xl font-semibold mb-4">Informasi Pengajar</h4>
                            @if ($kelas->guru)
                                <div class="bg-white dark:bg-white p-4 rounded-lg shadow flex items-center space-x-4">
                        {{-- Tabbed View --}}
                        <div x-data="{ openTab: 'materi' }" class="mt-8">
                            <div class="border-b border-gray-200 dark:border-gray-200">
                                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                                    <button @click="openTab = 'materi'" :class="{ 'border-indigo-500 text-indigo-600 dark:text-indigo-600': openTab === 'materi', 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-700 hover:border-gray-300 dark:hover:border-gray-400': openTab !== 'materi' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                        Materi
                                    </button>
                                    <button @click="openTab = 'peserta'" :class="{ 'border-indigo-500 text-indigo-600 dark:text-indigo-600': openTab === 'peserta', 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-700 hover:border-gray-300 dark:hover:border-gray-400': openTab !== 'peserta' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                        Peserta (Siswa)
                                    </button>
                                    <button @click="openTab = 'pengajar'" :class="{ 'border-indigo-500 text-indigo-600 dark:text-indigo-600': openTab === 'pengajar', 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-700 hover:border-gray-300 dark:hover:border-gray-400': openTab !== 'pengajar' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                        Pengajar (Guru)
                                    </button>
                                </nav>
                            </div>

                            <div x-show="openTab === 'materi'" class="mt-6">
                                <h4 class="text-xl font-semibold mb-4">Daftar Materi</h4>
                                @if ($materi->count() > 0)
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-200">
                                            <thead class="bg-white dark:bg-white">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-500 uppercase tracking-wider">Judul</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-500 uppercase tracking-wider">Tipe</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-500 uppercase tracking-wider">Status</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-500 uppercase tracking-wider">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white dark:bg-white divide-y divide-gray-200 dark:divide-gray-200">
                                                @foreach ($materi as $item)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->judul }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->file_type }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->status }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                            @if ($item->status === 'approved')
                                                                <a href="{{ route('admin.materi.show', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-600 dark:hover:text-indigo-800">Lihat Materi</a>
                                                            @else
                                                                <span class="text-gray-500 dark:text-gray-500">Menunggu Persetujuan</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt-4">
                                        {{ $materi->links() }}
                                    </div>
                                @else
                                    <p>Belum ada materi untuk kelas ini.</p>
                                @endif
                            </div>

                            <div x-show="openTab === 'peserta'" class="mt-6">
                                <h4 class="text-xl font-semibold mb-4">Daftar Peserta</h4>
                                @if (count($studentsProgress) > 0)
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-200">
                                            <thead class="bg-gray-100 dark:bg-gray-100">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-500 uppercase tracking-wider">ID Siswa</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-500 uppercase tracking-wider">Email</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-500 uppercase tracking-wider">Progress Individual</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-500 uppercase tracking-wider">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white dark:bg-white divide-y divide-gray-200 dark:divide-gray-200">
                                                @foreach ($studentsProgress as $studentData)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap">{{ $studentData['student']->name }}</td>
                                                        @php $displayId = $studentData['student']->student_id ?? $studentData['student']->id_siswa; @endphp
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            @if($displayId)
                                                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-700">{{ $displayId }}</span>
                                                            @else
                                                                <span class="text-gray-400 italic">Belum diisi</span>
                                                            @endif
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">{{ $studentData['student']->email }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-200">
                                                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $studentData['progress'] }}%"></div>
                                                            </div>
                                                            <p class="text-xs text-gray-600 dark:text-gray-600 mt-1">{{ $studentData['completed_materi_count'] }} dari {{ $studentData['total_approved_materi'] }} Materi ({{ $studentData['progress'] }}%)</p>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-3">
                                                            <a href="{{ route('admin.kelas.student.progress', ['kelas' => $kelas->id, 'siswa' => $studentData['student']->id]) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-600 dark:hover:text-blue-800">Lihat Progress</a>
                                                            <a href="{{ route('admin.kelas.student.log.export', ['kelas' => $kelas->id, 'user' => $studentData['student']->id]) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-600 dark:hover:text-indigo-800">Export Log Belajar</a>
                                                            <form action="{{ route('admin.kelas.unenroll', ['kelas' => $kelas->id, 'user' => $studentData['student']->id]) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin mengeluarkan siswa ini dari kelas?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-600 dark:hover:text-red-800">Keluarkan</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p>Belum ada siswa terdaftar di kelas ini.</p>
                                @endif
                            </div>

                            <div x-show="openTab === 'pengajar'" class="mt-6">
                                <h4 class="text-xl font-semibold mb-4">Informasi Pengajar</h4>
                                @if ($kelas->guru)
                                    <div class="bg-white dark:bg-white p-4 rounded-lg shadow flex items-center space-x-4">
                                        <img class="h-16 w-16 rounded-full object-cover" src="{{ $kelas->guru->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($kelas->guru->name) . '&color=7F9CF5&background=EBF4FF' }}" alt="{{ $kelas->guru->name }}">
                                        <div>
                                            <p class="text-lg font-semibold">{{ $kelas->guru->name }}</p>
                                            <p class="text-gray-600 dark:text-gray-600">{{ $kelas->guru->email }}</p>
                                            <p class="text-gray-600 dark:text-gray-600">Bidang: {{ $kelas->guru->bidang ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                @else
                                    <p>Belum ada guru yang ditunjuk untuk kelas ini.</p>
                                @endif
                            </div>
                        </div>
                                    <div>
                                        <p class="text-lg font-semibold">{{ $kelas->guru->name }}</p>
                                        <p class="text-gray-600 dark:text-gray-600">{{ $kelas->guru->email }}</p>
                                        <p class="text-gray-600 dark:text-gray-600">Bidang: {{ $kelas->guru->bidang ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            @else
                                <p>Belum ada guru yang ditunjuk untuk kelas ini.</p>
                            @endif
                        </div>

                        <div class="mt-8 flex flex-col space-y-4">
                            <!-- Primary Action: Manage Pertemuan -->
                            <a href="{{ route('admin.pertemuan.index', $kelas) }}" class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-cyan-600 to-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:from-cyan-700 hover:to-blue-700 active:from-cyan-800 active:to-blue-800 focus:outline-none focus:border-cyan-800 focus:ring ring-cyan-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Kelola Pertemuan & Absen
                            </a>

                            <!-- Secondary Actions -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <a href="{{ route('admin.kelas.attendance.export', $kelas) }}" class="inline-flex items-center justify-center px-4 py-2 bg-amber-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-700 active:bg-amber-800 focus:outline-none focus:border-amber-800 focus:ring ring-amber-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Export Kehadiran
                                </a>
                                <a href="{{ route('admin.kelas.enroll', $kelas) }}" class="inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-800 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Daftarkan Siswa
                                </a>
                                <a href="{{ route('admin.kelas.edit', $kelas) }}" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit Kelas
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>