# 🚀 Fix Upload File Besar untuk Laravel Herd

## ❌ Masalah
Error: "POST Content-Length exceeds the limit" saat menggunakan Laravel Herd
- File php.ini: `C:\Users\atom\.config\herd-lite\bin\php.ini`
- Batas saat ini: upload_max_filesize = 2M, post_max_size = 8M

## ✅ Solusi untuk Laravel Herd

### METODE 1: Otomatis (Recommended)

1. **Jalankan script PowerShell:**
   ```powershell
   .\fix-herd-upload.ps1
   ```

2. **Restart Laravel Herd:**
   - Buka aplikasi Laravel Herd
   - Klik "Stop"
   - Klik "Start"
   - Atau jalankan: `herd restart`

3. **Verifikasi:**
   - Akses: `http://127.0.0.1:8000/check-upload-config.php`
   - Atau: `http://127.0.0.1:8000/check-php-config`

### METODE 2: Manual

1. **Buka file php.ini:**
   ```
   C:\Users\atom\.config\herd-lite\bin\php.ini
   ```

2. **Tambahkan atau ubah setting berikut:**
   ```ini
   upload_max_filesize = 100M
   post_max_size = 100M
   max_execution_time = 300
   max_input_time = 300
   memory_limit = 256M
   max_file_uploads = 20
   ```

3. **Save file**

4. **Restart Laravel Herd** (wajib!)

5. **Verifikasi perubahan**

## 🔍 Verifikasi

Setelah restart Herd, cek dengan:

### Method 1: Browser
```
http://127.0.0.1:8000/check-upload-config.php
```

### Method 2: Command Line
```powershell
php -i | findstr "upload_max_filesize post_max_size"
```

### Method 3: Laravel Route
```
http://127.0.0.1:8000/check-php-config
```

Pastikan:
- ✅ `upload_max_filesize` = 100M
- ✅ `post_max_size` = 100M

## ⚠️ PENTING

1. **WAJIB restart Herd** setelah mengubah php.ini
2. **Herd menggunakan PHP CLI**, jadi perubahan di php.ini langsung berlaku
3. **Tidak perlu restart Apache** (karena menggunakan built-in PHP server)

## 🆘 Troubleshooting

### Masalah: Perubahan tidak apply

**Solusi:**
1. Pastikan file php.ini yang benar sudah diubah
2. Pastikan Herd sudah di-restart
3. Cek dengan `php -i` untuk memastikan perubahan

### Masalah: Masih error setelah restart

**Solusi:**
1. Pastikan tidak ada cache: `php artisan config:clear`
2. Pastikan tidak ada cache opcache: `php artisan optimize:clear`
3. Cek dengan `phpinfo()` untuk memastikan nilai yang aktif

### Masalah: Error "ValidatePostSize"

**Solusi:**
- Middleware `IncreasePostSize` sudah ditambahkan
- Pastikan Herd sudah di-restart
- Pastikan php.ini sudah diubah

## ✅ Checklist

- [ ] File php.ini sudah diubah
- [ ] Herd sudah di-restart
- [ ] Konfigurasi sudah diverifikasi
- [ ] Upload file besar sudah berhasil
- [ ] File check-upload-config.php sudah dihapus (keamanan)

---

**Setelah selesai, upload file besar sekarang sudah bisa dilakukan! 🎉**

