<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Welcome back, {{ Auth::user()->name }}! Manage your platform efficiently.</p>
            </div>
        </div>
    </x-slot>

    <!-- Welcome Banner -->
    <div class="relative overflow-hidden rounded-xl bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 p-8 mb-8 shadow-xl border border-slate-700/50">
        <div class="absolute inset-0 bg-grid-white/10 [mask-image:linear-gradient(0deg,white,rgba(255,255,255,0.6))]"></div>
        <div class="relative">
            <h3 class="text-3xl font-bold text-white mb-2">Welcome back, Admin!</h3>
            <p class="text-slate-300 text-lg">Manage Coding Academy platform with ease and efficiency.</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <a href="{{ route('admin.users.index') }}" class="group block p-6 bg-white rounded-xl shadow-sm hover:shadow-lg border border-slate-200 hover:border-blue-300 transition-all duration-200">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <p class="text-sm font-medium text-slate-600 mb-1">Total Users</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $stats['total_pengguna'] }}</p>
                    <p class="text-xs text-slate-500 mt-2">All platform users</p>
                </div>
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-3 rounded-xl shadow-lg shadow-blue-500/20 group-hover:scale-110 transition-transform">
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m-4.5 3.903A2.5 2.5 0 017 15h10a2.5 2.5 0 012.5 2.5V21" /></svg>
                </div>
            </div>
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'guru']) }}" class="group block p-6 bg-white rounded-xl shadow-sm hover:shadow-lg border border-slate-200 hover:border-emerald-300 transition-all duration-200">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <p class="text-sm font-medium text-slate-600 mb-1">Teachers</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $stats['total_guru'] }}</p>
                    <p class="text-xs text-slate-500 mt-2">Active instructors</p>
                </div>
                <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 p-3 rounded-xl shadow-lg shadow-emerald-500/20 group-hover:scale-110 transition-transform">
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </div>
            </div>
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'siswa']) }}" class="group block p-6 bg-white rounded-xl shadow-sm hover:shadow-lg border border-slate-200 hover:border-amber-300 transition-all duration-200">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <p class="text-sm font-medium text-slate-600 mb-1">Students</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $stats['total_siswa'] }}</p>
                    <p class="text-xs text-slate-500 mt-2">Enrolled learners</p>
                </div>
                <div class="bg-gradient-to-br from-amber-500 to-amber-600 p-3 rounded-xl shadow-lg shadow-amber-500/20 group-hover:scale-110 transition-transform">
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-5.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222 4 2.222V20" /></svg>
                </div>
            </div>
        </a>
        <a href="{{ route('admin.kelas.index') }}" class="group block p-6 bg-white rounded-xl shadow-sm hover:shadow-lg border border-slate-200 hover:border-purple-300 transition-all duration-200">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <p class="text-sm font-medium text-slate-600 mb-1">Classes</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $stats['total_kelas'] }}</p>
                    <p class="text-xs text-slate-500 mt-2">Available courses</p>
                </div>
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-3 rounded-xl shadow-lg shadow-purple-500/20 group-hover:scale-110 transition-transform">
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" /></svg>
                </div>
            </div>
        </a>
    </div>

    <!-- Additional Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <a href="{{ route('admin.users.index', ['role' => 'siswa', 'status' => 'active']) }}" class="group block p-6 bg-white rounded-xl shadow-sm hover:shadow-lg border border-slate-200 hover:border-teal-300 transition-all duration-200">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <p class="text-sm font-medium text-slate-600 mb-1">Active Students</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $stats['siswa_aktif'] }}</p>
                </div>
                <div class="bg-gradient-to-br from-teal-500 to-teal-600 p-3 rounded-xl shadow-lg shadow-teal-500/20 group-hover:scale-110 transition-transform">
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                </div>
            </div>
        </a>
        <a href="{{ route('admin.materi.index') }}" class="group block p-6 bg-white rounded-xl shadow-sm hover:shadow-lg border border-slate-200 hover:border-yellow-300 transition-all duration-200">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <p class="text-sm font-medium text-slate-600 mb-1">Pending Review</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $stats['pending_materi'] }}</p>
                    <p class="text-xs text-slate-500 mt-2">Needs attention</p>
                </div>
                <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 p-3 rounded-xl shadow-lg shadow-yellow-500/20 group-hover:scale-110 transition-transform">
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
        </a>
        <a href="{{ route('admin.materi.index') }}" class="group block p-6 bg-white rounded-xl shadow-sm hover:shadow-lg border border-slate-200 hover:border-indigo-300 transition-all duration-200">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <p class="text-sm font-medium text-slate-600 mb-1">Active Materials</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $stats['materi_aktif'] }}</p>
                    <p class="text-xs text-slate-500 mt-2">Verified content</p>
                </div>
                <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 p-3 rounded-xl shadow-lg shadow-indigo-500/20 group-hover:scale-110 transition-transform">
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                </div>
            </div>
        </a>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Activity -->
        <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <div class="flex justify-between items-center mb-6">
                <h4 class="text-lg font-bold text-slate-900">Recent Activity</h4>
                <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700">View All</a>
            </div>
            <div class="space-y-4">
                <!-- Static Activity Item 1 -->
                <div class="flex items-start space-x-4 p-4 rounded-lg hover:bg-slate-50 transition-colors">
                    <div class="bg-blue-100 p-2.5 rounded-lg"><svg class="h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" /></svg></div>
                    <div class="flex-1">
                        <p class="text-sm text-slate-900 font-medium"><b>Dr. Sarah Ahmad</b> uploaded material "Algoritma Dasar"</p>
                        <p class="text-xs text-slate-500 mt-1">2 hours ago</p>
                    </div>
                    <span class="text-xs font-medium text-yellow-700 bg-yellow-100 px-3 py-1 rounded-full">Pending</span>
                </div>
                <!-- Static Activity Item 2 -->
                <div class="flex items-start space-x-4 p-4 rounded-lg hover:bg-slate-50 transition-colors">
                    <div class="bg-emerald-100 p-2.5 rounded-lg"><svg class="h-5 w-5 text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg></div>
                    <div class="flex-1">
                        <p class="text-sm text-slate-900 font-medium"><b>Ahmad Fauzi</b> registered as new student</p>
                        <p class="text-xs text-slate-500 mt-1">3 hours ago</p>
                    </div>
                    <span class="text-xs font-medium text-slate-700 bg-slate-100 px-3 py-1 rounded-full">Completed</span>
                </div>
                <!-- Static Activity Item 3 -->
                <div class="flex items-start space-x-4 p-4 rounded-lg hover:bg-slate-50 transition-colors">
                    <div class="bg-indigo-100 p-2.5 rounded-lg"><svg class="h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
                    <div class="flex-1">
                        <p class="text-sm text-slate-900 font-medium"><b>Prof. Lisa Wong</b> material "UI/UX Principles" verified</p>
                        <p class="text-xs text-slate-500 mt-1">5 hours ago</p>
                    </div>
                    <span class="text-xs font-medium text-emerald-700 bg-emerald-100 px-3 py-1 rounded-full">Approved</span>
                </div>
            </div>
        </div>

        <!-- Pending Verifications -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <div class="flex justify-between items-center mb-6">
                <h4 class="text-lg font-bold text-slate-900">Pending Review</h4>
                <a href="{{ route('admin.materi.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">Manage All</a>
            </div>
            <div class="space-y-4">
                @forelse($pending_verifications as $materi)
                    <div class="p-4 bg-slate-50 rounded-lg border border-slate-200 hover:border-slate-300 transition-colors">
                        <p class="text-sm font-bold text-slate-900 mb-1">{{ $materi->judul }}</p>
                        <p class="text-xs text-slate-600 mb-3">By: {{ $materi->uploadedBy->name ?? 'N/A' }} &bull; Class: {{ $materi->kelas->nama_kelas ?? 'N/A' }}</p>
                        <div class="flex justify-end items-center space-x-2">
                            <form action="{{ route('admin.materi.approve', $materi->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="p-2 bg-emerald-100 text-emerald-600 rounded-lg hover:bg-emerald-200 transition-colors">
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                </button>
                            </form>
                            <form action="{{ route('admin.materi.reject', $materi->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors">
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-500 text-center py-4">No materials waiting for verification.</p>
                @endforelse
            </div>
        </div>
    </div>

</x-app-layout>



