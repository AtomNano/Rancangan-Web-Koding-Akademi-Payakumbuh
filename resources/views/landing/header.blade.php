<!-- Header / Navigasi -->
<header class="glass-nav sticky top-0 z-50">
    <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
        <a href="{{ url('/') }}" class="flex items-center space-x-3 group">
            <img src="{{ asset('images/logo/logo-transparent.png') }}" alt="Coding Academy Payakumbuh" class="h-12 w-auto object-contain group-hover:scale-105 transition-transform duration-300">
            <div class="flex flex-col">
                <span class="text-xl font-bold text-white leading-tight drop-shadow-lg">Coding Academy</span>
                <span class="text-xs text-white/80 leading-tight">Payakumbuh</span>
            </div>
        </a>
        <div class="hidden md:flex items-center space-x-8">
            <a href="#fitur" class="text-white/90 hover:text-white font-medium transition-colors duration-200 drop-shadow-sm">Fitur</a>
            <a href="#kelas" class="text-white/90 hover:text-white font-medium transition-colors duration-200 drop-shadow-sm">Kelas</a>
            <a href="#alur" class="text-white/90 hover:text-white font-medium transition-colors duration-200 drop-shadow-sm">Alur</a>
            <a href="#pricing" class="text-white/90 hover:text-white font-medium transition-colors duration-200 drop-shadow-sm">Biaya</a>
            <a href="#kontak" class="text-white/90 hover:text-white font-medium transition-colors duration-200 drop-shadow-sm">Kontak</a>
        </div>
        <div class="hidden md:flex items-center space-x-4">
            <a href="/login" class="text-white/90 hover:text-white font-medium transition-colors duration-200">Masuk</a>
            <a href="#kelas" class="glass-strong text-white px-6 py-2.5 rounded-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 font-semibold">
                Daftar Sekarang
            </a>
        </div>
        <button id="mobile-menu-button" class="md:hidden text-white focus:outline-none p-2 hover:bg-white/10 rounded-lg transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
        </button>
    </nav>
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden px-6 pb-4 border-t border-white/20">
        <a href="#fitur" class="block py-3 text-white/90 hover:text-white font-medium transition-colors">Fitur</a>
        <a href="#kelas" class="block py-3 text-white/90 hover:text-white font-medium transition-colors">Kelas</a>
        <a href="#alur" class="block py-3 text-white/90 hover:text-white font-medium transition-colors">Alur</a>
        <a href="#pricing" class="block py-3 text-white/90 hover:text-white font-medium transition-colors">Biaya</a>
        <a href="#kontak" class="block py-3 text-white/90 hover:text-white font-medium transition-colors">Kontak</a>
        <div class="pt-4 space-y-2">
            <a href="/login" class="block w-full text-center glass text-white px-4 py-3 rounded-lg hover:glass-strong transition-all font-medium">
                Masuk
            </a>
            <a href="#kelas" class="block w-full text-center glass-strong text-white px-4 py-3 rounded-lg hover:shadow-2xl transition-all font-semibold">
                Daftar Sekarang
            </a>
        </div>
    </div>
</header>