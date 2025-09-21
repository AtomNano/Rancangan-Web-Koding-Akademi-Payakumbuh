<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lihat Materi') }}: {{ $materi->judul }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-2">{{ $materi->judul }}</h3>
                    <p class="text-gray-600 mb-4">{{ $materi->deskripsi }}</p>

                    <div class="mt-6">
                        @if ($materi->file_type === 'pdf')
                            <iframe src="{{ Storage::url($materi->file_path) }}#toolbar=0" class="w-full" style="height: 800px;" frameborder="0"></iframe>
                        @elseif ($materi->file_type === 'video')
                            <video controls class="w-full" src="{{ Storage::url($materi->file_path) }}"></video>
                        @elseif ($materi->file_type === 'document')
                            <p>Untuk melihat dokumen, silakan unduh:</p>
                            <a href="{{ Storage::url($materi->file_path) }}" download class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Unduh Dokumen
                            </a>
                        @elseif ($materi->file_type === 'link')
                            <p>Akses materi melalui tautan berikut:</p>
                            <a href="{{ $materi->file_path }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Buka Tautan
                            </a>
                        @else
                            <p>Tipe materi tidak didukung untuk ditampilkan langsung. Silakan hubungi administrator.</p>
                        @endif
                    </div>

                    <div class="mt-6">
                        <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
