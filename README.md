# Materi Online - Platform E-Learning v2.10

Platform E-Learning "Materi Online" adalah sistem pembelajaran digital yang dirancang untuk mendukung proses belajar mengajar antara Admin, Guru, dan Siswa. Aplikasi ini dibangun menggunakan framework Laravel dengan antarmuka yang modern dan responsif.

## 🌐 Demo & Deployment

- **Production URL:** [https://luthfiserver.site](https://luthfiserver.site)
- **Local Development:** `http://127.0.0.1:8000`

## 📋 Daftar Isi

- [Fitur Utama](#fitur-utama)
- [Teknologi yang Digunakan](#teknologi-yang-digunakan)
- [Struktur Database](#struktur-database)
- [Panduan Instalasi](#panduan-instalasi)
- [Penggunaan](#penggunaan)
- [Dokumentasi API](#dokumentasi-api)

## ✨ Fitur Utama

Platform ini memiliki tiga hak akses utama dengan fungsionalitas yang berbeda:

### 1. 👨‍💼 Panel Admin

**Dashboard & Analytics**
- Dashboard dengan statistik real-time (total pengguna, kelas, materi)
- Analytics untuk monitoring aktivitas sistem
- Activity log untuk tracking semua perubahan data

**Manajemen Pengguna**
- CRUD (Create, Read, Update, Delete) pengguna Guru dan Siswa
- Aktivasi/Deaktivasi akun pengguna
- Manajemen status aktif/tidak aktif siswa
- Filter dan pencarian pengguna

**Manajemen Kelas**
- CRUD kelas pembelajaran
- Enrollment siswa ke kelas (bulk enrollment)
- Unenroll siswa dari kelas
- Lihat detail kelas dengan daftar siswa dan materi

**Manajemen Pertemuan**
- CRUD pertemuan untuk setiap kelas
- Input dan edit data pertemuan (judul, deskripsi, tanggal, waktu)
- Kelola presensi siswa per pertemuan (Hadir/Izin/Sakit/Alpa)
- Detail absensi per pertemuan

**Verifikasi Materi**
- Review materi yang diunggah oleh Guru
- Approve/Reject materi dengan catatan
- Kirim reminder ke Guru untuk materi pending
- Download materi untuk preview

**Export & Reporting**
- Export absensi kelas ke Excel (format: Absensi_NamaKelas_Tanggal.xlsx)
- Export learning log siswa ke Excel (riwayat pembelajaran per siswa)
- Export data pengguna ke Excel
- Export activity logs ke Excel

**Backup & Restore**
- Backup database MySQL (SQL dump)
- Export semua materi dalam ZIP
- Download backup files
- Restore dari backup

### 2. 👨‍🏫 Panel Guru

**Dashboard**
- Statistik materi (total, pending, approved)
- Daftar kelas yang diampu
- Quick access ke fitur utama

**Manajemen Materi**
- Upload materi pembelajaran (PDF, Video, Dokumen)
- CRUD materi untuk kelas yang diampu
- Track status verifikasi materi (pending/approved/rejected)
- Download materi yang sudah diupload

**Manajemen Pertemuan**
- CRUD pertemuan untuk kelas yang diampu
- Input presensi siswa per pertemuan
- Lihat detail absensi dan statistik kehadiran
- Edit/hapus pertemuan

**Monitoring Siswa**
- Lihat daftar siswa per kelas
- Monitor progress pembelajaran siswa
- Export learning log siswa individual
- Lihat riwayat kehadiran siswa

**Absensi**
- Input absensi dengan flow yang disederhanakan
- Pilih kelas → Pilih pertemuan → Input absensi
- Lihat detail absensi per pertemuan

### 3. 👨‍🎓 Panel Siswa

**Dashboard**
- Daftar kelas yang diikuti
- Progress pembelajaran per kelas
- Akses cepat ke materi terbaru

**Akses Kelas**
- Lihat semua kelas yang diikuti
- Akses materi yang sudah diverifikasi Admin
- Lihat deskripsi dan informasi kelas

**Pembelajaran Materi**
- Akses dan baca materi (PDF viewer, video player)
- Download materi untuk offline learning
- Track progress membaca PDF (halaman terakhir dibaca)
- Mark materi sebagai selesai

**Progress Tracking**
- Progress bar per materi
- Progress bar per kelas
- Riwayat materi yang sudah dipelajari
- Statistik pembelajaran

**Presensi**
- Lihat riwayat kehadiran
- Submit absensi (jika fitur aktif)

## 🛠️ Teknologi yang Digunakan

### Backend
- **Framework:** Laravel 11
- **PHP Version:** 8.2+
- **Database:** MySQL 8.0+
- **Authentication:** Laravel Breeze
- **Authorization:** Laravel Policies & Gates
- **Excel Export:** Maatwebsite Excel (PhpSpreadsheet)

### Frontend
- **Template Engine:** Blade Templates
- **CSS Framework:** Tailwind CSS 3.x
- **JavaScript:** Alpine.js (via Breeze)
- **Icons:** Heroicons
- **Build Tool:** Vite

### Third-Party Services
- **Google OAuth:** Login dengan Google (Socialite)
- **Cloudflare Turnstile:** CAPTCHA protection
- **Storage:** Local filesystem + Symbolic link

## 📊 Struktur Database

### Tabel Utama

1. **users** - Data pengguna (Admin, Guru, Siswa)
   - Kolom: id, name, email, password, role, is_active, dll.

2. **kelas** - Data kelas pembelajaran
   - Kolom: id, nama_kelas, deskripsi, guru_id, dll.

3. **enrollments** - Relasi siswa dengan kelas
   - Kolom: id, user_id, kelas_id, start_date, dll.

4. **materis** - Data materi pembelajaran
   - Kolom: id, judul, deskripsi, file_path, kelas_id, uploaded_by, status, dll.

5. **pertemuans** - Data pertemuan kelas
   - Kolom: id, kelas_id, judul_pertemuan, tanggal_pertemuan, guru_id, materi_id, dll.

6. **presensis** - Data presensi siswa
   - Kolom: id, user_id, pertemuan_id, status (H/I/S/A), dll.

7. **materi_progress** - Progress pembelajaran siswa
   - Kolom: id, user_id, materi_id, last_page, total_pages, is_completed, dll.

8. **activity_logs** - Log aktivitas sistem
   - Kolom: id, user_id, action, description, ip_address, dll.

### Relasi Database

```
users (1) ----< (N) enrollments (N) >---- (1) kelas
users (1) ----< (N) materis (uploaded_by)
users (1) ----< (N) presensis
kelas (1) ----< (N) materis
kelas (1) ----< (N) pertemuans
pertemuans (1) ----< (N) presensis
materis (1) ----< (N) materi_progress
```

## 🚀 Panduan Instalasi

### Prasyarat

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL 8.0+
- Git

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/AtomNano/Rancangan-Web-Koding-Akademi-Payakumbuh.git
   cd Rancangan-Web-Koding-Akademi-Payakumbuh
   ```

2. **Install Dependensi Composer**
   ```bash
   composer install
   ```

3. **Install Dependensi NPM**
   ```bash
   npm install
   ```

4. **Salin File Environment**
   ```bash
   # Windows
   copy .env.example .env
   
   # Linux/Mac
   cp .env.example .env
   ```

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

6. **Konfigurasi Database**
   
   Buka file `.env` dan sesuaikan konfigurasi database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=codingacademi
   DB_USERNAME=root
   DB_PASSWORD=
   ```

7. **Konfigurasi Google OAuth (Opsional)**
   
   Untuk mengaktifkan login dengan Google:
   ```env
   GOOGLE_CLIENT_ID=your_google_client_id
   GOOGLE_CLIENT_SECRET=your_google_client_secret
   GOOGLE_REDIRECT_URI=${APP_URL}/auth/google/callback
   ```

8. **Jalankan Migrasi Database**
   ```bash
   php artisan migrate:fresh --seed
   ```
   
   Perintah ini akan:
   - Membuat semua tabel yang dibutuhkan
   - Mengisi data seeder (user default, dll)

9. **Buat Storage Link**
   ```bash
   php artisan storage:link
   ```
   
   Link ini menghubungkan folder `storage/app/public` ke `public/storage` untuk akses file upload.

10. **Compile Aset Frontend**
    ```bash
    # Development
    npm run dev
    
    # Production
    npm run build
    ```

11. **Jalankan Server Development**
    ```bash
    php artisan serve
    ```
    
    Aplikasi akan berjalan di `http://127.0.0.1:8000`

### Akun Default (Setelah Seeder)

Jika Anda menjalankan seeder, akun default yang tersedia:

- **Admin:** admin@example.com / password
- **Guru:** guru@example.com / password
- **Siswa:** siswa@example.com / password

## 📖 Penggunaan

### Akses Aplikasi

1. Buka browser dan akses `http://127.0.0.1:8000`
2. Klik tombol "Masuk" untuk login
3. Pilih role yang sesuai (Admin/Guru/Siswa)
4. Masukkan email dan password
5. Anda akan diarahkan ke dashboard sesuai role

### Quick Login (Development Only)

Untuk development, tersedia quick login:

```
http://127.0.0.1:8000/quick-login/admin
http://127.0.0.1:8000/quick-login/guru
http://127.0.0.1:8000/quick-login/siswa
```

⚠️ **Catatan:** Quick login hanya tersedia di environment `local`

### Workflow Umum

#### Untuk Admin:
1. Login → Dashboard
2. Kelola pengguna (tambah Guru/Siswa)
3. Buat kelas pembelajaran
4. Enroll siswa ke kelas
5. Verifikasi materi yang diupload Guru
6. Monitor aktivitas sistem
7. Export laporan dan backup data

#### Untuk Guru:
1. Login → Dashboard
2. Lihat kelas yang diampu
3. Upload materi pembelajaran
4. Buat pertemuan untuk kelas
5. Input presensi siswa
6. Monitor progress siswa
7. Export learning log siswa

#### Untuk Siswa:
1. Login → Dashboard
2. Lihat kelas yang diikuti
3. Akses dan pelajari materi
4. Track progress pembelajaran
5. Lihat riwayat kehadiran

## 📡 Dokumentasi API

### Authentication Routes

```
POST   /login                    - Login
POST   /register                 - Register (jika aktif)
POST   /logout                   - Logout
GET    /auth/google              - Login dengan Google
GET    /auth/google/callback     - Callback Google OAuth
```

### Admin Routes (Prefix: /admin)

```
GET    /admin/dashboard                                    - Dashboard Admin
GET    /admin/analytics                                    - Analytics

# Users
GET    /admin/users                                        - List users
POST   /admin/users                                        - Create user
GET    /admin/users/{user}                                 - Show user
PUT    /admin/users/{user}                                 - Update user
DELETE /admin/users/{user}                                 - Delete user
POST   /admin/users/{user}/activate                        - Activate user
POST   /admin/users/{user}/deactivate                      - Deactivate user

# Kelas
GET    /admin/kelas                                        - List kelas
POST   /admin/kelas                                        - Create kelas
GET    /admin/kelas/{kelas}                                - Show kelas
PUT    /admin/kelas/{kelas}                                - Update kelas
DELETE /admin/kelas/{kelas}                                - Delete kelas
GET    /admin/kelas/{kelas}/enroll                         - Enrollment form
POST   /admin/kelas/{kelas}/enroll                         - Enroll students
DELETE /admin/kelas/{kelas}/enroll/{user}                  - Unenroll student

# Pertemuan
GET    /admin/pertemuan                                    - Select kelas
GET    /admin/kelas/{kelas}/pertemuan                      - List pertemuan
POST   /admin/kelas/{kelas}/pertemuan                      - Create pertemuan
GET    /admin/kelas/{kelas}/pertemuan/{pertemuan}          - Show pertemuan
PUT    /admin/kelas/{kelas}/pertemuan/{pertemuan}          - Update pertemuan
DELETE /admin/kelas/{kelas}/pertemuan/{pertemuan}          - Delete pertemuan
POST   /admin/kelas/{kelas}/pertemuan/{pertemuan}/absen    - Input absensi

# Materi
GET    /admin/materi                                       - List materi
GET    /admin/materi/{materi}                              - Show materi
POST   /admin/materi/{materi}/approve                      - Approve materi
POST   /admin/materi/{materi}/reject                       - Reject materi
POST   /admin/materi/{materi}/remind                       - Remind guru

# Export
GET    /admin/kelas/{kelas}/attendance/export              - Export absensi
GET    /admin/kelas/{kelas}/siswa/{user}/log/export        - Export learning log

# Backup
GET    /admin/backup                                       - Backup dashboard
GET    /admin/backup/export/users                          - Export users Excel
GET    /admin/backup/export/logs                           - Export logs Excel
GET    /admin/backup/download/materials                    - Download all materials ZIP
POST   /admin/backup/database                              - Backup database SQL
```

### Guru Routes (Prefix: /guru)

```
GET    /guru/dashboard                                     - Dashboard Guru

# Materi
GET    /guru/materi                                        - List materi
POST   /guru/materi                                        - Upload materi
GET    /guru/materi/{materi}                               - Show materi
PUT    /guru/materi/{materi}                               - Update materi
DELETE /guru/materi/{materi}                               - Delete materi

# Kelas
GET    /guru/kelas                                         - List kelas
GET    /guru/kelas/{kelas}                                 - Show kelas

# Pertemuan
GET    /guru/absen                                         - Absensi index
GET    /guru/kelas/{kelas}/pertemuan                       - List pertemuan
POST   /guru/kelas/{kelas}/pertemuan                       - Create pertemuan
GET    /guru/kelas/{kelas}/pertemuan/{pertemuan}           - Show pertemuan
PUT    /guru/kelas/{kelas}/pertemuan/{pertemuan}           - Update pertemuan
DELETE /guru/kelas/{kelas}/pertemuan/{pertemuan}           - Delete pertemuan
POST   /guru/kelas/{kelas}/pertemuan/{pertemuan}/absen     - Input absensi

# Export
GET    /guru/kelas/{kelas}/siswa/{user}/log/export         - Export learning log

# Progress
GET    /guru/kelas/{kelas}/siswa/{siswa}/progress          - Student progress
```

### Siswa Routes (Prefix: /siswa)

```
GET    /siswa/dashboard                                    - Dashboard Siswa
GET    /siswa/kelas/{kelas}                                - Show kelas
GET    /siswa/materi/{materi}                              - Show materi
GET    /siswa/materi/{materi}/download                     - Download materi
POST   /siswa/materi/{materi}/complete                     - Mark complete
POST   /siswa/materi/{materi}/absen                        - Submit absensi
GET    /siswa/progress                                     - Overall progress

# PDF Progress
POST   /siswa/materi/{materi}/progress                     - Update progress
GET    /siswa/materi/{materi}/progress                     - Get progress
POST   /siswa/materi/{materi}/mark-completed               - Mark completed
```

### Notification Routes

```
GET    /notifications                                      - List notifications
POST   /notifications/{id}/read                            - Mark as read
POST   /notifications/mark-all-read                        - Mark all as read
```

## 🔒 Security Features

- **Authentication:** Laravel Breeze dengan session-based auth
- **Authorization:** Policy-based authorization untuk setiap resource
- **CSRF Protection:** Token CSRF untuk semua form
- **Password Hashing:** Bcrypt hashing untuk password
- **SQL Injection Prevention:** Eloquent ORM dengan prepared statements
- **XSS Protection:** Blade template escaping
- **File Upload Validation:** Validasi tipe dan ukuran file
- **Activity Logging:** Tracking semua aktivitas penting
- **Cloudflare Turnstile:** CAPTCHA untuk mencegah bot

## 📦 Export Features

### 1. Export Absensi Kelas
- Format: Excel (.xlsx)
- Nama file: `Absensi_NamaKelas_Tanggal.xlsx`
- Isi: Nama siswa, kelas, pertemuan, tanggal, status kehadiran, topik

### 2. Export Learning Log Siswa
- Format: Excel (.xlsx)
- Nama file: `log-belajar-{nama-siswa}-kelas-{id}.xlsx`
- Isi: Nama siswa, kelas, pertemuan, tanggal belajar, mentor, materi

### 3. Export Data Pengguna
- Format: Excel (.xlsx)
- Isi: Semua data pengguna (Admin, Guru, Siswa)

### 4. Export Activity Logs
- Format: Excel (.xlsx)
- Isi: Riwayat aktivitas sistem dengan timestamp

### 5. Backup Database
- Format: SQL dump
- Isi: Full database backup

### 6. Download All Materials
- Format: ZIP archive
- Isi: Semua file materi yang diupload

## 🐛 Troubleshooting

### Upload File Gagal

Jika upload file gagal, cek:
1. PHP upload limits di `php.ini`:
   ```ini
   upload_max_filesize = 100M
   post_max_size = 100M
   max_execution_time = 300
   ```
2. Jalankan script fix:
   ```bash
   # Windows
   .\fix-upload-limits.ps1
   
   # Linux/Mac
   ./fix-upload-limits.sh
   ```

### Storage Link Tidak Berfungsi

```bash
# Hapus link lama
rm public/storage

# Buat link baru
php artisan storage:link
```

### Database Migration Error

```bash
# Reset database
php artisan migrate:fresh

# Dengan seeder
php artisan migrate:fresh --seed
```

### Google OAuth Tidak Berfungsi

1. Cek konfigurasi di `.env`
2. Pastikan callback URL sudah didaftarkan di Google Console
3. Verifikasi dengan:
   ```
   http://127.0.0.1:8000/check-google-oauth
   ```

## 📝 Changelog

### v2.10 (Current)
- ✅ Fix export learning log error (missing materi relationship)
- ✅ Improved documentation
- ✅ Enhanced backup features
- ✅ Activity logging system

### v2.0
- ✅ Complete rewrite with Laravel 11
- ✅ Tailwind CSS integration
- ✅ Google OAuth login
- ✅ PDF progress tracking
- ✅ Export features
- ✅ Backup system

## 👥 Contributors

- **Luthfi** - Lead Developer
- **Tim Koding Akademi Payakumbuh** - Project Team

## 📄 License

This project is proprietary software developed for Koding Akademi Payakumbuh.

## 📞 Support

Untuk bantuan dan pertanyaan:
- **Website:** [https://luthfiserver.site](https://luthfiserver.site)
- **Email:** support@kodingakademi.com

---

**Materi Online v2.10** - Platform E-Learning untuk Koding Akademi Payakumbuh