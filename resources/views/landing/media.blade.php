<!-- Media Akademi -->
<section id="media" class="relative overflow-hidden py-24">
    <div class="pointer-events-none absolute inset-0 opacity-70">
        <div class="absolute inset-x-0 top-0 h-32 bg-gradient-to-b from-white/10 via-transparent to-transparent"></div>
        <div class="absolute -right-16 bottom-10 h-[24rem] w-[24rem] rounded-full bg-blue-500/20 blur-[140px]"></div>
        <div class="absolute -left-20 top-16 h-[22rem] w-[22rem] rounded-full bg-purple-500/20 blur-[140px]"></div>
    </div>

    <div class="container relative z-10 mx-auto px-6">
        <!-- Header Section -->
        <div class="mx-auto mb-16 max-w-4xl text-center">
            <div class="inline-flex items-center gap-3 rounded-full border border-white/15 bg-white/10 px-5 py-2 text-sm font-semibold text-white/80 shadow-lg shadow-blue-500/20 backdrop-blur-lg">
                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-white/15 text-white">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14m0 0l-6.553 3.276A1 1 0 017 16.382V7.618a1 1 0 011.447-.894L15 10z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 5v14"></path>
                    </svg>
                </span>
                Dokumentasi & Promosi
            </div>
            <h2 class="mt-8 text-center text-4xl font-extrabold leading-tight text-white text-high-contrast md:text-5xl lg:text-6xl">
                Saksikan atmosfer belajar di Coding Academy Payakumbuh
            </h2>
            <p class="mt-6 text-center text-lg leading-relaxed text-white/80 md:text-xl">
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

            $externalVideoUrl = 'https://www.youtube.com/embed/TOPBdqvdAwM';

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

            $classPhotos = [
                [
                    'src' => 'images/class-photos/classfoto.jpg',
                    'caption' => 'Kegiatan Kolaboratif',
                    'description' => 'Sesi pembelajaran interaktif dengan pendekatan kolaboratif',
                ],
                [
                    'src' => 'images/class-photos/classfoto2.jpg',
                    'caption' => 'Pendampingan Mentor',
                    'description' => 'Mentor memberikan bimbingan langsung kepada siswa',
                ],
                [
                    'src' => 'images/class-photos/classfoto3.jpg',
                    'caption' => 'Suasana Kelas Coding',
                    'description' => 'Atmosfer belajar coding yang kondusif dan menyenangkan',
                ],
            ];

            $classPhotos = array_values(array_filter($classPhotos, function ($photo) {
                return file_exists(public_path($photo['src']));
            }));
        @endphp

        <!-- Video Promosi Section -->
        <div class="mb-16">
            <div class="mx-auto max-w-5xl">
                <div class="relative overflow-hidden rounded-3xl border border-white/20 bg-gradient-to-br from-white/10 to-white/5 p-4 shadow-2xl shadow-blue-900/50 backdrop-blur-xl">
                    <div class="relative overflow-hidden rounded-2xl border border-white/10 bg-black/60">
                        @if ($externalVideoUrl)
                            <div class="relative overflow-hidden rounded-2xl pb-[56.25%]">
                                <iframe
                                    src="{{ $externalVideoUrl }}?rel=0&modestbranding=1&playsinline=1"
                                    title="Video Promosi Coding Academy Payakumbuh"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen
                                    class="absolute left-0 top-0 h-full w-full rounded-2xl border-0">
                                </iframe>
                            </div>
                        @elseif ($videoUrl)
                            <video class="h-full w-full rounded-2xl" controls preload="metadata" @if ($posterUrl) poster="{{ $posterUrl }}" @endif>
                                <source src="{{ $videoUrl }}" type="video/mp4">
                                Browser Anda tidak mendukung pemutaran video. Silakan unduh video promosi kami melalui tautan
                                <a href="{{ $videoUrl }}" class="underline">berikut</a>.
                            </video>
                        @else
                            <div class="flex h-96 flex-col items-center justify-center rounded-2xl border border-dashed border-white/30 bg-white/5 text-center text-white/70 backdrop-blur-xl">
                                <svg class="mb-4 h-12 w-12 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 6v6l3 3m6 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-sm font-semibold uppercase tracking-[0.3em]">Video belum tersedia</p>
                                <p class="mt-2 max-w-xs text-sm text-white/60">
                                    Simpan file <span class="font-semibold text-white">Video Promosi.mp4</span> ke folder <code>public/videos</code> atau perbarui path pada berkas view <code>landing/media.blade.php</code>.
                                </p>
                            </div>
                        @endif
                    </div>
                    <div class="mt-6 flex flex-wrap items-center justify-between gap-4 px-2">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-white/60">Video Promosi</p>
                            <p class="mt-1 text-lg font-bold text-white text-high-contrast">Coding Academy Payakumbuh</p>
                        </div>
                        <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-5 py-2.5 text-xs font-semibold uppercase tracking-[0.25em] text-white/80 backdrop-blur-sm">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Durasi ± 2 menit
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fokus Dokumentasi Section -->
        <div class="mb-16">
            <div class="mx-auto max-w-5xl rounded-3xl border border-white/20 bg-gradient-to-br from-white/10 to-white/5 p-8 shadow-2xl shadow-blue-900/30 backdrop-blur-xl md:p-10">
                <div class="mb-6 flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-500/20 text-blue-300">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white md:text-2xl">Fokus Dokumentasi</h3>
                </div>
                <div class="grid gap-6 md:grid-cols-3">
                    <div class="group rounded-2xl border border-white/10 bg-white/5 p-6 transition-all duration-300 hover:border-white/20 hover:bg-white/10">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-blue-500/20 text-blue-300 transition-transform duration-300 group-hover:scale-110">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                        <h4 class="mb-2 text-sm font-semibold uppercase tracking-[0.15em] text-white/90">Kegiatan Harian</h4>
                        <p class="text-sm leading-relaxed text-white/75">
                            Sesi coding, desain grafis, hingga laboratorium robotik yang dilakukan secara rutin.
                        </p>
                    </div>
                    <div class="group rounded-2xl border border-white/10 bg-white/5 p-6 transition-all duration-300 hover:border-white/20 hover:bg-white/10">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-purple-500/20 text-purple-300 transition-transform duration-300 group-hover:scale-110">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                        </div>
                        <h4 class="mb-2 text-sm font-semibold uppercase tracking-[0.15em] text-white/90">Showcase Proyek</h4>
                        <p class="text-sm leading-relaxed text-white/75">
                            Highlight showcase dan presentasi proyek akhir setiap angkatan siswa.
                        </p>
                    </div>
                    <div class="group rounded-2xl border border-white/10 bg-white/5 p-6 transition-all duration-300 hover:border-white/20 hover:bg-white/10">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-green-500/20 text-green-300 transition-transform duration-300 group-hover:scale-110">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h4 class="mb-2 text-sm font-semibold uppercase tracking-[0.15em] text-white/90">Testimoni</h4>
                        <p class="text-sm leading-relaxed text-white/75">
                            Testimoni siswa, orang tua, serta mentor mengenai perkembangan pembelajaran.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Class Photos Gallery Section -->
        @if (count($classPhotos) > 0)
            <div class="mb-16">
                <div class="mb-8 text-center">
                    <h3 class="text-3xl font-bold text-white md:text-4xl">Galeri Dokumentasi</h3>
                    <p class="mt-3 text-white/70">Momen-momen berharga dari aktivitas pembelajaran di Coding Academy</p>
                </div>
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($classPhotos as $index => $photo)
                        <figure class="group relative overflow-hidden rounded-3xl border border-white/20 bg-gradient-to-br from-white/10 to-white/5 shadow-xl shadow-blue-900/30 backdrop-blur-xl transition-all duration-500 hover:scale-[1.02] hover:shadow-2xl hover:shadow-blue-900/50">
                            <div class="relative overflow-hidden pb-[75%]">
                                <img 
                                    src="{{ asset($photo['src']) }}" 
                                    alt="{{ $photo['caption'] }}" 
                                    class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                                    loading="lazy">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
                                <div class="absolute inset-x-0 bottom-0 translate-y-full p-6 text-white transition-transform duration-300 group-hover:translate-y-0">
                                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-white/90">{{ $photo['caption'] }}</p>
                                    <p class="mt-2 text-sm text-white/80">{{ $photo['description'] }}</p>
                                </div>
                            </div>
                            <figcaption class="p-6">
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-white/90">{{ $photo['caption'] }}</p>
                                <p class="mt-1 text-xs text-white/60">{{ $photo['description'] }}</p>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- CTA Section -->
        <div class="mx-auto max-w-4xl">
            <div class="relative overflow-hidden rounded-3xl border border-white/20 bg-gradient-to-br from-blue-600/20 via-purple-600/20 to-blue-600/20 p-8 shadow-2xl shadow-blue-900/40 backdrop-blur-xl md:p-12">
                <div class="absolute -right-20 -top-20 h-40 w-40 rounded-full bg-white/10 blur-3xl"></div>
                <div class="absolute -bottom-20 -left-20 h-40 w-40 rounded-full bg-white/10 blur-3xl"></div>
                <div class="relative z-10 text-center">
                    <div class="mb-6 inline-flex items-center justify-center rounded-full bg-white/10 p-3">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="mb-4 text-2xl font-bold text-white md:text-3xl">Butuh Versi Lengkap?</h3>
                    <p class="mx-auto mb-8 max-w-2xl text-base leading-relaxed text-white/90 md:text-lg">
                        Silakan hubungi tim akademi untuk mendapatkan paket media lengkap termasuk foto kegiatan resolusi tinggi dan booklet profil.
                    </p>
                    <a 
                        href="#kontak" 
                        class="group inline-flex items-center gap-3 rounded-2xl border border-white/30 bg-white/20 px-8 py-4 text-sm font-semibold uppercase tracking-[0.25em] text-white backdrop-blur-sm transition-all duration-300 hover:bg-white/30 hover:shadow-xl hover:shadow-white/20">
                        Hubungi Tim Kami
                        <svg class="h-5 w-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
