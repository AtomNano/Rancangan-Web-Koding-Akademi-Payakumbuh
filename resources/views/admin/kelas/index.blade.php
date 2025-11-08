<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 leading-tight">
                    {{ __('Class Management') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Manage classes and student enrollment</p>
            </div>
        </div>
    </x-slot>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <p class="text-sm font-medium text-slate-600 mb-1">Total Classes</p>
            <p class="text-3xl font-bold text-slate-900">{{ $stats['total_kelas'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <p class="text-sm font-medium text-slate-600 mb-1">Total Students</p>
            <p class="text-3xl font-bold text-slate-900">{{ $stats['total_siswa'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <p class="text-sm font-medium text-slate-600 mb-1">Total Teachers</p>
            <p class="text-3xl font-bold text-slate-900">{{ $stats['total_guru'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <p class="text-sm font-medium text-slate-600 mb-1">Total Materials</p>
            <p class="text-3xl font-bold text-slate-900">{{ $stats['total_materi'] }}</p>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-bold text-slate-900">Classes List</h3>
        <a href="{{ route('admin.kelas.create') }}" class="inline-flex items-center px-4 py-2.5 bg-slate-900 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-colors shadow-lg shadow-slate-900/20">
            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
            Create New Class
        </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($kelasList as $kelas)
            @php 
                $totalMateri = $kelas->materi->count();
                // Assuming progress is based on number of materials, max 15 for 100%
                $progress = $totalMateri > 0 ? min(100, ($totalMateri / 15) * 100) : 0; 
            @endphp
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden flex flex-col hover:shadow-xl hover:border-slate-300 transition-all duration-200 cursor-pointer group" onclick="window.location.href='{{ route('admin.kelas.show', $kelas->id) }}'">
                <!-- You can replace this with your actual images -->
                <div class="relative h-48 w-full overflow-hidden bg-gradient-to-br from-slate-900 to-slate-700">
                    <img class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300" src="https://placehold.co/600x400/475569/FFFFFF?text={{$kelas->nama_kelas}}" alt="Gambar kelas {{ $kelas->nama_kelas }}">
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-500/90 backdrop-blur-sm text-white shadow-lg">Active</span>
                    </div>
                </div>
                <div class="p-6 flex-grow flex flex-col">
                    <div class="flex justify-between items-start mb-3">
                        <h4 class="text-xl font-bold text-slate-900 group-hover:text-slate-700 transition-colors">{{ $kelas->nama_kelas }}</h4>
                    </div>
                    <p class="text-sm text-slate-600 mb-6 flex-grow leading-relaxed">{{ Str::limit($kelas->deskripsi, 80) }}</p>
                    
                    <div class="grid grid-cols-3 gap-4 text-center mb-4">
                        <div class="p-3 bg-slate-50 rounded-lg">
                            <p class="text-2xl font-bold text-slate-900">{{ $kelas->enrollments->count() }}</p>
                            <p class="text-xs text-slate-500 mt-1">Students</p>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-lg">
                            <p class="text-2xl font-bold text-slate-900">{{ $kelas->materi->count() }}</p>
                            <p class="text-xs text-slate-500 mt-1">Materials</p>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-lg">
                            <p class="text-2xl font-bold text-slate-900">{{ round($progress) }}%</p>
                            <p class="text-xs text-slate-500 mt-1">Progress</p>
                        </div>
                    </div>

                    <div class="w-full bg-slate-200 rounded-full h-2.5 mb-4">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2.5 rounded-full transition-all duration-300" style="width: {{ $progress }}%"></div>
                    </div>

                    <div class="border-t border-slate-200 pt-4">
                        <p class="text-xs font-medium text-slate-500 mb-2 uppercase tracking-wider">Instructor</p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center shadow-lg shadow-blue-500/20">
                                <span class="text-white font-bold text-sm">{{ substr($kelas->guru->name ?? 'N/A', 0, 2) }}</span>
                            </div>
                            <p class="ml-3 text-sm font-semibold text-slate-900">{{ $kelas->guru->name ?? 'Not assigned' }}</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-slate-50 border-t border-slate-200 flex justify-between items-center" onclick="event.stopPropagation();">
                    <a href="{{ route('admin.kelas.show', $kelas->id) }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">View Details</a>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('admin.kelas.edit', $kelas->id) }}" class="p-2 rounded-lg text-slate-400 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L16.732 3.732z" /></svg>
                        </a>
                        <form action="{{ route('admin.kelas.destroy', $kelas->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this class?');">
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
