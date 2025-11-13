<!-- Hero Section -->
<section class="relative min-h-[90vh] flex items-center justify-center overflow-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="{{ asset('images/hero-bg.jpg') }}" alt="Coding Academy Payakumbuh" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/80 via-blue-500/70 to-purple-900/80"></div>
    </div>
    
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-900 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-blue-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-1/2 w-72 h-72 bg-purple-900 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
    </div>
    
    <!-- Content -->
    <div class="container mx-auto px-6 py-24 md:py-32 relative z-10 text-center">
        <div class="max-w-4xl mx-auto">
            <!-- Badge -->
            <div class="inline-flex items-center px-4 py-2 glass rounded-full mb-6">
                <span class="text-sm font-semibold text-white drop-shadow-lg">Platform E-Learning Terpercaya</span>
            </div>
            
            <!-- Main Heading -->
            <h1 class="text-5xl md:text-7xl font-extrabold leading-tight mb-6">
                <span class="text-white">Coding Academy</span>
                <br class="hidden md:block">
                <span class="bg-gradient-to-r from-blue-200 via-blue-100 to-white bg-clip-text text-transparent animate-gradient">
                    Payakumbuh
                </span>
            </h1>
            
            <!-- Subheading -->
            <p class="mt-6 text-xl md:text-2xl max-w-3xl mx-auto text-gray-100 leading-relaxed">
                Platform pembelajaran digital yang mendukung <span class="font-semibold text-white">Admin</span>, 
                <span class="font-semibold text-white">Guru</span>, dan <span class="font-semibold text-white">Siswa</span> 
                dengan manajemen kelas terintegrasi dan pemantauan progres yang efektif.
            </p>
            
            <!-- Stats -->
            <div class="mt-12 flex flex-wrap justify-center gap-8 md:gap-12">
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-white">3</div>
                    <div class="text-sm md:text-base text-gray-200 mt-1">Kelas Tersedia</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-white">5</div>
                    <div class="text-sm md:text-base text-gray-200 mt-1">Guru Berpengalaman</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-white">20+</div>
                    <div class="text-sm md:text-base text-gray-200 mt-1">Siswa Aktif</div>
                </div>
            </div>
            
            <!-- CTA Buttons -->
            <div class="mt-12 flex flex-col sm:flex-row justify-center items-center gap-4">
                <a href="#kelas" class="group w-full sm:w-auto bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-4 px-8 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl flex items-center justify-center space-x-2">
                    <span>Daftar Kelas Sekarang</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
                <a href="#kelas" class="w-full sm:w-auto glass hover:glass-strong text-white font-semibold py-4 px-8 rounded-xl transition-all duration-300">
                    Pelajari Lebih Lanjut
                </a>
            </div>
            
           
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-10 animate-bounce">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</section>