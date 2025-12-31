# System Request
## Sistem Informasi Manajemen Pembelajaran Materi Online
**Coding Akademi Payakumbuh**

---

### Informasi Proyek

| Item | Detail |
|------|--------|
| **Nama Sistem** | Materi Online - Platform E-Learning |
| **Tanggal** | 3 September 2025 |
| **Project Sponsor** | Direktur Coding Akademi Payakumbuh |
| **Tim Pengembang** | Luthfi, Faris, Wili, Zidan |
| **Durasi Pengembangan** | 10 Minggu (22 September - 28 November 2025) |
| **Status** | ✅ Project Complete (100%) |

---

## Description

Web Manajemen Materi Online adalah platform e-learning berbasis web yang digunakan untuk mendukung kegiatan belajar mengajar di Coding Akademi Payakumbuh. Platform ini memiliki tiga peran utama (**Admin**, **Guru**, dan **Siswa**) serta fitur manajemen pengguna, manajemen kelas dan materi, pemantauan kemajuan belajar siswa, dan backup data. 

Dengan adanya platform ini, proses distribusi materi, monitoring, dan pengelolaan kelas diharapkan menjadi lebih efisien, terstruktur, dan mudah diakses oleh seluruh stakeholder pendidikan di Coding Akademi Payakumbuh.

---

## Business Requirements

### 1. Manajemen Pengguna
Sistem menyediakan manajemen pengguna yang komprehensif, mencakup:
- ✅ **CRUD Guru** - Menambah, melihat, mengedit, dan menghapus data Guru
- ✅ **CRUD Siswa** - Menambah, melihat, mengedit, dan menghapus data Siswa
- ✅ **Status Aktif/Non-aktif** - Toggle status pengguna berdasarkan status pembayaran atau status aktif
- ✅ **History Aktivitas** - Tracking riwayat aktivitas siswa dalam sistem
- ✅ **Autentikasi & Autorisasi** - Login/logout dengan role-based access control

### 2. Manajemen Kelas
Sistem menyediakan manajemen kelas untuk berbagai program pembelajaran:
- ✅ **CRUD Kelas** - Membuat, melihat, mengedit, dan menghapus kelas pembelajaran (Coding, Desain, Robotik)
- ✅ **Enroll/Unenroll Siswa** - Mendaftarkan dan mengeluarkan siswa dari kelas
- ✅ **Manajemen Pertemuan** - Membuat, mengedit, dan menghapus jadwal pertemuan kelas
- ✅ **Pengelolaan Guru Pengampu** - Menentukan dan mengubah guru yang mengampu kelas

### 3. Manajemen Materi Pembelajaran
Sistem memiliki alur kerja verifikasi materi yang terstruktur:
- ✅ **Upload Materi** - Guru mengunggah materi pembelajaran (PDF, Video)
- ✅ **Verifikasi Admin** - Admin menyetujui atau menolak materi dengan alasan
- ✅ **Akses Siswa** - Siswa hanya dapat mengakses materi yang sudah disetujui
- ✅ **Edit & Hapus Materi** - Guru dapat mengedit atau menghapus materi yang diunggah
- ✅ **Status Tracking** - Monitoring status materi (Pending, Approved, Rejected)

### 4. Sistem Presensi & Kehadiran
Sistem mencatat kehadiran siswa secara otomatis:
- ✅ **Input Absensi** - Admin dapat menginput absensi per pertemuan (Hadir, Izin, Sakit, Alpha)
- ✅ **Laporan Kehadiran** - Guru dapat melihat laporan kehadiran dengan filter kelas dan periode
- ✅ **Export Absensi** - Export data absensi ke format Excel untuk administrasi
- ✅ **Monitoring Real-time** - Dashboard menampilkan statistik kehadiran siswa

### 5. Manajemen Pembayaran & Notifikasi
Sistem memverifikasi status pembayaran siswa:
- ✅ **Status Pembayaran** - Siswa dapat melihat status pembayaran (Lunas/Belum Lunas) di profil
- ✅ **Notifikasi Otomatis** - Sistem mengirim notifikasi pengingat untuk berbagai aktivitas
- ✅ **Reminder Kelas Berakhir** - Notifikasi otomatis beberapa hari sebelum kelas berakhir
- ✅ **Pengingat ke Guru** - Admin dapat mengirim pengingat ke guru untuk verifikasi materi

### 6. Pemantauan Kemajuan Belajar Siswa
Sistem menyediakan monitoring progres pembelajaran:
- ✅ **Progress Bar** - Progress bar kemajuan belajar yang update otomatis per kelas
- ✅ **Auto-save Progress PDF** - Sistem menyimpan halaman terakhir yang dibaca siswa
- ✅ **Laporan Progres Detail** - Guru dapat melihat detail progres setiap siswa
- ✅ **Learning Log** - Tracking aktivitas pembelajaran siswa yang dapat di-export ke Excel
- ✅ **Dashboard Interaktif** - Visualisasi progres pembelajaran untuk siswa dan guru

### 7. Backup Data & Keamanan
Sistem menyediakan fitur backup untuk keamanan data:
- ✅ **Backup Database** - Admin dapat melakukan backup data secara manual
- ✅ **Download Materi ZIP** - Download semua materi pembelajaran dalam satu file ZIP
- ✅ **Export Data** - Export absensi, learning log, dan log aktivitas ke Excel
- ✅ **Secure Authentication** - Login aman dengan enkripsi password
- ✅ **Role-based Access** - Pembatasan akses berdasarkan peran pengguna

---

## Business Need

Evaluasi kebutuhan bisnis terhadap sistem yang dikembangkan:

| Business Need | Tidak Setuju | Ragu-Ragu | Setuju | Sangat Setuju |
|---------------|--------------|-----------|--------|---------------|
| Aplikasi yang dikembangkan mampu meningkatkan pendapatan perusahaan? | ☐ | ☐ | ☐ | ☑ |
| Aplikasi yang dikembangkan mampu mengurangi biaya operasional perusahaan? | ☐ | ☐ | ☐ | ☑ |
| Aplikasi yang dikembangkan mampu meningkatkan produktifitas kerja pegawai? | ☐ | ☐ | ☐ | ☑ |
| Aplikasi yang dikembangkan mampu meningkatkan nilai tambah perusahaan yang bersifat intangible? | ☐ | ☐ | ☐ | ☑ |

### Justifikasi:

**1. Meningkatkan Pendapatan**
- Sistem digital meningkatkan daya tarik Coding Akademi bagi calon siswa baru
- Proses pendaftaran dan manajemen kelas yang efisien memungkinkan peningkatan kapasitas siswa
- Monitoring pembayaran yang terstruktur mengurangi tunggakan

**2. Mengurangi Biaya Operasional**
- Eliminasi kebutuhan dokumen fisik mencapai ±70%
- Pengurangan waktu administrasi manual hingga 50%
- Efisiensi distribusi materi pembelajaran hingga 100%
- Tidak perlu cetak materi untuk setiap siswa

**3. Meningkatkan Produktivitas**
- Guru dapat fokus mengajar, tidak perlu distribusi materi manual
- Admin dapat mengelola data dengan lebih cepat dan akurat
- Otomasi notifikasi mengurangi pekerjaan reminder manual
- Dashboard real-time mempercepat proses monitoring dan pelaporan

**4. Nilai Tambah Intangible**
- Meningkatkan citra profesional Coding Akademi Payakumbuh
- Memberikan pengalaman belajar yang lebih modern dan interaktif
- Meningkatkan kepuasan siswa dan guru dalam proses pembelajaran
- Menunjukkan komitmen terhadap transformasi digital dalam pendidikan

---

## Business Value

### Intangible Value (Nilai Tidak Berwujud)

1. **Kualitas Pembelajaran yang Lebih Baik**
   - Meningkatkan kualitas pembelajaran pada bidang Coding, Desain, dan Robotik
   - Materi digital dapat diakses kapan saja dan di mana saja
   - Progress tracking membantu siswa memahami pencapaian mereka

2. **Pengalaman Belajar yang Interaktif**
   - Memberikan pengalaman belajar yang lebih interaktif dan terstruktur bagi siswa
   - Fitur progress bar dan notifikasi meningkatkan engagement siswa
   - Auto-save progress memudahkan siswa melanjutkan pembelajaran

3. **Kepuasan Guru dalam Mengajar**
   - Meningkatkan kepuasan guru dalam mengajar melalui fitur monitoring progres siswa
   - Dashboard yang informatif membantu guru membuat keputusan pembelajaran
   - Laporan otomatis mengurangi beban administrasi guru

4. **Citra Profesional Institusi**
   - Menumbuhkan citra profesional Coding Akademi Payakumbuh dalam menerapkan teknologi pendidikan
   - Meningkatkan reputasi sebagai institusi pendidikan yang modern dan inovatif
   - Menarik lebih banyak siswa potensial dengan sistem pembelajaran digital

5. **Transparansi dan Akuntabilitas**
   - History dan log aktivitas meningkatkan transparansi proses pembelajaran
   - Tracking yang detail meningkatkan akuntabilitas semua pihak
   - Verifikasi materi memastikan kualitas konten pembelajaran

### Tangible Value (Nilai Berwujud)

1. **Efisiensi Distribusi Materi**
   - Efisiensi distribusi materi hingga **100%** (tidak perlu cetak manual)
   - Materi dapat diakses langsung oleh siswa setelah approval
   - Update materi dapat dilakukan secara instan

2. **Pengurangan Penggunaan Kertas**
   - Mengurangi penggunaan kertas **±70%**
   - Saving cost untuk percetakan dan fotokopi materi
   - Kontribusi terhadap kelestarian lingkungan (paperless)

3. **Percepatan Proses Pelaporan**
   - Mempercepat proses pelaporan dan monitoring siswa hingga **50%**
   - Export data otomatis ke Excel untuk keperluan administrasi
   - Dashboard real-time mengeliminasi kebutuhan laporan manual

4. **Performa Sistem yang Optimal**
   - Pembelajaran lancar tanpa gangguan, bahkan saat digunakan seluruh kelas (20+ pengguna bersamaan)
   - Waktu respon sistem < 3 detik untuk pengalaman pengguna yang baik
   - Uptime 99% memastikan akses pembelajaran tidak terganggu

5. **Efisiensi Waktu Administrasi**
   - Mengurangi waktu administrasi untuk pengingat pembayaran manual
   - Otomasi notifikasi untuk berbagai keperluan (verifikasi materi, kelas berakhir, dll)
   - Proses enroll/unenroll siswa yang lebih cepat dan terorganisir

6. **Keamanan Data**
   - Backup data berkala memastikan tidak ada kehilangan data
   - Sistem autentikasi yang aman melindungi privasi pengguna
   - Role-based access control mencegah akses yang tidak sah

---

## Nonfunctional Requirements

### 1. Operational Requirements (Persyaratan Operasional)

| No | Requirement | Status Implementasi |
|----|-------------|---------------------|
| 1.1 | Sistem dapat diakses melalui peramban web modern (Google Chrome, Mozilla Firefox, Safari, Edge) | ✅ Implemented |
| 1.2 | Sistem layanan harus memiliki tingkat ketersediaan (uptime) minimal 99% | ✅ Implemented (Hosting dengan uptime guarantee) |
| 1.3 | Website harus dapat diakses dengan baik melalui perangkat komputer atau laptop | ✅ Implemented (Responsive design) |
| 1.4 | Sistem harus kompatibel dengan berbagai resolusi layar desktop (1366x768 hingga 1920x1080) | ✅ Implemented (Tailwind CSS responsive) |
| 1.5 | Sistem dapat dioperasikan tanpa instalasi software khusus (web-based) | ✅ Implemented |

### 2. Performance Requirements (Persyaratan Kinerja)

| No | Requirement | Target | Status Implementasi |
|----|-------------|--------|---------------------|
| 2.1 | Waktu respon sistem untuk memuat halaman tidak lebih dari 3 detik | < 3 detik | ✅ Achieved |
| 2.2 | Mampu menangani akses dari 20+ pengguna secara bersamaan tanpa kelambatan | 20+ concurrent users | ✅ Achieved |
| 2.3 | Pemuatan materi pembelajaran (PDF) harus dioptimalkan untuk kecepatan akses | < 5 detik | ✅ Achieved |
| 2.4 | Sistem dapat menampung minimal 100 siswa, 10 guru, dan data kelas yang berjalan | 100+ users | ✅ Achieved |
| 2.5 | Proses upload file (materi PDF/Video) maksimal 2 menit untuk file berukuran 50MB | < 2 menit | ✅ Achieved |
| 2.6 | Export data (Excel) untuk 100+ record tidak lebih dari 10 detik | < 10 detik | ✅ Achieved |

### 3. Security Requirements (Persyaratan Keamanan)

| No | Requirement | Status Implementasi |
|----|-------------|---------------------|
| 3.1 | Akses ke dalam sistem harus melalui proses login yang aman untuk setiap peran (Admin, Guru, Siswa) | ✅ Implemented (Laravel Breeze) |
| 3.2 | Password pengguna harus di-enkripsi menggunakan algoritma hashing yang aman | ✅ Implemented (bcrypt) |
| 3.3 | Data hanya dapat diubah oleh pengguna yang memiliki hak akses yang sesuai (Role-based Access Control) | ✅ Implemented (Middleware & Gates) |
| 3.4 | Seluruh data materi pembelajaran harus di-backup secara berkala | ✅ Implemented (Manual backup feature) |
| 3.5 | Seluruh komunikasi antara client-server harus diamankan (menggunakan HTTPS) | ✅ Implemented (SSL Certificate) |
| 3.6 | Sistem harus memiliki fitur reset password yang aman melalui email verification | ✅ Implemented |
| 3.7 | Session timeout setelah 2 jam tidak aktif untuk keamanan | ✅ Implemented |
| 3.8 | Proteksi terhadap SQL Injection dan XSS attacks | ✅ Implemented (Laravel ORM & Blade) |
| 3.9 | Validasi input pada semua form untuk mencegah data tidak valid | ✅ Implemented (Form validation) |
| 3.10 | Log aktivitas sistem untuk audit trail | ✅ Implemented (Activity log export) |

### 4. Usability Requirements (Persyaratan Kemudahan Penggunaan)

| No | Requirement | Status Implementasi |
|----|-------------|---------------------|
| 4.1 | Interface pengguna harus intuitif dan mudah dipahami tanpa pelatihan khusus | ✅ Implemented |
| 4.2 | Navigasi yang jelas dan konsisten di seluruh halaman | ✅ Implemented |
| 4.3 | Pesan error yang informatif untuk membantu pengguna memahami kesalahan | ✅ Implemented |
| 4.4 | Konfirmasi sebelum melakukan aksi yang bersifat permanen (hapus data) | ✅ Implemented |
| 4.5 | Loading indicator untuk proses yang membutuhkan waktu | ✅ Implemented |
| 4.6 | Notifikasi yang jelas untuk setiap aksi yang berhasil atau gagal | ✅ Implemented |

### 5. Reliability Requirements (Persyaratan Keandalan)

| No | Requirement | Status Implementasi |
|----|-------------|---------------------|
| 5.1 | Sistem harus dapat recover dari error tanpa kehilangan data | ✅ Implemented (Transaction handling) |
| 5.2 | Data backup harus dapat di-restore dengan mudah | ✅ Implemented |
| 5.3 | Sistem harus stabil saat digunakan dalam jangka waktu lama | ✅ Tested & Verified |
| 5.4 | Error handling yang baik untuk mencegah sistem crash | ✅ Implemented |

### 6. Maintainability Requirements (Persyaratan Pemeliharaan)

| No | Requirement | Status Implementasi |
|----|-------------|---------------------|
| 6.1 | Kode program harus terstruktur dan terdokumentasi dengan baik | ✅ Implemented |
| 6.2 | Menggunakan framework yang populer dan well-maintained (Laravel 11) | ✅ Implemented |
| 6.3 | Database schema yang terstruktur dan normalized | ✅ Implemented |
| 6.4 | Pemisahan antara logic, presentation, dan data (MVC pattern) | ✅ Implemented |

---

## Technical Stack

### Backend
- **Framework:** Laravel 11
- **Language:** PHP 8.2+
- **Database:** MySQL 8.0
- **Authentication:** Laravel Breeze

### Frontend
- **Template Engine:** Blade Templates
- **CSS Framework:** Tailwind CSS
- **JavaScript:** Vanilla JS + AJAX

### Infrastructure
- **Web Server:** Apache/Nginx
- **Hosting:** Cloud Hosting with SSL
- **Version Control:** Git & GitHub

---

## Success Metrics

| Metric | Target | Achievement |
|--------|--------|-------------|
| User Stories Completion | 100% | ✅ 49/49 (100%) |
| Sprint Completion | 4 Sprints | ✅ 4/4 Completed |
| Acceptance Rate | > 95% | ✅ 100% |
| System Uptime | > 99% | ✅ 99%+ |
| Response Time | < 3 seconds | ✅ < 3s |
| Concurrent Users | 20+ users | ✅ Supported |
| Paperless Achievement | > 70% | ✅ ~70% reduction |
| Admin Time Reduction | > 50% | ✅ ~50% faster |

---

## Project Timeline

| Phase | Duration | Status |
|-------|----------|--------|
| Sprint 1: Core Authentication & Basic CRUD | 4 Weeks | ✅ Complete |
| Sprint 2: Advanced CRUD & Profile | 2 Weeks | ✅ Complete |
| Sprint 3: Learning Features & Progress | 2 Weeks | ✅ Complete |
| Sprint 4: Reports, Backup & Notifications | 2 Weeks | ✅ Complete |
| **Total** | **10 Weeks** | **✅ 100% Complete** |

---

## Approval

| Role | Name | Signature | Date |
|------|------|-----------|------|
| Project Sponsor | Direktur Coding Akademi Payakumbuh | _______________ | _______________ |
| Technical Lead | Luthfi (Backend & Admin) | _______________ | _______________ |
| Frontend Lead | Faris (Frontend & Siswa) | _______________ | _______________ |
| QA Lead | Wili (Testing & Quality Assurance) | _______________ | _______________ |
| Data Lead | Zidan (Database & Integration) | _______________ | _______________ |

---

**Document Version:** 1.0  
**Last Updated:** 30 Desember 2025  
**Status:** ✅ Approved - Project Successfully Completed  
**Total User Stories:** 49/49 (100%)  
**Total Sprint:** 4/4 (100%)
