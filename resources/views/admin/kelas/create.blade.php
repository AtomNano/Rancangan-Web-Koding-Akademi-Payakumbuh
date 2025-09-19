<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Kelas Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.kelas.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <x-input-label for="nama_kelas" :value="__('Nama Kelas')" />
                                <x-text-input id="nama_kelas" class="block mt-1 w-full" type="text" name="nama_kelas" :value="old('nama_kelas')" required autofocus />
                                <x-input-error :messages="$errors->get('nama_kelas')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="bidang" :value="__('Bidang')" />
                                <select id="bidang" name="bidang" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Pilih Bidang</option>
                                    <option value="coding" {{ old('bidang') === 'coding' ? 'selected' : '' }}>Coding</option>
                                    <option value="desain" {{ old('bidang') === 'desain' ? 'selected' : '' }}>Desain</option>
                                    <option value="robotik" {{ old('bidang') === 'robotik' ? 'selected' : '' }}>Robotik</option>
                                </select>
                                <x-input-error :messages="$errors->get('bidang')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="deskripsi" :value="__('Deskripsi')" />
                                <textarea id="deskripsi" name="deskripsi" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('deskripsi') }}</textarea>
                                <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.kelas.index') }}" 
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
</x-app-layout>
