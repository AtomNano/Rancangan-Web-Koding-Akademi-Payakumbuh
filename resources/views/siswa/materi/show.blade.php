<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Materi: ' . $materi->judul) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">{{ $materi->judul }}</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('siswa.kelas.show', $materi->kelas) }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Kembali ke Kelas
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Informasi Materi</h4>
                            <dl class="mt-2 space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Kelas</dt>
                                    <dd class="text-sm text-gray-900">{{ $materi->kelas->nama_kelas }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Tipe File</dt>
                                    <dd class="text-sm text-gray-900">{{ ucfirst($materi->file_type) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Oleh</dt>
                                    <dd class="text-sm text-gray-900">{{ $materi->uploadedBy->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Tanggal</dt>
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
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-4">File Materi</h4>
                        <div class="border border-gray-200 rounded-lg p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="h-12 w-12 text-gray-400 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <div>
                                        <p class="text-lg font-medium text-gray-900">{{ basename($materi->file_path) }}</p>
                                        <p class="text-sm text-gray-500">{{ ucfirst($materi->file_type) }} File</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ Storage::url($materi->file_path) }}" target="_blank"
                                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Buka File
                                    </a>
                                    <a href="{{ Storage::url($materi->file_path) }}" download
                                       class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PDF Viewer for PDF files -->
                    @if($materi->file_type === 'pdf')
                        <div class="mb-8">
                            <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-4">Preview</h4>
                            <div class="border border-gray-200 rounded-lg">
                                <iframe src="{{ Storage::url($materi->file_path) }}" 
                                        class="w-full h-96" 
                                        frameborder="0">
                                </iframe>
                            </div>
                        </div>
                    @endif

                    <!-- Video Player for Video files -->
                    @if($materi->file_type === 'video')
                        <div class="mb-8">
                            <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-4">Video Player</h4>
                            <div class="border border-gray-200 rounded-lg">
                                <video controls class="w-full">
                                    <source src="{{ Storage::url($materi->file_path) }}" type="video/mp4">
                                    Browser Anda tidak mendukung video player.
                                </video>
                            </div>
                        </div>
                    @endif

                    <!-- Completion Button -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-green-800">Selesaikan Materi</h4>
                                <p class="text-sm text-green-700">Klik tombol di bawah setelah selesai mempelajari materi ini.</p>
                            </div>
                            <form action="{{ route('siswa.materi.complete', $materi) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                                        onclick="return confirm('Apakah Anda yakin sudah selesai mempelajari materi ini?')">
                                    Tandai Selesai
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
