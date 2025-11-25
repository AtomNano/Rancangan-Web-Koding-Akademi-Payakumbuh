# ⚡ QUICK FIX - Upload File Besar

## 🎯 Masalah
Error: "POST Content-Length exceeds the limit of 8388608 bytes"
File ~10MB tidak bisa diupload karena batas hanya 8MB.

## 🚀 SOLUSI CEPAT

### Untuk XAMPP/WAMP (Windows Local Development)

1. **Buka file php.ini**:
   - XAMPP: `C:\xampp\php\php.ini`
   - WAMP: `C:\wamp\bin\php\phpX.X\php.ini`

2. **Cari dan ubah** (gunakan Ctrl+F):
   ```
   upload_max_filesize = 8M
   ```
   Ubah menjadi:
   ```
   upload_max_filesize = 100M
   ```

3. **Cari dan ubah**:
   ```
   post_max_size = 8M
   ```
   Ubah menjadi:
   ```
   post_max_size = 100M
   ```

4. **Cari dan ubah**:
   ```
   max_execution_time = 30
   ```
   Ubah menjadi:
   ```
   max_execution_time = 300
   ```

5. **Cari dan ubah**:
   ```
   memory_limit = 128M
   ```
   Ubah menjadi:
   ```
   memory_limit = 256M
   ```

6. **SAVE file php.ini**

7. **RESTART Apache** dari XAMPP/WAMP Control Panel

8. **Test**: Akses `http://localhost/check-upload-config.php`

### Untuk Shared Hosting (cPanel)

1. **Login ke cPanel**

2. **Buka "MultiPHP INI Editor"** atau **"Select PHP Version"**

3. **Pilih domain/website Anda**

4. **Edit nilai-nilai berikut**:
   - `upload_max_filesize` = `100M`
   - `post_max_size` = `100M`
   - `max_execution_time` = `300`
   - `memory_limit` = `256M`

5. **Klik "Save"**

6. **Tunggu 1-2 menit** untuk apply

7. **Test**: Akses `http://your-domain/check-upload-config.php`

### Alternatif: File .user.ini (Shared Hosting)

1. **Buat file `.user.ini`** di root folder aplikasi (bukan public)

2. **Isi dengan**:
   ```ini
   upload_max_filesize = 100M
   post_max_size = 100M
   max_execution_time = 300
   max_input_time = 300
   memory_limit = 256M
   ```

3. **Upload ke server** (pastikan nama file `.user.ini` dengan titik di depan)

4. **Tunggu beberapa menit** untuk apply

## ✅ Verifikasi

Setelah perubahan, cek dengan:
- `http://your-domain/check-upload-config.php`
- `http://your-domain/phpinfo.php`

Pastikan:
- ✅ `upload_max_filesize` = 100M
- ✅ `post_max_size` = 100M
- ✅ `max_execution_time` = 300

## ⚠️ PENTING

1. **Pastikan restart web server** setelah edit php.ini
2. **Pastikan `post_max_size` >= `upload_max_filesize`**
3. **Hapus file `check-upload-config.php` dan `phpinfo.php` setelah selesai** (keamanan)

## 🆘 Masih Error?

1. Cek apakah perubahan sudah apply dengan `phpinfo.php`
2. Pastikan restart web server
3. Clear browser cache
4. Coba upload file kecil dulu untuk test
5. Cek error log: `storage/logs/laravel.log`

