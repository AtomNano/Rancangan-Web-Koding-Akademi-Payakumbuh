# BAB 1 - PENDAHULUAN

## 1.1 Latar Belakang

Coding Academy Payakumbuh merupakan lembaga pendidikan non-formal yang fokus pada pengembangan keterampilan teknologi bagi anak-anak dan remaja. Lembaga ini menyediakan tiga program utama yaitu Coding, Robotik, dan Desain & Ilustrasi yang dikelola oleh 5 orang pengajar profesional dan 2 orang admin. Saat ini, Coding Academy Payakumbuh melayani 79 siswa aktif yang terdistribusi dalam tiga kelas: 31 siswa di kelas Coding, 27 siswa di kelas Robotik, dan 21 siswa di kelas Desain.

> **Gambar 1.1: Data Siswa dan Kelas Coding Academy**
> ![Data Siswa Coding Academy](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\data_screenshot_siswa.jpeg)

Dalam operasionalnya, Coding Academy Payakumbuh masih mengelola seluruh proses pembelajaran dan administrasi secara manual. Berdasarkan **System Request** bertanggal 3 September 2025 yang disetujui oleh Direktur Coding Academy Payakumbuh (*Project Sponsor*), teridentifikasi kebutuhan mendesak akan sebuah platform digital. Saat ini, proses distribusi materi, pemantauan kemajuan siswa, dan manajemen kelas masih dilakukan secara konvensional yang tidak terstruktur.

Data operasional masih tersebar dalam berbagai file spreadsheet terpisah dan pencatatan manual di buku, yang menyulitkan integrasi data seperti yang terlihat pada dokumentasi berikut:

> **Gambar 1.2: Contoh Pencatatan Data Manual**
> ![Contoh Data Manual](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\data_screenshot_1.jpeg)

Guru-guru membagikan materi pembelajaran melalui aplikasi pesan instan seperti WhatsApp atau melalui email, yang menyebabkan distribusi materi menjadi tidak terstruktur, tertumpuk chat lain, dan sulit untuk dipantau. Kondisi ini menyulitkan Guru dalam memantau progres belajar siswa, serta menyulitkan Admin dalam merekap kehadiran 79 siswa dan status pembayarannya secara akurat.

Oleh karena itu, diusulkan pengembangan **Sistem Informasi Manajemen Pembelajaran Materi Online** (disingkat **"Materi Online"**). Platform ini bertujuan agar proses pembelajaran dapat terstruktur, terpusat, dan mudah diakses oleh semua pihak (Admin, Guru, Siswa).

Permasalahan lain yang ditemukan adalah dalam pengelolaan status pembayaran siswa. Sistem manual tidak memiliki mekanisme otomatis untuk tracking status pembayaran dan mengatur akses siswa berdasarkan status pembayaran mereka. Hal ini menyebabkan admin harus melakukan pengecekan manual secara berkala, yang memakan waktu dan berpotensi terjadi kesalahan administratif.

Dari sisi verifikasi materi pembelajaran, saat ini belum ada sistem yang mengatur alur persetujuan materi sebelum dibagikan kepada siswa. Setiap materi yang diunggah guru langsung dapat diakses siswa tanpa melalui proses verifikasi terlebih dahulu. Kondisi ini berisiko terhadap kualitas dan kesesuaian materi yang diterima siswa.

Dampak dari permasalahan-permasalahan tersebut adalah rendahnya efisiensi operasional, lambatnya proses administrasi, tingginya potensi kesalahan data, kesulitan dalam monitoring dan evaluasi pembelajaran, serta tidak tersedianya laporan yang terstruktur untuk pengambilan keputusan. Kondisi ini menghambat pengembangan kualitas layanan pendidikan yang diberikan Coding Academy Payakumbuh kepada para siswanya.

Untuk mengatasi permasalahan tersebut, diperlukan sebuah sistem informasi berbasis web yang dapat mengotomasi dan mengintegrasikan seluruh proses pembelajaran dan administrasi. Sistem informasi yang dikembangkan diharapkan dapat mengelola data pengguna, mengatur distribusi dan verifikasi materi pembelajaran, melakukan tracking progres belajar siswa, mengelola kehadiran secara otomatis, serta menyediakan laporan-laporan yang dibutuhkan untuk evaluasi dan pengambilan keputusan.

Pemilihan platform berbasis web dipilih karena kemudahan akses melalui browser tanpa perlu instalasi aplikasi tambahan, dapat diakses dari berbagai perangkat, serta memudahkan maintenance dan update sistem secara terpusat. Dengan adanya sistem informasi ini, diharapkan Coding Academy Payakumbuh dapat meningkatkan efisiensi operasional, meningkatkan kualitas pembelajaran, serta memberikan layanan yang lebih baik kepada siswa dan orang tua.

## 1.2 Rumusan Masalah

Berdasarkan latar belakang yang telah diuraikan, maka rumusan masalah dalam pengembangan Sistem Informasi Manajemen Pembelajaran Materi Online Coding Academy Payakumbuh adalah sebagai berikut:

1. Bagaimana merancang sistem yang dapat mengelola data pengguna (guru, siswa, dan admin) secara terstruktur dan efisien untuk mendukung operasional Coding Academy dengan 79 siswa dan 7 staff?

2. Bagaimana mengimplementasikan sistem verifikasi materi pembelajaran yang memungkinkan admin untuk memeriksa dan menyetujui materi sebelum dapat diakses oleh siswa?

3. Bagaimana membangun sistem tracking progres belajar siswa secara real-time yang dapat digunakan oleh guru untuk monitoring dan oleh siswa untuk melihat kemajuan belajar mereka?

4. Bagaimana mengimplementasikan sistem absensi otomatis dan manajemen status pembayaran yang terintegrasi untuk mengatur akses siswa terhadap materi pembelajaran?

5. Bagaimana menyediakan sistem pelaporan dan backup data yang lengkap untuk mendukung evaluasi pembelajaran dan keamanan data?

## 1.3 Tujuan Pengembangan

Berdasarkan rumusan masalah di atas, tujuan dari pengembangan Sistem Informasi Manajemen Pembelajaran Materi Online Coding Academy Payakumbuh adalah:

1. Mengembangkan sistem informasi berbasis web yang dapat mengelola data guru, siswa, dan admin secara terstruktur dengan fitur Create, Read, Update, dan Delete (CRUD) yang lengkap.

2. Membangun fitur verifikasi materi pembelajaran yang terintegrasi dengan sistem notifikasi, memungkinkan admin untuk menyetujui atau menolak materi yang diunggah guru sebelum dapat diakses oleh siswa.

3. Mengimplementasikan sistem tracking progres belajar yang menampilkan progress bar visual untuk siswa dan dashboard monitoring yang komprehensif untuk guru, termasuk fitur auto-save reading progress untuk materi berbentuk PDF.

4. Merancang dan mengimplementasikan sistem absensi otomatis yang mencatat kehadiran siswa saat mengakses kelas/materi, serta sistem manajemen status pembayaran yang secara otomatis mengatur status aktif/non-aktif siswa berdasarkan pembayaran mereka.

5. Menyediakan fitur pelaporan lengkap dengan kemampuan export data ke format Excel dan sistem backup data manual untuk memastikan keamanan dan ketersediaan data pembelajaran.

6. Menerapkan metodologi Agile Scrum dalam proses pengembangan sistem untuk memastikan keterlibatan stakeholder dan kualitas produk yang sesuai dengan kebutuhan pengguna.

Selain itu, pengembangan sistem ini diharapkan memberikan manfaat (*Business Value*) sebagai berikut:

**Intangible Value (Nilai Non-Fisik):**
*   Meningkatkan kualitas pembelajaran dan citra profesional Coding Academy Payakumbuh.
*   Memberikan pengalaman belajar yang lebih interaktif dan terstruktur.

**Tangible Value (Nilai Terukur):**
*   Meningkatkan efisiensi distribusi materi hingga 100% (paperless).
*   Mempercepat proses pelaporan monitoring siswa hingga 50%.

## 1.4 Batasan Masalah

Agar pengembangan sistem tetap fokus dan dapat diselesaikan sesuai dengan waktu dan sumber daya yang tersedia, maka ditetapkan batasan masalah sebagai berikut:

### 1.4.1 Batasan Fungsional

1. **Kelas yang Dikelola**: Sistem hanya mengelola tiga kelas yaitu Coding, Desain, dan Robotik sesuai dengan program yang ditawarkan Coding Academy Payakumbuh saat ini.

2. **Format Materi**: Materi pembelajaran yang dapat diunggah terbatas pada format PDF, video (MP4), dan link eksternal (YouTube atau Google Drive). Format materi lainnya tidak didukung dalam versi ini.

3. **Sistem Pembayaran**: Sistem hanya mengelola status pembayaran dan verifikasi bukti pembayaran yang diunggah siswa. Integrasi dengan payment gateway untuk pembayaran online otomatis tidak termasuk dalam scope pengembangan ini.

4. **Absensi**: Sistem absensi bersifat otomatis berbasis akses, yaitu mencatat kehadiran saat siswa mengakses kelas atau materi. Tidak termasuk fitur absensi manual real-time dengan verifikasi biometrik atau lokasi.

5. **Notifikasi**: Notifikasi ditampilkan di dalam dashboard sistem. Notifikasi melalui email atau SMS tidak termasuk dalam scope pengembangan ini.

### 1.4.2 Batasan Teknis

1. **Platform**: Sistem dikembangkan sebagai aplikasi web-based yang diakses melalui browser. Pengembangan aplikasi mobile native (Android/iOS) tidak termasuk dalam scope project ini.

2. **Browser Support**: Sistem dirancang untuk kompatibel dengan browser modern (Google Chrome, Mozilla Firefox, Microsoft Edge, Safari) dengan versi terbaru.

3. **Perangkat**: Sistem dioptimalkan untuk diakses melalui komputer atau laptop. Responsive design untuk smartphone tersedia namun tidak dioptimalkan penuh untuk pengalaman mobile.

4. **Concurrent Users**: Sistem dirancang untuk dapat menangani minimal 20 pengguna concurrent sesuai dengan jumlah siswa yang biasa mengakses sistem secara bersamaan.

5. **Backup**: Fitur backup bersifat manual yang dapat dijalankan oleh admin. Automated scheduled backup tidak termasuk dalam scope pengembangan ini.

### 1.4.3 Batasan Pengguna

1. **Peran Pengguna**: Sistem memiliki tiga peran pengguna yaitu Admin, Guru, dan Siswa. Peran tambahan seperti Orang Tua atau Supervisor tidak termasuk dalam pengembangan ini.

2. **Registrasi**: Pendaftaran pengguna dilakukan oleh admin. Fitur self-registration untuk siswa atau guru tidak disediakan dalam versi ini.

### 1.4.4 Batasan Lingkup Pengujian

1. **Testing**: Pengujian dilakukan menggunakan metode black box testing untuk memastikan fungsionalitas sistem sesuai dengan kebutuhan. Testing kinerja lanjutan seperti stress testing, load testing, dan security penetration testing tidak termasuk dalam scope pengembangan ini.

2. **Deployment**: Sistem di-deploy pada hosting shared (Niagahoster) dengan spesifikasi 30GB paket business. Optimasi untuk cloud infrastructure atau dedicated server tidak termasuk dalam scope ini.

## 1.5 Metodologi Pengembangan

Pengembangan Sistem Informasi Manajemen Pembelajaran Materi Online Coding Academy Payakumbuh menggunakan **metodologi Agile Scrum**. Pemilihan metodologi ini didasarkan pada kebutuhan untuk pengembangan yang iteratif, fleksibel terhadap perubahan, dan melibatkan stakeholder secara aktif dalam proses pengembangan.

### 1.5.1 Prinsip Agile Scrum

Agile Scrum adalah framework pengembangan perangkat lunak yang menekankan pada:

1. **Iterative Development**: Pengembangan dilakukan dalam siklus-siklus pendek (sprint) yang menghasilkan increment produk yang dapat digunakan.

2. **Incremental Delivery**: Setiap sprint menghasilkan fitur yang lengkap dan siap digunakan, bukan hanya komponen teknis parsial.

3. **Continuous Feedback**: Melibatkan stakeholder dalam setiap sprint review untuk mendapatkan feedback dan penyesuaian.

4. **Self-organizing Team**: Tim pengembangan memiliki otonomi dalam menentukan cara terbaik untuk menyelesaikan pekerjaan mereka.

5. **Transparency**: Semua proses dan progress pengembangan visible bagi seluruh tim dan stakeholder.

### 1.5.2 Komponen Scrum

#### A. Roles (Peran)

Dalam pengembangan sistem ini, peran Scrum didistribusikan sebagai berikut:

| Peran | Anggota Tim | Tanggung Jawab Utama |
|-------|-------------|----------------------|
| **Product Owner** | **Andrean Willian Syach** | Menentukan prioritas fitur, menerima/menolak hasil sprint |
| **Scrum Master** | **Muhammad Luthfi Naldi** | Memfasilitasi proses Scrum, menghilangkan hambatan |
| **Development Team** | Seluruh Anggota Tim | Mendesain, mengembangkan, dan menguji sistem |

**Pembagian Fokus Development Team:**
- **Muhammad Luthfi Naldi:** Fokus pada pengembangan fitur **Admin**
- **Andrean Willian Syach:** Fokus pada pengembangan fitur **Guru**
- **Faris Muhammad Taufik:** Fokus pada pengembangan fitur **Siswa** dan Integrasi UI/UX
- **Thilal Said Zaidan:** Fokus pada **Testing**, Desain Database, dan membantu fitur Admin

#### B. Artifacts (Artifak)

1. **Product Backlog**
   - Daftar lengkap dari semua fitur yang diinginkan untuk sistem
   - Berisi 49 user stories yang diprioritaskan berdasarkan nilai bisnis
   - Dikelola oleh Product Owner dengan input dari stakeholder

2. **Sprint Backlog**
   - Subset dari Product Backlog yang akan dikerjakan dalam satu sprint
   - Dipilih oleh tim berdasarkan prioritas dan kapasitas
   - Dapat berubah selama sprint dengan persetujuan tim

3. **Increment**
   - Hasil kerja yang telah selesai dan memenuhi Definition of Done
   - Merupakan fitur yang dapat digunakan dan telah melalui testing
   - Dikumpulkan dari semua sprint sebelumnya

#### C. Events (Acara/Meeting)

1. **Sprint Planning**
   - Durasi: 2-4 jam di awal setiap sprint
   - Tim memilih user stories dari Product Backlog
   - Menentukan sprint goal dan membuat sprint backlog
   - Output: Sprint Backlog dan Sprint Goal yang jelas

2. **Daily Scrum**
   - Durasi maksimal: 15 menit setiap hari kerja
   - Format: Apa yang dikerjakan kemarin? Apa yang akan dikerjakan hari ini? Ada hambatan?
   - Terdokumentasi: 317 daily scrum records selama pengembangan
   - Beberapa sesi didokumentasikan dengan video recording

3. **Sprint Review**
   - Durasi: 2-3 jam di akhir setiap sprint
   - Demonstrasi fitur yang telah selesai kepada stakeholder
   - Mendapatkan feedback untuk penyesuaian Product Backlog
   - Dilakukan setiap akhir sprint (total 4 kali)

4. **Sprint Retrospective**
   - Durasi: 1-2 jam setelah Sprint Review
   - Tim mengevaluasi proses yang berjalan
   - Identifikasi apa yang berjalan baik dan area perbaikan
   - Action items untuk sprint berikutnya

### 1.5.3 Implementasi Sprint

Pengembangan sistem dilakukan dalam **4 sprint** dengan durasi dan fokus sebagai berikut:

| Sprint | Durasi | Periode | Jumlah US | Fokus Utama |
|--------|--------|---------|-----------|-------------|
| **Sprint 1** | 4 minggu | 22 Sep - 17 Okt 2025 | 20 | Core Authentication & Basic CRUD |
| **Sprint 2** | 2 minggu | 20 Okt - 31 Okt 2025 | 13 | Advanced CRUD & Profile Management |
| **Sprint 3** | 5 minggu | 3 Nov - 3 Des 2025 | 10 | Learning Features & Progress Tracking |
| **Sprint 4** | 3 minggu | 4 Des - 24 Des 2025 | 6 | Reports, Backup & Notifications |

**Total Durasi Proyek:** 14 minggu (22 September - 24 Desember 2025)

#### Detail Sprint:

**Sprint 1 - MVP (Minimum Viable Product)**
- Goal: Membangun fitur inti autentikasi dan CRUD dasar
- Output: Login/logout, manajemen pengguna, manajemen kelas dasar, upload dan verifikasi materi
- Review: 100% user stories selesai dan diterima

**Sprint 2 - Enhancement**
- Goal: Fitur advanced CRUD dan manajemen profil
- Output: Edit/delete pengguna, ubah/reset password, landing page, sistem notifikasi, progress bar
- Review: 100% user stories selesai dan diterima

**Sprint 3 - Advanced Features**
- Goal: Learning features dan progress tracking
- Output: Auto-save PDF progress, export Excel, history aktivitas, laporan kehadiran
- Review: 100% user stories selesai dan diterima

**Sprint 4 - Polish & Finalization**
- Goal: Reports, backup, dan finalisasi sistem
- Output: Backup database, download ZIP, laporan presensi keseluruhan, full regression testing
- Review: 100% user stories selesai dan diterima

### 1.5.4 Release Strategy

Sistem dirilis dalam **2 release utama**:

**Release 1 (21 November 2025)**
- Sprint pembentuk: Sprint 1, 2, 3
- Fitur: MVP dengan 43 user stories lengkap
- Status: Production-ready untuk uji coba terbatas

**Release 2 - Final (20 Desember 2025)**
- Sprint pembentuk: Sprint 4
- Fitur: Sistem lengkap dengan 49 user stories
- Status: Production-ready untuk deployment penuh

### 1.5.5 Keunggulan Metodologi Agile Scrum

Penggunaan metodologi Agile Scrum dalam proyek ini memberikan beberapa keunggulan:

1. **Fleksibilitas**: Dapat mengakomodasi perubahan kebutuhan yang muncul selama pengembangan
2. **Risk Mitigation**: Masalah dapat terdeteksi lebih awal melalui sprint review dan retrospective
3. **Stakeholder Involvement**: Stakeholder terlibat aktif memberikan feedback di setiap sprint review
4. **Incremental Value**: Setiap sprint menghasilkan fitur yang dapat digunakan
5. **Quality Assurance**: Testing dilakukan di setiap sprint, tidak ditunda hingga akhir proyek
6. **Team Collaboration**: Daily scrum meningkatkan komunikasi dan kolaborasi tim
7. **Continuous Improvement**: Sprint retrospective mendorong perbaikan proses berkelanjutan

Dengan implementasi Agile Scrum yang konsisten, proyek ini berhasil mencapai **100% completion rate** dari 49 user stories yang direncanakan dengan **100% acceptance rate** dari stakeholder.
