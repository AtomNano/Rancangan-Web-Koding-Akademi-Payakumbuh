<x-app-layout>
    @php
        // Ensure materi is loaded and set file type flag
        if (!isset($materi) || !$materi) {
            abort(404, 'Materi tidak ditemukan.');
        }
        $isPdf = strtolower(trim($materi->file_type ?? '')) === 'pdf';
    @endphp

    @if($isPdf)
        <!-- Modern PDF Reading Experience for Guru -->
        <div class="pdf-reading-mode" id="pdfReadingMode">
            
            <!-- Right Sidebar (from partial) -->
            @include('guru.materi.partials.sidebar', ['materi' => $materi])

            <!-- Main Content Area - Full Canvas -->
            <div class="fixed inset-0 transition-all duration-300" id="mainContent">
                <!-- Floating PDF Controls Bar -->
                <div class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-white/95 backdrop-blur-sm border border-gray-200 rounded-lg px-4 py-2 z-50 shadow-lg transition-all duration-300" id="pdfControlsBar">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2">
                            <button id="prevPage" class="p-2 hover:bg-gray-100 rounded-lg transition-colors disabled:opacity-50" title="Halaman Sebelumnya"><svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
                            <div class="flex items-center space-x-2 px-3">
                                <input type="number" id="pageInput" min="1" value="1" class="w-16 px-2 py-1 text-sm border-gray-300 rounded text-center focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <span class="text-sm text-gray-600">/</span>
                                <span class="text-sm text-gray-600" id="totalPagesDisplay">1</span>
                            </div>
                            <button id="nextPage" class="p-2 hover:bg-gray-100 rounded-lg transition-colors disabled:opacity-50" title="Halaman Selanjutnya"><svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
                        </div>
                        <div class="flex items-center space-x-2 border-l border-gray-200 pl-4">
                            <button id="zoomOut" class="p-2 hover:bg-gray-100 rounded-lg" title="Zoom Out"><svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"></path></svg></button>
                            <span class="text-sm font-medium text-gray-700 w-16 text-center" id="zoomLevel">100%</span>
                            <button id="zoomIn" class="p-2 hover:bg-gray-100 rounded-lg" title="Zoom In"><svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"></path></svg></button>
                        </div>
                    </div>
                </div>

                <!-- PDF Viewer -->
                <div class="w-full h-full bg-gray-900" id="pdfViewerContainer">
                    <iframe id="pdfViewer" src="{{ route('guru.materi.download', $materi) }}#toolbar=0&navpanes=0&scrollbar=1&zoom=page-fit" class="w-full h-full" frameborder="0"></iframe>
                </div>
                
                <!-- Floating Sidebar Toggle Button -->
                <button id="openSidebar" class="fixed right-4 top-1/2 -translate-y-1/2 bg-white/95 backdrop-blur-sm border border-gray-200 rounded-full p-3 z-40 shadow-lg hover:bg-gray-100" title="Buka Sidebar">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
        </div>

    @else 
        <!-- Non-PDF Content with Sidebar -->
        <div class="flex h-screen bg-gray-100">
            <!-- Main Content -->
            <div id="mainContent" class="flex-1 flex flex-col overflow-hidden transition-all duration-300">
                <x-slot name="header">
                    <div class="flex items-center justify-between">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            Detail Materi: {{ $materi->judul }}
                        </h2>
                        <button id="openSidebar" class="p-2 rounded-md hover:bg-gray-200 lg:hidden">
                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>
                    </div>
                </x-slot>

                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                    <div class="container mx-auto px-6 py-8">
                        <div class="bg-white p-6 rounded-lg shadow-md">

                            @if ($materi->file_type === 'video')
                                @php $embedUrl = $materi->youtube_embed_url; @endphp
                                <div class="mb-8">
                                    <h4 class="font-semibold text-lg text-gray-800 mb-4">Preview Video</h4>
                                    <div class="border border-gray-200 rounded-lg overflow-hidden bg-black">
                                        @if($embedUrl)
                                            <div class="relative w-full pt-[56.25%]">
                                                <iframe src="{{ $embedUrl }}" class="absolute inset-0 w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                            </div>
                                        @else
                                            <p class="p-6 text-center text-sm text-gray-500">Link video tidak valid atau tidak dapat ditampilkan.</p>
                                        @endif
                                    </div>
                                    <p class="mt-4 text-sm text-gray-500 break-all">Link sumber: <a href="{{ $materi->file_path }}" target="_blank" class="text-indigo-600 hover:text-indigo-800">{{ $materi->file_path }}</a></p>
                                </div>
                            @elseif ($materi->file_type === 'link')
                                <div class="mb-8 p-6 bg-indigo-50 rounded-lg border border-indigo-200">
                                    <h4 class="font-semibold text-lg text-gray-800 mb-4">Tautan Eksternal</h4>
                                    <p class="text-gray-600 mb-4">Materi ini adalah tautan ke sumber eksternal. Klik tombol di bawah untuk membukanya di tab baru.</p>
                                    <a href="{{ $materi->file_path }}" target="_blank" 
                                       class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        Buka Tautan
                                    </a>
                                </div>
                            @else
                                <div class="mb-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
                                     <h4 class="font-semibold text-lg text-gray-800 mb-4">Materi {{ ucfirst($materi->file_type) }}</h4>
                                     <p class="text-gray-600 mb-4">Preview tidak tersedia untuk tipe file ini. Silakan unduh materi untuk melihatnya.</p>
                                     <a href="{{ route('guru.materi.download', $materi) }}" download 
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                                         <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                         Unduh Materi
                                     </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </main>
            </div>

            <!-- Right Sidebar (from partial) -->
            @include('guru.materi.partials.sidebar', ['materi' => $materi])
        </div>
    @endif

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('rightSidebar');
        const openBtn = document.getElementById('openSidebar');
        const closeBtn = document.getElementById('closeSidebar');
        const mainContent = document.getElementById('mainContent');

        const openSidebar = () => {
            if (sidebar) sidebar.style.transform = 'translateX(0)';
            if (mainContent && window.innerWidth > 1024) { // Only push content on desktop
                mainContent.style.marginRight = sidebar.offsetWidth + 'px';
            }
            if (openBtn) openBtn.style.display = 'none';
        };

        const closeSidebar = () => {
            if (sidebar) sidebar.style.transform = 'translateX(100%)';
            if (mainContent) mainContent.style.marginRight = '0';
            if (openBtn) openBtn.style.display = 'block';
        };

        // Default state
        if (window.innerWidth > 1024) { // Open by default on desktop
            openSidebar();
        } else {
            closeSidebar();
        }
        
        if (openBtn) openBtn.addEventListener('click', openSidebar);
        if (closeBtn) closeBtn.addEventListener('click', closeSidebar);

        // PDF specific controls - only run if it's the PDF view
        if (document.body.contains(document.getElementById('pdfReadingMode'))) {
            const pdfControlsBar = document.getElementById('pdfControlsBar');
            let controlsBarTimeout;
            let lastMouseMove = Date.now();
            
            function showControlsBar() {
                if (pdfControlsBar) {
                    pdfControlsBar.style.opacity = '1';
                    pdfControlsBar.style.pointerEvents = 'auto';
                    clearTimeout(controlsBarTimeout);
                    controlsBarTimeout = setTimeout(() => {
                        if (Date.now() - lastMouseMove > 3000) {
                            pdfControlsBar.style.opacity = '0';
                            pdfControlsBar.style.pointerEvents = 'none';
                        }
                    }, 3000);
                }
            }
            
            document.addEventListener('mousemove', () => {
                lastMouseMove = Date.now();
                showControlsBar();
            });
            window.addEventListener('scroll', showControlsBar);
            showControlsBar();
        }
    });
    </script>
    @endpush
    
    @push('styles')
    <style>
        .pdf-reading-mode {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            overflow: hidden;
        }
        #rightSidebar {
            transition: transform 0.3s ease-in-out;
        }
    </style>
    @endpush
</x-app-layout>
