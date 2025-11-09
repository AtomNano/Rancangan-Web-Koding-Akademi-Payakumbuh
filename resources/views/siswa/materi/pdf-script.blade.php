<style>
    .pdf-reading-mode {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }
    
    #rightSidebar {
        transform: translateX(100%);
    }
    
    #rightSidebar.open {
        transform: translateX(0);
    }
    
    #mainContent.right-sidebar-open {
        margin-right: 20rem;
    }
    
    /* Center PDF viewer */
    #mainContent .bg-gray-100 {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }
    
    #mainContent #pdfContainer {
        max-width: 100%;
        width: 100%;
    }
    
    @media (max-width: 768px) {
        #rightSidebar {
            width: 100%;
        }
        
        #mainContent {
            margin-left: 0;
        }
        
        #mainContent.right-sidebar-open {
            margin-right: 0;
        }
    }
    
    /* Custom scrollbar for right sidebar */
    #rightSidebar::-webkit-scrollbar {
        width: 6px;
    }
    
    #rightSidebar::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    
    #rightSidebar::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }
    
    #rightSidebar::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    
    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }
    
    /* Custom scrollbar */
    #sidebar::-webkit-scrollbar {
        width: 6px;
    }
    
    #sidebar::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    
    #sidebar::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }
    
    #sidebar::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const rightSidebar = document.getElementById('rightSidebar');
    const toggleRightSidebarBtn = document.getElementById('toggleRightSidebar');
    const mainContent = document.getElementById('mainContent');
    const pdfViewer = document.getElementById('pdfViewer');
    const prevPageBtn = document.getElementById('prevPage');
    const nextPageBtn = document.getElementById('nextPage');
    const pageInput = document.getElementById('pageInput');
    const zoomInBtn = document.getElementById('zoomIn');
    const zoomOutBtn = document.getElementById('zoomOut');
    const zoomLevel = document.getElementById('zoomLevel');
    const fitWidthBtn = document.getElementById('fitWidth');
    const fitPageBtn = document.getElementById('fitPage');
    const toggleFullscreenBtn = document.getElementById('toggleFullscreen');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    const sidebarCurrentPage = document.getElementById('sidebarCurrentPage');
    const sidebarTotalPages = document.getElementById('sidebarTotalPages');
    const totalPagesDisplay = document.getElementById('totalPagesDisplay');
    const completeForm = document.getElementById('completeForm');
    
    let currentPage = {{ $currentPage ?? 1 }};
    let totalPages = {{ $totalPages ?? 1 }};
    let currentZoom = 100;
    let isFullscreen = false;
    let rightSidebarOpen = true; // Default open
    let progressUpdateTimeout;

    // Initialize
    updatePageInfo();
    updateZoom();
    
    // Open right sidebar by default
    if (rightSidebar) {
        rightSidebarOpen = true;
        rightSidebar.classList.add('open');
        if (window.innerWidth > 768) {
            mainContent.classList.add('right-sidebar-open');
        }
    }

    // Right Sidebar Toggle
    if (toggleRightSidebarBtn && rightSidebar) {
        toggleRightSidebarBtn.addEventListener('click', () => {
            rightSidebarOpen = !rightSidebarOpen;
            rightSidebar.classList.toggle('open', rightSidebarOpen);
            if (window.innerWidth > 768) {
                mainContent.classList.toggle('right-sidebar-open', rightSidebarOpen);
            }
        });
    }

    // Page Navigation
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

    // Page Input
    pageInput.addEventListener('change', () => {
        const page = parseInt(pageInput.value);
        if (page >= 1 && page <= totalPages) {
            currentPage = page;
            updatePDFView();
            updateProgress();
        } else {
            pageInput.value = currentPage;
        }
    });

    // Keyboard Navigation
    document.addEventListener('keydown', (e) => {
        if (e.target.tagName === 'INPUT') return;
        
        switch(e.key) {
            case 'ArrowLeft':
            case 'ArrowUp':
                e.preventDefault();
                if (currentPage > 1) {
                    currentPage--;
                    updatePDFView();
                    updateProgress();
                }
                break;
            case 'ArrowRight':
            case 'ArrowDown':
            case ' ':
                e.preventDefault();
                if (currentPage < totalPages) {
                    currentPage++;
                    updatePDFView();
                    updateProgress();
                }
                break;
            case 'f':
            case 'F':
                e.preventDefault();
                toggleFullscreen();
                break;
            case 'Escape':
                if (isFullscreen) {
                    exitFullscreen();
                }
                break;
        }
    });

    // Zoom Controls
    zoomInBtn.addEventListener('click', () => {
        currentZoom = Math.min(currentZoom + 25, 200);
        updateZoom();
    });

    zoomOutBtn.addEventListener('click', () => {
        currentZoom = Math.max(currentZoom - 25, 50);
        updateZoom();
    });

    fitWidthBtn.addEventListener('click', () => {
        const pdfUrl = `{{ route('siswa.materi.download', $materi->id) }}#page=${currentPage}&toolbar=0&navpanes=0&scrollbar=1&zoom=page-width`;
        pdfViewer.src = pdfUrl;
        zoomLevel.textContent = 'Fit Width';
    });

    fitPageBtn.addEventListener('click', () => {
        const pdfUrl = `{{ route('siswa.materi.download', $materi->id) }}#page=${currentPage}&toolbar=0&navpanes=0&scrollbar=1&zoom=page-fit`;
        pdfViewer.src = pdfUrl;
        zoomLevel.textContent = 'Fit Page';
    });

    // Fullscreen Toggle
    toggleFullscreenBtn.addEventListener('click', toggleFullscreen);

    function toggleFullscreen() {
        if (!isFullscreen) {
            if (document.documentElement.requestFullscreen) {
                document.documentElement.requestFullscreen();
            } else if (document.documentElement.webkitRequestFullscreen) {
                document.documentElement.webkitRequestFullscreen();
            } else if (document.documentElement.msRequestFullscreen) {
                document.documentElement.msRequestFullscreen();
            }
            isFullscreen = true;
        } else {
            exitFullscreen();
        }
    }

    function exitFullscreen() {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
        isFullscreen = false;
    }


    // Update Functions
    function updatePageInfo() {
        pageInput.value = currentPage;
        pageInput.max = totalPages;
        totalPagesDisplay.textContent = totalPages;
        if (sidebarCurrentPage) sidebarCurrentPage.textContent = currentPage;
        if (sidebarTotalPages) sidebarTotalPages.textContent = totalPages;
        prevPageBtn.disabled = currentPage <= 1;
        nextPageBtn.disabled = currentPage >= totalPages;
    }

    function updatePDFView() {
        const pdfUrl = `{{ route('siswa.materi.download', $materi->id) }}#page=${currentPage}&toolbar=0&navpanes=0&scrollbar=1&zoom=${currentZoom}`;
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
            const progressPercentage = totalPages > 0 ? (currentPage / totalPages) * 100 : 0;
            
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
                if (data.success && data.progress) {
                    const newProgress = data.progress.progress_percentage;
                    updateProgressUI(newProgress);
                } else {
                    updateProgressUI(progressPercentage);
                }
            })
            .catch(error => {
                console.error('Error updating progress:', error);
                updateProgressUI(progressPercentage);
            });
        }, 1000);
    }

    function updateProgressUI(percentage) {
        const formatted = percentage.toFixed(1);
        if (progressBar) progressBar.style.width = `${percentage}%`;
        if (progressText) progressText.textContent = `${formatted}%`;
    }

    // Form submission with confirmation
    if (completeForm) {
        completeForm.addEventListener('submit', (e) => {
            e.preventDefault();
            if (confirm('Apakah Anda yakin sudah selesai mempelajari materi ini?')) {
                // Use the mark-completed route for AJAX
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
                        // Update sidebar completion status
                        const completionDiv = completeForm.parentElement;
                        completionDiv.innerHTML = `
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm font-medium text-green-800">Materi Selesai Dibaca</span>
                                </div>
                            </div>
                        `;
                        updateProgressUI(100);
                        currentPage = totalPages;
                        updatePageInfo();
                    } else {
                        // Fallback to normal form submission
                        completeForm.submit();
                    }
                })
                .catch(() => {
                    // Fallback to normal form submission
                    completeForm.submit();
                });
            }
        });
    }

    // Load initial progress
    fetch(`{{ route('siswa.materi.progress.get', $materi) }}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.progress) {
                currentPage = data.progress.current_page || currentPage;
                totalPages = data.progress.total_pages || totalPages;
                updatePageInfo();
                updatePDFView();
                if (data.progress.progress_percentage) {
                    updateProgressUI(data.progress.progress_percentage);
                }
            }
        })
        .catch(error => {
            console.error('Error loading progress:', error);
        });

    // Handle window resize
    window.addEventListener('resize', () => {
        if (window.innerWidth <= 768) {
            if (rightSidebarOpen) {
                mainContent.classList.remove('right-sidebar-open');
            }
        } else {
            if (rightSidebarOpen) {
                mainContent.classList.add('right-sidebar-open');
            }
        }
    });

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', (e) => {
        if (window.innerWidth <= 768) {
            if (rightSidebarOpen && rightSidebar &&
                !rightSidebar.contains(e.target) && 
                toggleRightSidebarBtn &&
                !toggleRightSidebarBtn.contains(e.target)) {
                rightSidebarOpen = false;
                rightSidebar.classList.remove('open');
            }
        }
    });
});
</script>

