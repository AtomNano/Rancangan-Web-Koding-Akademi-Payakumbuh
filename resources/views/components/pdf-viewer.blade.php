<div class="pdf-viewer-container">
    <!-- Progress Bar -->
    @if($progressPercentage !== null)
        <div class="mb-4">
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-medium text-gray-700">Progres Membaca</span>
                <span class="text-sm text-gray-500">{{ number_format($progressPercentage, 1) }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" 
                     style="width: {{ $progressPercentage }}%"></div>
            </div>
            @if($currentPage && $totalPages)
                <div class="text-xs text-gray-500 mt-1">
                    Halaman {{ $currentPage }} dari {{ $totalPages }}
                </div>
            @endif
        </div>
    @endif

    <!-- PDF Viewer Controls -->
    <div class="pdf-controls mb-4 flex items-center justify-between bg-gray-50 p-3 rounded-lg">
        <div class="flex items-center space-x-2">
            <button id="prevPage" class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                ← Sebelumnya
            </button>
            <span id="pageInfo" class="text-sm text-gray-600">
                @if($currentPage && $totalPages)
                    Halaman {{ $currentPage }} dari {{ $totalPages }}
                @else
                    Memuat...
                @endif
            </span>
            <button id="nextPage" class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                Selanjutnya →
            </button>
        </div>
        
        <div class="flex items-center space-x-2">
            <button id="zoomOut" class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded text-sm">
                Zoom -
            </button>
            <span id="zoomLevel" class="text-sm text-gray-600">100%</span>
            <button id="zoomIn" class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded text-sm">
                Zoom +
            </button>
            <a href="{{ route(auth()->user()->isAdmin() ? 'admin.materi.download' : (auth()->user()->isGuru() ? 'guru.materi.download' : 'siswa.materi.download'), $materi->id) }}" download 
               class="px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded text-sm">
                Unduh PDF
            </a>
        </div>
    </div>

    <!-- PDF Container -->
    <div class="pdf-container border border-gray-300 rounded-lg overflow-hidden">
        <iframe id="pdfViewer" 
                src="{{ route(auth()->user()->isAdmin() ? 'admin.materi.download' : (auth()->user()->isGuru() ? 'guru.materi.download' : 'siswa.materi.download'), $materi->id) }}#toolbar=0&navpanes=0&scrollbar=1" 
                class="w-full h-96 md:h-[600px]"
                frameborder="0">
        </iframe>
    </div>

    <!-- Completion Button -->
    @if(auth()->user()->isSiswa())
        <div class="mt-4 text-center">
            <button id="markCompleted" 
                    class="px-6 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg font-medium disabled:opacity-50 disabled:cursor-not-allowed"
                    {{ $isCompleted ? 'disabled' : '' }}>
                {{ $isCompleted ? '✓ Selesai Dibaca' : 'Tandai Selesai' }}
            </button>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pdfViewer = document.getElementById('pdfViewer');
    const prevPageBtn = document.getElementById('prevPage');
    const nextPageBtn = document.getElementById('nextPage');
    const pageInfo = document.getElementById('pageInfo');
    const zoomInBtn = document.getElementById('zoomIn');
    const zoomOutBtn = document.getElementById('zoomOut');
    const zoomLevel = document.getElementById('zoomLevel');
    const markCompletedBtn = document.getElementById('markCompleted');
    
    let currentPage = {{ $currentPage ?? 1 }};
    let totalPages = {{ $totalPages ?? 0 }};
    let currentZoom = 100;
    let progressUpdateTimeout;

    // Initialize PDF.js if available
    if (typeof PDFJS !== 'undefined') {
        initializePDFJS();
    } else {
        // Fallback to iframe controls
        initializeIframeControls();
    }

    function initializePDFJS() {
        // PDF.js implementation would go here
        // For now, we'll use iframe controls
        initializeIframeControls();
    }

    function initializeIframeControls() {
        // Update page info
        updatePageInfo();
        
        // Set up event listeners
        prevPageBtn.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                updatePDFView();
                updateProgress();
            }
        });

        nextPageBtn.addEventListener('click', () => {
            if (currentPage < totalPages) {
                currentPage++;
                updatePDFView();
                updateProgress();
            }
        });

        zoomInBtn.addEventListener('click', () => {
            currentZoom = Math.min(currentZoom + 25, 200);
            updateZoom();
        });

        zoomOutBtn.addEventListener('click', () => {
            currentZoom = Math.max(currentZoom - 25, 50);
            updateZoom();
        });

        if (markCompletedBtn) {
            markCompletedBtn.addEventListener('click', () => {
                markAsCompleted();
            });
        }

        // Auto-save progress when page changes
        pdfViewer.addEventListener('load', () => {
            // Try to get total pages from PDF
            if (totalPages === 0) {
                // This would require PDF.js to get actual page count
                // For now, we'll estimate or use a default
                totalPages = 10; // Default estimate
            }
        });
    }

    function updatePageInfo() {
        pageInfo.textContent = `Halaman ${currentPage} dari ${totalPages}`;
        prevPageBtn.disabled = currentPage <= 1;
        nextPageBtn.disabled = currentPage >= totalPages;
    }

    function updatePDFView() {
        const pdfUrl = `{{ Storage::url($materi->file_path) }}#page=${currentPage}&toolbar=0&navpanes=0&scrollbar=1&zoom=${currentZoom}`;
        pdfViewer.src = pdfUrl;
        updatePageInfo();
    }

    function updateZoom() {
        zoomLevel.textContent = `${currentZoom}%`;
        updatePDFView();
    }

    function updateProgress() {
        // Clear existing timeout
        if (progressUpdateTimeout) {
            clearTimeout(progressUpdateTimeout);
        }

        // Debounce progress updates
        progressUpdateTimeout = setTimeout(() => {
            fetch(`{{ route('siswa.materi.progress.update', $materi) }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    current_page: currentPage,
                    total_pages: totalPages
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update progress bar
                    const progressBar = document.querySelector('.bg-blue-600');
                    const progressText = document.querySelector('.text-gray-500');
                    if (progressBar && progressText) {
                        progressBar.style.width = `${data.progress.progress_percentage}%`;
                        progressText.textContent = `${data.progress.progress_percentage.toFixed(1)}%`;
                    }
                }
            })
            .catch(error => {
                console.error('Error updating progress:', error);
            });
        }, 1000); // Wait 1 second before saving
    }

    function markAsCompleted() {
        fetch(`{{ route('siswa.materi.mark-completed', $materi) }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                markCompletedBtn.textContent = '✓ Selesai Dibaca';
                markCompletedBtn.disabled = true;
                markCompletedBtn.classList.add('bg-green-600');
                
                // Update progress bar to 100%
                const progressBar = document.querySelector('.bg-blue-600');
                const progressText = document.querySelector('.text-gray-500');
                if (progressBar && progressText) {
                    progressBar.style.width = '100%';
                    progressText.textContent = '100.0%';
                }
            }
        })
        .catch(error => {
            console.error('Error marking as completed:', error);
        });
    }

    // Load initial progress
    @if(auth()->user()->isSiswa())
        fetch(`{{ route('siswa.materi.progress.get', $materi) }}`)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.progress) {
                    currentPage = data.progress.current_page;
                    totalPages = data.progress.total_pages || totalPages;
                    updatePageInfo();
                    updatePDFView();
                }
            })
            .catch(error => {
                console.error('Error loading progress:', error);
            });
    @endif
});
</script>