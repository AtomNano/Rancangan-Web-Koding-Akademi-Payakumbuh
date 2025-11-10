# 🚀 PANDUAN LENGKAP: Fix Upload File Besar

## 📋 Daftar Isi
1. [Masalah](#-masalah)
2. [Solusi Cepat](#-solusi-cepat)
3. [Script Otomatis](#-script-otomatis)
4. [Verifikasi](#-verifikasi)
5. [Troubleshooting](#-troubleshooting)

---

## ❌ Masalah

**Error yang muncul:**
```
Warning: PHP Request Startup: POST Content-Length of 9802335 bytes exceeds the limit of 8388608 bytes
The POST data is too large.
```

**Penyebab:**
- Batas upload PHP default: 8MB
- File yang diupload: ~10MB
- Perlu meningkatkan batasan upload

---

## ⚡ Solusi Cepat

### 🪟 Windows (XAMPP/WAMP) - METODE TERMUDAH

#### **Opsi 1: Gunakan Script PowerShell (Recommended)**

1. **Buka PowerShell sebagai Administrator**
   - Klik kanan PowerShell → Run as Administrator

2. **Jalankan script:**
   ```powershell
   cd "C:\Users\atom\Documents\GitHub\Rancangan-Web-Koding-Akademi-Payakumbuh\CodingAkademi"
   .\fix-upload-limits.ps1
   ```

3. **Script akan:**
   - Mencari file php.ini secara otomatis
   - Membuat backup otomatis
   - Mengubah semua setting yang diperlukan
   - Memberikan instruksi untuk restart Apache

4. **Restart Apache** dari XAMPP/WAMP Control Panel

#### **Opsi 2: Manual Edit php.ini**

1. **Buka file php.ini:**
   - XAMPP: `C:\xampp\php\php.ini`
   - WAMP: `C:\wamp\bin\php\phpX.X\php.ini`

2. **Cari (Ctrl+F) dan ubah:**
   ```ini
   upload_max_filesize = 8M
   ```
   Menjadi:
   ```ini
   upload_max_filesize = 100M
   ```

3. **Cari dan ubah:**
   ```ini
   post_max_size = 8M
   ```
   Menjadi:
   ```ini
   post_max_size = 100M
   ```

4. **Cari dan ubah:**
   ```ini
   max_execution_time = 30
   ```
   Menjadi:
   ```ini
   max_execution_time = 300
   ```

5. **Cari dan ubah:**
   ```ini
   memory_limit = 128M
   ```
   Menjadi:
   ```ini
   memory_limit = 256M
   ```

6. **SAVE** file php.ini

7. **RESTART Apache** dari Control Panel

---

### 🐧 Linux/Mac - METODE TERMUDAH

#### **Opsi 1: Gunakan Script Bash**

1. **Berikan permission:**
   ```bash
   chmod +x fix-upload-limits.sh
   ```

2. **Jalankan dengan sudo:**
   ```bash
   sudo ./fix-upload-limits.sh
   ```

3. **Restart web server:**
   ```bash
   # Apache
   sudo systemctl restart apache2
   
   # PHP-FPM + Nginx
   sudo systemctl restart php8.2-fpm
   sudo systemctl restart nginx
   ```

#### **Opsi 2: Manual Edit**

1. **Cari file php.ini:**
   ```bash
   php --ini
   ```

2. **Edit file yang ditampilkan:**
   ```bash
   sudo nano /etc/php/8.2/apache2/php.ini
   ```

3. **Ubah nilai yang sama seperti di Windows**

4. **Restart web server**

---

### 🌐 Shared Hosting (cPanel)

1. **Login ke cPanel**

2. **Buka "MultiPHP INI Editor"** atau **"Select PHP Version"**

3. **Pilih domain Anda**

4. **Edit nilai:**
   - `upload_max_filesize` = `100M`
   - `post_max_size` = `100M`
   - `max_execution_time` = `300`
   - `memory_limit` = `256M`

5. **Klik "Save"**

6. **Tunggu 1-2 menit** untuk apply

---

## 🔍 Verifikasi

### Method 1: Gunakan Script Check (Recommended)
Akses di browser:
```
http://localhost/check-upload-config.php
```
atau
```
http://your-domain/check-upload-config.php
```

### Method 2: Gunakan Route Laravel (Development Only)
Akses:
```
http://localhost/check-php-config
```

### Method 3: Gunakan phpinfo
Akses:
```
http://localhost/phpinfo.php
```

Cari dan pastikan:
- ✅ `upload_max_filesize` = **100M**
- ✅ `post_max_size` = **100M**
- ✅ `max_execution_time` = **300**
- ✅ `memory_limit` = **256M**

---

## 🛠️ Troubleshooting

### ❌ Masalah: Script PowerShell tidak bisa dijalankan

**Error:** "cannot be loaded because running scripts is disabled"

**Solusi:**
```powershell
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
```

Kemudian jalankan script lagi.

---

### ❌ Masalah: .htaccess tidak bekerja

**Penyebab:** 
- Apache tidak mengizinkan override
- Menggunakan PHP-FPM (tidak membaca .htaccess untuk PHP settings)

**Solusi:**
- **Edit php.ini langsung** (lebih reliable)
- Untuk PHP-FPM: Edit `/etc/php/8.x/fpm/php.ini`

---

### ❌ Masalah: File .user.ini tidak bekerja

**Penyebab:**
- File berada di folder yang salah
- Nama file salah
- Hosting tidak mendukung .user.ini

**Solusi:**
1. Pastikan file `.user.ini` berada di **ROOT** folder (bukan public)
2. Pastikan nama file benar: `.user.ini` (dengan titik di depan)
3. Tunggu beberapa menit untuk apply
4. Atau gunakan cPanel MultiPHP INI Editor

---

### ❌ Masalah: Masih error setelah perubahan

**Checklist:**
1. ✅ Apakah sudah **restart web server**?
2. ✅ Apakah perubahan sudah **apply**? (cek dengan phpinfo)
3. ✅ Apakah `post_max_size` >= `upload_max_filesize`?
4. ✅ Apakah sudah **clear browser cache**?
5. ✅ Apakah ada **konflik dengan konfigurasi lain**?

**Debug:**
```bash
# Cek nilai PHP saat ini
php -i | grep upload_max_filesize
php -i | grep post_max_size

# Cek error log
tail -f storage/logs/laravel.log
```

---

### ❌ Masalah: Error "413 Request Entity Too Large" (Nginx)

**Solusi:**
Edit file konfigurasi Nginx:
```bash
sudo nano /etc/nginx/nginx.conf
# atau
sudo nano /etc/nginx/sites-available/your-site
```

Tambahkan atau ubah:
```nginx
client_max_body_size 100M;
```

Restart Nginx:
```bash
sudo systemctl restart nginx
```

---

## 📝 File yang Tersedia

### Script Otomatis
- ✅ `fix-upload-limits.ps1` - Script PowerShell untuk Windows
- ✅ `fix-upload-limits.sh` - Script Bash untuk Linux/Mac

### Konfigurasi
- ✅ `public/.htaccess` - Konfigurasi Apache
- ✅ `.user.ini` - Konfigurasi untuk shared hosting (root)
- ✅ `public/.user.ini` - Konfigurasi alternatif (public)

### Tools Check
- ✅ `public/check-upload-config.php` - Script check konfigurasi
- ✅ `public/phpinfo.php` - Script phpinfo
- ✅ Route `/check-php-config` - API endpoint untuk check (dev only)

### Dokumentasi
- ✅ `FIX_UPLOAD.md` - Dokumentasi lengkap
- ✅ `QUICK_FIX.md` - Quick reference
- ✅ `README_UPLOAD_FIX.md` - Panduan ini

---

## 🚨 PENTING: Keamanan

**HAPUS file berikut setelah selesai:**
- ❌ `public/check-upload-config.php`
- ❌ `public/phpinfo.php`

**Cara menghapus:**
```bash
# Windows (PowerShell)
Remove-Item public\check-upload-config.php
Remove-Item public\phpinfo.php

# Linux/Mac
rm public/check-upload-config.php
rm public/phpinfo.php
```

---

## ✅ Setelah Berhasil

1. **Test upload file:**
   - Upload file ~10MB
   - Pastikan tidak ada error
   - Pastikan file terupload dengan benar

2. **Monitor storage:**
   - Pastikan server memiliki storage yang cukup
   - Pertimbangkan cleanup file lama secara berkala

3. **Update dokumentasi:**
   - Catat perubahan yang dilakukan
   - Dokumentasikan untuk tim

---

## 🆘 Masih Butuh Bantuan?

1. **Cek log error:**
   ```
   storage/logs/laravel.log
   ```

2. **Cek konfigurasi PHP:**
   ```
   http://your-domain/check-upload-config.php
   ```

3. **Hubungi provider hosting** (jika shared hosting)

4. **Cek dokumentasi:**
   - `FIX_UPLOAD.md` - Panduan lengkap
   - `QUICK_FIX.md` - Quick reference

---

## 📞 Quick Commands

### Windows
```powershell
# Jalankan script fix
.\fix-upload-limits.ps1

# Check PHP config
php -i | findstr upload_max_filesize
php -i | findstr post_max_size

# Restart Apache (XAMPP)
# Gunakan XAMPP Control Panel
```

### Linux/Mac
```bash
# Jalankan script fix
sudo ./fix-upload-limits.sh

# Check PHP config
php -i | grep upload_max_filesize
php -i | grep post_max_size

# Restart Apache
sudo systemctl restart apache2

# Restart PHP-FPM + Nginx
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx
```

---

**Selamat! Upload file besar sekarang sudah bisa dilakukan! 🎉**

