<!-- Kelas yang Tersedia -->
<section id="kelas" class="relative overflow-hidden py-24 bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950">
    <div class="section-transition-top"></div>
    <div class="pointer-events-none absolute inset-0 opacity-80">
        <div class="absolute inset-x-0 top-0 h-32 bg-gradient-to-b from-white/10 via-white/5 to-transparent"></div>
        <div class="absolute -right-16 top-32 h-[26rem] w-[26rem] rounded-full bg-purple-500/20 blur-[140px]"></div>
        <div class="absolute -left-20 bottom-0 h-[24rem] w-[24rem] rounded-full bg-blue-500/20 blur-[140px]"></div>
    </div>
    <div class="section-transition-bottom"></div>

    <div class="container relative z-10 mx-auto px-6">
        <div class="max-w-4xl scroll-fade-in">
            <div
                class="inline-flex items-center gap-3 rounded-full border border-white/15 bg-white/10 px-5 py-2 text-sm font-semibold text-white/80 shadow-lg shadow-blue-500/20 backdrop-blur-lg">
                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-500/25 text-white">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3"
                            d="M3 7l9-4 9 4-9 4-9-4zm0 10l9 4 9-4m-9-10v18"></path>
                    </svg>
                </span>
                Program Unggulan
            </div>
            <h2 class="mt-8 text-3xl font-extrabold leading-tight text-white text-high-contrast md:text-4xl">
                Jelajahi kurikulum berbasis proyek yang dirancang untuk menumbuhkan skill digital masa kini
            </h2>
            <p class="mt-6 max-w-3xl text-lg leading-relaxed text-white/80">
                Setiap kelas memadukan modul interaktif, sesi mentoring, serta project akhir yang relevan dengan
                kebutuhan industri. Pilih jalur yang paling sesuai dan nikmati pengalaman belajar yang terukur.
            </p>
        </div>

        <div class="mt-16 grid gap-8 lg:grid-cols-3 scroll-fade-in-children">
            <!-- Kelas Coding -->
            <div
                class="group relative flex h-full flex-col overflow-hidden rounded-3xl border border-white/15 bg-white/5 p-8 shadow-2xl shadow-blue-900/30 backdrop-blur-xl transition-transform duration-300 hover:-translate-y-2">
                <div
                    class="absolute inset-x-0 top-0 h-32 bg-gradient-to-b from-blue-500/30 via-indigo-500/20 to-transparent opacity-70">
                </div>
                <div class="relative flex items-center justify-between">
                    <span
                        class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/15 px-4 py-1 text-xs font-semibold uppercase tracking-[0.25em] text-white/80">
                        Coding
                        <span class="flex h-2 w-2 items-center justify-center rounded-full bg-emerald-400"></span>
                    </span>
                    <span class="text-xs font-semibold uppercase tracking-[0.25em] text-white/50">8 minggu</span>
                </div>
                <div class="relative mt-6 flex items-start gap-4">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-500/20 text-white">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M9 19V6l12-4v13M9 19l12-4M9 19l-6-2m6-11L3 6v11l6 2m6-15v5"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-white text-high-contrast">Kelas Coding</h3>
                        <p class="mt-3 text-sm leading-relaxed text-white/75">
                            Pahami algoritma dasar hingga membangun aplikasi pertama dengan Python. Cocok untuk pemula
                            ambisius yang ingin menjejak karier teknologi.
                        </p>
                    </div>
                </div>
                <div class="mt-8 flex items-end justify-between gap-2 sm:gap-4">
                    <dl class="space-y-4 text-sm text-white/80">
                        <div class="flex items-start gap-3">
                            <svg class="mt-1 h-5 w-5 text-blue-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div>
                                <dt class="font-semibold text-white">Fokus Kurikulum</dt>
                                <dd>Programming dasar, versi kontrol Git, dan project mini berbasis API.</dd>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="mt-1 h-5 w-5 text-blue-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div>
                                <dt class="font-semibold text-white">Mentor</dt>
                                <dd>2 mentor profesional + sesi klinik kode mingguan.</dd>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="mt-1 h-5 w-5 text-blue-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div>
                                <dt class="font-semibold text-white">Kapasitas</dt>
                                <dd>8 peserta untuk interaksi personal dan review kode mendalam.</dd>
                            </div>
                        </div>
                    </dl>
                    <div class="shrink-0">
                        <img src="{{ asset('images/robotc.png') }}" alt="Robot Mascot"
                            class="w-24 drop-shadow-xl sm:w-28 md:w-32 lg:w-28 xl:w-36">
                    </div>
                </div>
                <div class="mt-8 flex items-center gap-3 text-xs uppercase tracking-[0.25em] text-white/60">
                    <span class="flex h-2 w-2 items-center justify-center rounded-full bg-emerald-400"></span>
                    Live Coding & Hands-on Project
                </div>
                <div class="mt-9">
                    <a href="#pricing"
                        class="inline-flex w-full items-center justify-center rounded-2xl bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-blue-500/30 transition-transform duration-300 hover:scale-[1.02]">
                        Lihat Paket & Jadwal
                    </a>
                </div>
            </div>

            <!-- Kelas Desain -->
            <div
                class="group relative flex h-full flex-col overflow-hidden rounded-3xl border border-white/15 bg-white/5 p-8 shadow-2xl shadow-purple-900/30 backdrop-blur-xl transition-transform duration-300 hover:-translate-y-2">
                <div
                    class="absolute inset-x-0 top-0 h-32 bg-gradient-to-b from-pink-500/30 via-purple-500/20 to-transparent opacity-70">
                </div>
                <div class="relative flex items-center justify-between">
                    <span
                        class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/15 px-4 py-1 text-xs font-semibold uppercase tracking-[0.25em] text-white/80">
                        Desain
                        <span class="flex h-2 w-2 items-center justify-center rounded-full bg-fuchsia-400"></span>
                    </span>
                    <span class="text-xs font-semibold uppercase tracking-[0.25em] text-white/50">6 minggu</span>
                </div>
                <div class="relative mt-6 flex items-start gap-4">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-purple-500/20 text-white">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M9 2H7a2 2 0 00-2 2v16a2 2 0 002 2h10a2 2 0 002-2v-5m-6-9l6 6m-6-6v6h6"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-white text-high-contrast">Kelas Desain</h3>
                        <p class="mt-3 text-sm leading-relaxed text-white/75">
                            Kuasai desain grafis, tipografi, dan storytelling visual menggunakan tools industri seperti
                            Figma dan Adobe Suite.
                        </p>
                    </div>
                </div>
                <div class="mt-8 flex items-end justify-between gap-2 sm:gap-4">
                    <dl class="space-y-4 text-sm text-white/80">
                        <div class="flex items-start gap-3">
                            <svg class="mt-1 h-5 w-5 text-purple-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div>
                                <dt class="font-semibold text-white">Fokus Kurikulum</dt>
                                <dd>Brand guideline, UI kit, dan final project portofolio interaktif.</dd>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="mt-1 h-5 w-5 text-purple-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div>
                                <dt class="font-semibold text-white">Mentor</dt>
                                <dd>2 visual designer senior dengan sesi portfolio review.</dd>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="mt-1 h-5 w-5 text-purple-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div>
                                <dt class="font-semibold text-white">Kapasitas</dt>
                                <dd>8 peserta, fokus kolaborasi dan peer feedback.</dd>
                            </div>
                        </div>
                    </dl>
                    <div class="shrink-0">
                        <img src="{{ asset('images/robota.png') }}" alt="Robot Mascot"
                            class="w-24 drop-shadow-xl sm:w-28 md:w-32 lg:w-28 xl:w-36">
                    </div>
                </div>
                <div class="mt-8 flex items-center gap-3 text-xs uppercase tracking-[0.25em] text-white/60">
                    <span class="flex h-2 w-2 items-center justify-center rounded-full bg-fuchsia-400"></span>
                    Design Sprint & Showcase Night
                </div>
                <div class="mt-9">
                    <a href="#pricing"
                        class="inline-flex w-full items-center justify-center rounded-2xl border border-white/20 bg-white/10 px-6 py-3 text-sm font-bold text-white backdrop-blur-xl transition-all duration-300 hover:bg-white/20">
                        Ajukan Konsultasi Kelas
                    </a>
                </div>
            </div>

            <!-- Kelas Robotik -->
            <div
                class="group relative flex h-full flex-col overflow-hidden rounded-3xl border border-white/15 bg-white/5 p-8 shadow-2xl shadow-indigo-900/30 backdrop-blur-xl transition-transform duration-300 hover:-translate-y-2">
                <div
                    class="absolute inset-x-0 top-0 h-32 bg-gradient-to-b from-indigo-500/30 via-blue-500/20 to-transparent opacity-70">
                </div>
                <div class="relative flex items-center justify-between">
                    <span
                        class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/15 px-4 py-1 text-xs font-semibold uppercase tracking-[0.25em] text-white/80">
                        Robotik
                        <span class="flex h-2 w-2 items-center justify-center rounded-full bg-cyan-400"></span>
                    </span>
                    <span class="text-xs font-semibold uppercase tracking-[0.25em] text-white/50">10 minggu</span>
                </div>
                <div class="relative mt-6 flex items-start gap-4">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-500/20 text-white">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M9 2v2m6-2v2M9 20v2m6-2v2M4 7h16M4 17h16M7 7v10m10-10v10M9 11h6v4H9z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-white text-high-contrast">Kelas Robotik</h3>
                        <p class="mt-3 text-sm leading-relaxed text-white/75">
                            Merakit MRT 1, memahami sensor dasar, hingga memprogram pergerakan robot dengan teknik block
                            coding dan Python.
                        </p>
                    </div>
                </div>
                <div class="mt-8 flex items-end justify-between gap-2 sm:gap-4">
                    <dl class="space-y-4 text-sm text-white/80">
                        <div class="flex items-start gap-3">
                            <svg class="mt-1 h-5 w-5 text-indigo-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div>
                                <dt class="font-semibold text-white">Fokus Kurikulum</dt>
                                <dd>Pengenalan hardware, sensor, dan logika kontrol robotik.</dd>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="mt-1 h-5 w-5 text-indigo-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div>
                                <dt class="font-semibold text-white">Mentor</dt>
                                <dd>1 mentor spesialis robotik dengan asistensi teknisi lapangan.</dd>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="mt-1 h-5 w-5 text-indigo-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div>
                                <dt class="font-semibold text-white">Kapasitas</dt>
                                <dd>4 peserta eksklusif untuk eksperimen mendalam.</dd>
                            </div>
                        </div>
                    </dl>
                    <div class="shrink-0">
                        <img src="{{ asset('images/robotb.png') }}" alt="Robot Mascot"
                            class="w-24 drop-shadow-xl sm:w-28 md:w-32 lg:w-28 xl:w-36">
                    </div>
                </div>
                <div class="mt-8 flex items-center gap-3 text-xs uppercase tracking-[0.25em] text-white/60">
                    <span class="flex h-2 w-2 items-center justify-center rounded-full bg-cyan-400"></span>
                    Showcase Robotik & Demo Day
                </div>
                <div class="mt-9">
                    <a href="#pricing"
                        class="inline-flex w-full items-center justify-center rounded-2xl border border-white/20 bg-white/10 px-6 py-3 text-sm font-bold text-white backdrop-blur-xl transition-all duration-300 hover:bg-white/20">
                        Lihat Detail Modul
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>