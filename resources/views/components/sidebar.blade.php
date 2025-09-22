@props(['user'])

<div :class="{'w-64': sidebarOpen, 'w-20': !sidebarOpen}" class="fixed inset-y-0 left-0 bg-white shadow-lg z-30 transform md:relative md:translate-x-0 transition-all duration-300 ease-in-out">
    
    <div class="flex flex-col h-full">
        <!-- Sidebar Header -->
        <div class="flex items-center justify-center h-16 px-4 border-b border-gray-200 flex-shrink-0">
            <a href="{{ route('dashboard') }}" class="flex items-center">
                <svg class="h-8 w-8 text-indigo-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M12 5a7 7 0 100 14 7 7 0 000-14z"/>
                </svg>
                <span x-show="sidebarOpen" class="ml-3 text-lg font-bold text-gray-800 whitespace-nowrap">
                    @if($user->role === 'admin')
                        Admin Panel
                    @elseif($user->role === 'guru')
                        Guru Panel
                    @else
                        Siswa Panel
                    @endif
                </span>
            </a>
        </div>

        <!-- Navigation Menu -->
        <nav class="mt-5 px-2 flex-1 overflow-y-auto">
            @if($user->role === 'admin')
                {{-- Admin Links --}}
                <div class="space-y-1">
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="flex items-center justify-center py-2 px-4">
                        <svg class="h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Dashboard</span>
                    </x-nav-link>
                </div>
                <div class="mt-8">
                    <h3 x-show="sidebarOpen" class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Manajemen</h3>
                    <div class="mt-2 space-y-1">
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" class="flex items-center justify-center py-2 px-4">
                            <svg class="h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m-4.5 3.903A2.5 2.5 0 017 15h10a2.5 2.5 0 012.5 2.5V21" />
                            </svg>
                            <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Manajemen Pengguna</span>
                        </x-nav-link>
                        <x-nav-link :href="route('admin.kelas.index')" :active="request()->routeIs('admin.kelas.*')" class="flex items-center justify-center py-2 px-4">
                             <svg class="h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                            </svg>
                            <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Manajemen Kelas</span>
                        </x-nav-link>
                        <x-nav-link :href="route('admin.materi.index')" :active="request()->routeIs('admin.materi.*')" class="flex items-center justify-center py-2 px-4">
                            <svg class="h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Verifikasi Materi</span>
                        </x-nav-link>
                        <x-nav-link :href="route('admin.backup.index')" :active="request()->routeIs('admin.backup.*')" class="flex items-center justify-center py-2 px-4">
                            <svg class="h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4M4 7s0 4 8 4 8-4 8-4" />
                            </svg>
                            <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Backup Data</span>
                        </x-nav-link>
                    </div>
                </div>

            @elseif($user->role === 'guru')
                {{-- Guru Links --}}
                <div class="space-y-1">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center justify-center py-2 px-4">
                        <svg class="h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Dashboard</span>
                    </x-nav-link>
                    <x-nav-link :href="route('guru.materi.index')" :active="request()->routeIs('guru.materi.*')" class="flex items-center justify-center py-2 px-4">
                        <svg class="h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                        <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Manajemen Materi</span>
                    </x-nav-link>
                </div>

            @elseif($user->role === 'siswa')
                {{-- Siswa Links --}}
                <div class="space-y-1">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center justify-center py-2 px-4">
                        <svg class="h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Dashboard</span>
                    </x-nav-link>
                    <x-nav-link :href="route('siswa.progress')" :active="request()->routeIs('siswa.progress')" class="flex items-center justify-center py-2 px-4">
                        <svg class="h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V7a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Progress Belajar</span>
                    </x-nav-link>
                </div>
            @endif

            {{-- Common Links for All Roles --}}
            <div class="mt-8">
                <h3 x-show="sidebarOpen" class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Akun</h3>
                <div class="mt-2 space-y-1">
                     <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" class="flex items-center justify-center py-2 px-4">
                        <svg class="h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0 3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.608 3.292 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Profil</span>
                    </x-nav-link>
                </div>
            </div>
        </nav>

        <!-- Bottom Section with User Info & Logout -->
        <div class="mt-auto p-4 border-t border-gray-200">
            <div class="flex items-center justify-center">
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded-full object-cover" src="{{ $user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF' }}" alt="{{ $user->name }}">
                </div>
                <div x-show="sidebarOpen" class="ml-3 flex-1">
                    <p class="text-sm font-semibold text-gray-900 whitespace-nowrap">{{ $user->name }}</p>
                    <p class="text-xs text-gray-500 whitespace-nowrap">{{ $user->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" x-show="sidebarOpen">
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
</div>

<!-- Sidebar backdrop for mobile -->
<div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-50 z-20 md:hidden" x-cloak></div>