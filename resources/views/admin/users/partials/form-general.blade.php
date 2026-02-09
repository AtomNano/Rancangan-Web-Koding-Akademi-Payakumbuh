@php
    $roleLabel = match ($role ?? optional($user ?? null)->role) {
        'admin' => 'Admin',
        'cs' => 'CS',
        'guru' => 'Guru',
        default => 'Pengguna'
    };
@endphp
<div class="p-6 space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', optional($user ?? null)->name)" required autofocus placeholder="Nama lengkap {{ $roleLabel }}" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', optional($user ?? null)->email)" required placeholder="email@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
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