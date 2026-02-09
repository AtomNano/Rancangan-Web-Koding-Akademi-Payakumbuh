<div class="p-6 bg-white border-b border-gray-200">
    <div class="flex items-center mb-4">
        <svg class="w-6 h-6 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
        <h3 class="text-lg font-semibold text-gray-800">Informasi Dasar</h3>
    </div>
    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name ?? '')" required autofocus placeholder="Masukkan nama lengkap" />
            <p class="mt-1 text-xs text-gray-500">Nama lengkap sesuai identitas</p>
        </div>
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email ?? '')" required placeholder="email@example.com" />
            <p class="mt-1 text-xs text-gray-500">Email aktif untuk login</p>
        </div>

        @if(isset($user))
            <div>
                <x-input-label :value="__('ID Siswa')" />
                <div class="mt-1 p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-sm font-semibold text-gray-800">{{ $user->id_siswa ?? '-' }}</p>
                    <p class="text-xs text-gray-500 mt-1">Format: NNN-KODEKELASNUM2-MMYYYY</p>
                </div>
            </div>
        @else
            <div>
                <x-input-label :value="__('ID Siswa')" />
                <div class="mt-1 p-3 bg-gray-100 rounded-lg border border-gray-300">
                    <p class="text-sm text-gray-600">Akan di-generate otomatis setelah pendaftaran</p>
                    <p class="text-xs text-gray-500 mt-1">Format: NNN-KODEKELASNUM2-MMYYYY (contoh: 001-01-122025)</p>
                </div>
            </div>
        @endif

        <div>
            <x-input-label for="no_telepon" :value="__('No. Telepon / WhatsApp')" />
            <div class="mt-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="text-gray-500 sm:text-sm">+62</span>
                </div>
                <x-text-input id="no_telepon" class="block w-full pl-12" type="tel" name="no_telepon"
                    :value="old('no_telepon', $user->no_telepon ?? '')" placeholder="81234567890"
                    pattern="[0-9]{10,13}" />
            </div>
            <p class="mt-1 text-xs text-gray-500">Contoh: 81234567890 (tanpa 0 di depan)</p>
        </div>
        <div>
            <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
            <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir"
                :value="old('tanggal_lahir', isset($user) && $user->tanggal_lahir ? $user->tanggal_lahir->format('Y-m-d') : '')" max="{{ date('Y-m-d', strtotime('-5 years')) }}" />
            <p class="mt-1 text-xs text-gray-500">Minimal 5 tahun</p>
        </div>
        <div>
            <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
            <select id="jenis_kelamin" name="jenis_kelamin"
                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="">Pilih Jenis Kelamin</option>
                <option value="laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin ?? '') == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin ?? '') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>
        <div class="md:col-span-2">
            <x-input-label :value="__('Alamat Lengkap')" />
            <div class="mt-2 space-y-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <!-- Detail Alamat -->
                @php
                    $alamatParts = [];
                    if (isset($user) && $user->alamat) {
                        // ... (Parsing logic from edit.blade.php would go here if we want to share it, otherwise we rely on controller or view composer)
                        // For now, let's just make it work for create primarily, and standardise for edit later or pass data in.
                        $parts = explode(',', $user->alamat);
                        foreach ($parts as $part) {
                            $part = trim($part);
                            if (strpos($part, 'Kel. ') === 0 || strpos($part, 'Kel ') === 0) {
                                $alamatParts['kelurahan'] = str_replace(['Kel. ', 'Kel '], '', $part);
                            } elseif (strpos($part, 'Kec. ') === 0 || strpos($part, 'Kec ') === 0) {
                                $alamatParts['kecamatan'] = str_replace(['Kec. ', 'Kec '], '', $part);
                            } else {
                                // Check if it's a known province
                                $provincesList = [
                                    'Sumatera Barat',
                                    'Sumatera Utara',
                                    'Sumatera Selatan',
                                    'Riau',
                                    'Kepulauan Riau',
                                    'Jambi',
                                    'Bengkulu',
                                    'Lampung',
                                    'Bangka Belitung',
                                    'Aceh',
                                    'DKI Jakarta',
                                    'Jawa Barat',
                                    'Jawa Tengah',
                                    'Jawa Timur',
                                    'Yogyakarta',
                                    'Banten',
                                    'Bali',
                                    'Nusa Tenggara Barat',
                                    'Nusa Tenggara Timur',
                                    'Kalimantan Barat',
                                    'Kalimantan Tengah',
                                    'Kalimantan Selatan',
                                    'Kalimantan Timur',
                                    'Kalimantan Utara',
                                    'Sulawesi Utara',
                                    'Sulawesi Tengah',
                                    'Sulawesi Selatan',
                                    'Sulawesi Tenggara',
                                    'Gorontalo',
                                    'Sulawesi Barat',
                                    'Maluku',
                                    'Maluku Utara',
                                    'Papua Barat',
                                    'Papua',
                                    'Papua Selatan',
                                    'Papua Tengah',
                                    'Papua Pegunungan'
                                ];
                                if (in_array($part, $provincesList)) {
                                    $alamatParts['provinsi'] = $part;
                                } elseif (!isset($alamatParts['jalan']) && !isset($alamatParts['kota']) && !isset($alamatParts['provinsi'])) {
                                    $alamatParts['jalan'] = $part;
                                } elseif (!isset($alamatParts['kota']) && isset($alamatParts['jalan']) && !isset($alamatParts['provinsi'])) {
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
                    <select id="provinsi" name="provinsi"
                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Pilih Provinsi</option>
                        @php
                            $provinces = [
                                'Sumatera Barat',
                                'Sumatera Utara',
                                'Sumatera Selatan',
                                'Riau',
                                'Kepulauan Riau',
                                'Jambi',
                                'Bengkulu',
                                'Lampung',
                                'Bangka Belitung',
                                'Aceh',
                                'DKI Jakarta',
                                'Jawa Barat',
                                'Jawa Tengah',
                                'Jawa Timur',
                                'Yogyakarta',
                                'Banten',
                                'Bali',
                                'Nusa Tenggara Barat',
                                'Nusa Tenggara Timur',
                                'Kalimantan Barat',
                                'Kalimantan Tengah',
                                'Kalimantan Selatan',
                                'Kalimantan Timur',
                                'Kalimantan Utara',
                                'Sulawesi Utara',
                                'Sulawesi Tengah',
                                'Sulawesi Selatan',
                                'Sulawesi Tenggara',
                                'Gorontalo',
                                'Sulawesi Barat',
                                'Maluku',
                                'Maluku Utara',
                                'Papua Barat',
                                'Papua',
                                'Papua Selatan',
                                'Papua Tengah',
                                'Papua Pegunungan'
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
                    <select id="kota" name="kota"
                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        {{ isset($alamatParts['kota']) ? '' : 'disabled' }}>
                        @if(isset($alamatParts['kota']))
                            <option value="{{ $alamatParts['kota'] }}" selected>{{ $alamatParts['kota'] }}</option>
                        @else
                            <option value="">Pilih Provinsi terlebih dahulu</option>
                        @endif
                    </select>
                </div>

                <!-- Kecamatan -->
                <div>
                    <x-input-label for="kecamatan" :value="__('Kecamatan')" />
                    <select id="kecamatan" name="kecamatan"
                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        {{ isset($alamatParts['kecamatan']) ? '' : 'disabled' }}>
                        @if(isset($alamatParts['kecamatan']))
                            <option value="{{ $alamatParts['kecamatan'] }}" selected>{{ $alamatParts['kecamatan'] }}
                            </option>
                        @else
                            <option value="">Pilih Kota terlebih dahulu</option>
                        @endif
                    </select>
                </div>

                <!-- Kelurahan -->
                <div>
                    <x-input-label for="kelurahan" :value="__('Kelurahan / Desa')" />
                    <select id="kelurahan" name="kelurahan"
                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        {{ isset($alamatParts['kelurahan']) ? '' : 'disabled' }}>
                        @if(isset($alamatParts['kelurahan']))
                            <option value="{{ $alamatParts['kelurahan'] }}" selected>{{ $alamatParts['kelurahan'] }}
                            </option>
                        @else
                            <option value="">Pilih Kecamatan terlebih dahulu</option>
                        @endif
                    </select>
                </div>

                <!-- Alamat Lengkap (Hidden - akan diisi otomatis) -->
                <input type="hidden" id="alamat" name="alamat" value="{{ old('alamat', $user->alamat ?? '') }}">
            </div>
        </div>
    </div>
</div>