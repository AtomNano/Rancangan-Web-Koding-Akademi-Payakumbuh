@props(['user'])

<div class="flex flex-col h-screen bg-white shadow-lg w-64">
    <!-- Sidebar Header -->
    <div class="flex items-center h-16 px-6 border-b border-gray-200 flex-shrink-0">
        <div class="flex items-center">
            <svg class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M12 5a7 7 0 100 14 7 7 0 000-14z"/>
            </svg>
            <span class="ml-3 text-lg font-bold text-gray-800">Admin Panel</span>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="mt-5 px-4 flex-1 overflow-y-auto">
        <div class="space-y-1">
            <a href="{{ route('admin.dashboard') }}" 
               class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                Dashboard
            </a>
        </div>

        <div class="mt-8">
            <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Manajemen</h3>
            <div class="mt-2 space-y-1">
                <a href="{{ route('admin.users.index') }}" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.users.index') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m-4.5 3.903A2.5 2.5 0 017 15h10a2.5 2.5 0 012.5 2.5V21" />
                    </svg>
                    Manajemen Pengguna
                </a>
                <a href="{{ route('admin.kelas.index') }}" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.kelas.index') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                     <svg class="mr-3 h-6 w-6" xmlns="http://www.w3org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                    </svg>
                    Manajemen Kelas
                </a>
                <a href="{{ route('admin.materi.index') }}" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.materi.index') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Verifikasi Materi
                </a>
                <a href="#" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-400 cursor-not-allowed">
                    <svg class="mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4M4 7s0 4 8 4 8-4 8-4" />
                    </svg>
                    Backup Data
                </a>
            </div>
        </div>

        <div class="mt-8">
            <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Lainnya</h3>
            <div class="mt-2 space-y-1">
                <a href="#" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-400 cursor-not-allowed">
                    <svg class="mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V7a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Laporan
                </a>
                <a href="{{ route('profile.edit') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('profile.edit') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.608 3.292 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Pengaturan
                </a>
            </div>
        </div>
    </nav>

    <!-- Bottom Section with User Info & Logout -->
    <div class="mt-auto p-4 border-t border-gray-200">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-indigo-500 rounded-full flex items-center justify-center">
                    <span class="text-white font-semibold text-lg">{{ substr($user->name, 0, 1) }}</span>
                </div>
            </div>
            <div class="ml-3 flex-1">
                <p class="text-sm font-semibold text-gray-900">{{ $user->name }}</p>
                <p class="text-xs text-gray-500">{{ $user->email }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" title="Logout" class="text-gray-400 hover:text-red-500">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>