# Panduan Memperbaiki Masalah Kelas Tidak Tampil di Dashboard Guru

## Masalah
Kelas yang diassign ke guru tidak tampil di dashboard guru.

## Solusi yang Sudah Diterapkan

### 1. Query yang Disederhanakan
- Query sekarang langsung mencari kelas berdasarkan `guru_id` yang sesuai dengan ID guru yang login
- Tidak menggunakan filter status yang terlalu ketat
- Menambahkan logging untuk debugging

### 2. Perbaikan Controller
- `GuruKelasController` sudah diperbaiki untuk mengambil semua kelas yang diassign ke guru
- Query di dashboard juga sudah disederhanakan

## Cara Mengecek Masalah

### 1. Cek Data di Database

Jalankan query SQL berikut untuk mengecek:

```sql
-- Cek semua kelas dan guru_id-nya
SELECT id, nama_kelas, guru_id, status FROM kelas;

-- Cek kelas yang dimiliki guru tertentu (ganti 2 dengan ID guru Anda)
SELECT id, nama_kelas, guru_id, status FROM kelas WHERE guru_id = 2;

-- Cek semua guru
SELECT id, name, email, role FROM users WHERE role = 'guru';
```

### 2. Cek Log Laravel

Setelah login sebagai guru dan buka dashboard, cek log:

```bash
tail -f storage/logs/laravel.log
```

Log akan menunjukkan:
- User ID yang login
- Kelas yang ditemukan
- Detail semua kelas di database

### 3. Pastikan Guru ID Sudah Diassign

Jika kelas tidak memiliki `guru_id` yang benar:

**Via Admin Panel:**
1. Login sebagai admin
2. Buka halaman kelas: `/admin/kelas`
3. Klik "Edit" pada kelas yang ingin diassign
4. Pilih guru dari dropdown "Guru Pengajar"
5. Simpan perubahan

**Via Database (jika diperlukan):**
```sql
-- Update guru_id untuk kelas tertentu
UPDATE kelas SET guru_id = 2 WHERE id = 1; -- Ganti dengan ID yang sesuai
```

### 4. Verifikasi User ID

Pastikan ID guru yang login sesuai dengan `guru_id` di tabel kelas:

```sql
-- Cek user yang sedang login (ganti dengan email guru)
SELECT id, name, email, role FROM users WHERE email = 'guru@gmail.com';

-- Cek kelas dengan guru_id tersebut
SELECT * FROM kelas WHERE guru_id = [ID_GURU_DARI_QUERY_DIATAS];
```

## Jika Masih Tidak Tampil

### Langkah 1: Cek Log
Lihat log Laravel setelah mengakses dashboard guru. Log akan menunjukkan:
- Berapa banyak kelas yang ditemukan
- Detail setiap kelas
- Semua kelas yang ada di database

### Langkah 2: Pastikan Guru ID Benar
Pastikan `guru_id` di tabel `kelas` sesuai dengan ID user guru yang login.

### Langkah 3: Cek Query Manual
Coba query langsung di database:

```sql
-- Cek apakah ada kelas dengan guru_id tertentu
SELECT COUNT(*) FROM kelas WHERE guru_id = 2; -- Ganti dengan ID guru

-- Jika hasilnya 0, berarti tidak ada kelas yang diassign ke guru tersebut
```

### Langkah 4: Assign Kelas ke Guru
Jika tidak ada kelas yang diassign, assign melalui admin panel atau database.

## Debug Mode

Jika `APP_DEBUG=true` di file `.env`, dashboard akan menampilkan info debug:
- User ID
- Email
- Role

Gunakan info ini untuk memastikan user yang login adalah guru yang benar.

## Kontak Admin

Jika setelah semua langkah di atas kelas masih tidak tampil, hubungi admin untuk:
1. Memverifikasi data di database
2. Assign kelas ke guru yang benar
3. Memastikan tidak ada masalah dengan permission atau middleware

