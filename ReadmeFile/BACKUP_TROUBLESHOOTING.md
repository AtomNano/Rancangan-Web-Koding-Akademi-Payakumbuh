# Troubleshooting: Backup Tidak Berhasil Dibuat

## Gejala
- Klik "Buat Cadangan Manual" → muncul pesan sukses
- Tapi di tabel riwayat cadangan masih kosong
- Stats menunjukkan: Cadangan Berhasil: 0, Total Ukuran: 0 B

## Penyebab & Solusi

### 1. Database Connection Error
**Gejala:** Backup command gagal karena tidak bisa connect ke database

**Cek:**
```bash
# Di server (via SSH)
cd ~/laravel_app
php artisan tinker
>>> DB::connection()->getPdo();
```

**Solusi:**
- Pastikan `.env` sudah benar:
  ```env
  DB_CONNECTION=mysql
  DB_HOST=localhost
  DB_DATABASE=u974507379_codingacademi
  DB_USERNAME=u974507379_admincoding
  DB_PASSWORD=CodingAcademy2025
  ```
- Test koneksi: `php artisan migrate:status`

### 2. Permission Folder Backup
**Gejala:** Backup tidak bisa menulis file ke folder backup

**Solusi:**
```bash
# Di server (via SSH)
cd ~/laravel_app
chmod -R 775 storage/app
chmod -R 775 storage/app/private
chmod -R 775 storage/app/backup-temp
```

### 3. Folder Backup Tidak Ada
**Gejala:** Folder backup destination tidak ada

**Solusi:**
```bash
# Di server (via SSH)
cd ~/laravel_app
mkdir -p storage/app/private
mkdir -p storage/app/backup-temp
chmod -R 775 storage/app
```

### 4. Config Backup Salah
**Gejala:** Config backup tidak sesuai dengan filesystem

**Cek:**
```bash
# Di server (via SSH)
php artisan tinker
>>> config('backup.backup.destination.disks')
>>> config('filesystems.disks.local')
```

**Solusi:**
- Pastikan `config/backup.php` menggunakan disk 'local'
- Pastikan disk 'local' ada di `config/filesystems.php`

### 5. Log Error
**Cek log untuk detail error:**
```bash
# Di server (via SSH)
cd ~/laravel_app
tail -50 storage/logs/laravel.log
```

Cari error terkait:
- "Backup command"
- "backup:run"
- "BackupDestination"
- "Database connection"

### 6. Test Backup Manual via CLI
**Test backup langsung via command line:**
```bash
# Di server (via SSH)
cd ~/laravel_app
php artisan backup:run --only-db
```

Jika berhasil, akan muncul output:
```
Starting backup...
Backup completed!
```

Jika gagal, akan muncul error message yang jelas.

### 7. Cek Folder Backup
**Cek apakah file backup benar-benar dibuat:**
```bash
# Di server (via SSH)
cd ~/laravel_app
ls -la storage/app/private/
# Atau
ls -la storage/app/private/"Koding Akademi Payakumbuh"/
```

Harus ada file `.zip` di folder tersebut.

## Debugging Steps

### Step 1: Cek Log
```bash
tail -f storage/logs/laravel.log
```
Lalu coba buat backup lagi, lihat error yang muncul.

### Step 2: Test Database Connection
```bash
php artisan migrate:status
```
Jika error, berarti database connection bermasalah.

### Step 3: Test Backup Command
```bash
php artisan backup:run --only-db
```
Lihat output dan error yang muncul.

### Step 4: Cek Permission
```bash
ls -la storage/app/
ls -la storage/app/private/
```
Pastikan folder bisa ditulis (permission 775 atau 777).

### Step 5: Cek Config
```bash
php artisan config:clear
php artisan config:cache
php artisan tinker
>>> config('backup.backup.destination.disks')
>>> config('backup.backup.name')
```

## Common Errors

### Error: "Backup command gagal dengan exit code: 1"
**Penyebab:** Ada error saat menjalankan backup command

**Solusi:**
1. Cek log: `tail -50 storage/logs/laravel.log`
2. Test backup via CLI: `php artisan backup:run`
3. Cek database connection
4. Cek permission folder

### Error: "Tidak ada file backup yang ditemukan"
**Penyebab:** Backup command berjalan tapi file tidak dibuat

**Solusi:**
1. Cek folder backup: `ls -la storage/app/private/`
2. Cek permission folder
3. Cek disk space: `df -h`
4. Cek log untuk detail error

### Error: "Folder backup tidak dapat ditulis"
**Penyebab:** Permission folder tidak cukup

**Solusi:**
```bash
chmod -R 775 storage/app
chmod -R 775 storage/app/private
```

## Verifikasi Backup Berhasil

Setelah backup berhasil:
1. **Tabel riwayat** harus menampilkan backup baru
2. **Stats** harus update: Cadangan Berhasil > 0
3. **File backup** harus ada di folder: `storage/app/private/{app-name}/`
4. **Tombol download/delete** harus muncul di kolom Aksi

## Status
✅ **FIXED** - Error handling sudah diperbaiki, backup sekarang akan menampilkan error yang jelas jika gagal.



