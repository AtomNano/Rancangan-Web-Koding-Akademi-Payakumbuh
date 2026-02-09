<div class="p-6 space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', optional($user ?? null)->name)" required autofocus placeholder="Nama lengkap guru" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', optional($user ?? null)->email)" required placeholder="email@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="no_telepon" :value="__('No. Telepon / WhatsApp')" />
            <div class="mt-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="text-gray-500 sm:text-sm">+62</span>
                </div>
                <x-text-input id="no_telepon" class="block w-full pl-12" type="tel" name="no_telepon"
                    :value="old('no_telepon', optional($user ?? null)->no_telepon ?? '')" placeholder="81234567890"
                    pattern="[0-9]{10,13}" />
            </div>
            <p class="mt-1 text-xs text-gray-500">Contoh: 81234567890 (tanpa 0 di depan)</p>
            <x-input-error :messages="$errors->get('no_telepon')" class="mt-2" />
        </div>
    </div>

    <div>
        <x-input-label :value="__('Kelas yang Diajar')" />
        <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
            @php
                $selectedBidangAjar = old('bidang_ajar', optional($user ?? null)->bidang_ajar ?? []);
            @endphp
            @foreach ($kelas as $item)
                <label class="flex items-center p-2 rounded hover:bg-white transition-colors cursor-pointer">
                    <input type="checkbox" name="bidang_ajar[]" value="{{ $item->nama_kelas }}"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ is_array($selectedBidangAjar) && in_array($item->nama_kelas, $selectedBidangAjar) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700 font-medium">{{ $item->nama_kelas }}</span>
                </label>
            @endforeach
        </div>
        <p class="mt-2 text-sm text-gray-500">Pilih kelas yang akan diajar oleh guru ini.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <x-input-label for="password" :value="__('Kata Sandi')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                placeholder="Minimal 8 karakter" :required="!isset($user)" />
            <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter
                {{ isset($user) ? '(Kosongkan jika tidak ingin mengubah)' : '' }}
            </p>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" placeholder="Ulangi kata sandi" :required="!isset($user)" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
    </div>
</div>