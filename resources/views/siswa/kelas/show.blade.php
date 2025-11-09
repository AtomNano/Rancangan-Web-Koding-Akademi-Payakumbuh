<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelas: ' . $kelas->nama_kelas) }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Class Hero Section -->
            @php
                // Warna solid menyesuaikan dengan sidebar (slate)
                $bgColor = 'bg-slate-800';
                $totalMateri = $materi->total();
                $completedMateri = 0;
                $totalProgress = 0;
                
                foreach($materi as $m) {
                    $userProgress = $m->userProgress(auth()->id());
                    if ($userProgress && $userProgress->is_completed) {
                        $completedMateri++;
                    }
                    if ($userProgress) {
                        $totalProgress += $userProgress->progress_percentage;
                    }
                }
                
                $avgProgress = $totalMateri > 0 ? round($totalProgress / $totalMateri, 1) : 0;
                $completionRate = $totalMateri > 0 ? round(($completedMateri / $totalMateri) * 100, 1) : 0;
            @endphp
            
            <div class="mb-8">
                <div class="{{ $bgColor }} rounded-2xl shadow-xl overflow-hidden">
                    <div class="px-8 py-10 text-white">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center mb-4">
                                    <h1 class="text-4xl font-bold mr-4">{{ $kelas->nama_kelas }}</h1>
                                    <span class="bg-white/20 backdrop-blur-sm px-4 py-1 rounded-full text-sm font-semibold">
                                        {{ ucfirst($kelas->bidang) }}
                                    </span>
                                </div>
                                <p class="text-lg text-white/90 mb-6">{{ $kelas->deskripsi }}</p>
                                
                                <!-- Quick Stats -->
                                <div class="grid grid-cols-3 gap-4 mt-6">
                                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4">
                                        <p class="text-sm text-white/80 mb-1">Total Materi</p>
                                        <p class="text-2xl font-bold">{{ $totalMateri }}</p>
                                    </div>
                                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4">
                                        <p class="text-sm text-white/80 mb-1">Selesai</p>
                                        <p class="text-2xl font-bold">{{ $completedMateri }}</p>
                                    </div>
                                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4">
                                        <p class="text-sm text-white/80 mb-1">Progress</p>
                                        <p class="text-2xl font-bold">{{ $completionRate }}%</p>
                                    </div>
                                </div>
                            </div>
                            <div class="hidden lg:block ml-8">
                                <svg class="w-32 h-32 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('siswa.dashboard') }}" 
                   class="inline-flex items-center text-gray-700 hover:text-gray-900 font-medium transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>

            <!-- Materials Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Materi Pembelajaran</h2>
                        <p class="text-gray-600 mt-1">Daftar materi yang tersedia untuk dipelajari</p>
                    </div>
                </div>

                @if($materi->count() > 0)
                    <div class="grid grid-cols-1 gap-6">
                        @foreach($materi as $m)
                            @php
                                $userProgress = $m->userProgress(auth()->id());
                                $progressPercentage = $userProgress ? $userProgress->progress_percentage : 0;
                                $isCompleted = $userProgress ? $userProgress->is_completed : false;
                                $currentPage = $userProgress ? $userProgress->current_page : null;
                                $totalPages = $userProgress ? $userProgress->total_pages : null;
                                
                                $fileTypeColor = $m->file_type === 'pdf' ? 'bg-red-100 text-red-800' : 
                                                ($m->file_type === 'video' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800');
                            @endphp
                            
                            <a href="{{ route('siswa.materi.show', $m) }}" class="block">
                                <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden border border-gray-100 group cursor-pointer">
                                    <div class="p-6">
                                        <div class="flex items-start justify-between">
                                            <!-- Left Content -->
                                            <div class="flex-1">
                                                <div class="flex items-start justify-between mb-4">
                                                    <div class="flex-1">
                                                        <div class="flex items-center mb-2">
                                                            <h3 class="text-xl font-bold text-gray-900 mr-3">{{ $m->judul }}</h3>
                                                            @if($isCompleted)
                                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                                    </svg>
                                                                    Selesai
                                                                </span>
                                                            @elseif($progressPercentage > 0)
                                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                                                    {{ number_format($progressPercentage, 1) }}% Selesai
                                                                </span>
                                                            @else
                                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                                                    Belum Dimulai
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <p class="text-gray-600 mb-4">{{ Str::limit($m->deskripsi, 150) }}</p>
                                                        
                                                        <!-- Progress Bar for PDF files -->
                                                        @if($m->file_type === 'pdf' && $progressPercentage > 0)
                                                            <div class="mb-4">
                                                                <div class="flex justify-between items-center mb-2">
                                                                    <span class="text-sm font-medium text-gray-700">Progres Membaca</span>
                                                                    <span class="text-sm font-bold text-gray-900">{{ number_format($progressPercentage, 1) }}%</span>
                                                                </div>
                                                                <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                                                    <div class="bg-slate-700 h-2.5 rounded-full transition-all duration-500" 
                                                                         style="width: {{ $progressPercentage }}%"></div>
                                                                </div>
                                                                @if($currentPage && $totalPages)
                                                                    <div class="text-xs text-gray-500 mt-2 flex items-center">
                                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                                        </svg>
                                                                        Terakhir dibaca: Halaman {{ $currentPage }} dari {{ $totalPages }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                        
                                                        <!-- Metadata -->
                                                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                                                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium {{ $fileTypeColor }}">
                                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    @if($m->file_type === 'pdf')
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                                    @elseif($m->file_type === 'video')
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                                    @else
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                                    @endif
                                                                </svg>
                                                                {{ strtoupper($m->file_type) }}
                                                            </span>
                                                            <span class="inline-flex items-center">
                                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                                </svg>
                                                                Oleh: <span class="font-medium ml-1">{{ $m->uploadedBy->name }}</span>
                                                            </span>
                                                            <span class="inline-flex items-center">
                                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                                </svg>
                                                                {{ $m->created_at->format('d M Y') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Right Action Indicator -->
                                            <div class="ml-6 flex-shrink-0 flex items-center">
                                                <div class="bg-slate-50 group-hover:bg-slate-100 rounded-lg px-4 py-3 transition-colors">
                                                    <div class="flex items-center text-slate-700 font-semibold">
                                                        @if($progressPercentage > 0 && !$isCompleted)
                                                            <span class="mr-2">Lanjutkan</span>
                                                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                            </svg>
                                                        @elseif($isCompleted)
                                                            <span class="mr-2">Buka Lagi</span>
                                                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                                            </svg>
                                                        @else
                                                            <span class="mr-2">Mulai Belajar</span>
                                                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                            </svg>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $materi->links() }}
                    </div>
                @else
                    <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                        <div class="max-w-md mx-auto">
                            <div class="bg-gray-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                                <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Belum ada materi</h3>
                            <p class="text-gray-600">Guru belum mengunggah materi untuk kelas ini.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
