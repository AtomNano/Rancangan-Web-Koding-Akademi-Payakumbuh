<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Siswa: ') . $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                @if ($errors->any())
                    <div class="p-6">
                        <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>
                        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="role" value="{{ $user->role }}">

                    @if ($user->role === 'siswa')
                        <!-- Basic Information Section -->
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div class="flex items-center mb-4">
                                <svg class="w-6 h-6 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-800">Informasi Dasar</h3>
                            </div>
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="name" :value="__('Nama Lengkap')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required autofocus placeholder="Masukkan nama lengkap" />
                                    <p class="mt-1 text-xs text-gray-500">Nama lengkap sesuai identitas</p>
                                </div>
                                <div>
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required placeholder="email@example.com" />
                                    <p class="mt-1 text-xs text-gray-500">Email aktif untuk login</p>
                                </div>
                                @if ($user->role === 'siswa')
                                <div>
                                    <x-input-label :value="__('ID Siswa')" />
                                    <div class="mt-1 p-3 bg-gray-50 rounded-lg border border-gray-200">
                                        <p class="text-sm font-semibold text-gray-800">{{ $user->id_siswa ?? '-' }}</p>
                                        <p class="text-xs text-gray-500 mt-1">Format: NNN-KODEKELASNUM2-MMYYYY (contoh: 001-01-122025)</p>
                                    </div>
                                </div>
                                @elseif ($user->role === 'admin')
                                <div>
                                    <x-input-label :value="__('Kode Admin')" />
                                    <div class="mt-1 p-3 bg-purple-50 rounded-lg border border-purple-200">
                                        <p class="text-sm font-semibold text-purple-800">{{ $user->kode_admin ?? '-' }}</p>
                                        <p class="text-xs text-purple-600 mt-1">Identitas unik admin</p>
                                    </div>
                                </div>
                                @elseif ($user->role === 'guru')
                                <div>
                                    <x-input-label :value="__('Kode Guru')" />
                                    <div class="mt-1 p-3 bg-green-50 rounded-lg border border-green-200">
                                        <p class="text-sm font-semibold text-green-800">{{ $user->kode_guru ?? '-' }}</p>
                                        <p class="text-xs text-green-600 mt-1">Identitas unik guru</p>
                                    </div>
                                </div>
                                @endif
                                <div>
                                    <x-input-label for="no_telepon" :value="__('No. Telepon / WhatsApp')" />
                                    <div class="mt-1 relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">+62</span>
                                        </div>
                                        <x-text-input id="no_telepon" class="block w-full pl-12" type="tel" name="no_telepon" :value="old('no_telepon', $user->no_telepon)" placeholder="81234567890" pattern="[0-9]{10,13}" />
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Contoh: 81234567890 (tanpa 0 di depan)</p>
                                </div>
                                <div>
                                    <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                                    <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir" :value="old('tanggal_lahir', $user->tanggal_lahir ? $user->tanggal_lahir->format('Y-m-d') : '')" max="{{ date('Y-m-d', strtotime('-5 years')) }}" />
                                    <p class="mt-1 text-xs text-gray-500">Minimal 5 tahun</p>
                                </div>
                                <div>
                                    <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                                    <select id="jenis_kelamin" name="jenis_kelamin" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                                <div class="md:col-span-2">
                                    <x-input-label :value="__('Alamat Lengkap')" />
                                    <div class="mt-2 space-y-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                        <!-- Detail Alamat -->
                                        @php
                                            // Parse alamat to extract components
                                            $alamatParts = [];
                                            if ($user->alamat) {
                                                $parts = explode(',', $user->alamat);
                                                foreach ($parts as $part) {
                                                    $part = trim($part);
                                                    if (strpos($part, 'Kel. ') === 0 || strpos($part, 'Kel ') === 0) {
                                                        $alamatParts['kelurahan'] = str_replace(['Kel. ', 'Kel '], '', $part);
                                                    } elseif (strpos($part, 'Kec. ') === 0 || strpos($part, 'Kec ') === 0) {
                                                        $alamatParts['kecamatan'] = str_replace(['Kec. ', 'Kec '], '', $part);
                                                    } else {
                                                        // Check if it's a known province
                                                        $provinces = [
                                                            'Sumatera Barat', 'Sumatera Utara', 'Sumatera Selatan', 'Riau', 'Kepulauan Riau',
                                                            'Jambi', 'Bengkulu', 'Lampung', 'Bangka Belitung', 'Aceh',
                                                            'DKI Jakarta', 'Jawa Barat', 'Jawa Tengah', 'Jawa Timur', 'Yogyakarta',
                                                            'Banten', 'Bali', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur',
                                                            'Kalimantan Barat', 'Kalimantan Tengah', 'Kalimantan Selatan', 'Kalimantan Timur', 'Kalimantan Utara',
                                                            'Sulawesi Utara', 'Sulawesi Tengah', 'Sulawesi Selatan', 'Sulawesi Tenggara', 'Gorontalo', 'Sulawesi Barat',
                                                            'Maluku', 'Maluku Utara', 'Papua Barat', 'Papua', 'Papua Selatan', 'Papua Tengah', 'Papua Pegunungan'
                                                        ];
                                                        if (in_array($part, $provinces)) {
                                                            $alamatParts['provinsi'] = $part;
                                                        } elseif (!isset($alamatParts['jalan']) && !isset($alamatParts['kota']) && !isset($alamatParts['provinsi'])) {
                                                            // First part without prefix is usually jalan
                                                            $alamatParts['jalan'] = $part;
                                                        } elseif (!isset($alamatParts['kota']) && isset($alamatParts['jalan']) && !isset($alamatParts['provinsi'])) {
                                                            // Second part without prefix is usually kota
                                                            $alamatParts['kota'] = $part;
                                                        }
                                                    }
                                                }
                                            }
                                        @endphp
                                        <div>
                                            <x-input-label for="jalan" :value="__('Jalan / Nama Jalan')" />
                                            <x-text-input id="jalan" class="block mt-1 w-full" type="text" name="jalan" :value="old('jalan', $alamatParts['jalan'] ?? '')" placeholder="Jl. Contoh No. 123" />
                                        </div>
                                        
                                        <!-- Provinsi -->
                                        <div>
                                            <x-input-label for="provinsi" :value="__('Provinsi')" />
                                            <select id="provinsi" name="provinsi" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                <option value="">Pilih Provinsi</option>
                                                @php
                                                    $provinces = [
                                                        'Sumatera Barat', 'Sumatera Utara', 'Sumatera Selatan', 'Riau', 'Kepulauan Riau',
                                                        'Jambi', 'Bengkulu', 'Lampung', 'Bangka Belitung', 'Aceh',
                                                        'DKI Jakarta', 'Jawa Barat', 'Jawa Tengah', 'Jawa Timur', 'Yogyakarta',
                                                        'Banten', 'Bali', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur',
                                                        'Kalimantan Barat', 'Kalimantan Tengah', 'Kalimantan Selatan', 'Kalimantan Timur', 'Kalimantan Utara',
                                                        'Sulawesi Utara', 'Sulawesi Tengah', 'Sulawesi Selatan', 'Sulawesi Tenggara', 'Gorontalo', 'Sulawesi Barat',
                                                        'Maluku', 'Maluku Utara', 'Papua Barat', 'Papua', 'Papua Selatan', 'Papua Tengah', 'Papua Pegunungan'
                                                    ];
                                                @endphp
                                                @foreach($provinces as $prov)
                                                    <option value="{{ $prov }}" {{ old('provinsi', $alamatParts['provinsi'] ?? '') == $prov ? 'selected' : '' }}>{{ $prov }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <!-- Kota/Kabupaten -->
                                        <div>
                                            <x-input-label for="kota" :value="__('Kota / Kabupaten')" />
                                            <select id="kota" name="kota" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" disabled>
                                                <option value="">Pilih Provinsi terlebih dahulu</option>
                                            </select>
                                        </div>
                                        
                                        <!-- Kecamatan -->
                                        <div>
                                            <x-input-label for="kecamatan" :value="__('Kecamatan')" />
                                            <select id="kecamatan" name="kecamatan" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" disabled>
                                                <option value="">Pilih Kota terlebih dahulu</option>
                                            </select>
                                        </div>
                                        
                                        <!-- Kelurahan -->
                                        <div>
                                            <x-input-label for="kelurahan" :value="__('Kelurahan / Desa')" />
                                            <select id="kelurahan" name="kelurahan" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" disabled>
                                                <option value="">Pilih Kecamatan terlebih dahulu</option>
                                            </select>
                                        </div>
                                        
                                        <!-- Alamat Lengkap (Hidden - akan diisi otomatis) -->
                                        <input type="hidden" id="alamat" name="alamat" value="{{ old('alamat', $user->alamat) }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Academic Information Section -->
                        <div class="p-6 bg-gray-50 border-b border-gray-200">
                            <div class="flex items-center mb-4">
                                <svg class="w-6 h-6 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-800">Informasi Akademik</h3>
                            </div>
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="tanggal_pendaftaran" :value="__('Tanggal Pendaftaran')" />
                                    <x-text-input id="tanggal_pendaftaran" class="block mt-1 w-full" type="date" name="tanggal_pendaftaran" :value="old('tanggal_pendaftaran', $user->tanggal_pendaftaran ? $user->tanggal_pendaftaran->format('Y-m-d') : date('Y-m-d'))" />
                                </div>
                                @php
                                    // Extract sekolah and kelas_sekolah from sekolah field
                                    $sekolahValue = old('sekolah', $user->sekolah ?? '');
                                    $kelasSekolahValue = '';
                                    if (strpos($sekolahValue, ' - ') !== false) {
                                        $parts = explode(' - ', $sekolahValue, 2);
                                        $sekolahValue = $parts[0];
                                        $kelasSekolahValue = $parts[1] ?? '';
                                    }
                                @endphp
                                <div>
                                    <x-input-label for="sekolah" :value="__('Nama Sekolah')" />
                                    <x-text-input id="sekolah" class="block mt-1 w-full" type="text" name="sekolah" :value="old('sekolah', $sekolahValue)" placeholder="Contoh: SD Negeri 01 Payakumbuh" required />
                                    <p class="mt-1 text-xs text-gray-500">Nama sekolah saat ini</p>
                                </div>
                                <div>
                                    <x-input-label for="kelas_sekolah" :value="__('Kelas')" />
                                    <select id="kelas_sekolah" name="kelas_sekolah" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="">Pilih Kelas</option>
                                        <optgroup label="SD (Sekolah Dasar)">
                                            <option value="1 SD" {{ old('kelas_sekolah', $kelasSekolahValue) == '1 SD' ? 'selected' : '' }}>Kelas 1 SD</option>
                                            <option value="2 SD" {{ old('kelas_sekolah', $kelasSekolahValue) == '2 SD' ? 'selected' : '' }}>Kelas 2 SD</option>
                                            <option value="3 SD" {{ old('kelas_sekolah', $kelasSekolahValue) == '3 SD' ? 'selected' : '' }}>Kelas 3 SD</option>
                                            <option value="4 SD" {{ old('kelas_sekolah', $kelasSekolahValue) == '4 SD' ? 'selected' : '' }}>Kelas 4 SD</option>
                                            <option value="5 SD" {{ old('kelas_sekolah', $kelasSekolahValue) == '5 SD' ? 'selected' : '' }}>Kelas 5 SD</option>
                                            <option value="6 SD" {{ old('kelas_sekolah', $kelasSekolahValue) == '6 SD' ? 'selected' : '' }}>Kelas 6 SD</option>
                                        </optgroup>
                                        <optgroup label="SMP (Sekolah Menengah Pertama)">
                                            <option value="7 SMP" {{ old('kelas_sekolah', $kelasSekolahValue) == '7 SMP' ? 'selected' : '' }}>Kelas 7 SMP</option>
                                            <option value="8 SMP" {{ old('kelas_sekolah', $kelasSekolahValue) == '8 SMP' ? 'selected' : '' }}>Kelas 8 SMP</option>
                                            <option value="9 SMP" {{ old('kelas_sekolah', $kelasSekolahValue) == '9 SMP' ? 'selected' : '' }}>Kelas 9 SMP</option>
                                        </optgroup>
                                        <optgroup label="SMA (Sekolah Menengah Atas)">
                                            <option value="10 SMA" {{ old('kelas_sekolah', $kelasSekolahValue) == '10 SMA' ? 'selected' : '' }}>Kelas 10 SMA</option>
                                            <option value="11 SMA" {{ old('kelas_sekolah', $kelasSekolahValue) == '11 SMA' ? 'selected' : '' }}>Kelas 11 SMA</option>
                                            <option value="12 SMA" {{ old('kelas_sekolah', $kelasSekolahValue) == '12 SMA' ? 'selected' : '' }}>Kelas 12 SMA</option>
                                        </optgroup>
                                        <optgroup label="Lainnya">
                                            <option value="Umum" {{ old('kelas_sekolah', $kelasSekolahValue) == 'Umum' ? 'selected' : '' }}>Umum</option>
                                            <option value="Mahasiswa" {{ old('kelas_sekolah', $kelasSekolahValue) == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                        </optgroup>
                                    </select>
                                    <p class="mt-1 text-xs text-gray-500">Pilih kelas saat ini di sekolah</p>
                                </div>
                                <div class="md:col-span-2">
                                    <x-input-label :value="__('Bidang Ajar (Kelas)')" />
                                    <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-4">
                                        @php
                                            $selectedBidangAjar = old('bidang_ajar', $user->bidang_ajar ?? []);
                                            if (!is_array($selectedBidangAjar)) {
                                                $selectedBidangAjar = []; // Ensure it's an array
                                            }
                                        @endphp
                                        @foreach ($kelas as $item)
                                        <label class="flex items-center">
                                            <input type="checkbox" name="bidang_ajar[]" value="{{ $item->nama_kelas }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ in_array($item->nama_kelas, $selectedBidangAjar) ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-600">{{ $item->nama_kelas }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">Pilih satu atau lebih kelas untuk siswa. Semua jenis kelas tersedia (Dasar, Umum, Mahasiswa, dll).</p>
                                </div>
                                <div>
                                    <x-input-label for="durasi" :value="__('Durasi Program')" />
                                    <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-3">
                                        <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer hover:bg-indigo-50 transition-colors {{ old('durasi', $user->durasi) == '1 Bulan' ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200' }}">
                                            <input type="radio" name="durasi" value="1 Bulan" class="text-indigo-600 focus:ring-indigo-500" {{ old('durasi', $user->durasi) == '1 Bulan' ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm font-medium text-gray-700">1 Bulan</span>
                                        </label>
                                        <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer hover:bg-indigo-50 transition-colors {{ old('durasi', $user->durasi) == '3 Bulan' ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200' }}">
                                            <input type="radio" name="durasi" value="3 Bulan" class="text-indigo-600 focus:ring-indigo-500" {{ old('durasi', $user->durasi) == '3 Bulan' ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm font-medium text-gray-700">3 Bulan</span>
                                        </label>
                                        <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer hover:bg-indigo-50 transition-colors {{ old('durasi', $user->durasi) == '6 Bulan' ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200' }}">
                                            <input type="radio" name="durasi" value="6 Bulan" class="text-indigo-600 focus:ring-indigo-500" {{ old('durasi', $user->durasi) == '6 Bulan' ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm font-medium text-gray-700">6 Bulan</span>
                                        </label>
                                        <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer hover:bg-indigo-50 transition-colors {{ old('durasi', $user->durasi) == '12 Bulan' ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200' }}">
                                            <input type="radio" name="durasi" value="12 Bulan" class="text-indigo-600 focus:ring-indigo-500" {{ old('durasi', $user->durasi) == '12 Bulan' ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm font-medium text-gray-700">12 Bulan</span>
                                        </label>
                                    </div>
                                </div>

                                @php
                                    $firstEnrollment = $user->enrollments->first();
                                    $enStart = old('enrollment_start_date', optional($firstEnrollment?->start_date)->format('Y-m-d'));
                                    // Derive months from durasi program (e.g., "3 Bulan")
                                    $durasiStr = old('durasi', $user->durasi ?? '');
                                    preg_match('/(\d+)/', $durasiStr, $matches);
                                    $enDuration = isset($matches[1]) ? (int)$matches[1] : ($firstEnrollment?->duration_months ?? 1);
                                    $enQuota = old('enrollment_monthly_quota', $firstEnrollment?->monthly_quota ?? 4);
                                    $enTarget = ($enDuration && $enQuota) ? $enDuration * $enQuota : '';
                                @endphp
                                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4 p-4 rounded-lg border border-gray-200 bg-white">
                                    <div>
                                        <x-input-label for="enrollment_start_date" :value="__('Tanggal Mulai Paket Sesi')" />
                                        <x-text-input id="enrollment_start_date" name="enrollment_start_date" type="date" class="block mt-1 w-full" value="{{ $enStart ?: date('Y-m-d') }}" required />
                                        <p class="text-xs text-gray-500 mt-1">Tanggal sesi pertama atau tanggal bergabung.</p>
                                    </div>
                                    <div>
                                        <x-input-label for="enrollment_monthly_quota" :value="__('Kuota Sesi per Bulan')" />
                                        <select id="enrollment_monthly_quota" name="enrollment_monthly_quota" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                            @foreach([4,8] as $q)
                                                <option value="{{ $q }}" {{ (int)$enQuota === $q ? 'selected' : '' }}>{{ $q }}x per bulan</option>
                                            @endforeach
                                        </select>
                                        <p class="text-xs text-gray-500 mt-1">Pilih 4x atau 8x per bulan.</p>
                                    </div>
                                    <div class="md:col-span-3">
                                        <div class="flex items-center justify-between bg-indigo-50 text-indigo-800 px-4 py-2 rounded">
                                            <span class="text-sm font-medium">Target total sesi</span>
                                            <span class="text-lg font-semibold" id="target_sessions_display">{{ $enTarget ? $enTarget . ' sesi' : '-' }}</span>
                                        </div>
                                        <input type="hidden" name="enrollment_duration_months" id="enrollment_duration_months" value="{{ old('enrollment_duration_months', $enDuration) }}">
                                        <input type="hidden" name="enrollment_target_sessions" id="enrollment_target_sessions" value="{{ old('enrollment_target_sessions', $enTarget) }}">
                                        <p class="text-xs text-gray-500 mt-1">Akan menonaktifkan akun setelah target sesi tercapai.</p>
                                    </div>
                                </div>
                                <div class="md:col-span-2">
                                    <x-input-label :value="__('Hari Belajar')" />
                                    <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-4">
                                        @php
                                            $old_hari_belajar = old('hari_belajar', $user->hari_belajar ?? []);
                                        @endphp
                                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                                        <label class="flex items-center">
                                            <input type="checkbox" name="hari_belajar[]" value="{{ $day }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ is_array($old_hari_belajar) && in_array($day, $old_hari_belajar) ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-600">{{ $day }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">Pilih hari yang dijadwalkan untuk belajar.</p>
                                </div>
                                <div>
                                    <x-input-label for="enrollment_status" :value="__('Status Pendaftaran')" />
                                    @php
                                        $currentEnrollmentStatus = old('enrollment_status', $user->enrollments->first()->status ?? 'active');
                                    @endphp
                                    <div class="mt-2 flex space-x-4">
                                        <label class="flex items-center">
                                            <input type="radio" name="enrollment_status" value="active" class="text-indigo-600 focus:ring-indigo-500" {{ $currentEnrollmentStatus == 'active' ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-600">Aktif</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" name="enrollment_status" value="inactive" class="text-indigo-600 focus:ring-indigo-500" {{ $currentEnrollmentStatus == 'inactive' ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-600">Tidak Aktif</span>
                                        </label>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">Status akan otomatis menjadi tidak aktif jika durasi program telah berakhir.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Information Section -->
                        <div class="p-6 bg-blue-50 border-b border-gray-200">
                            <div class="flex items-center mb-4">
                                <svg class="w-6 h-6 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-800">Informasi Pembayaran</h3>
                            </div>
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="metode_pembayaran" :value="__('Metode Pembayaran')" />
                                    <select id="metode_pembayaran" name="metode_pembayaran" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="">Pilih Metode Pembayaran</option>
                                        <option value="transfer" {{ old('metode_pembayaran', $user->metode_pembayaran) == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                        <option value="cash" {{ old('metode_pembayaran', $user->metode_pembayaran) == 'cash' ? 'selected' : '' }}>Tunai (Cash)</option>
                                    </select>
                                    <p class="mt-1 text-xs text-gray-500">Pilih metode pembayaran yang digunakan</p>
                                </div>
                                <div>
                                    <x-input-label for="status_promo" :value="__('Status Promo / Diskon')" />
                                    <select id="status_promo" name="status_promo" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="">Tidak Ada Promo</option>
                                        <option value="Promo Saudara Gratis" {{ old('status_promo', $user->status_promo) == 'Promo Saudara Gratis' ? 'selected' : '' }}>Promo Saudara Gratis</option>
                                        <option value="Promo Early Bird" {{ old('status_promo', $user->status_promo) == 'Promo Early Bird' ? 'selected' : '' }}>Promo Early Bird</option>
                                        <option value="Promo Referral" {{ old('status_promo', $user->status_promo) == 'Promo Referral' ? 'selected' : '' }}>Promo Referral</option>
                                        <option value="Beasiswa" {{ old('status_promo', $user->status_promo) == 'Beasiswa' ? 'selected' : '' }}>Beasiswa</option>
                                    </select>
                                    <p class="mt-1 text-xs text-gray-500">Pilih promo atau diskon yang berlaku (jika ada)</p>
                                </div>
                                <div>
                                    <x-input-label for="biaya_pendaftaran" :value="__('Biaya Pendaftaran')" />
                                    <x-text-input id="biaya_pendaftaran" class="block mt-1 w-full" type="text" name="biaya_pendaftaran" :value="old('biaya_pendaftaran', $user->biaya_pendaftaran ? 'Rp. ' . number_format($user->biaya_pendaftaran, 0, ',', '.') : 'Rp. 150.000')" />
                                </div>
                                <div>
                                    <x-input-label for="biaya_angsuran" :value="__('Biaya Angsuran')" />
                                    <x-text-input id="biaya_angsuran" class="block mt-1 w-full" type="text" name="biaya_angsuran" :value="old('biaya_angsuran', $user->biaya_angsuran ? 'Rp. ' . number_format($user->biaya_angsuran, 0, ',', '.') : 'Rp. 1.250.000')" />
                                </div>
                                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <x-input-label for="total_biaya" :value="__('Total Biaya')" />
                                        <x-text-input id="total_biaya" class="block mt-1 w-full bg-gray-200" type="text" name="total_biaya" :value="old('total_biaya', $user->total_biaya ? 'Rp. ' . number_format($user->total_biaya, 0, ',', '.') : '')" readonly />
                                    </div>
                                    <div>
                                        <x-input-label for="discount_type" :value="__('Tipe Diskon')" />
                                        <select id="discount_type" name="discount_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            <option value="">Tidak Ada Diskon</option>
                                            <option value="percentage" {{ old('discount_type', $user->discount_type) == 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                                            <option value="fixed" {{ old('discount_type', $user->discount_type) == 'fixed' ? 'selected' : '' }}>Potongan Tetap (Rp)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <x-input-label for="discount_value" :value="__('Nilai Diskon')" />
                                        <x-text-input id="discount_value" class="block mt-1 w-full" type="text" name="discount_value" :value="old('discount_value', $user->discount_value)" />
                                    </div>
                                    <div>
                                        <x-input-label for="total_setelah_diskon" :value="__('Total Setelah Diskon')" />
                                        <x-text-input id="total_setelah_diskon" class="block mt-1 w-full bg-gray-200" type="text" name="total_setelah_diskon" :value="old('total_setelah_diskon', $user->total_setelah_diskon ? 'Rp. ' . number_format($user->total_setelah_diskon, 0, ',', '.') : '')" readonly />
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- Login Information Section -->
                        <div class="p-6 bg-purple-50 border-b border-gray-200">
                            <div class="flex items-center mb-4">
                                <svg class="w-6 h-6 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-800">Informasi Masuk</h3>
                            </div>
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="password" :value="__('Kata Sandi')" />
                                    <div class="relative mt-1">
                                        <x-text-input id="password" class="block w-full pr-24" type="password" name="password" />
                                        <button type="button" class="absolute inset-y-0 right-0 px-3 text-sm text-indigo-600 hover:text-indigo-800 font-medium" data-password-target="password">Lihat</button>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah kata sandi.</p>
                                </div>
                                <div>
                                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" />
                                    <div class="relative mt-1">
                                        <x-text-input id="password_confirmation" class="block w-full pr-24" type="password" name="password_confirmation" />
                                        <button type="button" class="absolute inset-y-0 right-0 px-3 text-sm text-indigo-600 hover:text-indigo-800 font-medium" data-password-target="password_confirmation">Lihat</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @elseif ($user->role === 'guru')
                        <div class="p-6 space-y-6">
                            <div>
                                <x-input-label for="name" :value="__('Nama Lengkap')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required autofocus />
                            </div>
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required />
                            </div>
                            <div>
                                <x-input-label for="no_telepon" :value="__('No. Telepon')" />
                                <x-text-input id="no_telepon" class="block mt-1 w-full" type="text" name="no_telepon" :value="old('no_telepon', $user->no_telepon)" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label :value="__('Kelas yang Diajar')" />
                                <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @php
                                        $selectedBidangAjar = old('bidang_ajar', json_decode($user->bidang_ajar ?? '[]', true));
                                        if (!is_array($selectedBidangAjar)) {
                                            $selectedBidangAjar = [];
                                        }
                                    @endphp
                                    @foreach ($kelas as $item)
                                    <label class="flex items-center">
                                        <input type="checkbox" name="bidang_ajar[]" value="{{ $item->nama_kelas }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ in_array($item->nama_kelas, $selectedBidangAjar) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-600">{{ $item->nama_kelas }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <x-input-label for="password" :value="__('Password Baru (Opsional)')" />
                                <div class="relative mt-1">
                                    <x-text-input id="password" class="block w-full pr-24" type="password" name="password" />
                                    <button type="button" class="absolute inset-y-0 right-0 px-3 text-sm text-indigo-600 hover:text-indigo-800 font-medium" data-password-target="password">Lihat</button>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah password.</p>
                            </div>
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" />
                                <div class="relative mt-1">
                                    <x-text-input id="password_confirmation" class="block w-full pr-24" type="password" name="password_confirmation" />
                                    <button type="button" class="absolute inset-y-0 right-0 px-3 text-sm text-indigo-600 hover:text-indigo-800 font-medium" data-password-target="password_confirmation">Lihat</button>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Form for Admin -->
                        <div class="p-6 space-y-6">
                            <div>
                                <x-input-label for="name" :value="__('Nama Lengkap')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required autofocus />
                            </div>
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required />
                            </div>
                            <div>
                                <x-input-label for="password" :value="__('Password Baru (Opsional)')" />
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" />
                                <p class="text-sm text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah password.</p>
                            </div>
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" />
                                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" />
                            </div>
                        </div>
                    @endif

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end p-6 bg-gray-50">
                        <a href="{{ route('admin.users.index', ['role' => $user->role]) }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                            {{ __('Batal') }}
                        </a>
                        <x-primary-button>
                            {{ __('Simpan Perubahan') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if ($user->role === 'siswa')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const durasiRadios = Array.from(document.querySelectorAll('input[name="durasi"]'));
            const quotaSelect = document.getElementById('enrollment_monthly_quota');
            const targetDisplay = document.getElementById('target_sessions_display');
            const targetHidden = document.getElementById('enrollment_target_sessions');
            const durationHidden = document.getElementById('enrollment_duration_months');

            function getDurationMonths() {
                const selected = durasiRadios.find(r => r.checked);
                if (!selected) return 0;
                const match = (selected.value || '').match(/(\d+)/);
                return match ? parseInt(match[1], 10) : 0;
            }

            function updateTargetSessions() {
                const m = getDurationMonths();
                const q = parseInt(quotaSelect.value || '0', 10);
                const total = m > 0 && q > 0 ? m * q : '';
                targetDisplay.textContent = total ? `${total} sesi` : '-';
                targetHidden.value = total || '';
                durationHidden.value = m || '';
            }

            durasiRadios.forEach(r => r.addEventListener('change', updateTargetSessions));
            quotaSelect.addEventListener('change', updateTargetSessions);
            updateTargetSessions();

            // Address Data (Indonesia - focused on Sumatera Barat)
            const addressData = {
                'Sumatera Barat': {
                    'Kota Padang': {
                        'Padang Barat': ['Belakang Tangsi', 'Flamboyan Baru', 'Kampung Jao', 'Kampung Pondok', 'Korong Gadang', 'Lolong Belanti', 'Purus', 'Seberang Padang', 'Seberang Palinggam', 'Teluk Bayur'],
                        'Padang Selatan': ['Air Manis', 'Alang Laweh', 'Batang Arau', 'Bukit Gado-Gado', 'Mato Aie', 'Pasa Gadang', 'Ranah Parak Rumbio', 'Seberang Palinggam', 'Teluk Bayur'],
                        'Padang Timur': ['Andalas', 'Ganting', 'Jati', 'Jati Baru', 'Kubu Marapalam', 'Kubu Parak Karakah', 'Lubuk Begalung', 'Parak Gadang', 'Sawahan', 'Sawahan Timur'],
                        'Padang Utara': ['Air Tawar Barat', 'Air Tawar Timur', 'Alai Parak Kopi', 'Gunung Pangilun', 'Lolong', 'Ulak Karang Selatan', 'Ulak Karang Utara'],
                        'Koto Tangah': ['Batang Kabung Ganting', 'Bungus Selatan', 'Bungus Timur', 'Indarung', 'Koto Tangah', 'Lubuk Kilangan', 'Lubuk Minturun', 'Padang Besi', 'Tanjung Saba'],
                        'Lubuk Begalung': ['Ampang', 'Batang Kabung', 'Batu Gadang', 'Koto Baru', 'Lubuk Begalung', 'Piai', 'Piai Tangah', 'Sungai Sapih'],
                        'Lubuk Kilangan': ['Bandar Buat', 'Batu Gadang', 'Indarung', 'Koto Baru', 'Lubuk Begalung', 'Piai', 'Sungai Sapih'],
                        'Nanggalo': ['Gurun Laweh', 'Kampung Jua', 'Koto Tangah', 'Nanggalo', 'Surau Gadang'],
                        'Pauh': ['Bandar Buat', 'Batu Gadang', 'Indarung', 'Koto Baru', 'Lubuk Begalung', 'Piai', 'Sungai Sapih']
                    },
                    'Kota Payakumbuh': {
                        'Payakumbuh Barat': ['Aie Tabik', 'Balai Nan Duo', 'Koto Nan Gadang', 'Koto Nan IV', 'Kubang', 'Labuh Baru', 'Padang Tangah', 'Pakan Sinayan', 'Tanjung Pauh'],
                        'Payakumbuh Selatan': ['Aie Dingin', 'Koto Baru', 'Koto Nan Gadang', 'Kubang', 'Labuh Baru', 'Padang Tangah', 'Pakan Sinayan'],
                        'Payakumbuh Timur': ['Aie Dingin', 'Koto Baru', 'Koto Nan Gadang', 'Kubang', 'Labuh Baru', 'Padang Tangah', 'Pakan Sinayan'],
                        'Payakumbuh Utara': ['Aie Tabik', 'Balai Nan Duo', 'Koto Nan Gadang', 'Koto Nan IV', 'Kubang', 'Labuh Baru', 'Padang Tangah', 'Pakan Sinayan'],
                        'Lamposi Tigo Nagori': ['Aie Dingin', 'Koto Baru', 'Koto Nan Gadang', 'Kubang', 'Labuh Baru', 'Padang Tangah', 'Pakan Sinayan']
                    },
                    'Kota Bukittinggi': {
                        'Guguk Panjang': ['Aur Tajungkang', 'Bukit Cangang', 'Guguk Panjang', 'Koto Selayan', 'Kubang Putiah', 'Pakan Sinayan'],
                        'Mandiangin Koto Selayan': ['Aur Tajungkang', 'Bukit Cangang', 'Guguk Panjang', 'Koto Selayan', 'Kubang Putiah', 'Pakan Sinayan'],
                        'Aur Birugo Tigo Baleh': ['Aur Birugo', 'Kubang Putiah', 'Pakan Sinayan', 'Tigo Baleh']
                    },
                    'Kota Padang Panjang': {
                        'Padang Panjang Barat': ['Ganting', 'Guguk Malintang', 'Koto Baru', 'Koto Panjang', 'Pasar Baru', 'Pasar Usang'],
                        'Padang Panjang Timur': ['Ganting', 'Guguk Malintang', 'Koto Baru', 'Koto Panjang', 'Pasar Baru', 'Pasar Usang']
                    },
                    'Kota Pariaman': {
                        'Pariaman Selatan': ['Ampalu', 'Kampung Baru', 'Kampung Gadang', 'Pariaman', 'Pasar Baru', 'Pasar Usang'],
                        'Pariaman Tengah': ['Ampalu', 'Kampung Baru', 'Kampung Gadang', 'Pariaman', 'Pasar Baru', 'Pasar Usang'],
                        'Pariaman Utara': ['Ampalu', 'Kampung Baru', 'Kampung Gadang', 'Pariaman', 'Pasar Baru', 'Pasar Usang']
                    },
                    'Kota Sawahlunto': {
                        'Barangin': ['Aie Dingin', 'Kampung Baru', 'Koto Baru', 'Kubang', 'Labuh Baru', 'Padang Tangah'],
                        'Lembah Segar': ['Aie Dingin', 'Kampung Baru', 'Koto Baru', 'Kubang', 'Labuh Baru', 'Padang Tangah'],
                        'Silungkang': ['Aie Dingin', 'Kampung Baru', 'Koto Baru', 'Kubang', 'Labuh Baru', 'Padang Tangah'],
                        'Talawi': ['Aie Dingin', 'Kampung Baru', 'Koto Baru', 'Kubang', 'Labuh Baru', 'Padang Tangah']
                    },
                    'Kota Solok': {
                        'Lubuk Sikarah': ['Aie Dingin', 'Kampung Baru', 'Koto Baru', 'Kubang', 'Labuh Baru', 'Padang Tangah'],
                        'Tanjung Harapan': ['Aie Dingin', 'Kampung Baru', 'Koto Baru', 'Kubang', 'Labuh Baru', 'Padang Tangah']
                    }
                },
                'DKI Jakarta': {
                    'Jakarta Pusat': {
                        'Cempaka Putih': ['Cempaka Putih Barat', 'Cempaka Putih Timur', 'Rawasari'],
                        'Gambir': ['Cideng', 'Duri Pulo', 'Gambir', 'Kebon Kelapa', 'Petojo Selatan', 'Petojo Utara'],
                        'Johar Baru': ['Galur', 'Johar Baru', 'Kampung Rawa', 'Tanah Tinggi'],
                        'Kemayoran': ['Cempaka Baru', 'Gunung Sahari Selatan', 'Harapan Mulya', 'Kebon Kosong', 'Kemayoran', 'Serdang', 'Sumur Batu', 'Utan Panjang']
                    }
                },
                'Jawa Barat': {
                    'Kota Bandung': {
                        'Andir': ['Ciroyom', 'Ciseureuh', 'Dungus Cariang', 'Garuda', 'Kebon Jeruk'],
                        'Astana Anyar': ['Cibadak', 'Karang Anyar', 'Karasak', 'Nyengseret', 'Panjunan', 'Pelindung Hewan'],
                        'Bandung Kulon': ['Caringin', 'Cibuntu', 'Cigondewah Hilir', 'Cigondewah Kaler', 'Cigondewah Rahayu', 'Cijerah', 'Gempolsari', 'Warung Muncang']
                    }
                }
            };

            // Address form elements
            const provinsiSelect = document.getElementById('provinsi');
            const kotaSelect = document.getElementById('kota');
            const kecamatanSelect = document.getElementById('kecamatan');
            const kelurahanSelect = document.getElementById('kelurahan');
            const jalanInput = document.getElementById('jalan');
            const alamatHidden = document.getElementById('alamat');

            // Initialize address from existing data
            @if(isset($alamatParts) && !empty($alamatParts))
                const existingProvinsi = '{{ $alamatParts['provinsi'] ?? '' }}';
                const existingKota = '{{ $alamatParts['kota'] ?? '' }}';
                const existingKecamatan = '{{ $alamatParts['kecamatan'] ?? '' }}';
                const existingKelurahan = '{{ $alamatParts['kelurahan'] ?? '' }}';
                
                if (existingProvinsi && addressData[existingProvinsi]) {
                    provinsiSelect.value = existingProvinsi;
                    kotaSelect.disabled = false;
                    Object.keys(addressData[existingProvinsi]).forEach(kota => {
                        const option = document.createElement('option');
                        option.value = kota;
                        option.textContent = kota;
                        if (kota === existingKota) {
                            option.selected = true;
                        }
                        kotaSelect.appendChild(option);
                    });
                    
                    if (existingKota && addressData[existingProvinsi][existingKota]) {
                        kecamatanSelect.disabled = false;
                        Object.keys(addressData[existingProvinsi][existingKota]).forEach(kecamatan => {
                            const option = document.createElement('option');
                            option.value = kecamatan;
                            option.textContent = kecamatan;
                            if (kecamatan === existingKecamatan) {
                                option.selected = true;
                            }
                            kecamatanSelect.appendChild(option);
                        });
                        
                        if (existingKecamatan && addressData[existingProvinsi][existingKota][existingKecamatan]) {
                            kelurahanSelect.disabled = false;
                            addressData[existingProvinsi][existingKota][existingKecamatan].forEach(kelurahan => {
                                const option = document.createElement('option');
                                option.value = kelurahan;
                                option.textContent = kelurahan;
                                if (kelurahan === existingKelurahan) {
                                    option.selected = true;
                                }
                                kelurahanSelect.appendChild(option);
                            });
                        }
                    }
                }
            @endif

            // Update kota dropdown based on provinsi
            provinsiSelect.addEventListener('change', function() {
                const provinsi = this.value;
                kotaSelect.innerHTML = '<option value="">Pilih Kota / Kabupaten</option>';
                kecamatanSelect.innerHTML = '<option value="">Pilih Kota terlebih dahulu</option>';
                kelurahanSelect.innerHTML = '<option value="">Pilih Kecamatan terlebih dahulu</option>';
                
                if (provinsi && addressData[provinsi]) {
                    kotaSelect.disabled = false;
                    Object.keys(addressData[provinsi]).forEach(kota => {
                        const option = document.createElement('option');
                        option.value = kota;
                        option.textContent = kota;
                        kotaSelect.appendChild(option);
                    });
                } else {
                    kotaSelect.disabled = true;
                    kecamatanSelect.disabled = true;
                    kelurahanSelect.disabled = true;
                }
                updateAlamat();
            });

            // Update kecamatan dropdown based on kota
            kotaSelect.addEventListener('change', function() {
                const provinsi = provinsiSelect.value;
                const kota = this.value;
                kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                kelurahanSelect.innerHTML = '<option value="">Pilih Kecamatan terlebih dahulu</option>';
                
                if (provinsi && kota && addressData[provinsi] && addressData[provinsi][kota]) {
                    kecamatanSelect.disabled = false;
                    Object.keys(addressData[provinsi][kota]).forEach(kecamatan => {
                        const option = document.createElement('option');
                        option.value = kecamatan;
                        option.textContent = kecamatan;
                        kecamatanSelect.appendChild(option);
                    });
                } else {
                    kecamatanSelect.disabled = true;
                    kelurahanSelect.disabled = true;
                }
                updateAlamat();
            });

            // Update kelurahan dropdown based on kecamatan
            kecamatanSelect.addEventListener('change', function() {
                const provinsi = provinsiSelect.value;
                const kota = kotaSelect.value;
                const kecamatan = this.value;
                kelurahanSelect.innerHTML = '<option value="">Pilih Kelurahan / Desa</option>';
                
                if (provinsi && kota && kecamatan && addressData[provinsi] && addressData[provinsi][kota] && addressData[provinsi][kota][kecamatan]) {
                    kelurahanSelect.disabled = false;
                    addressData[provinsi][kota][kecamatan].forEach(kelurahan => {
                        const option = document.createElement('option');
                        option.value = kelurahan;
                        option.textContent = kelurahan;
                        kelurahanSelect.appendChild(option);
                    });
                } else {
                    kelurahanSelect.disabled = true;
                }
                updateAlamat();
            });

            // Update alamat when any field changes
            [kelurahanSelect, jalanInput].forEach(element => {
                if (element) {
                    element.addEventListener('change', updateAlamat);
                    element.addEventListener('input', updateAlamat);
                }
            });

            // Function to update alamat hidden field
            function updateAlamat() {
                const parts = [];
                
                if (jalanInput.value) parts.push(jalanInput.value);
                if (kelurahanSelect.value) parts.push('Kel. ' + kelurahanSelect.value);
                if (kecamatanSelect.value) parts.push('Kec. ' + kecamatanSelect.value);
                if (kotaSelect.value) parts.push(kotaSelect.value);
                if (provinsiSelect.value) parts.push(provinsiSelect.value);
                
                const alamatLengkap = parts.join(', ');
                alamatHidden.value = alamatLengkap;
            }

            // Format phone number
            const noTeleponInput = document.getElementById('no_telepon');
            if (noTeleponInput) {
                noTeleponInput.addEventListener('input', function(e) {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            }

            // Payment calculation
            const biayaPendaftaran = document.getElementById('biaya_pendaftaran');
            const biayaAngsuran = document.getElementById('biaya_angsuran');
            const totalBiaya = document.getElementById('total_biaya');

            function formatRupiah(angka, prefix) {
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
            }

            function calculateTotal() {
                const pendaftaran = parseFloat(biayaPendaftaran.value.replace(/[^,\d]/g, '')) || 0;
                const angsuran = parseFloat(biayaAngsuran.value.replace(/[^,\d]/g, '')) || 0;
                totalBiaya.value = pendaftaran + angsuran;
                totalBiaya.value = formatRupiah(totalBiaya.value.toString(), 'Rp. ');
            }

            if (biayaPendaftaran && biayaAngsuran && totalBiaya) {
                biayaPendaftaran.addEventListener('input', function(e) {
                    e.target.value = formatRupiah(this.value, 'Rp. ');
                    calculateTotal();
                });
                biayaAngsuran.addEventListener('input', function(e) {
                    e.target.value = formatRupiah(this.value, 'Rp. ');
                    calculateTotal();
                });

                // Initial formatting and calculation on page load
                biayaPendaftaran.value = formatRupiah(biayaPendaftaran.value, 'Rp. ');
                biayaAngsuran.value = formatRupiah(biayaAngsuran.value, 'Rp. ');
                calculateTotal();
                calculateDiscount();
            }

            // Initialize address
            updateAlamat();

            // Discount calculation
            const discountType = document.getElementById('discount_type');
            const discountValue = document.getElementById('discount_value');
            const totalSetelahDiskon = document.getElementById('total_setelah_diskon');

            function calculateDiscount() {
                const total = parseFloat(totalBiaya.value.replace(/[^,\d]/g, '')) || 0;
                let discount = parseFloat(discountValue.value.replace(/[^,\d]/g, '')) || 0;
                const type = discountType.value;
                let finalTotal = total;

                if (type === 'percentage' && discount > 0) {
                    // Ensure discount is not > 100 for percentage
                    if (discount > 100) {
                        discount = 100;
                        discountValue.value = '100%';
                    }
                    finalTotal = total - (total * (discount / 100));
                } else if (type === 'fixed' && discount > 0) {
                    finalTotal = total - discount;
                }

                totalSetelahDiskon.value = formatRupiah(finalTotal.toString(), 'Rp. ');
            }

            if (discountType && discountValue && totalSetelahDiskon) {
                biayaPendaftaran.addEventListener('input', calculateDiscount);
                biayaAngsuran.addEventListener('input', calculateDiscount);
                
                discountType.addEventListener('change', function() {
                    // Clear value when changing type for clarity
                    discountValue.value = '';
                    calculateDiscount();
                });

                discountValue.addEventListener('input', function(e) {
                    const type = discountType.value;
                    if (type === 'percentage') {
                        let value = this.value.replace(/[^0-9]/g, '');
                        if (value > 100) value = 100;
                        this.value = value ? value + '%' : '';
                    } else { // fixed or no type
                        this.value = formatRupiah(this.value, 'Rp. ');
                    }
                    calculateDiscount();
                });

                // Initial calculation and formatting on page load
                calculateTotal();
                
                const initialDiscountType = discountType.value;
                // Always format if fixed type, or if there's an existing value
                if (initialDiscountType === 'fixed') {
                    discountValue.value = formatRupiah(discountValue.value, 'Rp. ');
                } else if (discountValue.value && initialDiscountType === 'percentage') {
                     discountValue.value = discountValue.value.replace(/[^0-9]/g, '') + '%';
                }
                
                calculateDiscount();
            }
        });
    </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggles = document.querySelectorAll('[data-password-target]');
            toggles.forEach(button => {
                const targetId = button.getAttribute('data-password-target');
                const input = document.getElementById(targetId);
                if (!input) return;

                button.addEventListener('click', () => {
                    const isHidden = input.getAttribute('type') === 'password';
                    input.setAttribute('type', isHidden ? 'text' : 'password');
                    button.textContent = isHidden ? 'Sembunyikan' : 'Lihat';
                });
            });
        });
    </script>
</x-app-layout>
