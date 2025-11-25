# Setup Google OAuth untuk Login dengan Google

## Langkah-langkah Setup

### 1. Buat Google OAuth Credentials

1. Buka [Google Cloud Console](https://console.cloud.google.com/)
2. Pilih atau buat project baru
3. Buka **APIs & Services** > **Credentials**
4. Klik **Create Credentials** > **OAuth client ID**
5. Jika diminta, konfigurasi OAuth consent screen terlebih dahulu:
   - Pilih **External** (untuk testing) atau **Internal** (untuk G Suite)
   - Isi informasi aplikasi
   - Tambahkan scope: `email`, `profile`
6. Buat OAuth Client ID:
   - Application type: **Web application**
   - Name: Coding Academy Payakumbuh (atau nama aplikasi Anda)
   - Authorized redirect URIs: 
     ```
     http://localhost:8000/auth/google/callback  (untuk local)
     https://yourdomain.com/auth/google/callback  (untuk production)
     ```
7. Copy **Client ID** dan **Client Secret**

### 2. Setup Environment Variables

Tambahkan ke file `.env`:

```env
GOOGLE_CLIENT_ID=your-google-client-id-here
GOOGLE_CLIENT_SECRET=your-google-client-secret-here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback

# Untuk mengatasi SSL error di Windows (hanya development)
# CURL_VERIFY_SSL=false
```

Untuk production, ganti dengan URL domain Anda:
```env
GOOGLE_REDIRECT_URI=https://yourdomain.com/auth/google/callback
```

### 3. Clear Config Cache

```bash
php artisan config:clear
```

## Cara Kerja

### Untuk User yang Sudah Terdaftar
1. User klik "Masuk dengan Google"
2. Redirect ke Google untuk autentikasi
3. Google mengembalikan data user (email, nama)
4. Sistem mencari user berdasarkan email
5. Jika ditemukan, user langsung login
6. Redirect ke dashboard sesuai role

### Untuk User Baru
1. User klik "Masuk dengan Google"
2. Redirect ke Google untuk autentikasi
3. Google mengembalikan data user (email, nama)
4. Sistem tidak menemukan user dengan email tersebut
5. Sistem membuat user baru dengan:
   - Nama dari Google
   - Email dari Google
   - Role: `siswa` (default)
   - Password: random (tidak akan digunakan)
   - Data lainnya: kosong (dilengkapi oleh admin atau user sendiri)
6. User langsung login
7. Redirect ke dashboard siswa dengan pesan info

## Data yang Diperlukan

Saat login dengan Google, hanya data dasar yang diambil:
- ✅ Nama (name)
- ✅ Email

Data yang perlu dilengkapi oleh admin atau user:
- No. Telepon
- Tanggal Lahir
- Jenis Kelamin
- Alamat Lengkap
- Sekolah
- Kelas Sekolah
- Bidang Ajar (Kelas)
- Durasi Program
- Hari Belajar
- Metode Pembayaran
- dll.

## Catatan Penting

1. **User baru dari Google** akan otomatis dibuat sebagai **siswa** dengan status **tidak aktif** (karena belum ada enrollment)
2. Admin perlu melengkapi data siswa dan mengaktifkannya
3. User bisa login dengan Google, tapi tidak bisa akses sistem sampai admin mengaktifkan dan melengkapi datanya
4. Jika user sudah terdaftar dengan email yang sama, login dengan Google akan langsung masuk (tidak membuat duplikat)

## Troubleshooting

### Error: "cURL error 60: SSL peer certificate or SSH remote key was not OK"

**Ini adalah masalah SSL certificate verification, biasanya terjadi di Windows.**

**Solusi 1: Disable SSL Verification (Hanya untuk Development)**
   - Tambahkan ke file `.env`:
     ```env
     CURL_VERIFY_SSL=false
     ```
   - Jalankan: `php artisan config:clear`
   - **PENTING**: Jangan gunakan ini di production!

**Solusi 2: Download CA Bundle (Recommended)**
   1. Download CA bundle dari: https://curl.se/ca/cacert.pem
   2. Simpan di: `storage/cacert.pem`
   3. Sistem akan otomatis menggunakan file ini untuk verify SSL

**Solusi 3: Update cURL di Windows**
   1. Download cURL terbaru dari: https://curl.se/windows/
   2. Extract dan copy `curl-ca-bundle.crt` ke folder PHP
   3. Update `php.ini`:
     ```ini
     curl.cainfo = "C:\path\to\php\curl-ca-bundle.crt"
     ```
   4. Restart web server

### Error: "Terjadi kesalahan saat login dengan Google"

**1. Cek Konfigurasi OAuth**
   - Buka: `http://localhost:8000/check-google-oauth` (hanya di local)
   - Pastikan `google_oauth_configured` bernilai `true`
   - Pastikan `client_id_set` dan `client_secret_set` bernilai `true`

**2. Cek File .env**
   ```env
   GOOGLE_CLIENT_ID=your-client-id-here
   GOOGLE_CLIENT_SECRET=your-client-secret-here
   GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
   ```
   - Pastikan tidak ada spasi sebelum/sesudah `=`
   - Pastikan tidak ada tanda kutip di sekitar nilai
   - Setelah mengubah `.env`, jalankan: `php artisan config:clear`

**3. Cek Google Cloud Console**
   - Pastikan OAuth Client ID sudah dibuat
   - Pastikan redirect URI sudah ditambahkan di Google Console
   - Redirect URI harus sama persis dengan yang di `.env`

**4. Cek Log Laravel**
   - Buka: `storage/logs/laravel.log`
   - Cari error terkait "Google OAuth"
   - Error akan menunjukkan masalah spesifik

### Error: "Invalid credentials"
- Pastikan Client ID dan Client Secret sudah benar di `.env`
- Pastikan redirect URI sudah sesuai dengan yang didaftarkan di Google Console
- Jalankan: `php artisan config:clear` setelah mengubah `.env`

### Error: "Redirect URI mismatch"
- Pastikan redirect URI di `.env` sama persis dengan yang didaftarkan di Google Console
- Perhatikan `http` vs `https` dan `localhost` vs domain
- Contoh yang benar:
  - Local: `http://localhost:8000/auth/google/callback`
  - Production: `https://yourdomain.com/auth/google/callback`

### Error: "Sesi login dengan Google telah berakhir"
- User membatalkan proses login di Google
- Sesi OAuth expired
- Solusi: Coba login lagi dengan Google

### Error: "Login dengan Google belum dikonfigurasi"
- Google OAuth credentials belum di-setup
- Pastikan `GOOGLE_CLIENT_ID` dan `GOOGLE_CLIENT_SECRET` sudah di `.env`
- Jalankan: `php artisan config:clear`

### User tidak bisa login setelah login dengan Google
- Cek apakah user sudah diaktifkan oleh admin
- Cek apakah user sudah memiliki enrollment dengan status 'active'
- User baru dari Google akan otomatis dibuat sebagai siswa tidak aktif

### Debugging Tips

1. **Cek Konfigurasi**
   ```bash
   php artisan tinker
   >>> config('services.google.client_id')
   >>> config('services.google.client_secret')
   >>> config('services.google.redirect')
   ```

2. **Cek Log**
   ```bash
   tail -f storage/logs/laravel.log
   ```

3. **Test OAuth Flow**
   - Pastikan bisa akses: `http://localhost:8000/auth/google`
   - Harus redirect ke Google login page
   - Setelah login, harus redirect kembali ke callback

