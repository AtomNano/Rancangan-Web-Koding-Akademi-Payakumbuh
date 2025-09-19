<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Materi Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('guru.materi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <x-input-label for="judul" :value="__('Judul Materi')" />
                                <x-text-input id="judul" class="block mt-1 w-full" type="text" name="judul" :value="old('judul')" required autofocus />
                                <x-input-error :messages="$errors->get('judul')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="deskripsi" :value="__('Deskripsi')" />
                                <textarea id="deskripsi" name="deskripsi" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('deskripsi') }}</textarea>
                                <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="kelas_id" :value="__('Kelas')" />
                                <select id="kelas_id" name="kelas_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Pilih Kelas</option>
                                    @foreach($kelas as $k)
                                        <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama_kelas }} ({{ ucfirst($k->bidang) }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('kelas_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="file_type" :value="__('Tipe File')" />
                                <select id="file_type" name="file_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Pilih Tipe File</option>
                                    <option value="pdf" {{ old('file_type') === 'pdf' ? 'selected' : '' }}>PDF</option>
                                    <option value="video" {{ old('file_type') === 'video' ? 'selected' : '' }}>Video</option>
                                    <option value="document" {{ old('file_type') === 'document' ? 'selected' : '' }}>Dokumen (Word)</option>
                                    <option value="link" {{ old('file_type') === 'link' ? 'selected' : '' }}>Link</option>
                                </select>
                                <x-input-error :messages="$errors->get('file_type')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="file" :value="__('File')" />
                                <input id="file" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="file" name="file" required />
                                <p class="mt-1 text-sm text-gray-500">Maksimal 10MB. Format yang didukung: PDF, MP4, DOC, DOCX</p>
                                <x-input-error :messages="$errors->get('file')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('guru.materi.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Batal
                            </a>
                            <x-primary-button>
                                {{ __('Upload Materi') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
