<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('guru.kelas.show', $kelas->id) }}" class="text-indigo-500 hover:text-indigo-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h2 class="ml-3 font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Pertemuan & Absen: ') . $kelas->nama_kelas }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $kelas->nama_kelas }}</h3>
                            <p class="text-sm text-gray-600">{{ $kelas->deskripsi }}</p>
                        </div>
                        <a href="{{ route('guru.pertemuan.create', $kelas->id) }}" 
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Pertemuan
                        </a>
                    </div>
                </div>
            </div>

            @if($pertemuans->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pertemuan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal & Waktu</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Absen</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($pertemuans as $pertemuan)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $pertemuan->judul_pertemuan }}</div>
                                            @if($pertemuan->deskripsi)
                                                <div class="text-sm text-gray-500">{{ Str::limit($pertemuan->deskripsi, 50) }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $pertemuan->tanggal_pertemuan->format('d M Y') }}</div>
                                            @if($pertemuan->waktu_mulai)
                                                <div class="text-sm text-gray-500">
                                                    {{ $pertemuan->waktu_mulai }}
                                                    @if($pertemuan->waktu_selesai)
                                                        - {{ $pertemuan->waktu_selesai }}
                                                    @endif
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $pertemuan->presensi_count }} siswa
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('guru.pertemuan.show', ['kelas' => $kelas->id, 'pertemuan' => $pertemuan->id]) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900">Input Absen</a>
                                                <a href="{{ route('guru.pertemuan.edit', ['kelas' => $kelas->id, 'pertemuan' => $pertemuan->id]) }}" 
                                                   class="text-gray-600 hover:text-gray-900">Edit</a>
                                                <form action="{{ route('guru.pertemuan.destroy', ['kelas' => $kelas->id, 'pertemuan' => $pertemuan->id]) }}" 
                                                      method="POST" 
                                                      onsubmit="return confirm('Yakin ingin menghapus pertemuan ini?');"
                                                      class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4">
                        {{ $pertemuans->links() }}
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada pertemuan</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat pertemuan baru untuk kelas ini.</p>
                    <div class="mt-6">
                        <a href="{{ route('guru.pertemuan.create', $kelas->id) }}" 
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Pertemuan Pertama
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

