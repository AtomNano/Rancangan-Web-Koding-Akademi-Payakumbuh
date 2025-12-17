@props(['user'])

<!-- Mobile Overlay/Backdrop -->
<div x-show="sidebarOpen" 
     @click="sidebarOpen = false"
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 md:hidden"
     x-cloak
     style="display: none;"></div>

<!-- Sidebar -->
<div :class="{
    'translate-x-0': sidebarOpen,
    '-translate-x-full md:translate-x-0': !sidebarOpen,
    'w-60': sidebarOpen,
    'w-20': !sidebarOpen && window.innerWidth >= 768
}" 
     class="fixed inset-y-0 left-0 bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 shadow-2xl z-50 transform md:relative transition-all duration-300 ease-in-out border-r border-slate-700/50 w-60 md:w-auto">
    
    <div class="flex flex-col h-full">
        <!-- Sidebar Header -->
        <div class="flex items-center h-20 px-2 border-b border-slate-700/50 flex-shrink-0 bg-slate-900/50 backdrop-blur-sm overflow-hidden">
            <a href="{{ route('dashboard') }}" class="flex items-center w-full group transition-all duration-200 min-w-0" :class="{'justify-center': !sidebarOpen, 'justify-start': sidebarOpen}">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center justify-center">
                    <img src="{{ asset('images/logo/logo-transparent.png') }}" alt="Coding Academy" 
                         class="object-contain group-hover:scale-105 transition-transform duration-200 brightness-0 invert"
                         :class="sidebarOpen ? 'h-12' : 'h-10'">
                </div>
                <!-- Text - Only show when sidebar is open -->
                <div x-show="sidebarOpen" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-95"
                     class="flex flex-col ml-3 min-w-0 flex-1">
                    <span class="text-sm font-bold text-white leading-tight break-words">
                        Coding Academy Payakumbuh
                    </span>
                    <span class="text-xs text-slate-400 font-medium mt-0.5 break-words">
                        @if($user->role === 'admin')
                            Panel Admin
                        @elseif($user->role === 'guru')
                            Panel Guru
                        @else
                            Panel Siswa
                        @endif
                    </span>
                </div>
            </a>
        </div>

        <!-- Navigation Menu -->
        <nav class="mt-6 px-3 flex-1 overflow-y-auto scrollbar-thin scrollbar-thumb-slate-700 scrollbar-track-transparent">
            @if($user->role === 'admin')
                {{-- Admin Links --}}
                <div class="space-y-1.5">
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        <svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap" x-cloak>Dasbor</span>
                    </x-nav-link>
                </div>
                <div class="mt-8">
                    <h3 x-show="sidebarOpen" class="px-3 mb-3 text-xs font-semibold text-slate-400 uppercase tracking-wider" x-cloak>Manajemen</h3>
                    <div class="space-y-1.5">
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                            <svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m-4.5 3.903A2.5 2.5 0 017 15h10a2.5 2.5 0 012.5 2.5V21" />
                            </svg>
                            <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap" x-cloak>Pengguna</span>
                        </x-nav-link>
                        <x-nav-link :href="route('admin.kelas.index')" :active="request()->routeIs('admin.kelas.*')">
                             <svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                            </svg>
                            <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap" x-cloak>Kelas</span>
                        </x-nav-link>
                        <!-- Shortcut: Input Pertemuan & Absen -->
                        <!-- Shortcut: Pertemuan Management (select kelas first) -->
                        <x-nav-link :href="route('admin.pertemuan.select')" :active="request()->routeIs('admin.pertemuan.*')" title="Pilih kelas terlebih dahulu, lalu kelola pertemuan & absen">
                            <svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap" x-cloak>Pertemuan & Absen</span>
                        </x-nav-link>
                        <x-nav-link :href="route('admin.materi.index')" :active="request()->routeIs('admin.materi.*')">
                            <svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap" x-cloak>Materi</span>
                        </x-nav-link>
                        <x-nav-link :href="route('admin.backup.index')" :active="request()->routeIs('admin.backup.*')">
                            <svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4M4 7s0 4 8 4 8-4 8-4" />
                            </svg>
                            <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap" x-cloak>Cadangan Data</span>
                        </x-nav-link>
                    </div>
                </div>

            @elseif($user->role === 'guru')
                {{-- Guru Links --}}
                <div class="space-y-1.5">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap" x-cloak>Dasbor</span>
                    </x-nav-link>
                    <x-nav-link :href="route('guru.materi.index')" :active="request()->routeIs('guru.materi.*')">
                        <svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                        <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap" x-cloak>Materi</span>
                    </x-nav-link>
                    <!-- Shortcut: Input Pertemuan & Absen (Guru) -->
                    <x-nav-link :href="route('guru.absen.index')" :active="request()->routeIs('guru.absen.*') || request()->routeIs('guru.pertemuan.absen*') || request()->routeIs('guru.pertemuan.absen-detail')">
                        <svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap" x-cloak>Input Absen</span>
                    </x-nav-link>
                    <x-nav-link :href="route('guru.kelas.index')" :active="request()->routeIs('guru.kelas.*') || (request()->routeIs('guru.pertemuan.*') && !request()->routeIs('guru.pertemuan.absen*') && !request()->routeIs('guru.pertemuan.absen-detail'))">
                        <svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap" x-cloak>Kelas Ajar</span>
                    </x-nav-link>
                </div>

            @elseif($user->role === 'siswa')
                {{-- Siswa Links --}}
                <div class="space-y-1.5">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap" x-cloak>Dasbor</span>
                    </x-nav-link>
                    <x-nav-link :href="route('siswa.progress')" :active="request()->routeIs('siswa.progress')">
                        <svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V7a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap" x-cloak>Kemajuan</span>
                    </x-nav-link>
                </div>
            @endif

            {{-- Common Links for All Roles --}}
            <div class="mt-8">
                    <h3 x-show="sidebarOpen" class="px-3 mb-3 text-xs font-semibold text-slate-400 uppercase tracking-wider" x-cloak>Akun</h3>
                <div class="space-y-1.5">
                     <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                        <svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0 3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.608 3.292 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap" x-cloak>Profil</span>
                    </x-nav-link>
                </div>
            </div>
        </nav>

        <!-- Bottom Section with User Info & Logout -->
        <div class="mt-auto p-4 border-t border-slate-700/50 bg-slate-900/30 backdrop-blur-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded-lg object-cover ring-2 ring-slate-700/50" src="{{ $user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=FFFFFF&background=475569' }}" alt="{{ $user->name }}">
                </div>
                <div x-show="sidebarOpen" class="ml-3 flex-1 min-w-0" x-cloak>
                    <p class="text-sm font-semibold text-white truncate">{{ $user->name }}</p>
                    <p class="text-xs text-slate-400 truncate">{{ $user->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" x-show="sidebarOpen" class="ml-2" x-cloak>
                    @csrf
                    <button type="submit" title="Logout" class="p-2 text-slate-400 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-colors">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
