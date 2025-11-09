<x-app-layout>
    @if($materi->file_type === 'pdf')
        <!-- Modern PDF Reading Experience -->
        <div class="pdf-reading-mode" id="pdfReadingMode">
            <!-- Right Sidebar - All Info -->
            <div class="fixed right-0 top-0 bottom-0 w-80 bg-white border-l border-gray-200 shadow-lg z-40 overflow-y-auto" id="rightSidebar">
                <div class="p-6">
                    <!-- Header with Actions -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-900">{{ $materi->judul }}</h2>
                            <button id="toggleRightSidebar" class="p-1.5 hover:bg-gray-100 rounded-lg transition-colors" title="Tutup Sidebar">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <p class="text-sm text-gray-600 mb-4">{{ $materi->deskripsi }}</p>
                        <div class="space-y-2 text-sm mb-4">
                            <div class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                {{ $materi->kelas->nama_kelas }}
                            </div>
                            <div class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Diupload oleh: <span class="font-medium ml-1">{{ $materi->uploadedBy->name }}</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $materi->created_at->format('d M Y') }}
                            </div>
                        </div>
                        
                        <!-- Quick Actions -->
                        <div class="grid grid-cols-2 gap-2 mt-4">
                            <button id="toggleFullscreen" class="flex items-center justify-center px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                                </svg>
                                Fullscreen
                            </button>
                            <a href="{{ route('siswa.materi.download', $materi->id) }}" download 
                               class="flex items-center justify-center px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Download
                            </a>
                            <a href="{{ route('siswa.kelas.show', $materi->kelas) }}" 
                               class="col-span-2 flex items-center justify-center px-3 py-2 bg-indigo-100 hover:bg-indigo-200 rounded-lg transition-colors text-sm font-medium text-indigo-700">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Kembali ke Kelas
                            </a>
                        </div>
                    </div>
                    
                    <!-- Progress Overview -->
                    @php
                        $userProgress = $materi->userProgress(auth()->id());
                        $currentPage = $userProgress ? $userProgress->current_page : 1;
                        $totalPages = $userProgress ? $userProgress->total_pages : 1;
                        $progressPercentage = $userProgress ? $userProgress->progress_percentage : 0;
                        $isCompleted = $userProgress ? $userProgress->is_completed : false;
                    @endphp
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-900 mb-3">Progress Membaca</h3>
                        <div class="space-y-3">
                            <div>
                                <div class="flex items-center justify-between text-sm mb-2">
                                    <span class="text-gray-600">Kemajuan</span>
                                    <span class="font-medium text-gray-900" id="progressText">{{ number_format($progressPercentage, 1) }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-indigo-600 h-3 rounded-full transition-all duration-300" 
                                         id="progressBar" style="width: {{ $progressPercentage }}%"></div>
                                </div>
                            </div>
                            <div class="text-xs text-gray-500">
                                Halaman <span id="sidebarCurrentPage">{{ $currentPage }}</span> dari <span id="sidebarTotalPages">{{ $totalPages }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Absen Form -->
                    @php
                        $today = now()->toDateString();
                        $todayPresensi = \App\Models\Presensi::where('user_id', auth()->id())
                            ->where('materi_id', $materi->id)
                            ->whereDate('tanggal_akses', $today)
                            ->first();
                    @endphp
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-900 mb-3">Absen Hari Ini</h3>
                        @if($todayPresensi)
                            <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-green-800">Sudah Absen</p>
                                        <p class="text-xs text-green-600">{{ $todayPresensi->tanggal_akses->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <form action="{{ route('siswa.materi.absen', $materi) }}" method="POST" id="absenForm">
                                @csrf
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Status Kehadiran</label>
                                        <select name="status_kehadiran" class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                            <option value="hadir">Hadir</option>
                                            <option value="izin">Izin</option>
                                            <option value="sakit">Sakit</option>
                                            <option value="alpha">Alpha</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors text-sm">
                                        Submit Absen
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>

                    <!-- Log Akses -->
                    @php
                        $accessLogs = \App\Models\Presensi::where('user_id', auth()->id())
                            ->where('materi_id', $materi->id)
                            ->orderBy('tanggal_akses', 'desc')
                            ->limit(10)
                            ->get();
                    @endphp
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-900 mb-3">Riwayat Akses</h3>
                        <div class="space-y-2 max-h-48 overflow-y-auto">
                            @forelse($accessLogs as $log)
                                <div class="flex items-center justify-between text-xs p-2 bg-gray-50 rounded">
                                    <div>
                                        <p class="font-medium text-gray-700">{{ $log->tanggal_akses->format('d M Y') }}</p>
                                        <p class="text-gray-500">{{ $log->tanggal_akses->format('H:i') }}</p>
                                    </div>
                                    <span class="px-2 py-1 rounded text-xs font-medium
                                        {{ $log->status_kehadiran === 'hadir' ? 'bg-green-100 text-green-800' : 
                                           ($log->status_kehadiran === 'izin' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($log->status_kehadiran === 'sakit' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                        {{ ucfirst($log->status_kehadiran) }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-xs text-gray-500 text-center py-4">Belum ada riwayat akses</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Completion Status -->
                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-gray-900 mb-3">Status Membaca</h3>
                        @if($isCompleted)
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex items-center justify-center mb-3">
                                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <p class="text-center text-sm font-medium text-green-800 mb-1">Materi Selesai Dibaca</p>
                                <p class="text-center text-xs text-green-600">Selamat! Anda telah menyelesaikan materi ini.</p>
                            </div>
                        @else
                            <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4 mb-4">
                                <p class="text-center text-sm font-medium text-indigo-800 mb-2">Belum Selesai</p>
                                <p class="text-center text-xs text-indigo-600">Lanjutkan membaca untuk menyelesaikan materi</p>
                            </div>
                            <form action="{{ route('siswa.materi.complete', $materi) }}" method="POST" id="completeForm">
                                @csrf
                                <button type="submit" 
                                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-4 rounded-lg transition-colors flex items-center justify-center shadow-md">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Tandai Selesai
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Main Content Area - Full Canvas -->
            <div class="fixed inset-0 transition-all duration-300" id="mainContent" style="margin: 0; padding: 0;">
                <!-- Floating PDF Controls Bar -->
                <div class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-white/95 backdrop-blur-sm border border-gray-200 rounded-lg px-4 py-2 z-50 shadow-lg transition-all duration-300" id="pdfControlsBar">
                    <div class="flex items-center space-x-4">
                        <!-- Navigation Controls -->
                        <div class="flex items-center space-x-2">
                            <button id="prevPage" class="p-2 hover:bg-gray-100 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed" title="Halaman Sebelumnya">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <div class="flex items-center space-x-2 px-3">
                                <input type="number" id="pageInput" min="1" max="{{ $totalPages }}" value="{{ $currentPage }}" 
                                       class="w-16 px-2 py-1 text-sm border border-gray-300 rounded text-center focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <span class="text-sm text-gray-600">/</span>
                                <span class="text-sm text-gray-600" id="totalPagesDisplay">{{ $totalPages }}</span>
                            </div>
                            <button id="nextPage" class="p-2 hover:bg-gray-100 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed" title="Halaman Selanjutnya">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Zoom Controls -->
                        <div class="flex items-center space-x-2 border-l border-gray-200 pl-4">
                            <button id="zoomOut" class="p-2 hover:bg-gray-100 rounded-lg transition-colors" title="Zoom Out">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"></path>
                                </svg>
                            </button>
                            <span class="text-sm font-medium text-gray-700 w-16 text-center" id="zoomLevel">100%</span>
                            <button id="zoomIn" class="p-2 hover:bg-gray-100 rounded-lg transition-colors" title="Zoom In">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"></path>
                                </svg>
                            </button>
                            <button id="fitWidth" class="px-3 py-1 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors" title="Fit Width">
                                Fit Width
                            </button>
                            <button id="fitPage" class="px-3 py-1 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors" title="Fit Page">
                                Fit Page
                            </button>
                        </div>
                    </div>
                </div>

                <!-- PDF Viewer Container - Full Canvas -->
                <div class="w-full h-full bg-gray-900" id="pdfViewerContainer">
                    <iframe id="pdfViewer" 
                            src="{{ route('siswa.materi.download', $materi->id) }}#toolbar=0&navpanes=0&scrollbar=1&zoom=page-fit" 
                            class="w-full h-full"
                            frameborder="0">
                    </iframe>
                </div>
                
                <!-- Floating Sidebar Toggle Button -->
                <button id="floatingSidebarToggle" class="fixed right-4 top-1/2 transform -translate-y-1/2 bg-white/95 backdrop-blur-sm border border-gray-200 rounded-lg p-3 z-50 shadow-lg transition-all duration-300 hover:bg-white" title="Buka Sidebar">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </button>
            </div>
        </div>

        @include('siswa.materi.pdf-script', [
            'materi' => $materi,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'progressPercentage' => $progressPercentage,
            'isCompleted' => $isCompleted
        ])
    @else
        <!-- Non-PDF Content (Video, etc.) -->
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
                            <a href="{{ route('siswa.kelas.show', $materi->kelas) }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Kembali ke Kelas
                            </a>
                        </div>

                        @if($materi->file_type === 'video')
                            <div class="mb-8">
                                <div class="border border-gray-200 rounded-lg overflow-hidden">
                                    <video controls class="w-full">
                                        <source src="{{ route('siswa.materi.download', $materi->id) }}" type="video/mp4">
                                        Browser Anda tidak mendukung video player.
                                    </video>
                                </div>
                            </div>
                        @endif

                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <form action="{{ route('siswa.materi.complete', $materi) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Tandai Selesai
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>

