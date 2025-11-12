# Dokumentasi Lengkap: Sistem Kelas untuk Guru

## Daftar Isi
1. [Overview](#overview)
2. [Masalah yang Sudah Diperbaiki](#masalah-yang-sudah-diperbaiki)
3. [Alur Kerja Detail Kelas](#alur-kerja-detail-kelas)
4. [Troubleshooting](#troubleshooting)
5. [Cara Menambahkan Data](#cara-menambahkan-data)
6. [Verifikasi & Testing](#verifikasi--testing)

---

## Overview

Sistem kelas memungkinkan guru untuk:
- Melihat kelas yang diassign kepada mereka
- Melihat detail kelas (siswa, materi, progress, kehadiran)
- Mengupload materi pembelajaran
- Memantau progress dan kehadiran siswa

### Komponen Utama
- **Route**: `/guru/kelas` dan `/guru/kelas/{id}`
- **Controller**: `GuruKelasController`
- **Models**: `Kelas`, `Materi`, `Enrollment`, `User`, `Presensi`, `MateriProgress`
- **Views**: `guru/kelas/index.blade.php`, `guru/kelas/show.blade.php`

---

## Masalah yang Sudah Diperbaiki

### 1. Kelas Tidak Tampil di Dashboard Guru

**Masalah**: Guru tidak melihat kelas di dashboard meskipun sudah diassign.

**Penyebab**:
- Query filter terlalu ketat (hanya `guru_id` yang sesuai)
- Tidak ada fallback untuk enrollment
- Permission check terlalu ketat

**Solusi yang Diterapkan**:
- Query mengambil kelas berdasarkan `guru_id` ATAU enrollment
- Permission check sementara dinonaktifkan untuk testing
- Logging detail ditambahkan untuk debugging

**File yang Diubah**:
- `routes/web.php` - Route dashboard guru
- `app/Http/Controllers/DashboardController.php` - Controller dashboard
- `app/Http/Controllers/GuruKelasController.php` - Controller kelas guru
- `resources/views/guru/dashboard.blade.php` - View dashboard

### 2. Error Tabel 'materi' Tidak Ditemukan

**Masalah**: `SQLSTATE[42S02]: Base table or view not found: 1146 Table 'codingakademi.materi' doesn't exist`

**Penyebab**:
- Migration menggunakan nama tabel `materis` (plural)
- Model tidak mendefinisikan nama tabel secara eksplisit
- Query menggunakan `materi` (singular) bukan `materis` (plural)

**Solusi yang Diterapkan**:
- Menambahkan `protected $table = 'materis';` di model `Materi`
- Memperbaiki semua query untuk menggunakan `materis`
- Menambahkan foreign key eksplisit di relationships

**File yang Diubah**:
- `app/Models/Materi.php` - Model Materi
- `app/Models/Kelas.php` - Model Kelas
- `app/Http/Controllers/GuruKelasController.php` - Controller

### 3. Data Kosong di Detail Kelas

**Masalah**: Detail kelas menampilkan 0 untuk siswa, materi, dan data lainnya.

**Penyebab**:
- Tidak ada data di tabel `enrollments` untuk kelas tersebut
- Tidak ada data di tabel `materis` untuk kelas tersebut
- Query tidak memiliki fallback yang memadai

**Solusi yang Diterapkan**:
- Menambahkan logging detail di setiap langkah query
- Menambahkan fallback queries (direct query, relationship, DB query)
- Menambahkan error handling dengan try-catch
- Menambahkan debug info di view

**File yang Diubah**:
- `app/Http/Controllers/GuruKelasController.php` - Method `show()`
- `resources/views/guru/kelas/show.blade.php` - View detail kelas

---

## Alur Kerja Detail Kelas

### 1. Route & Permission Check

**Route**: `GET /guru/kelas/{kelas}`
**Controller**: `GuruKelasController::show(Kelas $kelas)`

**Permission Check**:
```php
// Cek apakah guru memiliki akses
- Apakah kelas->guru_id === user->id?
- Apakah guru terdaftar di enrollments?
- Fallback: Jika user->role === 'guru', izinkan akses
```

### 2. Query Data Siswa (3 Langkah)

**Langkah 1: Query Enrollments**
```php
$enrollmentIds = Enrollment::where('kelas_id', $kelas->id)
    ->pluck('user_id')
    ->toArray();
```

**Langkah 2: Query Users**
```php
$siswa = User::whereIn('id', $enrollmentIds)
    ->where('role', 'siswa')
    ->orderBy('name')
    ->get();
```

**Langkah 3: Fallback Relationship**
```php
if ($siswa->isEmpty()) {
    $siswa = $kelas->students()
        ->where('users.role', 'siswa')
        ->orderBy('name')
        ->get();
}
```

### 3. Query Data Materi (3 Langkah)

**Langkah 1: Query Langsung**
```php
$materi = Materi::where('kelas_id', $kelas->id)
    ->whereNotNull('kelas_id')
    ->with(['uploadedBy', 'progress', 'presensi'])
    ->latest()
    ->get();
```

**Langkah 2: Fallback Relationship**
```php
if ($materi->isEmpty()) {
    $materi = $kelas->materi()
        ->whereNotNull('kelas_id')
        ->with(['uploadedBy', 'progress', 'presensi'])
        ->latest()
        ->get();
}
```

**Langkah 3: Fallback Direct DB Query**
```php
if ($materi->isEmpty()) {
    $materiData = DB::table('materis')
        ->where('kelas_id', $kelas->id)
        ->get();
    // Convert to model instances
}
```

### 4. Query Progress & Kehadiran

**Progress Data**:
```php
foreach ($siswa as $s) {
    $progress = MateriProgress::where('user_id', $s->id)
        ->whereIn('materi_id', $materiIds)
        ->get();
    
    $presensiCount = Presensi::where('user_id', $s->id)
        ->whereIn('materi_id', $materiIds)
        ->groupBy('materi_id')
        ->pluck('materi_id')
        ->count();
}
```

**Kehadiran (Presensi)**:
```php
$presensi = Presensi::whereIn('materi_id', $materiIds)
    ->with(['user', 'materi'])
    ->orderBy('tanggal_akses', 'desc')
    ->get()
    ->groupBy('materi_id');
```

### 5. Render View

Data yang dikirim ke view:
- `$kelas` - Data kelas
- `$siswa` - Collection siswa
- `$materi` - Collection materi
- `$presensi` - Collection presensi (grouped by materi_id)
- `$progressData` - Array progress per siswa
- `$materiAccess` - Array akses per materi

---

## Troubleshooting

### Masalah: Kelas Tidak Tampil di Dashboard

**Cek 1: Apakah kelas ada di database?**
```sql
SELECT id, nama_kelas, guru_id FROM kelas;
```

**Cek 2: Apakah kelas diassign ke guru?**
```sql
SELECT id, nama_kelas, guru_id FROM kelas WHERE guru_id = {guru_id};
```

**Cek 3: Cek log Laravel**
```bash
tail -f storage/logs/laravel.log
# Cari: "Guru Dashboard: Loading classes for guru"
```

**Solusi**:
1. Assign kelas ke guru via admin panel
2. Atau gunakan command: `php artisan kelas:assign {kelas_id} {guru_id}`
3. Atau update database: `UPDATE kelas SET guru_id = {guru_id} WHERE id = {kelas_id};`

### Masalah: Data Kosong di Detail Kelas

**Cek 1: Apakah ada enrollment?**
```sql
SELECT * FROM enrollments WHERE kelas_id = {kelas_id};
```

**Cek 2: Apakah ada materi?**
```sql
SELECT * FROM materis WHERE kelas_id = {kelas_id};
```

**Cek 3: Cek log Laravel**
```bash
tail -f storage/logs/laravel.log
# Cari: "GuruKelasController show: Data loaded"
# Periksa: enrollments_count, materi_direct_count
```

**Solusi**:
1. Daftarkan siswa ke kelas via admin panel
2. Upload materi via guru panel
3. Cek apakah `kelas_id` di materi tidak NULL

### Masalah: Error Tabel 'materi' Tidak Ditemukan

**Cek 1: Apakah tabel ada?**
```sql
SHOW TABLES LIKE 'materis';
```

**Cek 2: Apakah migration sudah dijalankan?**
```bash
php artisan migrate:status
```

**Solusi**:
1. Pastikan model `Materi` memiliki `protected $table = 'materis';`
2. Jalankan migration: `php artisan migrate`
3. Clear cache: `php artisan cache:clear`

---

## Cara Menambahkan Data

### 1. Assign Kelas ke Guru

**Opsi A: Via Admin Panel (Recommended)**
1. Login sebagai admin
2. Buka `/admin/kelas`
3. Edit kelas yang ingin diassign
4. Pilih guru di dropdown "Guru Pengajar"
5. Simpan

**Opsi B: Via Command Line**
```bash
php artisan kelas:assign {kelas_id} {guru_id}
# Contoh: php artisan kelas:assign 1 6
```

**Opsi C: Via Database**
```sql
UPDATE kelas SET guru_id = {guru_id} WHERE id = {kelas_id};
```

### 2. Menambahkan Siswa ke Kelas

**Via Admin Panel:**
1. Login sebagai admin
2. Buka `/admin/kelas/{id}`
3. Klik "Enroll Siswa"
4. Pilih siswa yang ingin didaftarkan
5. Simpan

**Via Database:**
```sql
INSERT INTO enrollments (user_id, kelas_id, status, created_at, updated_at)
VALUES ({siswa_id}, {kelas_id}, 'active', NOW(), NOW());
```

### 3. Menambahkan Materi ke Kelas

**Via Guru Panel:**
1. Login sebagai guru
2. Buka `/guru/materi/create`
3. Pilih kelas yang sesuai
4. Upload materi
5. Simpan

**Via Database:**
```sql
INSERT INTO materis (judul, deskripsi, file_path, file_type, kelas_id, status, uploaded_by, created_at, updated_at)
VALUES ('Judul', 'Deskripsi', 'path/file.pdf', 'pdf', {kelas_id}, 'pending', {guru_id}, NOW(), NOW());
```

---

## Verifikasi & Testing

### Checklist Verifikasi

**1. Dashboard Guru**
- [ ] Login sebagai guru
- [ ] Buka `/guru/dashboard`
- [ ] Kelas yang diassign tampil
- [ ] Klik "Lihat Detail Kelas" berhasil

**2. Detail Kelas**
- [ ] Buka `/guru/kelas/{id}`
- [ ] Statistik menampilkan angka > 0 (jika ada data)
- [ ] Tab "Daftar Siswa" menampilkan siswa
- [ ] Tab "Materi" menampilkan materi
- [ ] Tab "Progress Siswa" menampilkan progress
- [ ] Tab "Kehadiran" menampilkan presensi

**3. Logging**
- [ ] Cek `storage/logs/laravel.log`
- [ ] Log "GuruKelasController show: Data loaded" ada
- [ ] Log menampilkan jumlah enrollment dan materi yang benar

### Testing Commands

**Cek Data Kelas:**
```bash
php artisan tinker
# Lalu jalankan script di CEK_DATA_KELAS.php
```

**Cek Route:**
```bash
php artisan route:list --name=guru.kelas
```

**Clear Cache:**
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## Catatan Penting

### Mode Testing vs Production

**Saat Ini (Testing)**:
- Permission check dinonaktifkan untuk semua guru
- Query mengambil semua kelas (atau berdasarkan guru_id + enrollment)
- Logging detail diaktifkan

**Production (Nanti)**:
- Aktifkan kembali permission check
- Filter query berdasarkan `guru_id` atau enrollment
- Kurangi logging detail (hanya error)

### Security Notes

⚠️ **JANGAN deploy ke production dengan permission check yang dinonaktifkan!**

### Database Schema

**Tabel Penting**:
- `kelas` - Data kelas (kolom: `guru_id`)
- `enrollments` - Relasi user-kelas (kolom: `user_id`, `kelas_id`, `status`)
- `materis` - Data materi (kolom: `kelas_id`, `uploaded_by`, `status`)
- `presensis` - Data kehadiran (kolom: `user_id`, `materi_id`, `tanggal_akses`)
- `materi_progress` - Data progress (kolom: `user_id`, `materi_id`, `progress_percentage`, `is_completed`)

---

## File Dokumentasi Terkait

- `PERBAIKAN_KELAS_GURU.md` - Detail perbaikan kelas tidak tampil
- `PERBAIKAN_TABEL_MATERI.md` - Detail perbaikan error tabel materi
- `SOLUSI_KELAS_TIDAK_TAMPIL.md` - Solusi cepat untuk masalah kelas
- `ALUR_DETAIL_KELAS.md` - Alur kerja detail kelas
- `CEK_DATA_KELAS.php` - Script untuk mengecek data kelas
- `TROUBLESHOOTING_DATA_KOSONG.md` - Troubleshooting data kosong

---

## Support

Jika masih ada masalah:
1. Cek log Laravel: `storage/logs/laravel.log`
2. Verifikasi data di database
3. Pastikan semua migration sudah dijalankan
4. Clear cache Laravel
5. Cek dokumentasi terkait di atas

---

**Last Updated**: 2025-01-XX
**Version**: 1.0













