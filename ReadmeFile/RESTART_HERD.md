# 🚨 PENTING: Restart Laravel Herd!

## ✅ Perubahan Sudah Dilakukan

File `php.ini` sudah diperbarui:
- Lokasi: `C:\Users\atom\.config\herd-lite\bin\php.ini`
- Setting sudah diubah ke 100M

## ⚠️ TAPI: Perlu Restart Herd!

**Perubahan di php.ini TIDAK akan berlaku sampai Herd di-restart!**

## 🚀 Cara Restart Herd

### Opsi 1: Via Aplikasi Herd
1. **Buka aplikasi Laravel Herd** (di system tray atau Start Menu)
2. **Klik "Stop"** atau ikon stop
3. **Tunggu beberapa detik**
4. **Klik "Start"** atau ikon play
5. **Tunggu sampai status "Running"**

### Opsi 2: Via Command Line
```powershell
herd restart
```

### Opsi 3: Manual Restart
1. **Stop Herd:**
   ```powershell
   herd stop
   ```

2. **Start Herd:**
   ```powershell
   herd start
   ```

## 🔍 Verifikasi Setelah Restart

1. **Cek konfigurasi PHP:**
   ```powershell
   php -i | findstr "upload_max_filesize post_max_size"
   ```
   Harus menunjukkan: `100M`

2. **Atau akses di browser:**
   ```
   http://127.0.0.1:8000/check-upload-config.php
   ```
   Atau:
   ```
   http://127.0.0.1:8000/check-php-config
   ```

3. **Test upload file:**
   - Coba upload file ~10MB
   - Pastikan tidak ada error

## ❌ Jika Masih Error Setelah Restart

1. **Pastikan Herd benar-benar sudah restart:**
   - Tutup semua terminal yang menjalankan `php artisan serve`
   - Stop Herd
   - Start Herd lagi

2. **Clear cache Laravel:**
   ```powershell
   php artisan config:clear
   php artisan cache:clear
   php artisan optimize:clear
   ```

3. **Cek file php.ini:**
   - Pastikan file `C:\Users\atom\.config\herd-lite\bin\php.ini` sudah berisi:
     ```ini
     upload_max_filesize = 100M
     post_max_size = 100M
     ```

4. **Cek dengan phpinfo:**
   - Akses: `http://127.0.0.1:8000/phpinfo.php`
   - Cari `upload_max_filesize` dan `post_max_size`
   - Pastikan nilai = 100M

## 📝 Checklist

- [ ] File php.ini sudah diubah
- [ ] Herd sudah di-restart
- [ ] Konfigurasi sudah diverifikasi (100M)
- [ ] Upload file besar sudah berhasil
- [ ] File check-upload-config.php dan phpinfo.php sudah dihapus

---

**RESTART HERD SEKARANG untuk menerapkan perubahan! 🚀**

