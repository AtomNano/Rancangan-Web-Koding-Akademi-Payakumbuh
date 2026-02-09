<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit ') . ($user->role === 'admin' ? 'Admin' : ($user->role === 'guru' ? 'Guru' : ($user->role === 'cs' ? 'CS' : 'Siswa'))) . ': ' . $user->name }}
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

                <form
                    action="{{ auth()->user()->isCS() ? route('cs.siswa.update', $user->id) : route('admin.users.update', $user->id) }}"
                    method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="role" value="{{ $user->role }}">

                    @if ($user->role === 'siswa')
                        @include('admin.users.partials.form-siswa-basic')
                        @include('admin.users.partials.form-siswa-academic')
                        @include('admin.users.partials.form-siswa-payment')

                        <!-- Login Information Section -->
                        <div class="p-6 bg-purple-50 border-b border-gray-200">
                            <div class="flex items-center mb-4">
                                <svg class="w-6 h-6 text-indigo-600 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-800">Informasi Masuk</h3>
                            </div>
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="password" :value="__('Kata Sandi')" />
                                    <div class="relative mt-1">
                                        <x-text-input id="password" class="block w-full pr-24" type="password"
                                            name="password" />
                                        <button type="button"
                                            class="absolute inset-y-0 right-0 px-3 text-sm text-indigo-600 hover:text-indigo-800 font-medium"
                                            data-password-target="password">Lihat</button>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah kata sandi.
                                    </p>
                                </div>
                                <div>
                                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" />
                                    <div class="relative mt-1">
                                        <x-text-input id="password_confirmation" class="block w-full pr-24" type="password"
                                            name="password_confirmation" />
                                        <button type="button"
                                            class="absolute inset-y-0 right-0 px-3 text-sm text-indigo-600 hover:text-indigo-800 font-medium"
                                            data-password-target="password_confirmation">Lihat</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @elseif ($user->role === 'guru')
                        @include('admin.users.partials.form-guru')
                    @else
                        @include('admin.users.partials.form-general')
                    @endif

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end p-6 bg-gray-50">
                        <a href="{{ auth()->user()->isCS() ? route('cs.siswa.index') : route('admin.users.index', ['role' => $user->role]) }}"
                            class="text-sm text-gray-600 hover:text-gray-900 mr-4">
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
                    if (durationHidden) durationHidden.value = m || '';
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
                            'Payakumbuh Selatan': ['Aie Dingin', 'Koto Baru', 'Koto Nan Gadang', 'Kubang', 'Labuh Baru', 'Padang Tangah', 'Pakan Sinayan', 'Balai Panjang', 'Limbukan', 'Koto Tuo Limo Kampuang', 'Padang Karambia', 'Kapalo Koto Ampangan', 'Sawahpadang', 'Aua Kuniang'],
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

                    // Trigger change events to populate dropdowns
                    if (existingProvinsi) {
                        provinsiSelect.value = existingProvinsi;
                        provinsiSelect.dispatchEvent(new Event('change'));

                        // Wait for kota dropdown to populate
                        setTimeout(() => {
                            if (existingKota) {
                                kotaSelect.value = existingKota;
                                kotaSelect.dispatchEvent(new Event('change'));

                                setTimeout(() => {
                                    if (existingKecamatan) {
                                        kecamatanSelect.value = existingKecamatan;
                                        kecamatanSelect.dispatchEvent(new Event('change'));

                                        setTimeout(() => {
                                            if (existingKelurahan) {
                                                kelurahanSelect.value = existingKelurahan;
                                            }
                                        }, 50);
                                    }
                                }, 50);
                            }
                        }, 50);
                    }
                @endif

                provinsiSelect.addEventListener('change', function () {
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

                kotaSelect.addEventListener('change', function () {
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

                kecamatanSelect.addEventListener('change', function () {
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

                [kelurahanSelect, jalanInput].forEach(element => {
                    if (element) {
                        element.addEventListener('change', updateAlamat);
                        element.addEventListener('input', updateAlamat);
                    }
                });

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

                const noTeleponInput = document.getElementById('no_telepon');
                if (noTeleponInput) {
                    noTeleponInput.addEventListener('input', function (e) {
                        this.value = this.value.replace(/[^0-9]/g, '');
                    });
                }

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
                    biayaPendaftaran.addEventListener('input', function (e) {
                        e.target.value = formatRupiah(this.value, 'Rp. ');
                        calculateTotal();
                    });
                    biayaAngsuran.addEventListener('input', function (e) {
                        e.target.value = formatRupiah(this.value, 'Rp. ');
                        calculateTotal();
                    });

                    // Initial format
                    biayaPendaftaran.value = formatRupiah(biayaPendaftaran.value, 'Rp. ');
                    biayaAngsuran.value = formatRupiah(biayaAngsuran.value, 'Rp. ');
                    calculateTotal();
                }

                const discountType = document.getElementById('discount_type');
                const discountValue = document.getElementById('discount_value');
                const totalSetelahDiskon = document.getElementById('total_setelah_diskon');

                function calculateDiscount() {
                    const total = parseFloat(totalBiaya.value.replace(/[^,\d]/g, '')) || 0;
                    const discount = parseFloat(discountValue.value.replace(/[^,\d]/g, '')) || 0;
                    const type = discountType.value;
                    let finalTotal = total;
                    if (type === 'percentage' && discount > 0) {
                        finalTotal = total - (total * (discount / 100));
                    } else if (type === 'fixed' && discount > 0) {
                        finalTotal = total - discount;
                    }
                    totalSetelahDiskon.value = formatRupiah(finalTotal.toString(), 'Rp. ');
                }

                if (discountType && discountValue && totalSetelahDiskon) {
                    biayaPendaftaran.addEventListener('input', calculateDiscount);
                    biayaAngsuran.addEventListener('input', calculateDiscount);
                    discountType.addEventListener('change', calculateDiscount);
                    discountValue.addEventListener('input', function (e) {
                        e.target.value = formatRupiah(this.value, 'Rp. ');
                        calculateDiscount();
                    });
                    calculateDiscount();
                }

                // Toggle view password
                document.querySelectorAll('[data-password-target]').forEach(button => {
                    button.addEventListener('click', function () {
                        const targetId = this.getAttribute('data-password-target');
                        const input = document.getElementById(targetId);
                        if (input) {
                            if (input.type === 'password') {
                                input.type = 'text';
                                this.textContent = 'Sembunyikan';
                            } else {
                                input.type = 'password';
                                this.textContent = 'Lihat';
                            }
                        }
                    });
                });
            });
        </script>
    @endif
</x-app-layout>