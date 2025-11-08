# Konfigurasi Upload File Besar

## Masalah
Error: "POST Content-Length exceeds the limit" saat mengupload file besar.

## Solusi yang Telah Diterapkan

### 1. File .htaccess (public/.htaccess)
Konfigurasi untuk meningkatkan batasan upload telah ditambahkan:
- `upload_max_filesize = 100M`
- `post_max_size = 100M`
- `max_execution_time = 300`
- `max_input_time = 300`
- `memory_limit = 256M`

### 2. Controller Validation (app/Http/Controllers/MateriController.php)
Batas validasi file telah ditingkatkan dari 10MB menjadi 100MB:
- Create: `max:102400` (100MB dalam KB)
- Update: `max:102400` (100MB dalam KB)

### 3. View Messages
Pesan di form telah diperbarui untuk menunjukkan batas 100MB.

## Jika Masih Mengalami Masalah

### Untuk Development (XAMPP/WAMP/Local)
1. Edit file `php.ini` di folder PHP installation
2. Cari dan ubah nilai berikut:
   ```ini
   upload_max_filesize = 100M
   post_max_size = 100M
   max_execution_time = 300
   max_input_time = 300
   memory_limit = 256M
   ```
3. Restart Apache/server

### Untuk Production (Shared Hosting)
1. Buat file `.user.ini` di root public_html (jika menggunakan cPanel)
2. Tambahkan konfigurasi:
   ```ini
   upload_max_filesize = 100M
   post_max_size = 100M
   max_execution_time = 300
   max_input_time = 300
   memory_limit = 256M
   ```
3. Atau hubungi provider hosting untuk meningkatkan batasan

### Untuk VPS/Server
1. Edit `/etc/php/8.x/apache2/php.ini` (sesuaikan versi PHP)
2. Edit `/etc/php/8.x/fpm/php.ini` (jika menggunakan PHP-FPM)
3. Restart web server:
   ```bash
   sudo systemctl restart apache2
   # atau
   sudo systemctl restart php8.x-fpm
   sudo systemctl restart nginx
   ```

## Catatan
- Pastikan `post_max_size` selalu lebih besar dari `upload_max_filesize`
- Untuk file yang lebih besar dari 100MB, sesuaikan nilai-nilai di atas
- Pastikan server memiliki storage yang cukup untuk file yang diupload
- Pertimbangkan menggunakan chunked upload untuk file yang sangat besar (>500MB)

