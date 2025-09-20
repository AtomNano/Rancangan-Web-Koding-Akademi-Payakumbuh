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
                                    <x-text-input id="tanggal_pendaftaran" class="block mt-1 w-full" type="date" name="tanggal_pendaftaran" :value="old('tanggal_pendaftaran', $user->tanggal_pendaftaran ? $user->tanggal_pendaftaran->format('Y-m-d') : '')" />
                                </div>
                                <div>
                                    <x-input-label for="sekolah" :value="__('Sekolah/Institusi')" />
                                    <x-text-input id="sekolah" class="block mt-1 w-full" type="text" name="sekolah" :value="old('sekolah', $user->sekolah)" />
                                </div>
                                <div class="md:col-span-2">
                                    <x-input-label :value="__('Bidang Ajar (Kelas)')" />
                                    <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-4">
                                        @php
                                            $selectedBidangAjar = old('bidang_ajar', json_decode($user->bidang_ajar ?? '[]', true));
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
                                    <p class="mt-2 text-sm text-gray-500">Pilih satu atau lebih kelas untuk siswa.</p>
                                </div>
                                <div>
                                    <x-input-label for="durasi" :value="__('Durasi Program')" />
                                    <div class="mt-2 flex space-x-4">
                                        <label class="flex items-center">
                                            <input type="radio" name="durasi" value="3 Bulan" class="text-indigo-600 focus:ring-indigo-500" {{ old('durasi', $user->durasi) == '3 Bulan' ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-600">3 Bulan</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" name="durasi" value="6 Bulan" class="text-indigo-600 focus:ring-indigo-500" {{ old('durasi', $user->durasi) == '6 Bulan' ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-600">6 Bulan</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" name="durasi" value="12 Bulan" class="text-indigo-600 focus:ring-indigo-500" {{ old('durasi', $user->durasi) == '12 Bulan' ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-600">12 Bulan</span>
                                        </label>
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
                                        $currentEnrollmentStatus = old('enrollment_status', $user->enrollments->first()->status ?? 'inactive');
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
                            <h3 class="text-lg font-semibold text-gray-800">Informasi Pembayaran</h3>
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="metode_pembayaran" :value="__('Metode Pembayaran')" />
                                    <select id="metode_pembayaran" name="metode_pembayaran" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="">Pilih Metode</option>
                                        <option value="transfer" {{ old('metode_pembayaran', $user->metode_pembayaran) == 'transfer' ? 'selected' : '' }}>Transfer</option>
                                        <option value="cash" {{ old('metode_pembayaran', $user->metode_pembayaran) == 'cash' ? 'selected' : '' }}>Cash</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="status_promo" :value="__('Status Promo')" />
                                    <x-text-input id="status_promo" class="block mt-1 w-full" type="text" name="status_promo" :value="old('status_promo', $user->status_promo)" placeholder="e.g., Free Siblings Promo" />
                                </div>
                                <div>
                                    <x-input-label for="biaya_pendaftaran" :value="__('Biaya Pendaftaran')" />
                                    <x-text-input id="biaya_pendaftaran" class="block mt-1 w-full" type="text" name="biaya_pendaftaran" :value="old('biaya_pendaftaran', $user->biaya_pendaftaran)" />
                                </div>
                                <div>
                                    <x-input-label for="biaya_angsuran" :value="__('Biaya Angsuran')" />
                                    <x-text-input id="biaya_angsuran" class="block mt-1 w-full" type="text" name="biaya_angsuran" :value="old('biaya_angsuran', $user->biaya_angsuran)" />
                                </div>
                                <div class="md:col-span-2">
                                    <x-input-label for="total_biaya" :value="__('Total Biaya')" />
                                    <x-text-input id="total_biaya" class="block mt-1 w-full bg-gray-200" type="text" name="total_biaya" :value="old('total_biaya', $user->total_biaya)" readonly />
                                </div>
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

                    @elseif ($user->role === 'guru')
                        <!-- Form for Guru -->
                        <div class="p-6 space-y-6">
                            <div>
                                <x-input-label for="name" :value="__('Nama Lengkap')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required autofocus />
                            </div>
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required />
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
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" />
                                <p class="text-sm text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah password.</p>
                            </div>
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" />
                                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" />
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
        });
    </script>
    @endif
</x-app-layout>
