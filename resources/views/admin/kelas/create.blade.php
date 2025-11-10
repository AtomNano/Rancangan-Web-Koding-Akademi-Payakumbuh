<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Kelas Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($errors->any())
                        <div class="mb-4">
                            <div class="font-medium text-red-600">{{ __('Ups! Terjadi kesalahan.') }}</div>
                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.kelas.store') }}" method="POST">
                        @csrf

                        <div>
                            <x-input-label for="nama_kelas" :value="__('Nama Kelas')" />
                            <x-text-input id="nama_kelas" class="block mt-1 w-full" type="text" name="nama_kelas" :value="old('nama_kelas')" required autofocus />
                            <x-input-error :messages="$errors->get('nama_kelas')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="guru_id" :value="__('Guru Pengajar')" />
                            <select name="guru_id" id="guru_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih seorang guru</option>
                                @foreach ($gurus as $guru)
                                    <option value="{{ $guru->id }}" {{ old('guru_id') == $guru->id ? 'selected' : '' }}>
                                        {{ $guru->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('guru_id')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="bidang" :value="__('Bidang')" />
                            <select name="bidang" id="bidang" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih bidang</option>
                                <option value="coding" {{ old('bidang') == 'coding' ? 'selected' : '' }}>Coding</option>
                                <option value="desain" {{ old('bidang') == 'desain' ? 'selected' : '' }}>Desain</option>
                                <option value="robotik" {{ old('bidang') == 'robotik' ? 'selected' : '' }}>Robotik</option>
                            </select>
                            <x-input-error :messages="$errors->get('bidang')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="deskripsi" :value="__('Deskripsi')" />
                            <textarea id="deskripsi" name="deskripsi" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('deskripsi') }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.kelas.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                {{ __('Batal') }}
                            </a>

                            <x-primary-button>
                                {{ __('Simpan Kelas') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>