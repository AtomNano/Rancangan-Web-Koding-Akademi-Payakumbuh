<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cadangan & Ekspor Data') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Session Messages -->
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Gagal!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <!-- Bagian Ekspor Data ke Excel -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center mb-4">
                            <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Ekspor Data (Excel)</h3>
                                <p class="text-sm text-gray-500">Unduh data pengguna atau log aktivitas dalam format .xlsx.</p>
                            </div>
                        </div>
                        <div class="space-y-4 mt-6">
                            <!-- User Exports -->
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <p class="font-medium text-gray-700 mb-3">Ekspor Data Pengguna:</p>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <a href="{{ route('admin.backup.export.users', ['role' => 'siswa']) }}" class="flex items-center justify-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition-colors">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197m4-10.303a4 4 0 110 5.292"></path></svg>
                                        Siswa
                                    </a>
                                    <a href="{{ route('admin.backup.export.users', ['role' => 'guru']) }}" class="flex items-center justify-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition-colors">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        Guru
                                    </a>
                                    <a href="{{ route('admin.backup.export.users', ['role' => 'admin']) }}" class="flex items-center justify-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition-colors">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        Admin
                                    </a>
                                </div>
                            </div>
                            <!-- Logs Export -->
                            <a href="{{ route('admin.backup.export.logs') }}" class="flex items-center justify-center w-full px-4 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Ekspor Log Aktivitas
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Bagian Cadangan File -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center mb-4">
                            <svg class="w-8 h-8 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h4a2 2 0 002-2V7a2 2 0 00-2-2h-4a2 2 0 00-2 2z"></path></svg>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Cadangan File & Database</h3>
                                <p class="text-sm text-gray-500">Unduh semua file materi atau buat cadangan database.</p>
                            </div>
                        </div>
                        <div class="space-y-4 mt-6">
                            <!-- Download All Materials -->
                            <a href="{{ route('admin.backup.download.materials') }}" class="flex items-center justify-center w-full px-4 py-3 bg-purple-600 text-white font-semibold rounded-lg shadow-md hover:bg-purple-700 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Unduh Semua Materi (.zip)
                            </a>
                            <!-- Database Backup -->
                            <form action="{{ route('admin.backup.database') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memulai proses backup database? Proses ini mungkin memakan waktu beberapa saat.');">
                                @csrf
                                <button type="submit" class="flex items-center justify-center w-full px-4 py-3 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4"></path></svg>
                                    Cadangkan Database MySQL
                                </button>
                            </form>
                            <div class="mt-2 text-xs text-gray-600 text-center">
                                <p><span class="font-semibold">Catatan:</span> Cadangan database akan diproses di latar belakang dan disimpan di server hosting sesuai konfigurasi.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>