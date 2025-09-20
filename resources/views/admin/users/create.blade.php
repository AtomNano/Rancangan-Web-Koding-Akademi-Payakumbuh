<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah ' . ucfirst($role) . ' Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="role" value="{{ $role }}">

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Basic Information -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="name" :value="__('Nama Lengkap')" />
                                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="email" :value="__('Email')" />
                                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="no_telepon" :value="__('No. Telepon')" />
                                        <x-text-input id="no_telepon" class="block mt-1 w-full" type="text" name="no_telepon" :value="old('no_telepon')" />
                                        <x-input-error :messages="$errors->get('no_telepon')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                                        <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir" :value="old('tanggal_lahir')" />
                                        <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                                        <select id="jenis_kelamin" name="jenis_kelamin" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="laki-laki" {{ old('jenis_kelamin') == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="perempuan" {{ old('jenis_kelamin') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
                                    </div>

                                    <div class="md:col-span-2">
                                        <x-input-label for="alamat" :value="__('Alamat')" />
                                        <textarea id="alamat" name="alamat" rows="3" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('alamat') }}</textarea>
                                        <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            <!-- Academic Information -->
                            @if($role === 'siswa')
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Akademik</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <x-input-label for="tanggal_pendaftaran" :value="__('Tanggal Pendaftaran')" />
                                            <x-text-input id="tanggal_pendaftaran" class="block mt-1 w-full" type="date" name="tanggal_pendaftaran" :value="old('tanggal_pendaftaran', date('Y-m-d'))" />
                                            <x-input-error :messages="$errors->get('tanggal_pendaftaran')" class="mt-2" />
                                        </div>

                                        <div>
                                            <x-input-label for="sekolah" :value="__('Sekolah/Institusi')" />
                                            <x-text-input id="sekolah" class="block mt-1 w-full" type="text" name="sekolah" :value="old('sekolah')" />
                                            <x-input-error :messages="$errors->get('sekolah')" class="mt-2" />
                                        </div>

                                        <div>
                                            <x-input-label for="bidang_ajar" :value="__('Bidang Ajar')" />
                                            <select id="bidang_ajar" name="bidang_ajar" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                <option value="">Pilih Bidang Ajar</option>
                                                <option value="Robotic" {{ old('bidang_ajar') == 'Robotic' ? 'selected' : '' }}>Robotic</option>
                                                <option value="Coding" {{ old('bidang_ajar') == 'Coding' ? 'selected' : '' }}>Coding</option>
                                            </select>
                                            <x-input-error :messages="$errors->get('bidang_ajar')" class="mt-2" />
                                        </div>

                                        <div>
                                            <x-input-label for="durasi" :value="__('Durasi Program')" />
                                            <select id="durasi" name="durasi" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                <option value="">Pilih Durasi</option>
                                                <option value="3 Bulan" {{ old('durasi') == '3 Bulan' ? 'selected' : '' }}>3 Bulan</option>
                                                <option value="6 Bulan" {{ old('durasi') == '6 Bulan' ? 'selected' : '' }}>6 Bulan</option>
                                                <option value="12 Bulan" {{ old('durasi') == '12 Bulan' ? 'selected' : '' }}>12 Bulan</option>
                                            </select>
                                            <x-input-error :messages="$errors->get('durasi')" class="mt-2" />
                                        </div>

                                        <div class="md:col-span-2">
                                            <x-input-label for="hari_belajar" :value="__('Hari Belajar')" />
                                            <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-2">
                                                @php
                                                    $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                                                @endphp
                                                @foreach($days as $day)
                                                    <label class="flex items-center">
                                                        <input type="checkbox" name="hari_belajar[]" value="{{ $day }}" 
                                                               {{ in_array($day, old('hari_belajar', [])) ? 'checked' : '' }}
                                                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                        <span class="ml-2 text-sm text-gray-700">{{ $day }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                            <x-input-error :messages="$errors->get('hari_belajar')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment Information -->
                                <div class="bg-green-50 p-4 rounded-lg">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pembayaran</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <x-input-label for="metode_pembayaran" :value="__('Metode Pembayaran')" />
                                            <select id="metode_pembayaran" name="metode_pembayaran" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                <option value="">Pilih Metode Pembayaran</option>
                                                <option value="transfer" {{ old('metode_pembayaran') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                                                <option value="cash" {{ old('metode_pembayaran') == 'cash' ? 'selected' : '' }}>Cash</option>
                                            </select>
                                            <x-input-error :messages="$errors->get('metode_pembayaran')" class="mt-2" />
                                        </div>

                                        <div>
                                            <x-input-label for="status_promo" :value="__('Status Promo')" />
                                            <x-text-input id="status_promo" class="block mt-1 w-full" type="text" name="status_promo" :value="old('status_promo')" placeholder="Contoh: Free Siblings Promo" />
                                            <x-input-error :messages="$errors->get('status_promo')" class="mt-2" />
                                        </div>

                                        <div>
                                            <x-input-label for="biaya_pendaftaran" :value="__('Biaya Pendaftaran (Rp)')" />
                                            <x-text-input id="biaya_pendaftaran" class="block mt-1 w-full" type="number" name="biaya_pendaftaran" :value="old('biaya_pendaftaran')" min="0" step="1000" />
                                            <x-input-error :messages="$errors->get('biaya_pendaftaran')" class="mt-2" />
                                        </div>

                                        <div>
                                            <x-input-label for="biaya_angsuran" :value="__('Biaya Angsuran (Rp)')" />
                                            <x-text-input id="biaya_angsuran" class="block mt-1 w-full" type="number" name="biaya_angsuran" :value="old('biaya_angsuran')" min="0" step="1000" />
                                            <x-input-error :messages="$errors->get('biaya_angsuran')" class="mt-2" />
                                        </div>

                                        <div>
                                            <x-input-label for="total_biaya" :value="__('Total Biaya (Rp)')" />
                                            <x-text-input id="total_biaya" class="block mt-1 w-full" type="number" name="total_biaya" :value="old('total_biaya')" min="0" step="1000" />
                                            <x-input-error :messages="$errors->get('total_biaya')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Class Selection -->
                                <div class="bg-yellow-50 p-4 rounded-lg">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Pilihan Kelas</h3>
                                    <div>
                                        <x-input-label for="kelas_ids" :value="__('Kelas yang Diikuti')" />
                                        <div class="mt-2 space-y-2">
                                            @foreach($kelas as $k)
                                                <label class="flex items-center">
                                                    <input type="checkbox" name="kelas_ids[]" value="{{ $k->id }}" 
                                                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                    <span class="ml-2 text-sm text-gray-700">
                                                        {{ $k->nama_kelas }} ({{ ucfirst($k->bidang) }})
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                        <x-input-error :messages="$errors->get('kelas_ids')" class="mt-2" />
                                    </div>
                                </div>
                            @endif

                            <!-- Password Section -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Login</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="password" :value="__('Password')" />
                                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.users.index', ['role' => $role]) }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Batal
                            </a>
                            <x-primary-button>
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if($role === 'siswa')
    <script>
        // Auto-calculate total cost
        document.addEventListener('DOMContentLoaded', function() {
            const biayaPendaftaran = document.getElementById('biaya_pendaftaran');
            const biayaAngsuran = document.getElementById('biaya_angsuran');
            const totalBiaya = document.getElementById('total_biaya');

            function calculateTotal() {
                const pendaftaran = parseFloat(biayaPendaftaran.value) || 0;
                const angsuran = parseFloat(biayaAngsuran.value) || 0;
                const total = pendaftaran + angsuran;
                totalBiaya.value = total > 0 ? total : '';
            }

            biayaPendaftaran.addEventListener('input', calculateTotal);
            biayaAngsuran.addEventListener('input', calculateTotal);
        });
    </script>
    @endif
</x-app-layout>

