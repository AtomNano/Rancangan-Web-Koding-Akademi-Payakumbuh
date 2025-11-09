<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dasbor Siswa') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <!-- Hero Section -->
            <div class="mb-8">
                <div class="bg-slate-800 rounded-2xl shadow-xl overflow-hidden">
                    <div class="px-8 py-1 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-4xl font-bold mb-2">
                                    Selamat Datang, {{ auth()->user()->name }}! 👋
                                </h1>
                                <p class="text-gray-300 text-lg">
                                    Teruslah belajar dan tingkatkan kemampuanmu setiap hari
                                </p>
                            </div>
                            <div class="hidden lg:block">
                                <svg class="w-32 h-32 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Classes Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Kelas Saya</h2>
                        <p class="text-gray-600 mt-1">Kelas yang sedang Anda ikuti</p>
                    </div>
                </div>
                
                @if($enrolledClasses->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($enrolledClasses as $kelas)
                            @php
                                $totalMateri = $kelas->materi()->where('status', 'approved')->count();
                                $completedMateri = \App\Models\MateriProgress::where('user_id', auth()->id())
                                    ->whereHas('materi', function($query) use ($kelas) {
                                        $query->where('kelas_id', $kelas->id)->where('status', 'approved');
                                    })
                                    ->where('is_completed', true)
                                    ->count();
                                
                                $progressData = \App\Models\MateriProgress::where('user_id', auth()->id())
                                    ->whereHas('materi', function($query) use ($kelas) {
                                        $query->where('kelas_id', $kelas->id)->where('status', 'approved');
                                    })
                                    ->get();
                                
                                $avgProgress = $progressData->count() > 0 ? round($progressData->avg('progress_percentage'), 1) : 0;
                                $overallProgress = $totalMateri > 0 ? round(($completedMateri / $totalMateri) * 100, 1) : 0;
                                
                                // Warna solid sesuai sidebar
                                $bgColor = 'bg-slate-800';
                            @endphp
                            <a href="{{ route('siswa.kelas.show', $kelas) }}" class="block">
                                <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden group cursor-pointer">
                                    <!-- Header -->
                                    <div class="{{ $bgColor }} p-6 text-white">
                                        <div class="flex items-center justify-between mb-4">
                                            <h3 class="text-xl font-bold">{{ $kelas->nama_kelas }}</h3>
                                            <span class="bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold">
                                                {{ ucfirst($kelas->bidang) }}
                                            </span>
                                        </div>
                                        <p class="text-white/90 text-sm line-clamp-2">{{ Str::limit($kelas->deskripsi, 80) }}</p>
                                    </div>
                                    
                                    <!-- Content -->
                                    <div class="p-6">
                                        <!-- Progress Section -->
                                        <div class="mb-4">
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="text-sm font-medium text-gray-700">Progress</span>
                                                <span class="text-sm font-bold text-gray-900">{{ $overallProgress }}%</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                                <div class="bg-slate-700 h-3 rounded-full transition-all duration-500" 
                                                     style="width: {{ $overallProgress }}%"></div>
                                            </div>
                                            <div class="flex items-center justify-between mt-2 text-xs text-gray-500">
                                                <span>{{ $completedMateri }} dari {{ $totalMateri }} materi selesai</span>
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ $avgProgress }}% rata-rata
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <!-- Stats -->
                                        <div class="flex items-center justify-between py-4 border-t border-gray-200">
                                            <div class="flex items-center text-gray-600">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                                <span class="text-sm font-medium">{{ $totalMateri }} Materi</span>
                                            </div>
                                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                                {{ $kelas->pivot->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ $kelas->pivot->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                        </div>
                                        
                                        <!-- Action Indicator -->
                                        <div class="mt-4 bg-gray-50 rounded-lg py-3 px-4 text-center group-hover:bg-gray-100 transition-colors">
                                            <div class="flex items-center justify-center text-gray-700 font-semibold">
                                                <span>Masuk ke Kelas</span>
                                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                        <div class="max-w-md mx-auto">
                            <div class="bg-gray-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                                <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Belum ada kelas</h3>
                            <p class="text-gray-600 mb-6">Anda belum terdaftar di kelas manapun. Silakan hubungi admin untuk pendaftaran.</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Statistics Cards -->
            @php
                $totalKelas = $enrolledClasses->count();
                $totalMateri = 0;
                $totalCompleted = 0;
                $totalProgress = 0;
                
                foreach($enrolledClasses as $kelas) {
                    $materiCount = $kelas->materi()->where('status', 'approved')->count();
                    $totalMateri += $materiCount;
                    
                    $completed = \App\Models\MateriProgress::where('user_id', auth()->id())
                        ->whereHas('materi', function($query) use ($kelas) {
                            $query->where('kelas_id', $kelas->id)->where('status', 'approved');
                        })
                        ->where('is_completed', true)
                        ->count();
                    $totalCompleted += $completed;
                    
                    $progress = \App\Models\MateriProgress::where('user_id', auth()->id())
                        ->whereHas('materi', function($query) use ($kelas) {
                            $query->where('kelas_id', $kelas->id)->where('status', 'approved');
                        })
                        ->avg('progress_percentage') ?? 0;
                    $totalProgress += $progress;
                }
                
                $avgProgress = $totalKelas > 0 ? round($totalProgress / $totalKelas, 1) : 0;
                $completionRate = $totalMateri > 0 ? round(($totalCompleted / $totalMateri) * 100, 1) : 0;
            @endphp

            @if($totalKelas > 0)
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Statistik</h2>
                        <p class="text-gray-600 mt-1">Ringkasan kemajuan belajar Anda</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Total Kelas Card -->
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 p-6 border-l-4 border-blue-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Total Kelas</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $totalKelas }}</p>
                            </div>
                            <div class="bg-blue-100 rounded-full p-3">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Total Materi Card -->
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 p-6 border-l-4 border-purple-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Total Materi</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $totalMateri }}</p>
                            </div>
                            <div class="bg-purple-100 rounded-full p-3">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Completion Rate Card -->
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 p-6 border-l-4 border-green-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Tingkat Penyelesaian</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $completionRate }}%</p>
                            </div>
                            <div class="bg-green-100 rounded-full p-3">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Average Progress Card -->
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 p-6 border-l-4 border-indigo-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Rata-rata Progress</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $avgProgress }}%</p>
                            </div>
                            <div class="bg-indigo-100 rounded-full p-3">
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
