# Panduan Setup Cloudflare Turnstile CAPTCHA

Aplikasi ini menggunakan Cloudflare Turnstile untuk meningkatkan keamanan pada halaman login. Berikut adalah panduan untuk mengatur Turnstile.

## Langkah-langkah Setup

### 1. Daftar di Cloudflare Turnstile

1. Kunjungi [Cloudflare Dashboard](https://dash.cloudflare.com/)
2. Masuk ke akun Cloudflare Anda (atau buat akun baru jika belum punya)
3. Pilih domain Anda atau gunakan akun Cloudflare gratis
4. Navigasi ke **Security** > **Turnstile**
5. Klik **Add Site** untuk membuat site key baru

### 2. Konfigurasi Site

- **Site Name**: Beri nama untuk site Anda (contoh: "Materi Online Login")
- **Domain**: Masukkan domain Anda (untuk development, bisa gunakan `localhost` atau `127.0.0.1`)
- **Widget Mode**: Pilih **Managed** (recommended) atau **Non-interactive**
- **Pre-Clearance**: Optional, bisa diaktifkan untuk pengalaman pengguna yang lebih baik

### 3. Dapatkan Site Key dan Secret Key

Setelah membuat site, Anda akan mendapatkan:
- **Site Key** (Public Key) - untuk digunakan di frontend
- **Secret Key** (Private Key) - untuk digunakan di backend

### 4. Konfigurasi di Aplikasi

Tambahkan kunci-kunci berikut ke file `.env` Anda:

```env
TURNSTILE_ENABLED=true
TURNSTILE_SITE_KEY=your_site_key_here
TURNSTILE_SECRET_KEY=your_secret_key_here
```

Set `TURNSTILE_ENABLED=false` bila Anda ingin menonaktifkan Turnstile secara sementara (misalnya saat mengembangkan di localhost tanpa akses internet). Nilai default-nya adalah `true`.

### 5. Verifikasi Instalasi

1. Pastikan file `.env` sudah dikonfigurasi dengan benar
2. Clear config cache jika perlu:
   ```bash
   php artisan config:clear
   ```
3. Buka halaman login di browser
4. Anda seharusnya melihat widget Turnstile CAPTCHA di form login

## Catatan Penting

- **Development**: Untuk development lokal, pastikan domain di Turnstile mencakup `localhost` atau `127.0.0.1`
- **Production**: Pastikan domain production Anda sudah terdaftar di Turnstile
- **Keamanan**: Jangan pernah commit file `.env` ke repository. Secret Key harus tetap rahasia.

## Troubleshooting

### CAPTCHA tidak muncul
- Pastikan `TURNSTILE_ENABLED` diset ke `true`
- Pastikan `TURNSTILE_SITE_KEY` sudah diisi di file `.env`
- Clear config cache: `php artisan config:clear`
- Periksa console browser untuk error JavaScript

### Verifikasi selalu gagal
- Jika di development, Anda bisa memakai demo keys dari Cloudflare:
  ```env
  TURNSTILE_ENABLED=true
  TURNSTILE_SITE_KEY=1x00000000000000000000AA
  TURNSTILE_SECRET_KEY=1x0000000000000000000000000000000AA
  ```
- Pastikan `TURNSTILE_SECRET_KEY` sudah benar
- Pastikan domain yang digunakan sudah terdaftar di Turnstile dashboard
- Periksa log Laravel untuk detail error

### Widget tidak terlihat
- Pastikan script Turnstile sudah ter-load (cek Network tab di browser)
- Pastikan tidak ada ad blocker yang memblokir Cloudflare
- Cek apakah ada error JavaScript di console browser

## Informasi Tambahan

- Dokumentasi resmi: [Cloudflare Turnstile Docs](https://developers.cloudflare.com/turnstile/)
- Turnstile gratis untuk digunakan dan tidak memerlukan biaya
- Lebih ramah privasi dibandingkan reCAPTCHA karena tidak melacak pengguna

