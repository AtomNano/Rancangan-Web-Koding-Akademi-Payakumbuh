<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Materi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">
                            {{ $materi->judul }}
                        </h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('guru.materi.edit', $materi) }}" 
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Ubah
                            </a>
                            <a href="{{ route('guru.materi.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Kembali
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Informasi Materi</h4>
                            <dl class="mt-2 space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Judul</dt>
                                    <dd class="text-sm text-gray-900">{{ $materi->judul }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Kelas</dt>
                                    <dd class="text-sm text-gray-900">{{ $materi->kelas->nama_kelas }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Tipe File</dt>
                                    <dd class="text-sm text-gray-900">{{ $materi->file_type === 'pdf' ? 'PDF' : ($materi->file_type === 'video' ? 'Video' : ($materi->file_type === 'document' ? 'Dokumen' : 'File')) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="text-sm text-gray-900">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $materi->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                               ($materi->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ $materi->status === 'approved' ? 'Disetujui' : 
                                               ($materi->status === 'pending' ? 'Menunggu Verifikasi' : 'Ditolak') }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Diunggah</dt>
                                    <dd class="text-sm text-gray-900">{{ $materi->created_at->format('d M Y H:i') }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Deskripsi</h4>
                            <p class="mt-2 text-sm text-gray-900">{{ $materi->deskripsi }}</p>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-4">File</h4>
                        <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center mb-4">
                                    <svg class="h-8 w-8 text-gray-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ basename($materi->file_path) }}</p>
                                        <p class="text-sm text-gray-500">{{ $materi->file_type === 'pdf' ? 'PDF' : ($materi->file_type === 'video' ? 'Video' : 'File') }} File</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    @if ($materi->file_type === 'pdf')
                                        <div class="w-full">
                                            <x-pdf-viewer :materi="$materi" />
                                        </div>
                                    @else
                                        <a href="{{ Storage::url($materi->file_path) }}" download
                                           class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                                            Unduh
                                        </a>
                                    @endif
                                </div>
                        </div>
                    </div>

                    @if($materi->status === 'pending')
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.726-1.36 3.491 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">
                                        Menunggu Verifikasi Admin
                                    </h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <p>Materi ini sedang menunggu verifikasi dari admin sebelum dapat diakses oleh siswa.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

