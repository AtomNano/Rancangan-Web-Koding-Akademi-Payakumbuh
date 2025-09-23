<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
        <p class="text-sm text-gray-500">Kelola platform Materi Online</p>
    </x-slot>

    <!-- Welcome Banner -->
    <div class="p-6 mb-6 text-white rounded-lg shadow-md" style="background: linear-gradient(90deg, #6B46C1 0%, #9F7AEA 100%);">
        <h3 class="text-2xl font-bold">Selamat Datang, Admin!</h3>
        <p>Kelola platform e-learning Materi Online dengan mudah.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <a href="{{ route('admin.users.index') }}" class="block p-5 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500">Total Pengguna</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['total_pengguna'] }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m-4.5 3.903A2.5 2.5 0 017 15h10a2.5 2.5 0 012.5 2.5V21" /></svg>
                </div>
            </div>
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'guru']) }}" class="block p-5 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500">Total Guru</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['total_guru'] }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </div>
            </div>
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'siswa']) }}" class="block p-5 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500">Total Siswa</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['total_siswa'] }}</p>
                </div>
                <div class="bg-orange-100 p-3 rounded-full">
                    <svg class="h-6 w-6 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 14l9-5-9-5-9 5 9 5z" /><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-5.998 12.078 12.078 0 01.665-6.479L12 14z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-5.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222 4 2.222V20" /></svg>
                </div>
            </div>
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'siswa', 'status' => 'active']) }}" class="block p-5 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500">Siswa Aktif</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['siswa_aktif'] }}</p>
                </div>
                <div class="bg-teal-100 p-3 rounded-full">
                    <svg class="h-6 w-6 text-teal-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'siswa', 'status' => 'inactive']) }}" class="block p-5 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500">Siswa Tidak Aktif</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['siswa_tidak_aktif'] }}</p>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <svg class="h-6 w-6 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </div>
        </a>
        <a href="{{ route('admin.materi.index') }}" class="block p-5 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500">Pending Verifikasi</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['pending_materi'] }}</p>
                    <p class="text-xs text-gray-400">Perlu ditinjau</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <svg class="h-6 w-6 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
        </a>
        <a href="{{ route('admin.kelas.index') }}" class="block p-5 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500">Total Kelas</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['total_kelas'] }}</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <svg class="h-6 w-6 text-purple-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" /></svg>
                </div>
            </div>
        </a>
        <a href="{{ route('admin.materi.index') }}" class="block p-5 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500">Materi Aktif</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['materi_aktif'] }}</p>
                    <p class="text-xs text-gray-400">Sudah diverifikasi</p>
                </div>
                <div class="bg-indigo-100 p-3 rounded-full">
                    <svg class="h-6 w-6 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                </div>
            </div>
        </a>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
        <!-- Recent Activity -->
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-lg font-semibold text-gray-800">Aktivitas Terbaru</h4>
                <a href="#" class="text-sm text-indigo-600 hover:underline">Lihat Semua</a>
            </div>
            <div class="space-y-4">
                <!-- Static Activity Item 1 -->
                <div class="flex items-start space-x-4">
                    <div class="bg-blue-100 p-2 rounded-full"><svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" /></svg></div>
                    <div>
                        <p class="text-sm text-gray-800"><b>Dr. Sarah Ahmad</b> mengunggah materi "Algoritma Dasar"</p>
                        <p class="text-xs text-gray-500">2 jam yang lalu</p>
                    </div>
                    <span class="ml-auto text-xs font-medium text-yellow-600 bg-yellow-100 px-2 py-1 rounded-full">Menunggu</span>
                </div>
                <!-- Static Activity Item 2 -->
                <div class="flex items-start space-x-4">
                    <div class="bg-green-100 p-2 rounded-full"><svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg></div>
                    <div>
                        <p class="text-sm text-gray-800"><b>Ahmad Fauzi</b> mendaftar sebagai siswa baru</p>
                        <p class="text-xs text-gray-500">3 jam yang lalu</p>
                    </div>
                    <span class="ml-auto text-xs font-medium text-gray-600 bg-gray-100 px-2 py-1 rounded-full">Selesai</span>
                </div>
                <!-- Static Activity Item 3 -->
                <div class="flex items-start space-x-4">
                    <div class="bg-indigo-100 p-2 rounded-full"><svg class="h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
                    <div>
                        <p class="text-sm text-gray-800"><b>Prof. Lisa Wong</b> materi "UI/UX Principles" diverifikasi</p>
                        <p class="text-xs text-gray-500">5 jam yang lalu</p>
                    </div>
                    <span class="ml-auto text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded-full">Disetujui</span>
                </div>
            </div>
        </div>

        <!-- Pending Verifications -->
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-lg font-semibold text-gray-800">Verifikasi Pending</h4>
                <a href="{{ route('admin.materi.index') }}" class="text-sm text-indigo-600 hover:underline">Kelola Semua</a>
            </div>
            <div class="space-y-4">
                @forelse($pending_verifications as $materi)
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <p class="text-sm font-bold text-gray-800">{{ $materi->judul }}</p>
                        <p class="text-xs text-gray-500">Oleh: {{ $materi->uploadedBy->name ?? 'N/A' }} &bull; Kelas: {{ $materi->kelas->nama_kelas ?? 'N/A' }}</p>
                        <div class="flex justify-end items-center mt-2 space-x-2">
                            <form action="{{ route('admin.materi.approve', $materi->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="p-1.5 bg-green-100 text-green-600 rounded-md hover:bg-green-200">
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                </button>
                            </form>
                            <form action="{{ route('admin.materi.reject', $materi->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="p-1.5 bg-red-100 text-red-600 rounded-md hover:bg-red-200">
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Tidak ada materi yang menunggu verifikasi.</p>
                @endforelse
            </div>
        </div>
    </div>

</x-app-layout>



