<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Kelas') }}
        </h2>
        <p class="text-sm text-gray-500">Kelola kelas dan pendaftaran siswa</p>
    </x-slot>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-5 rounded-lg shadow-sm">
            <p class="text-sm text-gray-500">Total Kelas</p>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['total_kelas'] }}</p>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-sm">
            <p class="text-sm text-gray-500">Total Siswa</p>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['total_siswa'] }}</p>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-sm">
            <p class="text-sm text-gray-500">Total Guru</p>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['total_guru'] }}</p>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-sm">
            <p class="text-sm text-gray-500">Total Materi</p>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['total_materi'] }}</p>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-end items-center space-x-4 mb-6">
        <a href="{{ route('admin.users.index', ['role' => 'siswa']) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 disabled:opacity-25 transition">
            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
            Daftarkan Siswa
        </a>
        <a href="{{ route('admin.kelas.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition">
            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
            Buat Kelas Baru
        </a>
    </div>

    <!-- Class Cards -->
    <h3 class="text-xl font-semibold text-gray-800 mb-4">Daftar Kelas</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($kelasList as $kelas)
            <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                <!-- You can replace this with your actual images -->
                <img class="h-40 w-full object-cover" src="https://placehold.co/600x400/6B46C1/white?text={{$kelas->nama_kelas}}" alt="Gambar kelas {{ $kelas->nama_kelas }}">
                <div class="p-6 flex-grow flex flex-col">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="text-lg font-bold text-gray-900">{{ $kelas->nama_kelas }}</h4>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-4 flex-grow">{{ Str::limit($kelas->deskripsi, 80) }}</p>
                    
                    <div class="grid grid-cols-3 gap-4 text-center text-sm mb-4">
                        <div>
                            <p class="font-semibold">{{ $kelas->enrollments->count() }}</p>
                            <p class="text-gray-500 text-xs">Siswa</p>
                        </div>
                        <div>
                            <p class="font-semibold">{{ $kelas->materi->count() }}</p>
                            <p class="text-gray-500 text-xs">Materi</p>
                        </div>
                        <div>
                            @php 
                                $totalMateri = $kelas->materi->count();
                                // Assuming progress is based on number of materials, max 15 for 100%
                                $progress = $totalMateri > 0 ? min(100, ($totalMateri / 15) * 100) : 0; 
                            @endphp
                            <p class="font-semibold">{{ round($progress) }}%</p>
                            <p class="text-gray-500 text-xs">Progress</p>
                        </div>
                    </div>

                    <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
                        <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $progress }}%"></div>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <p class="text-xs text-gray-500 mb-2">Guru Pengajar</p>
                        <div class="flex items-center">
                             <div class="w-8 h-8 bg-indigo-200 rounded-full flex items-center justify-center">
                                <span class="text-indigo-700 font-bold text-xs">{{ substr($kelas->guru->name ?? 'N/A', 0, 2) }}</span>
                            </div>
                            <p class="ml-3 text-sm font-medium text-gray-800">{{ $kelas->guru->name ?? 'Belum ditugaskan' }}</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-gray-50 border-t border-gray-200 flex justify-between items-center">
                    <a href="{{ route('admin.kelas.show', $kelas->id) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">Lihat Detail</a>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('admin.kelas.edit', $kelas->id) }}" class="p-2 rounded-md text-gray-400 hover:bg-indigo-100 hover:text-indigo-600">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L16.732 3.732z" /></svg>
                        </a>
                        <form action="{{ route('admin.kelas.destroy', $kelas->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus kelas ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 rounded-md text-gray-400 hover:bg-red-100 hover:text-red-600">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</x-app-layout>
