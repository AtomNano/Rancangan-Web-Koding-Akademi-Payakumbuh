<div class="p-6 bg-blue-50 border-b border-gray-200">
    <div class="flex items-center mb-4">
        <svg class="w-6 h-6 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        <h3 class="text-lg font-semibold text-gray-800">Informasi Pembayaran</h3>
    </div>
    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <x-input-label for="metode_pembayaran" :value="__('Metode Pembayaran')" />
            <select id="metode_pembayaran" name="metode_pembayaran"
                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="">Pilih Metode Pembayaran</option>
                <option value="transfer" {{ old('metode_pembayaran', optional($user ?? null)->metode_pembayaran ?? '') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                <option value="cash" {{ old('metode_pembayaran', optional($user ?? null)->metode_pembayaran ?? '') == 'cash' ? 'selected' : '' }}>Tunai (Cash)</option>
            </select>
            <p class="mt-1 text-xs text-gray-500">Pilih metode pembayaran yang digunakan</p>
        </div>
        <div>
            <x-input-label for="status_promo" :value="__('Status Promo / Diskon')" />
            <select id="status_promo" name="status_promo"
                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="">Tidak Ada Promo</option>
                @foreach(['Promo Saudara Gratis', 'Promo Early Bird', 'Promo Referral', 'Beasiswa'] as $promo)
                    <option value="{{ $promo }}" {{ old('status_promo', optional($user ?? null)->status_promo ?? '') == $promo ? 'selected' : '' }}>{{ $promo }}</option>
                @endforeach
            </select>
            <p class="mt-1 text-xs text-gray-500">Pilih promo atau diskon yang berlaku (jika ada)</p>
        </div>
        <div>
            <x-input-label for="biaya_pendaftaran" :value="__('Biaya Pendaftaran')" />
            <x-text-input id="biaya_pendaftaran" class="block mt-1 w-full" type="text" name="biaya_pendaftaran"
                :value="old('biaya_pendaftaran', isset($user) && $user->biaya_pendaftaran ? 'Rp. ' . number_format($user->biaya_pendaftaran, 0, ',', '.') : '150.000')" />
        </div>
        <div>
            <x-input-label for="biaya_angsuran" :value="__('Biaya Angsuran')" />
            <x-text-input id="biaya_angsuran" class="block mt-1 w-full" type="text" name="biaya_angsuran"
                :value="old('biaya_angsuran', isset($user) && $user->biaya_angsuran ? 'Rp. ' . number_format($user->biaya_angsuran, 0, ',', '.') : '1.250.000')" />
        </div>
        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="total_biaya" :value="__('Total Biaya')" />
                <x-text-input id="total_biaya" class="block mt-1 w-full bg-gray-200" type="text" name="total_biaya"
                    :value="old('total_biaya', isset($user) && $user->total_biaya ? 'Rp. ' . number_format($user->total_biaya, 0, ',', '.') : '')" readonly />
            </div>
            <div>
                <x-input-label for="discount_type" :value="__('Tipe Diskon')" />
                <select id="discount_type" name="discount_type"
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">Tidak Ada Diskon</option>
                    <option value="percentage" {{ old('discount_type', optional($user ?? null)->discount_type ?? '') == 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                    <option value="fixed" {{ old('discount_type', optional($user ?? null)->discount_type ?? '') == 'fixed' ? 'selected' : '' }}>Potongan Tetap (Rp)</option>
                </select>
            </div>
        </div>
        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="discount_value" :value="__('Nilai Diskon')" />
                <x-text-input id="discount_value" class="block mt-1 w-full" type="text" name="discount_value"
                    :value="old('discount_value', optional($user ?? null)->discount_value ?? '')" />
            </div>
            <div>
                <x-input-label for="total_setelah_diskon" :value="__('Total Setelah Diskon')" />
                <x-text-input id="total_setelah_diskon" class="block mt-1 w-full bg-gray-200" type="text"
                    name="total_setelah_diskon" :value="old('total_setelah_diskon', isset($user) && $user->total_setelah_diskon ? 'Rp. ' . number_format($user->total_setelah_diskon, 0, ',', '.') : '')" readonly />
            </div>
        </div>
    </div>
</div>