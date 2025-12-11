<!-- Right Sidebar - Materi Info for Guru -->
<div class="fixed right-0 top-0 bottom-0 w-80 bg-white border-l border-gray-200 shadow-lg z-50 overflow-y-auto" id="rightSidebar">
    <div class="p-6">
        <!-- Header with Actions -->
        <div class="mb-6 pb-6 border-b border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">{{ $materi->judul }}</h2>
                <button id="closeSidebar" class="p-1.5 hover:bg-gray-100 rounded-lg transition-colors" title="Tutup Sidebar">
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
                    {{ $materi->status === 'pending' ? 'Menunggu Verifikasi' : ($materi->status === 'approved' ? 'Disetujui' : 'Ditolak') }}
                </span>
            </div>
            
            <div class="space-y-2 text-sm mb-4">
                <div class="flex items-center text-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Kelas: <span class="font-medium ml-1">{{ $materi->kelas->nama_kelas ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center text-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Diupload: <span class="font-medium ml-1">{{ $materi->created_at->format('d M Y H:i') }}</span>
                </div>
                <div class="flex items-center text-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Tipe: <span class="font-medium ml-1 uppercase">{{ $materi->file_type }}</span>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="grid grid-cols-2 gap-2 mt-4">
                <a href="{{ route('guru.materi.download', $materi) }}" download 
                   class="flex items-center justify-center col-span-2 px-3 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors text-sm font-medium text-white">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Download Materi
                </a>
                <a href="{{ route('guru.materi.edit', $materi) }}" 
                   class="flex items-center justify-center px-3 py-2 bg-blue-100 hover:bg-blue-200 rounded-lg transition-colors text-sm font-medium text-blue-700">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Edit
                </a>
                <a href="{{ route('guru.materi.index') }}" 
                   class="flex items-center justify-center px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors text-sm font-medium text-gray-700">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
            </div>
        </div>
        
        <!-- More teacher-specific info can be added here -->

    </div>
</div>
