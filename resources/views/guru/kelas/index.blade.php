<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('Kelas yang Saya Ajar') }}
        </h2>
                <p class="text-sm text-gray-600 mt-1">Kelola semua kelas yang Anda ajar</p>
            </div>
            <a href="{{ route('guru.dashboard') }}" 
               class="text-gray-600 hover:text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($kelas->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($kelas as $k)
                        <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 group cursor-pointer transform hover:-translate-y-1" 
                             onclick="window.location.href='{{ route('guru.kelas.show', $k) }}'">
                            <!-- Gradient Header -->
                            <div class="h-3 {{ $k->bidang === 'coding' ? 'bg-gradient-to-r from-blue-500 via-blue-600 to-indigo-600' : 
                                                  ($k->bidang === 'desain' ? 'bg-gradient-to-r from-purple-500 via-pink-500 to-rose-500' : 
                                                  'bg-gradient-to-r from-green-500 via-emerald-500 to-teal-500') }}"></div>
                            
                            <div class="p-6">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors">
                                            {{ $k->nama_kelas }}
                                        </h4>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                        {{ $k->bidang === 'coding' ? 'bg-blue-100 text-blue-800' : 
                                           ($k->bidang === 'desain' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800') }}">
                                        {{ ucfirst($k->bidang) }}
                                    </span>
                                    </div>
                                </div>
                                
                                <p class="text-sm text-gray-600 mb-5 line-clamp-3 min-h-[3.75rem]">{{ Str::limit($k->deskripsi ?? 'Tidak ada deskripsi', 120) }}</p>
                                
                                <div class="space-y-3 mb-5">
                                    <div class="flex items-center justify-between text-sm">
                                        <div class="flex items-center text-gray-600">
                                            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                            <span class="font-semibold text-gray-900">{{ $k->students_count ?? 0 }}</span>
                                            <span class="ml-1 text-gray-600">Siswa</span>
                                        </div>
                                        @if($k->status)
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $k->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ $k->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <a href="{{ route('guru.kelas.show', $k->id) }}" 
                                   class="block w-full text-center py-3 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                    Kelola Kelas
                                    <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                    <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Kelas</h3>
                    <p class="text-gray-600 mb-6">Anda belum ditugaskan ke kelas manapun. Silakan hubungi admin untuk penugasan kelas.</p>
                    <a href="{{ route('guru.dashboard') }}" 
                       class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Dashboard
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
