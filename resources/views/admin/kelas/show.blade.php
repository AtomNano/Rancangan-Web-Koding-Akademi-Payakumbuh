<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Kelas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Header --}}
                    <h3 class="text-2xl font-bold mb-2">{{ $kelas->nama_kelas }}</h3>
                    <p class="text-gray-600 mb-2">{{ $kelas->deskripsi }}</p>
                    <p class="text-gray-700 mb-4"><strong>Guru Pengajar:</strong> {{ $kelas->guru->name ?? 'N/A' }}</p>

                    {{-- Main Statistics --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-blue-100 p-4 rounded-lg shadow">
                            <h4 class="font-semibold text-lg">Jumlah Siswa Terdaftar</h4>
                            <p class="text-3xl font-bold">{{ count($studentsProgress) }}</p>
                        </div>
                        <div class="bg-green-100 p-4 rounded-lg shadow">
                            <h4 class="font-semibold text-lg">Jumlah Materi</h4>
                            <p class="text-3xl font-bold">{{ $materi->total() }}</p>
                        </div>
                        <div class="bg-purple-100 p-4 rounded-lg shadow">
                            <h4 class="font-semibold text-lg">Progress Rata-Rata Kelas</h4>
                            <div class="w-full bg-gray-200 rounded-full h-4 dark:bg-gray-700">
                                <div class="bg-purple-600 h-4 rounded-full" style="width: {{ $classProgress }}%"></div>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">{{ $classProgress }}% Selesai</p>
                        </div>
                    </div>

                    {{-- Tabbed View --}}
                    <div x-data="{ openTab: 'materi' }" class="mt-8">
                        <div class="border-b border-gray-200">
                            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                                <button @click="openTab = 'materi'" :class="{ 'border-indigo-500 text-indigo-600': openTab === 'materi', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': openTab !== 'materi' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Materi
                                </button>
                                <button @click="openTab = 'peserta'" :class="{ 'border-indigo-500 text-indigo-600': openTab === 'peserta', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': openTab !== 'peserta' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Peserta (Siswa)
                                </button>
                                <button @click="openTab = 'pengajar'" :class="{ 'border-indigo-500 text-indigo-600': openTab === 'pengajar', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': openTab !== 'pengajar' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Pengajar (Guru)
                                </button>
                            </nav>
                        </div>

                        <div x-show="openTab === 'materi'" class="mt-6">
                            <h4 class="text-xl font-semibold mb-4">Daftar Materi</h4>
                            @if ($materi->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($materi as $item)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->judul }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->file_type }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->status }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                        @if ($item->status === 'approved')
                                                            <a href="{{ route('admin.materi.show', $item->id) }}" class="text-indigo-600 hover:text-indigo-900">Lihat Materi</a>
                                                        @else
                                                            <span class="text-gray-500">Menunggu Persetujuan</span>
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
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress Individual</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($studentsProgress as $studentData)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">{{ $studentData['student']->name }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">{{ $studentData['student']->email }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                                                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $studentData['progress'] }}%"></div>
                                                        </div>
                                                        <p class="text-xs text-gray-600 mt-1">{{ $studentData['completed_materi_count'] }} dari {{ $studentData['total_approved_materi'] }} Materi Selesai ({{ $studentData['progress'] }}%)</p>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                        <form action="{{ route('admin.kelas.unenroll', ['kelas' => $kelas->id, 'user' => $studentData['student']->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengeluarkan siswa ini dari kelas?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900">Keluarkan</button>
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
                                <div class="bg-gray-50 p-4 rounded-lg shadow">
                                    <p class="text-lg font-semibold">{{ $kelas->guru->name }}</p>
                                    <p class="text-gray-600">{{ $kelas->guru->email }}</p>
                                    <p class="text-gray-600">Bidang: {{ $kelas->guru->bidang ?? 'N/A' }}</p>
                                </div>
                            @else
                                <p>Belum ada guru yang ditunjuk untuk kelas ini.</p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('admin.kelas.edit', $kelas) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">Edit Kelas</a>
                        <a href="{{ route('admin.kelas.enroll', $kelas) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Daftarkan Siswa</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
