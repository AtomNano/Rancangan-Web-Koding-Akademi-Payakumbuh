<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('guru.pertemuan.show', ['kelas' => $kelas->id, 'pertemuan' => $pertemuan->id]) }}" class="text-indigo-500 hover:text-indigo-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h2 class="ml-3 font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Pertemuan: ') . $pertemuan->judul_pertemuan }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('guru.pertemuan.update', ['kelas' => $kelas->id, 'pertemuan' => $pertemuan->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <div>
                                <x-input-label for="judul_pertemuan" :value="__('Judul Pertemuan')" />
                                <x-text-input id="judul_pertemuan" 
                                              class="block mt-1 w-full" 
                                              type="text" 
                                              name="judul_pertemuan" 
                                              :value="old('judul_pertemuan', $pertemuan->judul_pertemuan)" 
                                              required 
                                              autofocus />
                            </div>

                            <div>
                                <x-input-label for="deskripsi" :value="__('Deskripsi (Opsional)')" />
                                <textarea id="deskripsi" 
                                          name="deskripsi" 
                                          rows="3" 
                                          class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('deskripsi', $pertemuan->deskripsi) }}</textarea>
                            </div>

                            <div>
                                <x-input-label for="materi" :value="__('Materi yang Dipelajari (Opsional)')" />
                                <x-text-input id="materi" 
                                              class="block mt-1 w-full" 
                                              type="text" 
                                              name="materi" 
                                              :value="old('materi', $pertemuan->materi ?? '')" 
                                              placeholder="Contoh: Pengenalan HTML, CSS Dasar, JavaScript Fundamentals..." />
                                <p class="mt-1 text-xs text-gray-500">Masukkan nama materi atau topik yang akan dipelajari</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <x-input-label for="tanggal_pertemuan" :value="__('Tanggal Pertemuan')" />
                                    <x-text-input id="tanggal_pertemuan" 
                                                  class="block mt-1 w-full" 
                                                  type="date" 
                                                  name="tanggal_pertemuan" 
                                                  :value="old('tanggal_pertemuan', $pertemuan->tanggal_pertemuan->format('Y-m-d'))" 
                                                  required />
                                </div>

                                <div>
                                    <x-input-label for="waktu_mulai" :value="__('Waktu Mulai (Opsional)')" />
                                    <x-text-input id="waktu_mulai" 
                                                  class="block mt-1 w-full" 
                                                  type="time" 
                                                  name="waktu_mulai" 
                                                  :value="old('waktu_mulai', $pertemuan->waktu_mulai ?? '')" />
                                </div>

                                <div>
                                    <x-input-label for="waktu_selesai" :value="__('Waktu Selesai (Opsional)')" />
                                    <x-text-input id="waktu_selesai" 
                                                  class="block mt-1 w-full" 
                                                  type="time" 
                                                  name="waktu_selesai" 
                                                  :value="old('waktu_selesai', $pertemuan->waktu_selesai ?? '')" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('guru.pertemuan.show', ['kelas' => $kelas->id, 'pertemuan' => $pertemuan->id]) }}" 
                               class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                Batal
                            </a>
                            <x-primary-button>
                                Simpan Perubahan
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

