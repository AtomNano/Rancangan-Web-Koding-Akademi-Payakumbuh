{{-- TEST: View admin.materi.show is loading. Materi ID: {{ $materi->id ?? 'N/A' }}, File Type: {{ $materi->file_type ?? 'N/A' }} --}}
<x-app-layout>
    @php
        // Ensure materi is loaded
        if (!isset($materi) || !$materi) {
            abort(404, 'Materi tidak ditemukan.');
        }
        $isPdf = strtolower(trim($materi->file_type ?? '')) === 'pdf';
    @endphp
    @if($isPdf)
        <!-- Modern PDF Reading Experience for Admin -->
        <div class="pdf-reading-mode" id="pdfReadingMode">
            <!-- Right Sidebar - All Info -->
            <div class="fixed right-0 top-0 bottom-0 w-80 bg-white border-l border-gray-200 shadow-2xl z-50 overflow-y-auto" id="rightSidebar" style="transform: translateX(0);">
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
                        
                        <!-- Status Badge -->
                        @php
                            $status_classes = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'approved' => 'bg-green-100 text-green-800',
                                'rejected' => 'bg-red-100 text-red-800',
                            ];
                        @endphp
                        <div class="mb-4">
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $status_classes[$materi->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $materi->status === 'pending' ? 'Menunggu' : ($materi->status === 'approved' ? 'Disetujui' : 'Ditolak') }}
                            </span>
                        </div>
                        
                        <div class="space-y-2 text-sm mb-4">
                            <div class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Diupload oleh: <span class="font-medium ml-1">{{ $materi->uploadedBy->name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $materi->created_at->format('d M Y H:i') }}
                            </div>
                            <div class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Tipe: <span class="font-medium ml-1 uppercase">{{ $materi->file_type }}</span>
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
                            <a href="{{ route('admin.materi.download', $materi) }}" download 
                               class="flex items-center justify-center px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Download
                            </a>
                            <a href="{{ route('admin.materi.index') }}" 
                               class="col-span-2 flex items-center justify-center px-3 py-2 bg-indigo-100 hover:bg-indigo-200 rounded-lg transition-colors text-sm font-medium text-indigo-700">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Kembali ke Daftar Materi
                            </a>
                        </div>
                    </div>
                    
                    <!-- Informasi Kelas -->
                    @if($materi->kelas)
                        @php
                            $kelas = $materi->kelas;
                            $totalSiswaKelasInfo = \App\Models\Enrollment::where('kelas_id', $kelas->id)
                                ->whereHas('user', function($q) {
                                    $q->where('role', 'siswa');
                                })
                                ->count();
                            $totalMateriKelas = $kelas->materi()->where('status', 'approved')->count();
                        @endphp
                        <div class="mb-6 pb-6 border-b border-gray-200">
                            <h3 class="text-sm font-semibold text-gray-900 mb-3">Informasi Kelas</h3>
                            <div class="space-y-3">
                                <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-3">
                                    <div class="flex items-center mb-2">
                                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                        <span class="text-sm font-semibold text-indigo-900">{{ $kelas->nama_kelas }}</span>
                                    </div>
                                    <p class="text-xs text-indigo-700 line-clamp-2">{{ Str::limit($kelas->deskripsi, 100) }}</p>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-2">
                                        <div class="text-xs text-blue-700 font-medium mb-1">Total Siswa</div>
                                        <div class="text-lg font-bold text-blue-900">{{ $totalSiswaKelasInfo }}</div>
                                    </div>
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-2">
                                        <div class="text-xs text-green-700 font-medium mb-1">Materi Disetujui</div>
                                        <div class="text-lg font-bold text-green-900">{{ $totalMateriKelas }}</div>
                                    </div>
                                </div>
                                
                                @if($kelas->guru)
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center shadow-lg shadow-blue-500/20 mr-3">
                                                <span class="text-white font-bold text-xs">{{ substr($kelas->guru->name, 0, 2) }}</span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $kelas->guru->name }}</p>
                                                <p class="text-xs text-gray-500 truncate">Guru Pengajar</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                <a href="{{ route('admin.kelas.show', $kelas->id) }}" 
                                   class="block w-full text-center px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Lihat Detail Kelas
                                </a>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Statistik Materi -->
                    @php
                        $totalSiswaKelas = \App\Models\Enrollment::where('kelas_id', $materi->kelas_id)
                            ->whereHas('user', function($q) {
                                $q->where('role', 'siswa');
                            })
                            ->count();
                        
                        $totalAkses = \App\Models\Presensi::where('materi_id', $materi->id)->count();
                        $siswaYangAkses = \App\Models\Presensi::where('materi_id', $materi->id)
                            ->distinct('user_id')
                            ->count();
                        
                        $totalProgress = \App\Models\MateriProgress::where('materi_id', $materi->id)->count();
                        $siswaSelesai = \App\Models\MateriProgress::where('materi_id', $materi->id)
                            ->where('is_completed', true)
                            ->count();
                        
                        $avgProgress = \App\Models\MateriProgress::where('materi_id', $materi->id)
                            ->avg('progress_percentage') ?? 0;
                    @endphp
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-900 mb-3">Statistik Materi</h3>
                        <div class="space-y-3">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs text-blue-700 font-medium">Total Siswa di Kelas</span>
                                    <span class="text-sm font-bold text-blue-900">{{ $totalSiswaKelas }}</span>
                                </div>
                            </div>
                            <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs text-green-700 font-medium">Siswa yang Akses</span>
                                    <span class="text-sm font-bold text-green-900">{{ $siswaYangAkses }} / {{ $totalSiswaKelas }}</span>
                                </div>
                                <div class="w-full bg-green-200 rounded-full h-2 mt-2">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ $totalSiswaKelas > 0 ? ($siswaYangAkses / $totalSiswaKelas) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                            <div class="bg-purple-50 border border-purple-200 rounded-lg p-3">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs text-purple-700 font-medium">Siswa yang Selesai</span>
                                    <span class="text-sm font-bold text-purple-900">{{ $siswaSelesai }} / {{ $totalSiswaKelas }}</span>
                                </div>
                                <div class="w-full bg-purple-200 rounded-full h-2 mt-2">
                                    <div class="bg-purple-600 h-2 rounded-full" style="width: {{ $totalSiswaKelas > 0 ? ($siswaSelesai / $totalSiswaKelas) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                            <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-3">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs text-indigo-700 font-medium">Rata-rata Progress</span>
                                    <span class="text-sm font-bold text-indigo-900">{{ number_format($avgProgress, 1) }}%</span>
                                </div>
                                <div class="w-full bg-indigo-200 rounded-full h-2 mt-2">
                                    <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $avgProgress }}%"></div>
                                </div>
                            </div>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-700 font-medium">Total Akses</span>
                                    <span class="text-sm font-bold text-gray-900">{{ $totalAkses }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Status Approval -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-900 mb-3">Status Approval</h3>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between p-3 rounded-lg {{ $materi->status === 'pending' ? 'bg-yellow-50 border border-yellow-200' : ($materi->status === 'approved' ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200') }}">
                                <span class="text-sm font-medium {{ $materi->status === 'pending' ? 'text-yellow-800' : ($materi->status === 'approved' ? 'text-green-800' : 'text-red-800') }}">
                                    {{ $materi->status === 'pending' ? 'Menunggu Persetujuan' : ($materi->status === 'approved' ? 'Disetujui' : 'Ditolak') }}
                                </span>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $status_classes[$materi->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $materi->status === 'pending' ? 'Pending' : ($materi->status === 'approved' ? 'Approved' : 'Rejected') }}
                                </span>
                            </div>
                            @if($materi->status === 'approved' && $materi->updated_at)
                                <div class="text-xs text-gray-500 mt-2">
                                    Disetujui pada: {{ $materi->updated_at->format('d M Y H:i') }}
                                </div>
                            @elseif($materi->status === 'rejected' && $materi->updated_at)
                                <div class="text-xs text-gray-500 mt-2">
                                    Ditolak pada: {{ $materi->updated_at->format('d M Y H:i') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Admin Actions -->
                    @if ($materi->status == 'pending')
                        <div class="mb-6 pb-6 border-b border-gray-200">
                            <h3 class="text-sm font-semibold text-gray-900 mb-3">Aksi Admin</h3>
                            <div class="space-y-2">
                                <form action="{{ route('admin.materi.approve', $materi->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menyetujui materi ini?');">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Setujui Materi
                                    </button>
                                </form>
                                <form action="{{ route('admin.materi.reject', $materi->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menolak materi ini?');">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Tolak Materi
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Riwayat Akses Terbaru -->
                    @php
                        $recentAccess = \App\Models\Presensi::where('materi_id', $materi->id)
                            ->with('user')
                            ->orderBy('tanggal_akses', 'desc')
                            ->limit(5)
                            ->get();
                    @endphp
                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-gray-900 mb-3">Akses Terbaru</h3>
                        <div class="space-y-2 max-h-48 overflow-y-auto">
                            @forelse($recentAccess as $access)
                                <div class="flex items-center justify-between text-xs p-2 bg-gray-50 rounded">
                                    <div>
                                        <p class="font-medium text-gray-700">{{ $access->user->name ?? 'N/A' }}</p>
                                        <p class="text-gray-500">{{ $access->tanggal_akses->format('d M Y H:i') }}</p>
                                    </div>
                                    <span class="px-2 py-1 rounded text-xs font-medium
                                        {{ $access->status_kehadiran === 'hadir' ? 'bg-green-100 text-green-800' : 
                                           ($access->status_kehadiran === 'izin' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($access->status_kehadiran === 'sakit' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                        {{ ucfirst($access->status_kehadiran) }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-xs text-gray-500 text-center py-4">Belum ada akses</p>
                            @endforelse
                        </div>
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
                                <input type="number" id="pageInput" min="1" value="1" 
                                       class="w-16 px-2 py-1 text-sm border border-gray-300 rounded text-center focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <span class="text-sm text-gray-600">/</span>
                                <span class="text-sm text-gray-600" id="totalPagesDisplay">1</span>
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
                            src="{{ route('admin.materi.download', $materi) }}#toolbar=0&navpanes=0&scrollbar=1&zoom=page-fit" 
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

        @push('scripts')
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rightSidebar = document.getElementById('rightSidebar');
            const toggleRightSidebarBtn = document.getElementById('toggleRightSidebar');
            const floatingSidebarToggle = document.getElementById('floatingSidebarToggle');
            const mainContent = document.getElementById('mainContent');
            const pdfViewer = document.getElementById('pdfViewer');
            const pdfControlsBar = document.getElementById('pdfControlsBar');
            const toggleFullscreen = document.getElementById('toggleFullscreen');
            
            let rightSidebarOpen = true;
            let controlsBarTimeout;
            let lastMouseMove = Date.now();

            // Initialize - Sidebar default open
            if (rightSidebar) {
                rightSidebarOpen = true;
                rightSidebar.classList.remove('closed');
                if (floatingSidebarToggle) {
                    floatingSidebarToggle.classList.add('hidden');
                }
            }

            // Right Sidebar Toggle
            function toggleSidebar() {
                rightSidebarOpen = !rightSidebarOpen;
                if (rightSidebarOpen) {
                    rightSidebar.classList.remove('closed');
                    if (floatingSidebarToggle) {
                        floatingSidebarToggle.classList.add('hidden');
                    }
                } else {
                    rightSidebar.classList.add('closed');
                    if (floatingSidebarToggle) {
                        floatingSidebarToggle.classList.remove('hidden');
                    }
                }
            }
            
            if (toggleRightSidebarBtn && rightSidebar) {
                toggleRightSidebarBtn.addEventListener('click', toggleSidebar);
            }
            
            if (floatingSidebarToggle && rightSidebar) {
                floatingSidebarToggle.addEventListener('click', toggleSidebar);
            }

            // Auto-hide controls bar
            function showControlsBar() {
                if (pdfControlsBar) {
                    pdfControlsBar.classList.remove('hidden');
                    clearTimeout(controlsBarTimeout);
                    controlsBarTimeout = setTimeout(() => {
                        if (pdfControlsBar && Date.now() - lastMouseMove > 3000) {
                            pdfControlsBar.classList.add('hidden');
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

            // Fullscreen toggle
            if (toggleFullscreen) {
                toggleFullscreen.addEventListener('click', function() {
                    if (!document.fullscreenElement) {
                        if (mainContent.requestFullscreen) {
                            mainContent.requestFullscreen();
                        }
                    } else {
                        if (document.exitFullscreen) {
                            document.exitFullscreen();
                        }
                    }
                });
            }
        });
        </script>
        @endpush
        
        <style>
            .pdf-reading-mode {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                width: 100%;
                height: 100vh;
                margin: 0;
                padding: 0;
                overflow: hidden;
            }

            #mainContent {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                width: 100%;
                height: 100vh;
                margin: 0;
                padding: 0;
            }

            #pdfViewerContainer {
                width: 100%;
                height: 100%;
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
            }

            #pdfViewer {
                width: 100%;
                height: 100%;
                border: none;
            }

            #pdfControlsBar {
                opacity: 1;
                transition: opacity 0.3s ease;
            }

            #pdfControlsBar.hidden {
                opacity: 0;
                pointer-events: none;
            }

            #rightSidebar {
                transform: translateX(0) !important;
                z-index: 60;
                transition: transform 0.3s ease-in-out;
            }

            #rightSidebar.closed {
                transform: translateX(100%) !important;
            }

            #mainContent.right-sidebar-open {
                margin-right: 0;
            }

            #floatingSidebarToggle {
                opacity: 1;
                transition: opacity 0.3s ease;
            }

            #floatingSidebarToggle.hidden {
                opacity: 0;
                pointer-events: none;
            }
        </style>
    @else
        <!-- Non-PDF Content -->
        <x-slot name="header">
            <div class="flex items-center">
                <a href="{{ route('admin.materi.index') }}" class="text-indigo-500 hover:text-indigo-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h2 class="ml-3 font-semibold text-xl text-gray-800 leading-tight">
                    Detail Materi
                </h2>
            </div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 sm:p-8">
                        <div class="mb-6">
                            @php
                                $status_classes = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'approved' => 'bg-green-100 text-green-800',
                                    'rejected' => 'bg-red-100 text-red-800',
                                ];
                            @endphp
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $status_classes[$materi->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $materi->status === 'pending' ? 'Menunggu' : ($materi->status === 'approved' ? 'Disetujui' : 'Ditolak') }}
                            </span>
                        </div>

                        <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ $materi->judul }}</h3>
                        <p class="text-gray-600 mb-6">{{ $materi->deskripsi }}</p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-700 mb-6">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <strong>Kelas:</strong><span class="ml-2">{{ $materi->kelas->nama_kelas ?? 'N/A' }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <strong>Pengunggah:</strong><span class="ml-2">{{ $materi->uploadedBy->name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <strong>Tanggal Unggah:</strong><span class="ml-2">{{ $materi->created_at->format('d F Y') }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <strong>Tipe File:</strong><span class="ml-2 uppercase">{{ $materi->file_type }}</span>
                            </div>
                        </div>

                        @if ($materi->file_type === 'video')
                            @php $embedUrl = $materi->youtube_embed_url; @endphp
                            <div class="mb-8">
                                <h4 class="font-semibold text-lg text-gray-800 mb-4">Preview Video</h4>
                                <div class="border border-gray-200 rounded-lg overflow-hidden bg-black">
                                    @if($embedUrl)
                                        <div class="relative w-full" style="padding-top: 56.25%;">
                                            <iframe
                                                src="{{ $embedUrl }}"
                                                class="absolute inset-0 w-full h-full"
                                                frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen>
                                            </iframe>
                                        </div>
                                    @else
                                        <p class="p-6 text-center text-sm text-gray-500">Link video tidak valid atau tidak dapat ditampilkan.</p>
                                    @endif
                                </div>
                                <p class="mt-4 text-sm text-gray-500 break-all">Link sumber: <a href="{{ $materi->file_path }}" target="_blank" class="text-indigo-600 hover:text-indigo-800">{{ $materi->file_path }}</a></p>
                            </div>
                        @elseif ($materi->file_type === 'document')
                            <div class="mb-8">
                                <h4 class="font-semibold text-lg text-gray-800 mb-4">Materi Dokumen</h4>
                                <a href="{{ route('admin.materi.download', $materi) }}" download 
                                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                                    Unduh Dokumen
                                </a>
                            </div>
                        @elseif ($materi->file_type === 'link')
                            <div class="mb-8">
                                <h4 class="font-semibold text-lg text-gray-800 mb-4">Tautan Eksternal</h4>
                                <a href="{{ $materi->file_path }}" target="_blank" 
                                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                                    Buka Tautan
                                </a>
                            </div>
                        @endif

                        @if ($materi->status == 'pending')
                            <div class="mt-8 flex items-center space-x-4">
                                <form action="{{ route('admin.materi.approve', $materi->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menyetujui materi ini?');">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Setujui
                                    </button>
                                </form>
                                <form action="{{ route('admin.materi.reject', $materi->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menolak materi ini?');">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
