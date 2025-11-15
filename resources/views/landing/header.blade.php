<!-- Header / Navigasi -->
<header class="glass-nav sticky top-0 z-50 backdrop-blur-xl">
    <nav class="container mx-auto flex items-center justify-between px-6 py-4 lg:py-5">
        <a href="{{ url('/') }}" class="group flex items-center gap-3">
            <img src="{{ asset('images/logo/logo-transparent.png') }}" alt="Coding Academy Payakumbuh" class="h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
            <div class="flex flex-col">
                <span class="text-lg font-bold leading-tight text-white text-high-contrast sm:text-xl">Coding Academy</span>
                <span class="text-[0.7rem] font-medium leading-tight text-white/70 sm:text-xs">Payakumbuh</span>
            </div>
        </a>

        <div class="hidden lg:flex items-center gap-1 rounded-full border border-white/10 bg-white/5 px-6 py-2 shadow-lg shadow-slate-950/20 backdrop-blur-lg">
            <a href="#profil" class="rounded-full px-4 py-2 text-sm font-semibold text-white/70 transition-all duration-200 hover:bg-white/10 hover:text-white">Tentang</a>
            <a href="#kelas" class="rounded-full px-4 py-2 text-sm font-semibold text-white/70 transition-all duration-200 hover:bg-white/10 hover:text-white">Program</a>
            <a href="#pricing" class="rounded-full px-4 py-2 text-sm font-semibold text-white/70 transition-all duration-200 hover:bg-white/10 hover:text-white">Biaya</a>
            <a href="#media" class="rounded-full px-4 py-2 text-sm font-semibold text-white/70 transition-all duration-200 hover:bg-white/10 hover:text-white">Media</a>
            <a href="#kontak" class="rounded-full px-4 py-2 text-sm font-semibold text-white/70 transition-all duration-200 hover:bg-white/10 hover:text-white">Kontak</a>
        </div>

        <div class="hidden items-center gap-4 lg:flex">
            <a href="/login" class="rounded-full border border-white/20 px-5 py-2.5 text-sm font-semibold text-white/75 transition-all duration-200 hover:border-white/40 hover:text-white">
                Masuk
            </a>
            <a href="#kelas" class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-blue-500/30 transition-transform duration-200 hover:scale-[1.02]">
                <span>Diskusikan Kelas</span>
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>

        <button id="mobile-menu-button" class="inline-flex items-center justify-center rounded-xl border border-white/10 bg-white/10 p-2 text-white transition-all duration-200 hover:bg-white/20 lg:hidden">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden border-t border-white/10 bg-slate-950/75 px-6 pb-6 backdrop-blur-xl lg:hidden">
        <div class="pt-4 space-y-1">
            <a href="#profil" class="block rounded-2xl px-4 py-3 text-sm font-semibold text-white/80 transition-all duration-200 hover:bg-white/10 hover:text-white">Tentang</a>
            <a href="#kelas" class="block rounded-2xl px-4 py-3 text-sm font-semibold text-white/80 transition-all duration-200 hover:bg-white/10 hover:text-white">Program</a>
            <a href="#pricing" class="block rounded-2xl px-4 py-3 text-sm font-semibold text-white/80 transition-all duration-200 hover:bg-white/10 hover:text-white">Biaya</a>
            <a href="#media" class="block rounded-2xl px-4 py-3 text-sm font-semibold text-white/80 transition-all duration-200 hover:bg-white/10 hover:text-white">Media</a>
            <a href="#kontak" class="block rounded-2xl px-4 py-3 text-sm font-semibold text-white/80 transition-all duration-200 hover:bg-white/10 hover:text-white">Kontak</a>
        </div>
        <div class="mt-5 space-y-3 border-t border-white/10 pt-5">
            <a href="/login" class="block w-full rounded-2xl border border-white/15 px-4 py-3 text-center text-sm font-semibold text-white/85 transition-all duration-200 hover:border-white/40 hover:bg-white/10">
                Masuk
            </a>
            <a href="#kelas" class="block w-full rounded-2xl bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 px-4 py-3 text-center text-sm font-bold text-white shadow-lg shadow-blue-500/30 transition-transform duration-200 hover:scale-[1.01]">
                Diskusikan Kelas
            </a>
        </div>
    </div>
</header>