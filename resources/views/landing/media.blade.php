<!-- Media Akademi -->
<section id="media" class="relative overflow-hidden py-24">
    <div class="pointer-events-none absolute inset-0 opacity-70">
        <div class="absolute inset-x-0 top-0 h-32 bg-gradient-to-b from-white/10 via-transparent to-transparent"></div>
        <div class="absolute -right-16 bottom-10 h-[24rem] w-[24rem] rounded-full bg-blue-500/20 blur-[140px]"></div>
        <div class="absolute -left-20 top-16 h-[22rem] w-[22rem] rounded-full bg-purple-500/20 blur-[140px]"></div>
    </div>

    <div class="container relative z-10 mx-auto px-6">
        <div class="mb-12 max-w-3xl">
            <div class="inline-flex items-center gap-3 rounded-full border border-white/15 bg-white/10 px-5 py-2 text-sm font-semibold text-white/80 shadow-lg shadow-blue-500/20 backdrop-blur-lg">
                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-white/15 text-white">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14m0 0l-6.553 3.276A1 1 0 017 16.382V7.618a1 1 0 011.447-.894L15 10z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 5v14"></path>
                    </svg>
                </span>
                Dokumentasi & Promosi
            </div>
            <h2 class="mt-8 text-3xl font-extrabold leading-tight text-white text-high-contrast md:text-4xl">
                Saksikan atmosfer belajar di Coding Academy Payakumbuh
            </h2>
            <p class="mt-6 text-lg leading-relaxed text-white/80">
                Cuplikan aktivitas kelas, showcase karya, hingga suasana belajar bersama mentor kami rekam secara berkala. 
                Video promosi ini menampilkan ragam kegiatan terbaru para siswa selama berada di akademi.
            </p>
        </div>

        @php
            $videoCandidates = [
                'videos/video-promosi.mp4',
                'videos/Video Promosi.mp4',
                'Coding Academy Payakumbuh/Video Promosi.mp4',
                'Coding Academy Payakumbuh/video-promosi.mp4',
            ];

            $videoUrl = null;
            foreach ($videoCandidates as $candidate) {
                if (file_exists(public_path($candidate))) {
                    $videoUrl = asset($candidate);
                    break;
                }
            }

            $posterCandidates = [
                'images/Photo Square.jpg',
                'Coding Academy Payakumbuh/Photo Square.jpg',
                'images/photo-square.jpg',
            ];

            $posterUrl = null;
            foreach ($posterCandidates as $candidate) {
                if (file_exists(public_path($candidate))) {
                    $posterUrl = asset($candidate);
                    break;
                }
            }
        @endphp

        <div class="grid gap-10 lg:grid-cols-[minmax(0,1.1fr)_minmax(0,0.9fr)]">
            <div class="relative overflow-hidden rounded-3xl border border-white/15 bg-white/5 p-3 shadow-2xl shadow-blue-900/40 backdrop-blur-xl">
                <div class="relative overflow-hidden rounded-2xl border border-white/10 bg-black/40">
                    @if ($videoUrl)
                        <video class="h-full w-full rounded-2xl" controls preload="metadata" @if ($posterUrl) poster="{{ $posterUrl }}" @endif>
                            <source src="{{ $videoUrl }}" type="video/mp4">
                            Browser Anda tidak mendukung pemutaran video. Silakan unduh video promosi kami melalui tautan
                            <a href="{{ $videoUrl }}" class="underline">berikut</a>.
                        </video>
                    @else
                        <div class="flex h-64 flex-col items-center justify-center rounded-2xl border border-dashed border-white/30 bg-white/5 text-center text-white/70 backdrop-blur-xl">
                            <svg class="mb-4 h-10 w-10 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 6v6l3 3m6 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-sm font-semibold uppercase tracking-[0.3em]">Video belum tersedia</p>
                            <p class="mt-2 max-w-xs text-sm text-white/60">
                                Simpan file <span class="font-semibold text-white">Video Promosi.mp4</span> ke folder <code>public/videos</code> atau perbarui path pada berkas view <code>landing/media.blade.php</code>.
                            </p>
                        </div>
                    @endif
                </div>
                <div class="mt-6 flex flex-wrap items-center justify-between gap-4 px-2 pb-2">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-white/60">Video Promosi</p>
                        <p class="text-base font-bold text-white text-high-contrast">Coding Academy Payakumbuh</p>
                    </div>
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.25em] text-white/70">
                        Durasi ± 2 menit
                    </span>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-3xl border border-white/15 bg-white/5 p-7 shadow-2xl shadow-blue-900/30 backdrop-blur-xl">
                    <p class="text-sm font-semibold uppercase tracking-[0.35em] text-white/60">Fokus Dokumentasi</p>
                    <ul class="mt-4 space-y-3 text-sm text-white/80">
                        <li class="flex items-start gap-3">
                            <svg class="mt-1 h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Kegiatan kelas harian: sesi coding, desain grafis, hingga laboratorium robotik.
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="mt-1 h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Highlight showcase dan presentasi proyek akhir setiap angkatan.
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="mt-1 h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Testimoni siswa, orang tua, serta mentor mengenai perkembangan pembelajaran.
                        </li>
                    </ul>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <figure class="relative overflow-hidden rounded-3xl border border-white/15 bg-white/5 p-4 shadow-lg shadow-blue-900/30 backdrop-blur-xl">
                        <img src="{{ asset('images/Photo Halaman Depan.JPG') }}" alt="Suasana depan Coding Academy Payakumbuh" class="h-full w-full rounded-2xl object-cover">
                        <figcaption class="mt-3 text-xs uppercase tracking-[0.3em] text-white/70">Area depan akademi</figcaption>
                    </figure>
                    <figure class="relative overflow-hidden rounded-3xl border border-white/15 bg-white/5 p-4 shadow-lg shadow-blue-900/30 backdrop-blur-xl">
                        <img src="{{ asset('images/Photo Square.jpg') }}" alt="Aktivitas belajar di Coding Academy Payakumbuh" class="h-full w-full rounded-2xl object-cover">
                        <figcaption class="mt-3 text-xs uppercase tracking-[0.3em] text-white/70">Kelas dan mentoring</figcaption>
                    </figure>
                </div>

                <div class="rounded-3xl border border-white/15 bg-white/5 p-6 shadow-lg shadow-blue-900/30 backdrop-blur-xl">
                    <p class="text-sm font-semibold uppercase tracking-[0.35em] text-white/60">Butuh versi lengkap?</p>
                    <p class="mt-3 text-sm leading-relaxed text-white/75">
                        Silakan hubungi tim akademi untuk mendapatkan paket media lengkap termasuk foto kegiatan resolusi tinggi dan booklet profil.
                    </p>
                    <a href="#kontak" class="mt-4 inline-flex items-center gap-3 rounded-2xl border border-white/20 bg-white/10 px-5 py-3 text-xs font-semibold uppercase tracking-[0.25em] text-white/80 transition-all duration-300 hover:bg-white/20 hover:text-white">
                        Hubungi Tim Kami
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

