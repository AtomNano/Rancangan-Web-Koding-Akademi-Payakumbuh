# ✅ SOLUSI: Upload File Besar untuk Laravel Herd

## 🎯 Status
✅ **File php.ini sudah diperbarui ke 100M**
✅ **Konfigurasi sudah benar**

## ⚠️ PENTING: RESTART HERD!

**Meskipun php.ini sudah diubah, perubahan TIDAK akan berlaku sampai Herd di-restart!**

## 🚀 Langkah-Langkah

### 1. Restart Laravel Herd

**Opsi A: Via Aplikasi**
1. Buka aplikasi **Laravel Herd** (cari di Start Menu atau System Tray)
2. Klik **"Stop"** atau ikon stop
3. Tunggu beberapa detik
4. Klik **"Start"** atau ikon play
5. Tunggu sampai status menunjukkan "Running"

**Opsi B: Via Command Line**
```powershell
herd restart
```

**Opsi C: Manual**
```powershell
herd stop
herd start
```

### 2. Verifikasi

Setelah restart, verifikasi dengan:

**Method 1: Script PowerShell**
```powershell
.\verify-herd-config.ps1
```

**Method 2: Browser**
```
http://127.0.0.1:8000/check-upload-config.php
```

**Method 3: Command Line**
```powershell
php -i | findstr "upload_max_filesize post_max_size"
```

Pastikan menunjukkan: **100M**

### 3. Clear Cache Laravel

```powershell
php artisan config:clear
php artisan cache:clear
php artisan optimize:clear
```

### 4. Test Upload

1. Login sebagai Guru
2. Coba upload file ~10MB
3. Pastikan tidak ada error

## 📋 File yang Sudah Diperbaiki

1. ✅ `C:\Users\atom\.config\herd-lite\bin\php.ini` - Sudah diubah ke 100M
2. ✅ `bootstrap/app.php` - Middleware IncreasePostSize ditambahkan
3. ✅ `app/Http/Middleware/IncreasePostSize.php` - Middleware dibuat
4. ✅ `app/Http/Controllers/MateriController.php` - Error handling diperbaiki
5. ✅ `resources/views/errors/upload-too-large.blade.php` - Error page dibuat

## 🔍 Troubleshooting

### Masalah: Masih error setelah restart

**Checklist:**
1. ✅ Apakah Herd benar-benar sudah di-restart?
2. ✅ Apakah konfigurasi sudah diverifikasi? (gunakan verify-herd-config.ps1)
3. ✅ Apakah cache Laravel sudah di-clear?
4. ✅ Apakah browser cache sudah di-clear?

**Debug:**
```powershell
# Cek nilai PHP aktif
php -r "echo 'upload_max_filesize: ' . ini_get('upload_max_filesize') . PHP_EOL;"
php -r "echo 'post_max_size: ' . ini_get('post_max_size') . PHP_EOL;"

# Cek log Laravel
tail -f storage/logs/laravel.log
```

### Masalah: Error "ValidatePostSize"

**Solusi:**
- Middleware `IncreasePostSize` sudah ditambahkan
- Pastikan Herd sudah di-restart
- Pastikan php.ini sudah diubah

### Masalah: File php.ini tidak ditemukan

**Solusi:**
- Pastikan menggunakan Laravel Herd
- Cek lokasi: `C:\Users\atom\.config\herd-lite\bin\php.ini`
- Atau cari dengan: `php --ini`

## ✅ Checklist Final

- [ ] File php.ini sudah diubah (100M)
- [ ] Herd sudah di-restart
- [ ] Konfigurasi sudah diverifikasi (100M)
- [ ] Cache Laravel sudah di-clear
- [ ] Upload file besar sudah berhasil di-test
- [ ] File check-upload-config.php dan phpinfo.php sudah dihapus (keamanan)

## 🎉 Selesai!

Setelah restart Herd, upload file besar sekarang sudah bisa dilakukan!

---

**JANGAN LUPA: RESTART HERD SEKARANG! 🚀**

