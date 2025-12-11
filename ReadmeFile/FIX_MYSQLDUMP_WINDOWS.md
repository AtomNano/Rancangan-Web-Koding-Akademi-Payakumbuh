# Fix: mysqldump Not Found di Windows (Localhost)

## Masalah
Error saat backup: `'"mysqldump"' is not recognized as an internal or external command`

Ini terjadi karena `mysqldump` tidak ada di PATH Windows.

## Solusi

### Step 1: Cari Lokasi mysqldump

Cari file `mysqldump.exe` di komputer kamu. Lokasi umum:

#### XAMPP
```
C:\xampp\mysql\bin\mysqldump.exe
```

#### Laragon
```
C:\laragon\bin\mysql\mysql-8.x.x\bin\mysqldump.exe
```
(Ganti `8.x.x` dengan versi MySQL yang terinstall)

#### MySQL Standalone
```
C:\Program Files\MySQL\MySQL Server 8.0\bin\mysqldump.exe
```
atau
```
C:\Program Files (x86)\MySQL\MySQL Server 8.0\bin\mysqldump.exe
```

#### Herd (Laravel Herd)
```
C:\Users\{username}\AppData\Local\Programs\herd\bin\mysql\bin\mysqldump.exe
```

### Step 2: Verifikasi Path

Buka PowerShell dan test:
```powershell
# Ganti path sesuai lokasi kamu
& "C:\xampp\mysql\bin\mysqldump.exe" --version
```

Jika muncul versi MySQL, berarti path benar.

### Step 3: Tambahkan ke .env

Tambahkan ke file `.env`:
```env
MYSQL_DUMP_PATH=C:\xampp\mysql\bin
```

**PENTING:** 
- Jangan tambahkan `mysqldump.exe` di akhir, hanya folder `bin` saja
- Gunakan backslash `\` atau forward slash `/` (keduanya bisa)
- Jika pakai XAMPP: `C:\xampp\mysql\bin`
- Jika pakai Laragon: `C:\laragon\bin\mysql\mysql-8.0.30\bin` (sesuaikan versi)

### Step 4: Clear Config Cache

```bash
php artisan config:clear
php artisan config:cache
```

### Step 5: Test Backup

```bash
php artisan backup:run --only-db
```

Jika berhasil, akan muncul:
```
Starting backup...
Dumping database codingakademi...
Backup completed!
```

## Alternatif: Tambahkan ke PATH Windows (Permanen)

Jika ingin `mysqldump` bisa dipanggil dari mana saja:

### Windows 10/11:
1. Buka **System Properties** → **Environment Variables**
2. Di **System Variables**, cari `Path`
3. Klik **Edit**
4. Klik **New**
5. Tambahkan path ke folder `bin` MySQL (contoh: `C:\xampp\mysql\bin`)
6. Klik **OK** di semua dialog
7. Restart PowerShell/Command Prompt

### Test:
```powershell
mysqldump --version
```

Jika muncul versi, berarti sudah di PATH.

## Alternatif: Skip Database Backup untuk Development

Jika hanya ingin test backup files saja (tanpa database):

```bash
php artisan backup:run --only-files
```

Atau edit `config/backup.php` untuk sementara:
```php
'databases' => [], // Kosongkan untuk skip database backup
```

## Troubleshooting

### Error: "The system cannot find the path specified"
- Pastikan path benar (cek dengan `dir` di PowerShell)
- Pastikan menggunakan backslash `\` atau forward slash `/`
- Pastikan tidak ada spasi di path (jika ada, wrap dengan quotes)

### Error: "Access is denied"
- Pastikan file `mysqldump.exe` ada di lokasi tersebut
- Coba run PowerShell sebagai Administrator

### Error: Masih "not recognized"
- Pastikan sudah clear config cache: `php artisan config:clear`
- Pastikan path di `.env` benar
- Restart terminal/PowerShell

## Contoh .env untuk Berbagai Setup

### XAMPP
```env
MYSQL_DUMP_PATH=C:\xampp\mysql\bin
```

### Laragon
```env
MYSQL_DUMP_PATH=C:\laragon\bin\mysql\mysql-8.0.30\bin
```

### MySQL Standalone
```env
MYSQL_DUMP_PATH=C:\Program Files\MySQL\MySQL Server 8.0\bin
```

### Herd
```env
MYSQL_DUMP_PATH=C:\Users\YourName\AppData\Local\Programs\herd\bin\mysql\bin
```

## Status
✅ **FIXED** - Config sudah ditambahkan, tinggal set `MYSQL_DUMP_PATH` di `.env`



