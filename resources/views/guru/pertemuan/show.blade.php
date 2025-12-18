<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('guru.pertemuan.index', $kelas->id) }}" class="text-indigo-500 hover:text-indigo-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h2 class="ml-3 font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Input Absen: ') . $pertemuan->judul_pertemuan }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Left Sidebar: Pertemuan Quick Access -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-md overflow-hidden sticky top-20">
                        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-4">
                            <h3 class="text-sm font-bold text-white uppercase tracking-wide">Pertemuan</h3>
                        </div>
                        <div class="max-h-96 overflow-y-auto divide-y divide-gray-200">
                            @php
                                $allPertemuans = $kelas->pertemuan()->orderBy('tanggal_pertemuan')->get();
                            @endphp
                            @if($allPertemuans->count() > 0)
                                @foreach($allPertemuans as $p)
                                    <a href="{{ route('guru.pertemuan.show', ['kelas' => $kelas->id, 'pertemuan' => $p->id]) }}" 
                                       class="block p-3 hover:bg-indigo-50 transition-colors border-l-4 {{ $p->id === $pertemuan->id ? 'border-indigo-600 bg-indigo-50' : 'border-transparent' }}">
                                        <div class="text-xs font-semibold {{ $p->id === $pertemuan->id ? 'text-indigo-700' : 'text-gray-600' }} uppercase tracking-wide">{{ $p->judul_pertemuan }}</div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ optional($p->tanggal_pertemuan)?->format('d M Y') ?? '-' }}
                                        </div>
                                        @if($p->waktu_mulai)
                                            <div class="text-xs text-gray-500 mt-0.5">
                                                <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $p->waktu_mulai }}
                                            </div>
                                        @endif
                                    </a>
                                @endforeach
                            @else
                                <div class="p-4 text-center text-xs text-gray-500">
                                    Belum ada pertemuan
                                </div>
                            @endif
                        </div>
                        <div class="p-3 border-t border-gray-200 bg-gray-50">
                            <a href="{{ route('guru.pertemuan.index', $kelas->id) }}" 
                               class="block w-full text-center px-3 py-2 text-indigo-600 text-xs font-bold rounded hover:bg-indigo-100 transition-all">
                                Kelola Pertemuan
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Main Content: Absen Form -->
                <div class="lg:col-span-3">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Pertemuan Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $pertemuan->judul_pertemuan }}</h3>
                            @if($pertemuan->deskripsi)
                                <p class="text-sm text-gray-600 mt-1">{{ $pertemuan->deskripsi }}</p>
                            @endif
                            <div class="mt-2 flex items-center space-x-4 text-sm text-gray-500">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ optional($pertemuan->tanggal_pertemuan)?->format('d M Y') ?? '-' }}
                                </span>
                                @if($pertemuan->waktu_mulai)
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $pertemuan->waktu_mulai }}
                                        @if($pertemuan->waktu_selesai)
                                            - {{ $pertemuan->waktu_selesai }}
                                        @endif
                                    </span>
                                @endif
                                @if($pertemuan->materi)
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        Materi: {{ $pertemuan->materi }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('guru.pertemuan.edit', ['kelas' => $kelas->id, 'pertemuan' => $pertemuan->id]) }}" 
                               class="inline-flex items-center px-3 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Edit Pertemuan
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Absen Form -->
            @if($siswa->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="mb-4 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
                            <h3 class="text-lg font-semibold text-gray-900">Input Absen Siswa</h3>
                            <div class="flex flex-col md:flex-row gap-3 md:items-center">
                                <div class="relative">
                                    <input type="text" id="searchStudent" placeholder="Cari nama atau email siswa..." class="w-72 md:w-80 lg:w-96 pl-10 pr-3 py-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm" />
                                    <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                                    </svg>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    <button type="button" data-mark-all="hadir" class="px-3 py-2 text-xs font-medium rounded-md bg-green-100 text-green-800 hover:bg-green-200">Tandai semua: Hadir</button>
                                    <button type="button" data-mark-all="izin" class="px-3 py-2 text-xs font-medium rounded-md bg-yellow-100 text-yellow-800 hover:bg-yellow-200">Izin</button>
                                    <button type="button" data-mark-all="sakit" class="px-3 py-2 text-xs font-medium rounded-md bg-blue-100 text-blue-800 hover:bg-blue-200">Sakit</button>
                                    <button type="button" data-mark-all="alpha" class="px-3 py-2 text-xs font-medium rounded-md bg-red-100 text-red-800 hover:bg-red-200">Alpha</button>
                                </div>
                                <div id="statusCounts" class="text-xs text-gray-600 md:ml-2">
                                    <span class="inline-block mr-2"><span class="font-semibold text-green-700" data-count="hadir">0</span> Hadir</span>
                                    <span class="inline-block mr-2"><span class="font-semibold text-yellow-700" data-count="izin">0</span> Izin</span>
                                    <span class="inline-block mr-2"><span class="font-semibold text-blue-700" data-count="sakit">0</span> Sakit</span>
                                    <span class="inline-block"><span class="font-semibold text-red-700" data-count="alpha">0</span> Alpha</span>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('guru.pertemuan.absen', ['kelas' => $kelas->id, 'pertemuan' => $pertemuan->id]) }}" method="POST" id="absenForm">
                            @csrf
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Siswa</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Hadir</th>
                                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Izin</th>
                                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Sakit</th>
                                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Alpha</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($siswa as $index => $s)
                                            @php
                                                $existingPresensi = $presensi->get($s->id);
                                            @endphp
                                            <tr data-student-text="{{ strtolower($s->name . ' ' . $s->email) }}">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @php $displayId = $s->student_id ?? $s->id_siswa; @endphp
                                                    @if($displayId)
                                                        <div class="flex items-center">
                                                            <span class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-indigo-100 mr-2">
                                                                <span class="text-indigo-700 font-bold text-xs">{{ substr($displayId, 0, 1) }}</span>
                                                            </span>
                                                            <div class="text-sm font-semibold text-indigo-600">{{ $displayId }}</div>
                                                        </div>
                                                    @else
                                                        <span class="text-xs text-gray-400 italic">Belum diisi</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">{{ $s->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $s->email }}</div>
                                                </td>
                                                <input type="hidden" name="absen[{{ $index }}][user_id]" value="{{ $s->id }}">
                                                @php
                                                    $val = $existingPresensi->status_kehadiran ?? 'hadir';
                                                @endphp
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <input type="radio" data-absen-radio name="absen[{{ $index }}][status_kehadiran]" value="hadir" {{ $val === 'hadir' ? 'checked' : '' }} class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300" aria-label="Hadir" />
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <input type="radio" data-absen-radio name="absen[{{ $index }}][status_kehadiran]" value="izin" {{ $val === 'izin' ? 'checked' : '' }} class="h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300" aria-label="Izin" />
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <input type="radio" data-absen-radio name="absen[{{ $index }}][status_kehadiran]" value="sakit" {{ $val === 'sakit' ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" aria-label="Sakit" />
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <input type="radio" data-absen-radio name="absen[{{ $index }}][status_kehadiran]" value="alpha" {{ $val === 'alpha' ? 'checked' : '' }} class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300" aria-label="Alpha" />
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-6 sticky bottom-0 bg-white border-t border-gray-200 p-4 -mx-6 -mb-6 sm:rounded-b-lg flex items-center justify-between">
                                <p class="text-xs text-gray-500">Pastikan status kehadiran sudah sesuai sebelum menyimpan.</p>
                                <x-primary-button>
                                    Simpan Absen
                                </x-primary-button>
                            </div>
                        </form>
                        
                        <div class="mt-4 text-xs text-gray-500">
                            Keterangan: Hadir = mengikuti kelas, Izin = izin tidak hadir, Sakit = berhalangan karena sakit, Alpha = tidak hadir tanpa keterangan.
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <p class="text-gray-500">Belum ada siswa terdaftar di kelas ini.</p>
                </div>
            @endif
            </div>
        </div>
    </div>

    <script>
        (function() {
            const rows = () => Array.from(document.querySelectorAll('tbody tr[data-student-text]'));
            const radios = () => Array.from(document.querySelectorAll('input[data-absen-radio]'));
            const countEl = status => document.querySelector(`#statusCounts [data-count="${status}"]`);
            const valueOfRow = (row) => {
                const checked = row.querySelector('input[data-absen-radio]:checked');
                return checked ? checked.value : null;
            };
            const updateCounts = () => {
                const counts = { hadir: 0, izin: 0, sakit: 0, alpha: 0 };
                rows().forEach(r => {
                    const v = valueOfRow(r);
                    if (v && counts[v] !== undefined) counts[v]++;
                });
                Object.keys(counts).forEach(k => { const el = countEl(k); if (el) el.textContent = counts[k]; });
            };

            // Initial counts
            updateCounts();

            // Listen to changes
            radios().forEach(r => r.addEventListener('change', updateCounts));

            // Mark all handlers
            document.querySelectorAll('[data-mark-all]')?.forEach(btn => {
                btn.addEventListener('click', () => {
                    const val = btn.getAttribute('data-mark-all');
                    rows().forEach(row => {
                        const target = row.querySelector(`input[data-absen-radio][value="${val}"]`);
                        if (target) {
                            target.checked = true;
                        }
                    });
                    updateCounts();
                });
            });

            // Search filter
            const searchInput = document.getElementById('searchStudent');
            if (searchInput) {
                searchInput.addEventListener('input', () => {
                    const q = searchInput.value.trim().toLowerCase();
                    document.querySelectorAll('tbody tr[data-student-text]')?.forEach(row => {
                        const text = row.getAttribute('data-student-text') || '';
                        row.style.display = text.includes(q) ? '' : 'none';
                    });
                });
            }
        })();
    </script>
</x-app-layout>

