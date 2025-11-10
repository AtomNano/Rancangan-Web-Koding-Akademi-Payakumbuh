# SOLUSI MASALAH UPLOAD FILE BESAR

## ❌ Masalah
Error: "POST Content-Length exceeds the limit" saat upload file ~10MB
- Batas saat ini: 8MB (8388608 bytes)
- File yang diupload: ~10MB (9802335 bytes)

## ✅ Solusi Langkah demi Langkah

### OPSI 1: Untuk Development Local (XAMPP/WAMP/MAMP)

#### Step 1: Edit php.ini
1. Buka file `php.ini` di folder instalasi PHP
   - XAMPP: `C:\xampp\php\php.ini`
   - WAMP: `C:\wamp\bin\php\phpX.X\php.ini`
   - MAMP: `/Applications/MAMP/bin/php/phpX.X.X/conf/php.ini`

2. Cari dan ubah nilai berikut:
```ini
upload_max_filesize = 100M
post_max_size = 100M
max_execution_time = 300
max_input_time = 300
memory_limit = 256M
```

3. **PENTING**: Pastikan `post_max_size` >= `upload_max_filesize`

4. **Restart Apache/Web Server**

#### Step 2: Verifikasi
Akses: `http://localhost/check-upload-config.php` atau `http://localhost/phpinfo.php`
Pastikan semua nilai sudah berubah menjadi 100M.

---

### OPSI 2: Untuk Shared Hosting (cPanel, Plesk, dll)

#### Step 1: Buat file .user.ini
1. Buat file bernama `.user.ini` (dengan titik di depan)
2. Letakkan di **ROOT** folder aplikasi Laravel (bukan di public)
3. Isi dengan:
```ini
upload_max_filesize = 100M
post_max_size = 100M
max_execution_time = 300
max_input_time = 300
memory_limit = 256M
```

#### Step 2: Atau gunakan MultiPHP INI Editor (cPanel)
1. Login ke cPanel
2. Buka "MultiPHP INI Editor"
3. Pilih domain/website
4. Edit nilai-nilai tersebut
5. Save

#### Step 3: Verifikasi
Akses: `http://your-domain/check-upload-config.php`

---

### OPSI 3: Untuk VPS/Server (Ubuntu/Debian)

#### Step 1: Edit php.ini untuk Apache
```bash
sudo nano /etc/php/8.2/apache2/php.ini
# atau
sudo nano /etc/php/8.1/apache2/php.ini
```

#### Step 2: Edit php.ini untuk PHP-FPM (jika menggunakan Nginx)
```bash
sudo nano /etc/php/8.2/fpm/php.ini
# atau
sudo nano /etc/php/8.1/fpm/php.ini
```

#### Step 3: Ubah nilai
Cari dan ubah:
```ini
upload_max_filesize = 100M
post_max_size = 100M
max_execution_time = 300
max_input_time = 300
memory_limit = 256M
```

#### Step 4: Restart Service
```bash
# Untuk Apache
sudo systemctl restart apache2

# Untuk PHP-FPM + Nginx
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx
```

---

### OPSI 4: Untuk Windows Server (IIS)

#### Step 1: Edit php.ini
1. Cari lokasi php.ini:
```bash
php --ini
```

2. Edit file php.ini yang ditampilkan

3. Ubah nilai:
```ini
upload_max_filesize = 100M
post_max_size = 100M
max_execution_time = 300
max_input_time = 300
memory_limit = 256M
```

#### Step 2: Edit web.config (jika ada)
Tambahkan di `web.config`:
```xml
<system.webServer>
    <security>
        <requestFiltering>
            <requestLimits maxAllowedContentLength="104857600" />
        </requestFiltering>
    </security>
</system.webServer>
```

#### Step 3: Restart IIS
```bash
iisreset
```

---

## 🔍 Cara Mengecek Konfigurasi

### Method 1: Gunakan Script Check
Akses: `http://your-domain/check-upload-config.php`

### Method 2: Gunakan phpinfo
Akses: `http://your-domain/phpinfo.php`
Cari:
- `upload_max_filesize`
- `post_max_size`

### Method 3: Via Terminal
```bash
php -i | grep upload_max_filesize
php -i | grep post_max_size
```

---

## ⚠️ Troubleshooting

### Problem: .htaccess tidak bekerja
**Solusi**: 
- Pastikan Apache mengizinkan override: `AllowOverride All` di httpd.conf
- Atau edit php.ini langsung (lebih reliable)

### Problem: File .user.ini tidak bekerja
**Solusi**:
- Pastikan file berada di root (bukan public)
- Pastikan nama file benar: `.user.ini` (dengan titik)
- Beberapa hosting memerlukan waktu beberapa menit untuk apply

### Problem: Masih error setelah perubahan
**Solusi**:
1. Pastikan restart web server
2. Clear cache browser
3. Cek apakah perubahan sudah apply dengan phpinfo
4. Pastikan tidak ada konflik dengan konfigurasi lain

### Problem: Error "413 Request Entity Too Large" (Nginx)
**Solusi**: Edit `/etc/nginx/nginx.conf` atau file konfigurasi site:
```nginx
client_max_body_size 100M;
```
Kemudian restart Nginx:
```bash
sudo systemctl restart nginx
```

---

## 📝 File yang Sudah Dibuat

1. ✅ `public/.htaccess` - Konfigurasi untuk Apache
2. ✅ `public/.user.ini` - Konfigurasi untuk shared hosting (di public)
3. ✅ `.user.ini` - Konfigurasi untuk shared hosting (di root)
4. ✅ `public/check-upload-config.php` - Script untuk mengecek konfigurasi
5. ✅ `public/phpinfo.php` - Script untuk melihat info PHP
6. ✅ `app/Http/Controllers/MateriController.php` - Error handling yang lebih baik

---

## 🚀 Setelah Selesai

1. **HAPUS file berikut untuk keamanan**:
   - `public/check-upload-config.php`
   - `public/phpinfo.php`

2. **Test upload file**:
   - Coba upload file ~10MB
   - Pastikan tidak ada error
   - Pastikan file terupload dengan benar

3. **Monitor storage**:
   - Pastikan server memiliki storage yang cukup
   - Pertimbangkan cleanup file lama secara berkala

---

## 📞 Butuh Bantuan?

Jika masih mengalami masalah:
1. Cek log error: `storage/logs/laravel.log`
2. Cek konfigurasi PHP dengan `phpinfo.php`
3. Hubungi provider hosting jika menggunakan shared hosting
4. Pastikan semua file konfigurasi sudah di-apply dengan benar

