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
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                        <div>
                                            <x-input-label for="start_date" :value="__('Tanggal Mulai')" />
                                            <x-text-input id="start_date" name="start_date" type="date" class="block mt-1 w-full" value="{{ old('start_date', now()->toDateString()) }}" required />
                                            <p class="text-xs text-gray-500 mt-1">Tanggal bergabung untuk paket ini.</p>
                                        </div>
                                        <div>
                                            <x-input-label for="duration_months" :value="__('Durasi (Bulan)')" />
                                            <select id="duration_months" name="duration_months" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                                @foreach([1,2,3] as $month)
                                                    <option value="{{ $month }}" {{ old('duration_months', 1) == $month ? 'selected' : '' }}>{{ $month }} Bulan</option>
                                                @endforeach
                                            </select>
                                            <p class="text-xs text-gray-500 mt-1">Paket 1/2/3 bulan.</p>
                                        </div>
                                        <div>
                                            <x-input-label for="monthly_quota" :value="__('Kuota Sesi/Bulan')" />
                                            <select id="monthly_quota" name="monthly_quota" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                                @foreach([4,8] as $quota)
                                                    <option value="{{ $quota }}" {{ old('monthly_quota', 4) == $quota ? 'selected' : '' }}>{{ $quota }}x per bulan</option>
                                                @endforeach
                                            </select>
                                            <p class="text-xs text-gray-500 mt-1">Sesuai aturan kuota Lutfi (4x atau 8x).</p>
                                        </div>
                                    </div>
                                    <div class="border border-gray-200 rounded-md p-3 mb-4">
                                        @foreach ($availableStudents as $student)
                                            <div class="flex items-center mb-2">
                                                <input type="checkbox" name="student_ids[]" id="student_{{ $student->id }}" value="{{ $student->id }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                                @php $displayId = $student->student_id ?? $student->id_siswa; @endphp
                                                <label for="student_{{ $student->id }}" class="ml-2 text-sm text-gray-900">
                                                    {{ $student->name }}
                                                    @if($displayId)
                                                        <span class="text-xs text-indigo-600 font-semibold">({{ $displayId }})</span>
                                                    @else
                                                        <span class="text-xs text-gray-500">({{ $student->email }})</span>
                                                    @endif
                                                </label>
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
