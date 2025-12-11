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



