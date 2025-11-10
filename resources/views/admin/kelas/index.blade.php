<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 leading-tight">
                    {{ __('Manajemen Kelas') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Kelola kelas dan pendaftaran siswa</p>
            </div>
        </div>
    </x-slot>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <p class="text-sm font-medium text-slate-600 mb-1">Total Kelas</p>
            <p class="text-3xl font-bold text-slate-900">{{ $stats['total_kelas'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <p class="text-sm font-medium text-slate-600 mb-1">Total Siswa</p>
            <p class="text-3xl font-bold text-slate-900">{{ $stats['total_siswa'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <p class="text-sm font-medium text-slate-600 mb-1">Total Guru</p>
            <p class="text-3xl font-bold text-slate-900">{{ $stats['total_guru'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <p class="text-sm font-medium text-slate-600 mb-1">Total Materi</p>
            <p class="text-3xl font-bold text-slate-900">{{ $stats['total_materi'] }}</p>
        </div>
    </div>

    <!-- Alert for unassigned classes -->
    @if(isset($unassignedKelas) && $unassignedKelas->count() > 0)
        <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        <strong>Peringatan:</strong> Ada {{ $unassignedKelas->count() }} kelas yang belum diassign ke guru. 
                        Silakan edit kelas tersebut dan pilih guru pengajar.
                    </p>
                    <ul class="mt-2 list-disc list-inside text-sm text-yellow-600">
                        @foreach($unassignedKelas as $kelas)
                            <li>
                                <a href="{{ route('admin.kelas.edit', $kelas) }}" class="underline hover:text-yellow-800">
                                    {{ $kelas->nama_kelas }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Actions -->
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-bold text-slate-900">Daftar Kelas</h3>
        <a href="{{ route('admin.kelas.create') }}" class="inline-flex items-center px-4 py-2.5 bg-slate-900 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-colors shadow-lg shadow-slate-900/20">
            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
            Buat Kelas Baru
        </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($kelasList as $kelas)
            @php 
                // Count only students (not teachers) in enrollments
                // Filter by role = 'siswa'
                $totalSiswa = $kelas->students()->where('users.role', 'siswa')->count();
                
                $totalMateri = $kelas->materi->count();
                $approvedMateri = $kelas->materi->where('status', 'approved')->count();
                
                // Calculate progress based on student completion
                $progress = 0;
                if ($totalSiswa > 0 && $approvedMateri > 0) {
                    $totalProgress = 0;
                    $students = $kelas->students()->where('users.role', 'siswa')->get();
                    foreach ($students as $student) {
                        $completedMateri = \App\Models\MateriProgress::where('user_id', $student->id)
                            ->whereIn('materi_id', $kelas->materi->where('status', 'approved')->pluck('id'))
                            ->where('is_completed', true)
                            ->count();
                        $studentProgress = $approvedMateri > 0 ? ($completedMateri / $approvedMateri) * 100 : 0;
                        $totalProgress += $studentProgress;
                    }
                    $progress = $totalSiswa > 0 ? round($totalProgress / $totalSiswa, 1) : 0;
                }
            @endphp
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden flex flex-col hover:shadow-xl hover:border-slate-300 transition-all duration-200 cursor-pointer group" onclick="window.location.href='{{ route('admin.kelas.show', $kelas->id) }}'">
                <!-- You can replace this with your actual images -->
                <div class="relative h-48 w-full overflow-hidden bg-gradient-to-br from-slate-900 to-slate-700">
                    <img class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300" src="https://placehold.co/600x400/475569/FFFFFF?text={{$kelas->nama_kelas}}" alt="Gambar kelas {{ $kelas->nama_kelas }}">
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-500/90 backdrop-blur-sm text-white shadow-lg">Aktif</span>
                    </div>
                </div>
                <div class="p-6 flex-grow flex flex-col">
                    <div class="flex justify-between items-start mb-3">
                        <h4 class="text-xl font-bold text-slate-900 group-hover:text-slate-700 transition-colors">{{ $kelas->nama_kelas }}</h4>
                    </div>
                    <p class="text-sm text-slate-600 mb-6 flex-grow leading-relaxed">{{ Str::limit($kelas->deskripsi, 80) }}</p>
                    
                    <div class="grid grid-cols-3 gap-4 text-center mb-4">
                        <div class="p-3 bg-slate-50 rounded-lg">
                            <p class="text-2xl font-bold text-slate-900">{{ $totalSiswa }}</p>
                            <p class="text-xs text-slate-500 mt-1">Siswa</p>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-lg">
                            <p class="text-2xl font-bold text-slate-900">{{ $totalMateri }}</p>
                            <p class="text-xs text-slate-500 mt-1">Materi</p>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-lg">
                            <p class="text-2xl font-bold text-slate-900">{{ round($progress) }}%</p>
                            <p class="text-xs text-slate-500 mt-1">Kemajuan</p>
                        </div>
                    </div>

                    <div class="w-full bg-slate-200 rounded-full h-2.5 mb-4">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2.5 rounded-full transition-all duration-300" style="width: {{ $progress }}%"></div>
                    </div>

                    <div class="border-t border-slate-200 pt-4">
                        <p class="text-xs font-medium text-slate-500 mb-2 uppercase tracking-wider">Guru Pengajar</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center shadow-lg shadow-blue-500/20">
                                    <span class="text-white font-bold text-sm">{{ substr($kelas->guru->name ?? 'N/A', 0, 2) }}</span>
                                </div>
                                <p class="ml-3 text-sm font-semibold text-slate-900 truncate" title="{{ $kelas->guru->name ?? 'Belum ditugaskan' }}">{{ $kelas->guru->name ?? 'Belum ditugaskan' }}</p>
                            </div>
                            @if(!$kelas->guru_id)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Perlu Assign
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-slate-50 border-t border-slate-200 flex justify-between items-center" onclick="event.stopPropagation();">
                    <a href="{{ route('admin.kelas.show', $kelas->id) }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">Lihat Detail</a>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('admin.kelas.edit', $kelas->id) }}" class="p-2 rounded-lg text-slate-400 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L16.732 3.732z" /></svg>
                        </a>
                        <form action="{{ route('admin.kelas.destroy', $kelas->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus kelas ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-600 transition-colors">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</x-app-layout>
