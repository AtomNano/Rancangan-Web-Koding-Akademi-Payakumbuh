# Update .env untuk Fix Backup

## Masalah
`.env` masih menggunakan path lama: `C:\xampp\mysql\bin`
Tapi mysqldump sebenarnya ada di: `C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin`

## Solusi

### 1. Buka file `.env`
Buka file `.env` di root project.

### 2. Cari baris `MYSQL_DUMP_PATH`
Cari baris yang berisi:
```
MYSQL_DUMP_PATH=C:\xampp\mysql\bin
```

### 3. Ganti dengan path yang benar
Ganti menjadi:
```
MYSQL_DUMP_PATH=C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin
```

### 4. Clear config cache
Jalankan di PowerShell:
```bash
php artisan config:clear
php artisan config:cache
```

### 5. Test backup
```bash
php artisan backup:run --only-db
```

## Verifikasi
Setelah update, verifikasi dengan:
```bash
php artisan tinker --execute="echo config('database.connections.mysql.dump.dump_binary_path');"
```

Harus muncul: `C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin`

## Jika masih error
1. Pastikan path benar (cek dengan File Explorer)
2. Pastikan file `mysqldump.exe` ada di folder tersebut
3. Clear cache lagi: `php artisan config:clear`

## Konfigurasi untuk Server Linux (Hosting/VPS)

Jika aplikasi dideploy ke server Linux (seperti Hostinger, DigitalOcean, dll), path Windows tidak akan berfungsi dan menyebabkan Error 500.

### 1. Cek lokasi mysqldump
Biasanya ada di `/usr/bin` atau sudah terdaftar di global path.

### 2. Update .env di Server
Ganti konfigurasi menjadi:

```env
# Opsi 1: Kosongkan (biarkan sistem mencari sendiri)
MYSQL_DUMP_PATH=

# Opsi 2: Path absolut (jika Opsi 1 gagal)
MYSQL_DUMP_PATH=/usr/bin
```

### 3. Clear Cache
Jangan lupa clear cache setelah update .env di server:
```bash
php artisan config:clear
```
