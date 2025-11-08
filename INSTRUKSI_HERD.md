# 🚨 INSTRUKSI PENTING: Restart Herd untuk Fix Upload

## ✅ Yang Sudah Dilakukan

1. ✅ File `php.ini` sudah diperbarui:
   - Lokasi: `C:\Users\atom\.config\herd-lite\bin\php.ini`
   - `upload_max_filesize = 100M`
   - `post_max_size = 100M`

2. ✅ Middleware Laravel sudah ditambahkan
3. ✅ Error handling sudah diperbaiki
4. ✅ Cache Laravel sudah di-clear

## ⚠️ YANG PERLU ANDA LAKUKAN SEKARANG

### RESTART LARAVEL HERD!

**Perubahan di php.ini TIDAK akan berlaku sampai Herd di-restart!**

### Cara Restart:

**Opsi 1: Via Aplikasi (Termudah)**
1. Buka aplikasi **Laravel Herd** (di Start Menu)
2. Klik tombol **"Stop"** atau ikon stop
3. Tunggu 5 detik
4. Klik tombol **"Start"** atau ikon play
5. Tunggu sampai status "Running"

**Opsi 2: Via Command Line**
```powershell
herd restart
```

**Opsi 3: Manual**
```powershell
herd stop
# Tunggu beberapa detik
herd start
```

## 🔍 Verifikasi Setelah Restart

### 1. Cek dengan Script
```powershell
.\verify-herd-config.ps1
```

### 2. Cek di Browser
```
http://127.0.0.1:8000/check-upload-config.php
```

### 3. Test Upload
1. Login sebagai Guru
2. Upload file ~10MB
3. Pastikan tidak ada error

## ✅ Jika Berhasil

Anda akan melihat:
- ✅ Upload file besar berhasil
- ✅ Tidak ada error "POST data is too large"
- ✅ File terupload dengan benar

## ❌ Jika Masih Error

1. **Pastikan Herd benar-benar sudah restart**
2. **Cek konfigurasi:**
   ```powershell
   php -i | findstr "upload_max_filesize post_max_size"
   ```
   Harus menunjukkan: **100M**

3. **Clear cache lagi:**
   ```powershell
   php artisan config:clear
   php artisan cache:clear
   ```

4. **Restart ulang Herd**

---

## 📝 Ringkasan

1. ✅ php.ini sudah diubah → **DONE**
2. ⚠️ **RESTART HERD** → **YANG PERLU ANDA LAKUKAN**
3. ✅ Verifikasi → Setelah restart
4. ✅ Test upload → Setelah verifikasi

---

**RESTART HERD SEKARANG! 🚀**

Setelah restart, upload file besar akan berfungsi dengan baik!

