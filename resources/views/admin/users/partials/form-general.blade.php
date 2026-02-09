@php
    $roleLabel = match ($role ?? $user->role) {
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
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name ?? '')" required autofocus placeholder="Nama lengkap {{ $roleLabel }}" />
        </div>
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email ?? '')" required placeholder="email@example.com" />
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <x-input-label for="password" :value="__('Kata Sandi')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                placeholder="Minimal 8 karakter" {{ isset($user) ? '' : 'required' }} />
            <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter
                {{ isset($user) ? '(Kosongkan jika tidak ingin mengubah)' : '' }}</p>
        </div>
        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" placeholder="Ulangi kata sandi" {{ isset($user) ? '' : 'required' }} />
        </div>
    </div>
</div>