<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Berikut adalah data profil Anda. Data ini tidak dapat diubah melalui halaman ini.') }}
        </p>
    </header>

    <div class="mt-6 space-y-6">
        @if(auth()->user()->isSiswa())
            @php
                $activeEnrollment = $user->enrollments()->where('status', 'active')->first();
            @endphp
            
            <!-- Membership Status -->
            <div class="flex items-center">
                <h4 class="text-sm font-medium text-gray-700 mr-4">Status Keanggotaan:</h4>
                @if($activeEnrollment)
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Aktif
                    </span>
                @else
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                        Tidak Aktif
                    </span>
                @endif
            </div>

            <hr/>

            <!-- Student Data Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-6">
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Nama Lengkap</h4>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Email</h4>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500">No. Telepon</h4>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->no_telepon ?? '-' }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Tanggal Lahir</h4>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->tanggal_lahir ? $user->tanggal_lahir->format('d F Y') : '-' }}</p>
                </div>
                <div class="md:col-span-2">
                    <h4 class="text-sm font-medium text-gray-500">Alamat</h4>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->alamat ?? '-' }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Asal Sekolah</h4>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->sekolah ?? '-' }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Bidang Ajar</h4>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->bidang_ajar ?? '-' }}</p>
                </div>
                 <div>
                    <h4 class="text-sm font-medium text-gray-500">Tanggal Pendaftaran</h4>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->tanggal_pendaftaran ? $user->tanggal_pendaftaran->format('d F Y') : '-' }}</p>
                </div>
            </div>

        @else
            <!-- Default view for non-student users -->
            <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                @csrf
                @method('patch')
        
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>
        
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                </div>
            </form>
        @endif
    </div>
</section>