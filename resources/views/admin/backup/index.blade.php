<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cadangan Data') }}
        </h2>
        <p class="text-sm text-gray-500">Kelola cadangan dan pemulihan data platform</p>
    </x-slot>

    <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 md:mb-0">Ringkasan Cadangan</h3>
            <a href="{{ route('admin.backup.create') }}" class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                Buat Cadangan Manual
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-5 rounded-lg shadow-sm flex items-center space-x-4">
            <div class="bg-green-100 p-3 rounded-full"><svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg></div>
            <div>
                <p class="text-sm text-gray-500">Cadangan Berhasil</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['berhasil'] }}</p>
            </div>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-sm flex items-center space-x-4">
            <div class="bg-red-100 p-3 rounded-full"><svg class="h-6 w-6 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></div>
            <div>
                <p class="text-sm text-gray-500">Cadangan Gagal</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['gagal'] }}</p>
            </div>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-sm flex items-center space-x-4">
            <div class="bg-blue-100 p-3 rounded-full"><svg class="h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4M4 7s0 4 8 4 8-4 8-4" /></svg></div>
            <div>
                <p class="text-sm text-gray-500">Total Ukuran</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['total_ukuran'] }}</p>
            </div>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-sm flex items-center space-x-4">
            <div class="bg-purple-100 p-3 rounded-full"><svg class="h-6 w-6 text-purple-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
            <div>
                <p class="text-sm text-gray-500">Cadangan Otomatis</p>
                <p class="text-2xl font-bold text-gray-800">03:00</p>
            </div>
        </div>
    </div>

    <!-- Settings and History -->
    <div class="bg-white p-6 rounded-lg shadow-sm">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Pengaturan & Riwayat</h3>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Settings -->
            <div class="lg:col-span-1">
                <h4 class="font-medium text-gray-700 mb-2">Pengaturan Cadangan</h4>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between"><span>Status:</span> <span class="font-semibold text-green-600">Aktif</span></div>
                    <div class="flex justify-between"><span>Jadwal:</span> <span class="font-semibold">Harian (03:00 WIB)</span></div>
                    <div class="flex justify-between"><span>Retensi:</span> <span class="font-semibold">30 hari</span></div>
                </div>
                <h4 class="font-medium text-gray-700 mt-6 mb-2">Data yang Di-backup</h4>
                <div class="space-y-2 text-sm text-gray-600">
                    <div class="flex items-center"><svg class="w-4 h-4 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>Pengguna</div>
                    <div class="flex items-center"><svg class="w-4 h-4 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>Kelas</div>
                    <div class="flex items-center"><svg class="w-4 h-4 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>Materi</div>
                    <div class="flex items-center"><svg class="w-4 h-4 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>Pendaftaran</div>
                </div>
            </div>
            <!-- History -->
            <div class="lg:col-span-2">
                <h4 class="font-medium text-gray-700 mb-2">Riwayat Cadangan</h4>
                <div class="overflow-x-auto border rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal & Waktu</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ukuran</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($backups as $backup)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800">{{ $backup['date']->format('d/m/Y H:i:s') }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $backup['date']->isToday() ? 'Manual' : 'Otomatis' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $backup['size'] }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Berhasil</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            @if(isset($backup['filename']) && !empty($backup['filename']))
                                                <a href="{{ route('admin.backup.download', $backup['filename']) }}" 
                                                   class="p-2 rounded-md text-indigo-600 hover:bg-indigo-100 hover:text-indigo-700 transition-colors" 
                                                   title="Unduh Backup">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('admin.backup.delete', $backup['filename']) }}" 
                                                      method="POST" 
                                                      class="inline"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus backup ini? Tindakan ini tidak dapat dibatalkan.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="p-2 rounded-md text-red-600 hover:bg-red-100 hover:text-red-700 transition-colors" 
                                                            title="Hapus Backup">
                                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-xs text-gray-400">Tidak tersedia</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-3 text-center text-sm text-gray-500">Tidak ada riwayat cadangan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>