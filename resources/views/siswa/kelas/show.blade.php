<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelas: ' . $kelas->nama_kelas) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Class Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">{{ $kelas->nama_kelas }}</h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $kelas->bidang === 'coding' ? 'bg-blue-100 text-blue-800' : 
                               ($kelas->bidang === 'desain' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800') }}">
                            {{ ucfirst($kelas->bidang) }}
                        </span>
                    </div>
                    <p class="text-gray-600">{{ $kelas->deskripsi }}</p>
                </div>
            </div>

            <!-- Materials -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Materi Pembelajaran</h3>
                        <a href="{{ route('siswa.dashboard') }}" 
                           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Kembali ke Dashboard
                        </a>
                    </div>

                    @if($materi->count() > 0)
                        <div class="space-y-4">
                            @foreach($materi as $m)
                                @php
                                    $userProgress = $m->userProgress(auth()->id());
                                    $progressPercentage = $userProgress ? $userProgress->progress_percentage : 0;
                                    $isCompleted = $userProgress ? $userProgress->is_completed : false;
                                    $currentPage = $userProgress ? $userProgress->current_page : null;
                                    $totalPages = $userProgress ? $userProgress->total_pages : null;
                                @endphp
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-2">
                                                <h4 class="text-lg font-medium text-gray-900">{{ $m->judul }}</h4>
                                                @if($isCompleted)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        ✓ Selesai
                                                    </span>
                                                @elseif($progressPercentage > 0)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        {{ number_format($progressPercentage, 1) }}% Selesai
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="text-sm text-gray-600 mt-1">{{ Str::limit($m->deskripsi, 100) }}</p>
                                            
                                            <!-- Progress Bar for PDF files -->
                                            @if($m->file_type === 'pdf' && $progressPercentage > 0)
                                                <div class="mt-3">
                                                    <div class="flex justify-between items-center mb-1">
                                                        <span class="text-xs text-gray-500">Progres Membaca</span>
                                                        <span class="text-xs text-gray-500">{{ number_format($progressPercentage, 1) }}%</span>
                                                    </div>
                                                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                                                        <div class="bg-blue-600 h-1.5 rounded-full transition-all duration-300" 
                                                             style="width: {{ $progressPercentage }}%"></div>
                                                    </div>
                                                    @if($currentPage && $totalPages)
                                                        <div class="text-xs text-gray-500 mt-1">
                                                            Terakhir dibaca: Halaman {{ $currentPage }} dari {{ $totalPages }}
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                            
                                            <div class="flex items-center mt-2 space-x-4">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    {{ ucfirst($m->file_type) }}
                                                </span>
                                                <span class="text-sm text-gray-500">
                                                    Oleh: {{ $m->uploadedBy->name }}
                                                </span>
                                                <span class="text-sm text-gray-500">
                                                    {{ $m->created_at->format('d M Y') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('siswa.materi.show', $m) }}" 
                                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                                                {{ $progressPercentage > 0 ? 'Lanjutkan' : 'Buka Materi' }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $materi->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada materi</h3>
                            <p class="mt-1 text-sm text-gray-500">Guru belum mengunggah materi untuk kelas ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

