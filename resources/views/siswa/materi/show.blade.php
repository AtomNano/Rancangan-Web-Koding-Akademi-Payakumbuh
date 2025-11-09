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
                                    <dd class="text-sm text-gray-900">{{ $materi->file_type === 'pdf' ? 'PDF' : ($materi->file_type === 'video' ? 'Video' : 'File') }}</dd>
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
                            <div class="flex items-center justify-end space-x-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('siswa.materi.download', $materi->id) }}" target="_blank"
                                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Buka File
                                    </a>
                                    <a href="{{ route('siswa.materi.download', $materi->id) }}" download
                                       class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        Unduh
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PDF Viewer for PDF files -->
                    @if($materi->file_type === 'pdf')
                        <div class="mb-8">
                            <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-4">Pratinjau</h4>
                            @php
                                $userProgress = $materi->userProgress(auth()->id());
                                $currentPage = $userProgress ? $userProgress->current_page : null;
                                $totalPages = $userProgress ? $userProgress->total_pages : null;
                                $progressPercentage = $userProgress ? $userProgress->progress_percentage : null;
                                $isCompleted = $userProgress ? $userProgress->is_completed : false;
                            @endphp
                            <x-pdf-viewer 
                                :materi="$materi" 
                                :current-page="$currentPage"
                                :total-pages="$totalPages"
                                :progress-percentage="$progressPercentage"
                                :is-completed="$isCompleted" />
                        </div>
                    @endif

                    <!-- Video Player for Video files -->
                    @if($materi->file_type === 'video')
                        <div class="mb-8">
                            <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-4">Pemutar Video</h4>
                            <div class="border border-gray-200 rounded-lg">
                                <video controls class="w-full">
                                    <source src="{{ route('siswa.materi.download', $materi->id) }}" type="video/mp4">
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

