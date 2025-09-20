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
                            <h3 class="text-lg font-semibold text-gray-800">Informasi Dasar</h3>
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
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
                                <div>
                                    <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                                    <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir" :value="old('tanggal_lahir', $user->tanggal_lahir ? $user->tanggal_lahir->format('Y-m-d') : '')" />
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
                                    <x-input-label for="alamat" :value="__('Alamat')" />
                                    <textarea id="alamat" name="alamat" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('alamat', $user->alamat) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Academic Information Section -->
                        <div class="p-6 bg-gray-50 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800">Informasi Akademik</h3>
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="tanggal_pendaftaran" :value="__('Tanggal Pendaftaran')" />
                                    <x-text-input id="tanggal_pendaftaran" class="block mt-1 w-full bg-gray-200" type="date" name="tanggal_pendaftaran" :value="old('tanggal_pendaftaran', $user->tanggal_pendaftaran ? $user->tanggal_pendaftaran->format('Y-m-d') : '')" readonly />
                                </div>
                                <div>
                                    <x-input-label for="sekolah" :value="__('Sekolah/Institusi')" />
                                    <x-text-input id="sekolah" class="block mt-1 w-full" type="text" name="sekolah" :value="old('sekolah', $user->sekolah)" />
                                </div>
                                <div>
                                    <x-input-label for="bidang_ajar" :value="__('Bidang Ajar')" />
                                    <select id="bidang_ajar" name="bidang_ajar" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="">Pilih Bidang</option>
                                        <option value="Robotic" {{ old('bidang_ajar', $user->bidang_ajar) == 'Robotic' ? 'selected' : '' }}>Robotic</option>
                                        <option value="Coding" {{ old('bidang_ajar', $user->bidang_ajar) == 'Coding' ? 'selected' : '' }}>Coding</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="durasi" :value="__('Durasi Program')" />
                                    <select id="durasi" name="durasi" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="">Pilih Durasi</option>
                                        <option value="3 Bulan" {{ old('durasi', $user->durasi) == '3 Bulan' ? 'selected' : '' }}>3 Bulan</option>
                                        <option value="6 Bulan" {{ old('durasi', $user->durasi) == '6 Bulan' ? 'selected' : '' }}>6 Bulan</option>
                                        <option value="12 Bulan" {{ old('durasi', $user->durasi) == '12 Bulan' ? 'selected' : '' }}>12 Bulan</option>
                                    </select>
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
                                </div>
                            </div>
                        </div>

                        <!-- Payment Information Section -->
                        <div class="p-6 bg-blue-50 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800">Informasi Pembayaran</h3>
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="metode_pembayaran" :value="__('Metode Pembayaran')" />
                                    <select id="metode_pembayaran" name="metode_pembayaran" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="">Pilih Metode</option>
                                        <option value="Transfer" {{ old('metode_pembayaran', $user->metode_pembayaran) == 'Transfer' ? 'selected' : '' }}>Transfer</option>
                                        <option value="Cash" {{ old('metode_pembayaran', $user->metode_pembayaran) == 'Cash' ? 'selected' : '' }}>Cash</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="status_promo" :value="__('Status Promo')" />
                                    <x-text-input id="status_promo" class="block mt-1 w-full" type="text" name="status_promo" :value="old('status_promo', $user->status_promo)" placeholder="e.g., Free Siblings Promo" />
                                </div>
                                <div>
                                    <x-input-label for="biaya_pendaftaran" :value="__('Biaya Pendaftaran')" />
                                    <x-text-input id="biaya_pendaftaran" class="block mt-1 w-full" type="number" name="biaya_pendaftaran" :value="old('biaya_pendaftaran', $user->biaya_pendaftaran)" />
                                </div>
                                <div>
                                    <x-input-label for="biaya_angsuran" :value="__('Biaya Angsuran')" />
                                    <x-text-input id="biaya_angsuran" class="block mt-1 w-full" type="number" name="biaya_angsuran" :value="old('biaya_angsuran', $user->biaya_angsuran)" />
                                </div>
                                <div class="md:col-span-2">
                                    <x-input-label for="total_biaya" :value="__('Total Biaya')" />
                                    <x-text-input id="total_biaya" class="block mt-1 w-full bg-gray-200" type="number" name="total_biaya" :value="old('total_biaya', $user->total_biaya)" readonly />
                                </div>
                            </div>
                        </div>

                        <!-- Class Selection Section -->
                        <div class="p-6 bg-green-50 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800">Pilihan Kelas</h3>
                            <div class="mt-4">
                                <x-input-label for="kelas_ids" :value="__('Daftarkan ke Kelas')" />
                                <select name="kelas_ids[]" id="kelas_ids" multiple class="block mt-1 w-full h-40 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    @foreach ($kelas as $item)
                                        <option value="{{ $item->id }}" {{ in_array($item->id, old('kelas_ids', $enrolledClassIds)) ? 'selected' : '' }}>
                                            {{ $item->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-sm text-gray-500 mt-1">Tahan Ctrl (atau Cmd di Mac) untuk memilih lebih dari satu.</p>
                            </div>
                        </div>

                        <!-- Login Information Section -->
                        <div class="p-6 bg-purple-50 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800">Informasi Login</h3>
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
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
                        </div>

                    @else
                        <!-- Fallback for non-siswa roles -->
                        <div class="p-6">
                           <p>Editing for this role is not supported through this form.</p>
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
            const biayaPendaftaran = document.getElementById('biaya_pendaftaran');
            const biayaAngsuran = document.getElementById('biaya_angsuran');
            const totalBiaya = document.getElementById('total_biaya');

            function calculateTotal() {
                const pendaftaran = parseFloat(biayaPendaftaran.value) || 0;
                const angsuran = parseFloat(biayaAngsuran.value) || 0;
                totalBiaya.value = pendaftaran + angsuran;
            }

            biayaPendaftaran.addEventListener('input', calculateTotal);
            biayaAngsuran.addEventListener('input', calculateTotal);

            // Initial calculation on page load
            calculateTotal();
        });
    </script>
    @endif
</x-app-layout>
