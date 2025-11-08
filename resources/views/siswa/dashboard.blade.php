<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dasbor Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Kelas yang Saya Ikuti</h3>
                
                @if($enrolledClasses->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($enrolledClasses as $kelas)
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <h4 class="text-lg font-medium text-gray-900">{{ $kelas->nama_kelas }}</h4>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $kelas->bidang === 'coding' ? 'bg-blue-100 text-blue-800' : 
                                               ($kelas->bidang === 'desain' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800') }}">
                                            {{ ucfirst($kelas->bidang) }}
                                        </span>
                                    </div>
                                    
                                    <p class="text-sm text-gray-600 mb-4">{{ Str::limit($kelas->deskripsi, 100) }}</p>
                                    
                                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                        <span>{{ $kelas->materi_count }} Materi</span>
                                        <span>{{ $kelas->pivot->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}</span>
                                    </div>
                                    
                                    <a href="{{ route('siswa.kelas.show', $kelas) }}" 
                                       class="block w-full bg-blue-500 text-white text-center py-2 px-4 rounded hover:bg-blue-600">
                                        Masuk ke Kelas
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada kelas</h3>
                        <p class="mt-1 text-sm text-gray-500">Anda belum terdaftar di kelas manapun. Silakan hubungi admin untuk pendaftaran.</p>
                    </div>
                @endif
            </div>

            @if($enrolledClasses->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Kemajuan Belajar</h3>
                            <a href="{{ route('siswa.progress') }}" 
                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Lihat Detail
                            </a>
                        </div>
                        
                        <div class="space-y-4">
                            @foreach($enrolledClasses as $kelas)
                                @php
                                    $totalMateri = $kelas->materi()->where('status', 'approved')->count();
                                    $completedMateri = 0;
                                    $totalProgress = 0;
                                    
                                    if ($totalMateri > 0) {
                                        // Hitung materi yang sudah selesai
                                        $completedMateri = \App\Models\MateriProgress::where('user_id', auth()->id())
                                            ->whereHas('materi', function($query) use ($kelas) {
                                                $query->where('kelas_id', $kelas->id)->where('status', 'approved');
                                            })
                                            ->where('is_completed', true)
                                            ->count();
                                        
                                        // Hitung rata-rata progres dari semua materi
                                        $progressData = \App\Models\MateriProgress::where('user_id', auth()->id())
                                            ->whereHas('materi', function($query) use ($kelas) {
                                                $query->where('kelas_id', $kelas->id)->where('status', 'approved');
                                            })
                                            ->get();
                                        
                                        if ($progressData->count() > 0) {
                                            $totalProgress = $progressData->avg('progress_percentage');
                                        }
                                    }
                                    
                                    $overallProgress = $totalMateri > 0 ? round(($completedMateri / $totalMateri) * 100, 1) : 0;
                                @endphp
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm font-medium text-gray-700">{{ $kelas->nama_kelas }}</span>
                                        <span class="text-sm text-gray-500">{{ $overallProgress }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ $overallProgress }}%"></div>
                                    </div>
                                    @if($totalMateri > 0)
                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ $completedMateri }} dari {{ $totalMateri }} materi selesai
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

