<div class="p-6 bg-gray-50 border-b border-gray-200">
    <div class="flex items-center mb-4">
        <svg class="w-6 h-6 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
        <h3 class="text-lg font-semibold text-gray-800">Informasi Akademik</h3>
    </div>
    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <x-input-label for="tanggal_pendaftaran" :value="__('Tanggal Pendaftaran')" />
            <x-text-input id="tanggal_pendaftaran" class="block mt-1 w-full" type="date" name="tanggal_pendaftaran"
                :value="old('tanggal_pendaftaran', isset($user) && $user->tanggal_pendaftaran ? $user->tanggal_pendaftaran->format('Y-m-d') : date('Y-m-d'))" />
        </div>

        @php
            $sekolahValue = old('sekolah', $user->sekolah ?? '');
            $kelasSekolahValue = '';
            if (isset($user) && strpos($sekolahValue, ' - ') !== false) {
                $parts = explode(' - ', $sekolahValue, 2);
                $sekolahValue = $parts[0];
                $kelasSekolahValue = $parts[1] ?? '';
            } else {
                // Try to guess from old input if it has the format or just raw
                // Actually the controller usually combines them on save, so we need to split if editing
            }
            // However, for create form, old('kelas_sekolah') is separate. 
            // Logic in edit.blade.php handles splitting. Let's incorporate it.
            if (request()->routeIs('*.edit') || isset($user)) {
                if (strpos($sekolahValue, ' - ') !== false) {
                    $parts = explode(' - ', $sekolahValue, 2);
                    $sekolahValue = $parts[0];
                    $kelasSekolahValue = $parts[1] ?? '';
                }
            } else {
                $kelasSekolahValue = old('kelas_sekolah');
            }

            $kelasSekolahValue = old('kelas_sekolah', $kelasSekolahValue);
        @endphp

        <div>
            <x-input-label for="sekolah" :value="__('Nama Sekolah')" />
            <x-text-input id="sekolah" class="block mt-1 w-full" type="text" name="sekolah" :value="old('sekolah', $sekolahValue)" placeholder="Contoh: SD Negeri 01 Payakumbuh" required />
            <p class="mt-1 text-xs text-gray-500">Nama sekolah saat ini</p>
        </div>
        <div>
            <x-input-label for="kelas_sekolah" :value="__('Kelas')" />
            <select id="kelas_sekolah" name="kelas_sekolah"
                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                required>
                <option value="">Pilih Kelas</option>
                <optgroup label="SD (Sekolah Dasar)">
                    @foreach(['1 SD', '2 SD', '3 SD', '4 SD', '5 SD', '6 SD'] as $k)
                        <option value="{{ $k }}" {{ $kelasSekolahValue == $k ? 'selected' : '' }}>Kelas {{ $k }}</option>
                    @endforeach
                </optgroup>
                <optgroup label="SMP (Sekolah Menengah Pertama)">
                    @foreach(['7 SMP', '8 SMP', '9 SMP'] as $k)
                        <option value="{{ $k }}" {{ $kelasSekolahValue == $k ? 'selected' : '' }}>Kelas {{ $k }}</option>
                    @endforeach
                </optgroup>
                <optgroup label="SMA (Sekolah Menengah Atas)">
                    @foreach(['10 SMA', '11 SMA', '12 SMA'] as $k)
                        <option value="{{ $k }}" {{ $kelasSekolahValue == $k ? 'selected' : '' }}>Kelas {{ $k }}</option>
                    @endforeach
                </optgroup>
                <optgroup label="Lainnya">
                    <option value="Umum" {{ $kelasSekolahValue == 'Umum' ? 'selected' : '' }}>Umum</option>
                    <option value="Mahasiswa" {{ $kelasSekolahValue == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                </optgroup>
            </select>
            <p class="mt-1 text-xs text-gray-500">Pilih kelas saat ini di sekolah</p>
        </div>

        <div class="md:col-span-2">
            <x-input-label :value="__('Bidang Ajar (Kelas)')" />
            <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-4">
                @php
                    $selectedBidangAjar = old('bidang_ajar', $user->bidang_ajar ?? []);
                @endphp
                @foreach ($kelas as $item)
                    <label class="flex items-center">
                        <input type="checkbox" name="bidang_ajar[]" value="{{ $item->nama_kelas }}"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ is_array($selectedBidangAjar) && in_array($item->nama_kelas, $selectedBidangAjar) ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-600">{{ $item->nama_kelas }}</span>
                    </label>
                @endforeach
            </div>
            <p class="mt-2 text-sm text-gray-500">Pilih satu atau lebih kelas untuk siswa. Semua jenis kelas tersedia
                (Dasar, Umum, Mahasiswa, dll).</p>
        </div>

        <div>
            <x-input-label for="durasi" :value="__('Durasi Program')" />
            <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach(['1 Bulan', '3 Bulan', '6 Bulan', '12 Bulan'] as $d)
                    <label
                        class="flex items-center p-3 border-2 rounded-lg cursor-pointer hover:bg-indigo-50 transition-colors {{ old('durasi', $user->durasi ?? '') == $d ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200' }}">
                        <input type="radio" name="durasi" value="{{ $d }}" class="text-indigo-600 focus:ring-indigo-500" {{ old('durasi', $user->durasi ?? '') == $d ? 'checked' : '' }}>
                        <span class="ml-2 text-sm font-medium text-gray-700">{{ $d }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        @php
            // Enrollment logic
            $firstEnrollment = isset($user) ? $user->enrollments->first() : null;
            $enStart = old('enrollment_start_date', optional($firstEnrollment?->start_date)->format('Y-m-d') ?? date('Y-m-d'));

            // Derive months from durasi program if editing or just selected
            $durasiStr = old('durasi', $user->durasi ?? '');
            preg_match('/(\d+)/', $durasiStr, $matches);
            $enDuration = isset($matches[1]) ? (int) $matches[1] : ($firstEnrollment?->duration_months ?? 0);

            $enQuota = old('enrollment_monthly_quota', $firstEnrollment?->monthly_quota ?? 4);
            $enTarget = ($enDuration && $enQuota) ? $enDuration * $enQuota : '';

            // For create form, these might be empty initially
        @endphp

        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4 p-4 rounded-lg border border-gray-200 bg-white">
            <div>
                <x-input-label for="enrollment_start_date" :value="__('Tanggal Mulai Paket Sesi')" />
                <x-text-input id="enrollment_start_date" name="enrollment_start_date" type="date"
                    class="block mt-1 w-full" value="{{ $enStart }}" required />
                <p class="text-xs text-gray-500 mt-1">Tanggal sesi pertama atau tanggal bergabung.</p>
            </div>
            <div>
                <x-input-label for="enrollment_monthly_quota" :value="__('Kuota Sesi per Bulan')" />
                <select id="enrollment_monthly_quota" name="enrollment_monthly_quota"
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    required>
                    @foreach([4, 8] as $q)
                        <option value="{{ $q }}" {{ $enQuota == $q ? 'selected' : '' }}>{{ $q }}x per bulan</option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">Pilih 4x atau 8x per bulan.</p>
            </div>
            <div class="md:col-span-3">
                <div class="flex items-center justify-between bg-indigo-50 text-indigo-800 px-4 py-2 rounded">
                    <span class="text-sm font-medium">Target total sesi</span>
                    <span class="text-lg font-semibold"
                        id="target_sessions_display">{{ $enTarget ? $enTarget . ' sesi' : '-' }}</span>
                </div>
                <input type="hidden" name="enrollment_duration_months" id="enrollment_duration_months"
                    value="{{ old('enrollment_duration_months', $enDuration) }}">
                <input type="hidden" name="enrollment_target_sessions" id="enrollment_target_sessions"
                    value="{{ old('enrollment_target_sessions', $enTarget) }}">
                <p class="text-xs text-gray-500 mt-1">Akan menonaktifkan akun setelah target sesi tercapai.</p>
            </div>
        </div>
        <div class="md:col-span-2">
            <x-input-label :value="__('Hari Belajar')" />
            <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                    <label class="flex items-center">
                        <input type="checkbox" name="hari_belajar[]" value="{{ $day }}"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ is_array(old('hari_belajar', $user->hari_belajar ?? [])) && in_array($day, old('hari_belajar', $user->hari_belajar ?? [])) ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-600">{{ $day }}</span>
                    </label>
                @endforeach
            </div>
            <p class="mt-2 text-sm text-gray-500">Pilih hari yang dijadwalkan untuk belajar.</p>
        </div>
        <div>
            <x-input-label for="enrollment_status" :value="__('Status Pendaftaran')" />
            @php
                $status = old('enrollment_status', isset($user) ? ($user->enrollments->first()->status ?? 'active') : 'active');
            @endphp
            <div class="mt-2 flex space-x-4">
                <label class="flex items-center">
                    <input type="radio" name="enrollment_status" value="active"
                        class="text-indigo-600 focus:ring-indigo-500" {{ $status == 'active' ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-600">Aktif</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="enrollment_status" value="inactive"
                        class="text-indigo-600 focus:ring-indigo-500" {{ $status == 'inactive' ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-600">Tidak Aktif</span>
                </label>
            </div>
            <p class="mt-2 text-sm text-gray-500">Status akan otomatis menjadi tidak aktif jika durasi program telah
                berakhir.</p>
        </div>
    </div>
</div>