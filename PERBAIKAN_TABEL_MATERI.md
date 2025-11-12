# Perbaikan: Error Tabel 'materi' Tidak Ditemukan

## Masalah
Error: `SQLSTATE[42S02]: Base table or view not found: 1146 Table 'codingakademi.materi' doesn't exist`

## Penyebab
1. **Nama tabel salah**: Migration menggunakan `materis` (plural), tapi query mencari `materi` (singular)
2. **Model tidak mendefinisikan table name**: Model `Materi` tidak secara eksplisit mendefinisikan nama tabel

## Perbaikan yang Sudah Dilakukan

### 1. Model Materi (`app/Models/Materi.php`)
- Menambahkan `protected $table = 'materis';` untuk memastikan menggunakan tabel yang benar
- Memperbaiki relationship `kelas()` untuk menggunakan foreign key yang eksplisit

### 2. Model Kelas (`app/Models/Kelas.php`)
- Memperbaiki relationship `materi()` untuk menggunakan foreign key yang eksplisit

### 3. Controller (`app/Http/Controllers/GuruKelasController.php`)
- Memperbaiki query untuk menggunakan `DB::table('materis')` (plural)
- Menambahkan `whereNotNull('kelas_id')` untuk memastikan tidak mencari materi dengan kelas_id null
- Menambahkan error handling untuk query database

## Verifikasi

### 1. Cek Tabel di Database
```sql
-- Cek apakah tabel materis ada
SHOW TABLES LIKE 'materis';

-- Cek struktur tabel
DESCRIBE materis;

-- Cek data di tabel
SELECT * FROM materis;
```

### 2. Cek Migration
```bash
php artisan migrate:status
```

Pastikan migration `2025_09_16_034235_create_materis_table` sudah dijalankan.

### 3. Jika Tabel Tidak Ada
```bash
# Jalankan migration
php artisan migrate

# Atau refresh migration (HATI-HATI: ini akan menghapus data)
php artisan migrate:fresh
```

## Catatan Penting

- **Nama tabel**: Selalu gunakan `materis` (plural), bukan `materi` (singular)
- **Model**: Model `Materi` sudah dikonfigurasi untuk menggunakan tabel `materis`
- **Query**: Semua query sudah menggunakan tabel yang benar

## Jika Masih Error

1. **Clear cache**:
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   ```

2. **Cek log Laravel**:
   ```bash
   tail -f storage/logs/laravel.log
   ```

3. **Verifikasi tabel di database**:
   - Pastikan tabel `materis` ada
   - Pastikan struktur tabel sesuai dengan migration













