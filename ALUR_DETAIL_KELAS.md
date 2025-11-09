# Alur Kerja Halaman Detail Kelas (Guru)

## Overview
Halaman detail kelas (`/guru/kelas/{id}`) menampilkan informasi lengkap tentang kelas yang diajar oleh guru, termasuk:
- Daftar siswa yang terdaftar
- Materi pembelajaran
- Progress siswa
- Kehadiran siswa

## Alur Lengkap

### 1. Route & Controller
**Route**: `GET /guru/kelas/{kelas}`
**Controller**: `GuruKelasController::show(Kelas $kelas)`

### 2. Permission Check
- Cek apakah guru memiliki akses ke kelas ini
- Metode pengecekan:
  - Apakah `guru_id` di tabel `kelas` sesuai dengan ID guru yang login?
  - Apakah guru terdaftar di kelas ini via tabel `enrollments`?
  - Fallback: Jika user adalah guru, izinkan akses (untuk testing)

### 3. Query Data Siswa

**Langkah 1: Query Enrollments**
```php
$enrollmentIds = Enrollment::where('kelas_id', $kelas->id)
    ->pluck('user_id')
    ->toArray();
```
- Mengambil semua `user_id` dari tabel `enrollments` yang memiliki `kelas_id` sesuai
- Hasil: Array ID user yang terdaftar di kelas

**Langkah 2: Query Users**
```php
$siswa = User::whereIn('id', $enrollmentIds)
    ->where('role', 'siswa')
    ->orderBy('name')
    ->get();
```
- Mengambil user dengan ID yang ada di `$enrollmentIds`
- Filter: Hanya user dengan `role = 'siswa'`
- Urutkan berdasarkan nama

**Langkah 3: Fallback Relationship**
Jika query langsung kosong, coba menggunakan relationship:
```php
$siswa = $kelas->students()
    ->where('users.role', 'siswa')
    ->orderBy('name')
    ->get();
```

### 4. Query Data Materi

**Langkah 1: Query Langsung**
```php
$materi = Materi::where('kelas_id', $kelas->id)
    ->whereNotNull('kelas_id')
    ->with(['uploadedBy', 'progress', 'presensi'])
    ->latest()
    ->get();
```
- Mengambil semua materi dengan `kelas_id` yang sesuai
- Tidak ada filter status (menampilkan semua: pending, approved, rejected)
- Eager load: `uploadedBy`, `progress`, `presensi`

**Langkah 2: Fallback Relationship**
Jika query langsung kosong:
```php
$materi = $kelas->materi()
    ->with(['uploadedBy', 'progress', 'presensi'])
    ->latest()
    ->get();
```

**Langkah 3: Fallback Direct DB Query**
Jika masih kosong, coba query langsung ke database:
```php
$materiData = DB::table('materis')
    ->where('kelas_id', $kelas->id)
    ->get();
```

### 5. Query Progress Data

Untuk setiap siswa, hitung:
- **Progress**: Materi yang sudah dibaca (dari tabel `materi_progress`)
- **Presensi**: Jumlah materi yang diakses (dari tabel `presensis`)
- **Completed**: Materi yang sudah selesai (dari tabel `materi_progress` dengan `is_completed = true`)

### 6. Query Kehadiran (Presensi)

```php
$presensi = Presensi::whereIn('materi_id', $materiIds)
    ->with(['user', 'materi'])
    ->orderBy('tanggal_akses', 'desc')
    ->get()
    ->groupBy('materi_id');
```
- Mengambil semua presensi untuk materi di kelas ini
- Group berdasarkan `materi_id` untuk memudahkan display

### 7. Render View

Data yang dikirim ke view:
- `$kelas`: Data kelas
- `$siswa`: Collection siswa
- `$materi`: Collection materi
- `$presensi`: Collection presensi (grouped by materi_id)
- `$progressData`: Array progress per siswa
- `$materiAccess`: Array akses per materi

## Data yang Diperlukan di Database

### 1. Tabel `enrollments`
Untuk menampilkan siswa, harus ada data:
```sql
INSERT INTO enrollments (user_id, kelas_id, status, created_at, updated_at)
VALUES (siswa_id, kelas_id, 'active', NOW(), NOW());
```

### 2. Tabel `materis`
Untuk menampilkan materi, harus ada data:
```sql
INSERT INTO materis (judul, deskripsi, file_path, file_type, kelas_id, status, uploaded_by, created_at, updated_at)
VALUES ('Judul Materi', 'Deskripsi', 'path/to/file.pdf', 'pdf', kelas_id, 'pending', guru_id, NOW(), NOW());
```

### 3. Tabel `presensis` (Opsional)
Untuk menampilkan kehadiran:
```sql
INSERT INTO presensis (user_id, materi_id, tanggal_akses, created_at, updated_at)
VALUES (siswa_id, materi_id, NOW(), NOW(), NOW());
```

### 4. Tabel `materi_progress` (Opsional)
Untuk menampilkan progress:
```sql
INSERT INTO materi_progress (user_id, materi_id, progress_percentage, is_completed, created_at, updated_at)
VALUES (siswa_id, materi_id, 100.00, true, NOW(), NOW());
```

## Troubleshooting

### Jika Data Kosong

1. **Cek Enrollments**
   ```sql
   SELECT * FROM enrollments WHERE kelas_id = 2;
   ```
   - Jika kosong, daftarkan siswa ke kelas

2. **Cek Materi**
   ```sql
   SELECT * FROM materis WHERE kelas_id = 2;
   ```
   - Jika kosong, upload materi untuk kelas ini

3. **Cek Log Laravel**
   ```bash
   tail -f storage/logs/laravel.log
   ```
   - Cari log "GuruKelasController show: Data loaded"
   - Periksa `enrollments_count` dan `materi_direct_count`

## Cara Menambahkan Data

### Menambahkan Siswa ke Kelas

**Via Admin Panel:**
1. Login sebagai admin
2. Buka `/admin/kelas/{id}`
3. Klik "Enroll Siswa" atau tombol serupa
4. Pilih siswa yang ingin didaftarkan
5. Simpan

**Via Database:**
```sql
INSERT INTO enrollments (user_id, kelas_id, status, created_at, updated_at)
VALUES (siswa_id, 2, 'active', NOW(), NOW());
```

### Menambahkan Materi ke Kelas

**Via Guru Panel:**
1. Login sebagai guru
2. Buka `/guru/materi/create`
3. Pilih kelas yang sesuai
4. Upload materi
5. Simpan

**Via Database:**
```sql
INSERT INTO materis (judul, deskripsi, file_path, file_type, kelas_id, status, uploaded_by, created_at, updated_at)
VALUES ('Judul', 'Deskripsi', 'path/file.pdf', 'pdf', 2, 'pending', guru_id, NOW(), NOW());
```

## Verifikasi

Setelah menambahkan data:
1. Refresh halaman detail kelas
2. Cek statistik di header (seharusnya > 0)
3. Cek tab "Daftar Siswa" (seharusnya menampilkan siswa)
4. Cek tab "Materi" (seharusnya menampilkan materi)
5. Cek log Laravel untuk detail



