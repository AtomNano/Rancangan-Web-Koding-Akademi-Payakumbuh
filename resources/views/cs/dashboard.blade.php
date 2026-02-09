<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 leading-tight">
                    {{ __('Dashboard Customer Service') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Selamat datang kembali, {{ Auth::user()->name }}! Kelola data
                    siswa dengan mudah.</p>
            </div>
        </div>
    </x-slot>

    <!-- Welcome Banner -->
    <div
        class="relative overflow-hidden rounded-xl bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 p-8 mb-8 shadow-xl border border-slate-700/50">
        <div class="absolute inset-0 bg-grid-white/10 [mask-image:linear-gradient(0deg,white,rgba(255,255,255,0.6))]">
        </div>
        <div class="relative flex items-center justify-between">
            <div>
                <h3 class="text-3xl font-bold text-white mb-2">Selamat Datang, Customer Service!</h3>
                <p class="text-slate-300 text-lg">Kelola pendaftaran dan data siswa Coding Academy.</p>
            </div>
            <div class="hidden md:block text-white text-right">
                <div x-data="liveClock()" x-init="init()" class="text-3xl font-bold" x-text="time"></div>
                <p class="text-slate-300 text-sm mt-1">Zona Waktu: Asia/Jakarta</p>
            </div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="mb-8">
        <form action="{{ route('cs.siswa.index') }}" method="GET" class="relative">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="text" name="search" id="search"
                    class="block w-full pl-10 pr-3 py-4 border border-slate-200 rounded-xl leading-5 bg-white placeholder-slate-400 focus:outline-none focus:placeholder-slate-500 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 sm:text-sm shadow-sm transition-all duration-200"
                    placeholder="Cari siswa berdasarkan nama atau email..." autocomplete="off">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                        Cari
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <a href="{{ route('cs.siswa.index') }}"
            class="group block p-6 bg-white rounded-xl shadow-sm hover:shadow-lg border border-slate-200 hover:border-blue-300 transition-all duration-200">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <p class="text-sm font-medium text-slate-600 mb-1">Total Siswa</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $stats['total_siswa'] }}</p>
                    <p class="text-xs text-slate-500 mt-2">Semua siswa terdaftar</p>
                </div>
                <div
                    class="bg-gradient-to-br from-blue-500 to-blue-600 p-3 rounded-xl shadow-lg shadow-blue-500/20 group-hover:scale-110 transition-transform">
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m-4.5 3.903A2.5 2.5 0 017 15h10a2.5 2.5 0 012.5 2.5V21" />
                    </svg>
                </div>
            </div>
        </a>

        <a href="{{ route('cs.siswa.index', ['status' => 'active']) }}"
            class="group block p-6 bg-white rounded-xl shadow-sm hover:shadow-lg border border-slate-200 hover:border-emerald-300 transition-all duration-200">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <p class="text-sm font-medium text-slate-600 mb-1">Siswa Aktif</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $stats['siswa_aktif'] }}</p>
                    <p class="text-xs text-slate-500 mt-2">Siswa dengan status aktif</p>
                </div>
                <div
                    class="bg-gradient-to-br from-emerald-500 to-emerald-600 p-3 rounded-xl shadow-lg shadow-emerald-500/20 group-hover:scale-110 transition-transform">
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </a>

        <a href="{{ route('cs.siswa.index', ['status' => 'inactive']) }}"
            class="group block p-6 bg-white rounded-xl shadow-sm hover:shadow-lg border border-slate-200 hover:border-amber-300 transition-all duration-200">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <p class="text-sm font-medium text-slate-600 mb-1">Siswa Tidak Aktif</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $stats['siswa_tidak_aktif'] }}</p>
                    <p class="text-xs text-slate-500 mt-2">Siswa dengan status tidak aktif</p>
                </div>
                <div
                    class="bg-gradient-to-br from-amber-500 to-amber-600 p-3 rounded-xl shadow-lg shadow-amber-500/20 group-hover:scale-110 transition-transform">
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </a>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 mb-8">
        <h4 class="text-lg font-bold text-slate-900 mb-4">Aksi Cepat</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('cs.siswa.create', ['role' => 'siswa']) }}"
                class="flex items-center p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg border border-blue-200 hover:border-blue-300 hover:shadow-md transition-all duration-200 group">
                <div class="bg-blue-500 p-3 rounded-lg mr-4 group-hover:scale-110 transition-transform">
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-slate-900">Tambah Siswa Baru</p>
                    <p class="text-sm text-slate-600">Daftarkan siswa baru ke sistem</p>
                </div>
            </a>

            <a href="{{ route('cs.siswa.index') }}"
                class="flex items-center p-4 bg-gradient-to-r from-emerald-50 to-emerald-100 rounded-lg border border-emerald-200 hover:border-emerald-300 hover:shadow-md transition-all duration-200 group">
                <div class="bg-emerald-500 p-3 rounded-lg mr-4 group-hover:scale-110 transition-transform">
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-slate-900">Kelola Data Siswa</p>
                    <p class="text-sm text-slate-600">Lihat dan edit data siswa</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-8">
        <!-- Recent Students (4/5) -->
        <div class="lg:col-span-4 bg-white rounded-xl shadow-sm border border-slate-200 flex flex-col">
            <div class="p-6 border-b border-slate-200 flex justify-between items-center">
                <h4 class="text-lg font-bold text-slate-900">Siswa Terbaru</h4>
                <a href="{{ route('cs.siswa.index') }}"
                    class="text-sm text-blue-600 hover:text-blue-800 font-medium">Lihat Semua</a>
            </div>
            <div class="p-0 overflow-x-auto flex-1">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider whitespace-nowrap">
                                Siswa</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider whitespace-nowrap">
                                ID Siswa</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider whitespace-nowrap">
                                Kelas</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider whitespace-nowrap">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recent_students as $student)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <div
                                                class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold">
                                                {{ substr($student->name, 0, 2) }}
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-slate-900">{{ $student->name }}</div>
                                            <div class="text-xs text-slate-500">{{ $student->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-800">
                                        {{ $student->student_id ?: $student->id_siswa ?: '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($student->enrolledClasses->count() > 0)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $student->enrolledClasses->first()->nama_kelas }}
                                            @if($student->enrolledClasses->count() > 1)
                                                +{{ $student->enrolledClasses->count() - 1 }}
                                            @endif
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($student->is_active)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Aktif</span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">Nonaktif</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-slate-500">Belum ada data siswa.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Logs (1/5) -->
        <div class="lg:col-span-1 bg-white rounded-xl shadow-sm border border-slate-200 flex flex-col">
            <div class="p-4 border-b border-slate-200">
                <h4 class="text-lg font-bold text-slate-900">Aktivitas</h4>
            </div>
            <div class="p-4 space-y-4 overflow-y-auto max-h-[400px]">
                @forelse($recent_logs as $log)
                    <div class="relative pl-4 border-l-2 border-slate-200 pb-1 last:pb-0">
                        <div
                            class="absolute -left-[5.5px] top-1.5 h-2.5 w-2.5 rounded-full bg-indigo-400 border-2 border-white">
                        </div>
                        <p class="text-xs text-slate-500 mb-0.5">{{ $log->created_at->diffForHumans() }}</p>
                        <p class="text-sm font-medium text-slate-800 leading-snug">{{ $log->description }}</p>
                    </div>
                @empty
                    <p class="text-sm text-slate-500 text-center italic">Belum ada aktivitas.</p>
                @endforelse
            </div>
            <div class="p-4 border-t border-slate-200 bg-slate-50 rounded-b-xl text-center">
                <a href="{{ route('cs.logs') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800">Lihat
                    Semua &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Information Panel -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
        <h4 class="text-lg font-bold text-slate-900 mb-4">Informasi</h4>
        <div class="space-y-3">
            <div class="flex items-start p-4 bg-blue-50 rounded-lg border border-blue-200">
                <svg class="h-5 w-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <p class="font-semibold text-slate-900 text-sm">Akses Customer Service</p>
                    <p class="text-sm text-slate-600 mt-1">Anda memiliki akses untuk mengelola data siswa, mendaftarkan
                        siswa ke kelas, dan mengubah status siswa.</p>
                </div>
            </div>
            <div class="flex items-start p-4 bg-amber-50 rounded-lg border border-amber-200">
                <svg class="h-5 w-5 text-amber-600 mt-0.5 mr-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div>
                    <p class="font-semibold text-slate-900 text-sm">Batasan Akses</p>
                    <p class="text-sm text-slate-600 mt-1">Anda tidak memiliki akses untuk mengelola guru, kelas,
                        materi, atau pengaturan sistem lainnya.</p>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

<script>
    function liveClock() {
        return {
            time: new Date().toLocaleString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                timeZone: 'Asia/Jakarta'
            }),
            init() {
                setInterval(() => {
                    this.time = new Date().toLocaleString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        timeZone: 'Asia/Jakarta'
                    });
                }, 1000);
            }
        }
    }
</script>