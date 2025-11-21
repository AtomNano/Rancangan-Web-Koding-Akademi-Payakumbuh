<!-- Pricing Section -->
<section id="pricing" class="relative overflow-hidden py-24 bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950">
    <div class="section-transition-top"></div>
    <div class="pointer-events-none absolute inset-0 opacity-80">
        <div class="absolute inset-x-0 top-0 h-32 bg-gradient-to-b from-white/10 via-transparent to-transparent"></div>
        <div class="absolute -right-16 top-20 h-[24rem] w-[24rem] rounded-full bg-indigo-500/20 blur-[140px]"></div>
        <div class="absolute -left-20 bottom-0 h-[26rem] w-[26rem] rounded-full bg-purple-500/20 blur-[140px]"></div>
    </div>
    <div class="section-transition-bottom"></div>

    <div class="container relative z-10 mx-auto px-6">
        <div class="max-w-4xl scroll-fade-in">
            <div class="inline-flex items-center gap-3 rounded-full border border-white/15 bg-white/10 px-5 py-2 text-sm font-semibold text-white/80 shadow-lg shadow-blue-500/20 backdrop-blur-lg">
                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-white/15 text-white">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 8c1.657 0 3-1.343 3-3S13.657 2 12 2 9 3.343 9 5s1.343 3 3 3zm0 0v13m0 0c-1.657 0-3 1.343-3 3m3-3c1.657 0 3 1.343 3 3"></path>
                    </svg>
                </span>
                Investasi Pendidikan
            </div>
            <h2 class="mt-8 text-3xl font-extrabold leading-tight text-white text-high-contrast md:text-4xl">
                Libatkan siswa sesuai kebutuhan belajar: online fleksibel, tatap muka intensif, hingga kelas privat eksklusif
            </h2>
            <p class="mt-6 text-lg leading-relaxed text-white/80">
                Semua paket sudah termasuk akses dashboard, materi terkurasi, dan dukungan mentor. Klik pada kartu untuk membuka rincian biaya lengkap.
            </p>
        </div>
        
        <div class="mt-16 grid gap-10 lg:grid-cols-3 scroll-fade-in-children">
            <!-- Reguler Online Class -->
            <div class="group relative flex h-full flex-col overflow-hidden rounded-3xl border border-white/15 bg-white/5 p-8 shadow-2xl shadow-blue-900/30 backdrop-blur-xl transition-transform duration-300 hover:-translate-y-2">
                <div class="flex items-center justify-between text-xs font-semibold uppercase tracking-[0.25em] text-white/60">
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-1 text-white/80">
                        Reguler Online
                    </span>
                    <span class="text-white/50">Sesi Virtual</span>
                        </div>
                <div class="relative mt-8 overflow-hidden rounded-2xl border border-white/10 bg-white/10">
                    <img src="{{ asset('images/pricing/biaya-online.jpeg') }}" alt="Biaya Kursus Reguler Online" class="h-full w-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-900/10 to-transparent"></div>
                    <span class="absolute bottom-4 left-4 rounded-full border border-white/20 bg-white/10 px-3 py-1 text-[0.7rem] font-semibold uppercase tracking-[0.3em] text-white/70">
                        Fleksibel
                    </span>
                    </div>
                <ul class="mt-8 space-y-4 text-sm text-white/80">
                    <li class="flex items-start gap-3">
                        <svg class="mt-1 h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                        Kelas live interaktif + akses rekaman seumur hidup.
                        </li>
                    <li class="flex items-start gap-3">
                        <svg class="mt-1 h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                        Materi digital lengkap, bank latihan, dan forum diskusi.
                        </li>
                    <li class="flex items-start gap-3">
                        <svg class="mt-1 h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                        Sertifikat penyelesaian resmi + laporan progres per modul.
                        </li>
                    </ul>
                <div class="mt-8">
                    <a href="{{ asset('images/pricing/biaya-online.jpeg') }}" target="_blank" class="inline-flex w-full items-center justify-center rounded-2xl bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-blue-500/30 transition-transform duration-300 hover:scale-[1.02]">
                        Lihat Rincian Biaya
                    </a>
                </div>
            </div>
            
            <!-- Reguler Offline Class -->
            <div class="group relative flex h-full flex-col overflow-hidden rounded-3xl border border-white/15 bg-white/10 p-8 shadow-[0_40px_120px_-50px_rgba(79,70,229,0.7)] backdrop-blur-xl transition-transform duration-300 hover:-translate-y-2">
                <span class="absolute top-6 right-6 rounded-full border border-white/25 bg-white/15 px-4 py-1 text-[0.65rem] font-semibold uppercase tracking-[0.3em] text-white/85">
                    Populer
                </span>
                <div class="flex items-center justify-between text-xs font-semibold uppercase tracking-[0.25em] text-white/60">
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-1 text-white/80">
                        Reguler Offline
                    </span>
                    <span class="text-white/50">Tatap Muka</span>
                </div>
                <div class="relative mt-8 overflow-hidden rounded-2xl border border-white/10 bg-white/10">
                    <img src="{{ asset('images/pricing/biaya-offline-reguler.jpeg') }}" alt="Biaya Kursus Reguler Offline" class="h-full w-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-900/15 to-transparent"></div>
                    <span class="absolute bottom-4 left-4 rounded-full border border-white/20 bg-white/10 px-3 py-1 text-[0.7rem] font-semibold uppercase tracking-[0.3em] text-white/80">
                        Premium
                    </span>
                        </div>
                <ul class="mt-8 space-y-4 text-sm text-white/80">
                    <li class="flex items-start gap-3">
                        <svg class="mt-1 h-5 w-5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                        Kelas intensif di lab modern dengan perangkat lengkap.
                        </li>
                    <li class="flex items-start gap-3">
                        <svg class="mt-1 h-5 w-5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                        Interaksi langsung dengan mentor, coaching mingguan, dan evaluasi onsite.
                        </li>
                    <li class="flex items-start gap-3">
                        <svg class="mt-1 h-5 w-5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                        Sertifikat fisik dan laporan performa bulanan untuk orang tua.
                        </li>
                    </ul>
                <div class="mt-8">
                    <a href="{{ asset('images/pricing/biaya-offline-reguler.jpeg') }}" target="_blank" class="inline-flex w-full items-center justify-center rounded-2xl border border-white/20 bg-white/15 px-6 py-3 text-sm font-bold text-white backdrop-blur-xl transition-all duration-300 hover:bg-white/25">
                        Buka Detail Reguler Offline
                    </a>
                </div>
            </div>
            
            <!-- Privat Offline Class -->
            <div class="group relative flex h-full flex-col overflow-hidden rounded-3xl border border-white/15 bg-white/5 p-8 shadow-2xl shadow-blue-900/30 backdrop-blur-xl transition-transform duration-300 hover:-translate-y-2">
                <div class="flex items-center justify-between text-xs font-semibold uppercase tracking-[0.25em] text-white/60">
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-1 text-white/80">
                        Privat Offline
                    </span>
                    <span class="text-white/50">Eksklusif</span>
                        </div>
                <div class="relative mt-8 overflow-hidden rounded-2xl border border-white/10 bg-white/10">
                    <img src="{{ asset('images/pricing/biaya-offline-privat.jpeg') }}" alt="Biaya Kursus Privat Offline" class="h-full w-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-900/15 to-transparent"></div>
                    <span class="absolute bottom-4 left-4 rounded-full border border-white/20 bg-white/10 px-3 py-1 text-[0.7rem] font-semibold uppercase tracking-[0.3em] text-white/70">
                        Personal
                    </span>
                    </div>
                <ul class="mt-8 space-y-4 text-sm text-white/80">
                    <li class="flex items-start gap-3">
                        <svg class="mt-1 h-5 w-5 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                        Sesi 1-on-1 dengan kurikulum disesuaikan tujuan peserta.
                        </li>
                    <li class="flex items-start gap-3">
                        <svg class="mt-1 h-5 w-5 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                        Jadwal fleksibel, bisa onsite di akademi atau lokasi pilihan.
                        </li>
                    <li class="flex items-start gap-3">
                        <svg class="mt-1 h-5 w-5 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                        Laporan personal mingguan dan konsultasi karier.
                        </li>
                    </ul>
                <div class="mt-8">
                    <a href="{{ asset('images/pricing/biaya-offline-privat.jpeg') }}" target="_blank" class="inline-flex w-full items-center justify-center rounded-2xl border border-white/20 bg-white/10 px-6 py-3 text-sm font-bold text-white backdrop-blur-xl transition-all duration-300 hover:bg-white/20">
                        Minta Proposal Privat
                    </a>
                </div>
            </div>
        </div>
        
        <div class="mt-16 flex flex-col items-start gap-6 rounded-3xl border border-white/15 bg-white/5 p-8 shadow-2xl shadow-blue-900/30 backdrop-blur-xl md:flex-row md:items-center md:justify-between scroll-fade-in scroll-fade-in-delay-2">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-white/60">Butuh bantuan memilih paket?</p>
                <h3 class="mt-2 text-2xl font-bold text-white text-high-contrast">Tim akademik siap merekomendasikan opsi terbaik sesuai target Anda.</h3>
            </div>
            <a href="#kontak" class="inline-flex items-center gap-3 rounded-2xl bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-600 px-8 py-4 text-sm font-bold text-white shadow-lg shadow-blue-500/30 transition-transform duration-300 hover:scale-[1.02]">
                Konsultasi Gratis
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>
    </div>
</section>
