<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftarkan Siswa ke Kelas') }}: {{ $kelas->nama_kelas }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Manajemen Pendaftaran Siswa untuk Kelas: {{ $kelas->nama_kelas }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Kolom Kiri: Siswa Terdaftar --}}
                        <div>
                            <h4 class="text-md font-semibold mb-3">Siswa Terdaftar ({{ $kelas->students->count() }})</h4>
                            @if ($kelas->students->count() > 0)
                                <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                                    @foreach ($kelas->students as $student)
                                        <li class="p-3 flex items-center justify-between">
                                            <span>{{ $student->name }} ({{ $student->email }})</span>
                                            <form action="{{ route('admin.kelas.unenroll', ['kelas' => $kelas->id, 'user' => $student->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengeluarkan siswa ini dari kelas?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Keluarkan</button>
                                            </form>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-gray-600">Belum ada siswa terdaftar di kelas ini.</p>
                            @endif
                        </div>

                        {{-- Kolom Kanan: Siswa Tersedia untuk Pendaftaran --}}
                        <div>
                            <h4 class="text-md font-semibold mb-3">Siswa Tersedia untuk Pendaftaran ({{ $availableStudents->count() }})</h4>
                            @if ($availableStudents->count() > 0)
                                <form action="{{ route('admin.kelas.enroll.store', $kelas->id) }}" method="POST">
                                    @csrf
                                    <div class="border border-gray-200 rounded-md p-3 mb-4">
                                        @foreach ($availableStudents as $student)
                                            <div class="flex items-center mb-2">
                                                <input type="checkbox" name="student_ids[]" id="student_{{ $student->id }}" value="{{ $student->id }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                                <label for="student_{{ $student->id }}" class="ml-2 text-sm text-gray-900">{{ $student->name }} ({{ $student->email }})</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Daftarkan Siswa Terpilih
                                    </button>
                                </form>
                            @else
                                <p class="text-gray-600">Tidak ada siswa yang tersedia untuk didaftarkan ke kelas ini.</p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('admin.kelas.show', $kelas->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Kembali ke Detail Kelas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
