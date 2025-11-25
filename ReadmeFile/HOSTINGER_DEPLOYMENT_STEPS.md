# Langkah-Langkah Deployment ke Hostinger (Setelah .env Siap)

Panduan lengkap step-by-step deployment Laravel ke Hostinger Shared Hosting menggunakan Git.

---

## 📋 Prasyarat

Sebelum mulai, pastikan:
- [ ] `.env` sudah dikonfigurasi dengan benar (lihat `HOSTINGER_ENV_CONFIG.md`)
- [ ] Database sudah dibuat di hPanel Hostinger
- [ ] SSH Access sudah diaktifkan di hPanel
- [ ] Repository sudah ada di GitHub
- [ ] Git sudah terinstall di komputer lokal

---

## 🚀 FASE 1: Persiapan di Komputer Lokal

### Step 1: Build Assets (WAJIB!)

Karena Hostinger Shared Hosting tidak bisa build assets (RAM terbatas), kita harus build di lokal dulu.

```bash
# Pastikan kamu di root folder project
cd D:\github\semester5\Rancangan-Web-Koding-Akademi-Payakumbuh

# Install dependencies (jika belum)
npm install

# Build assets untuk production
npm run build
```

**Verifikasi:**
- Cek folder `public/build` sudah ada isinya
- File `public/build/manifest.json` harus ada
- File CSS dan JS harus ada di `public/build/assets/`

### Step 2: Verifikasi .gitignore

Pastikan `public/build` **TIDAK** di-ignore (agar hasil build ikut ter-commit).

```bash
# Buka .gitignore dan pastikan TIDAK ada baris:
# /public/build
# atau
# public/build
```

✅ **Status saat ini:** `.gitignore` sudah benar, `public/build` tidak di-ignore.

### Step 3: Commit dan Push ke GitHub

```bash
# Cek status git
git status

# Add semua perubahan (termasuk public/build)
git add .

# Commit
git commit -m "Ready for Hostinger deployment: include build assets"

# Push ke GitHub
git push origin main
```

**Verifikasi:**
- Buka GitHub repository kamu
- Pastikan folder `public/build` ada di repository
- Pastikan file `.env` **TIDAK** ada di repository (sudah di-ignore)

---

## 🔐 FASE 2: Setup SSH Access di Hostinger

### Step 4: Aktifkan SSH di hPanel

1. Login ke **hPanel Hostinger**
2. Buka **Advanced** → **SSH Access**
3. Klik **Enable SSH** (jika belum aktif)
4. **Catat informasi berikut:**
   - **IP Address:** `xxx.xxx.xxx.xxx`
   - **Port:** `65002` (biasanya)
   - **Username:** `u1234567` (contoh)
   - **Password:** `password_ssh_kamu`

### Step 5: Test Koneksi SSH

**Windows (PowerShell atau Git Bash):**
```bash
ssh -p 65002 u1234567@ip-server-kamu
```

**Masukkan password saat diminta** (ketikan tidak akan muncul di layar, itu normal).

Jika berhasil, kamu akan masuk ke terminal server Hostinger.

---

## 📥 FASE 3: Clone Repository di Server

### Step 6: Clone Repository

Setelah masuk SSH, kamu akan berada di home directory (`/home/u1234567`).

```bash
# Clone repository ke folder 'laravel_app'
git clone https://github.com/AtomNano/Rancangan-Web-Koding-Akademi-Payakumbuh.git laravel_app

# Masuk ke folder aplikasi
cd laravel_app
```

**Verifikasi:**
```bash
# Cek apakah folder public/build ada
ls -la public/build

# Harus ada file manifest.json
ls public/build/manifest.json
```

---

## 📦 FASE 4: Install Dependencies

### Step 7: Install Composer Dependencies

**PENTING:** Kita hanya install PHP dependencies. Jangan jalankan `npm install` di server!

```bash
# Masih di folder laravel_app
composer install --optimize-autoloader --no-dev
```

**Tunggu hingga selesai** (bisa beberapa menit).

**Jika error "composer not found":**
```bash
# Download composer
curl -sS https://getcomposer.org/installer | php

# Gunakan composer lokal
php composer.phar install --optimize-autoloader --no-dev
```

### Step 8: Setup .env di Server

```bash
# Copy .env.example menjadi .env
cp .env.example .env

# Edit .env dengan nano
nano .env
```

**Isi konfigurasi berikut di `.env`:**

```env
APP_NAME="Koding Akademi Payakumbuh"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://domainkamu.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u1234567_codingakademi
DB_USERNAME=u1234567_dbuser
DB_PASSWORD=password_database_kamu

SESSION_DRIVER=database
CACHE_STORE=database
LOG_LEVEL=error
```

**Cara edit di nano:**
- Tekan `Ctrl+X` untuk keluar
- Tekan `Y` untuk save
- Tekan `Enter` untuk confirm

### Step 9: Generate APP_KEY

```bash
php artisan key:generate
```

**Verifikasi:**
```bash
# Cek APP_KEY sudah terisi
grep APP_KEY .env
```

---

## 🗄️ FASE 5: Setup Database

### Step 10: Jalankan Migration

```bash
php artisan migrate --force
```

**Jika ada error:**
- Pastikan database sudah dibuat di hPanel
- Pastikan credentials di `.env` benar
- Pastikan `DB_HOST=localhost` (bukan 127.0.0.1)

**Verifikasi:**
```bash
# Cek status migration
php artisan migrate:status
```

---

## 🔗 FASE 6: Setup Symlink (Expose ke Publik)

### Step 11: Setup Symlink dari public_html ke public

**PENTING:** Ini langkah kritis agar aplikasi bisa diakses via domain.

```bash
# Keluar dari folder laravel_app
cd ~

# Masuk ke folder domain
cd domains/domainkamu.com

# Hapus folder public_html bawaan (BACKUP DULU jika ada file penting!)
rm -rf public_html

# Buat symlink dari folder repo ke public_html
ln -s ~/laravel_app/public public_html
```

**Verifikasi:**
```bash
# Cek symlink sudah benar
ls -la public_html

# Harus muncul: public_html -> /home/u1234567/laravel_app/public
```

### Step 12: Setup Storage Link

```bash
# Kembali ke folder aplikasi
cd ~/laravel_app

# Buat storage link
php artisan storage:link
```

**Verifikasi:**
```bash
# Cek link sudah ada
ls -la public/storage

# Harus muncul: storage -> /home/u1234567/laravel_app/storage/app/public
```

---

## ⚡ FASE 7: Optimize & Cache

### Step 13: Clear dan Cache Configuration

```bash
# Clear semua cache
php artisan optimize:clear

# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache
```

---

## ✅ FASE 8: Verifikasi Deployment

### Step 14: Test Aplikasi

1. **Buka browser** dan akses domain kamu: `https://domainkamu.com`
2. **Cek halaman utama** harus muncul
3. **Test login** dengan credentials yang ada
4. **Cek console browser** (F12) untuk error JavaScript/CSS

### Step 15: Cek Logs (Jika Ada Error)

```bash
# Masuk SSH lagi
cd ~/laravel_app

# Cek log Laravel
tail -f storage/logs/laravel.log
```

---

## 🔄 Cara Update Aplikasi (Maintenance)

Setelah deployment pertama, untuk update kode:

### Di Komputer Lokal:

1. **Edit kode**
2. **Build assets** (jika ada perubahan CSS/JS):
   ```bash
   npm run build
   ```
3. **Commit dan push:**
   ```bash
   git add .
   git commit -m "Update: deskripsi perubahan"
   git push origin main
   ```

### Di Server (via SSH):

```bash
# Masuk SSH
ssh -p 65002 u1234567@ip-server-kamu

# Masuk folder aplikasi
cd ~/laravel_app

# Pull kode terbaru
git pull origin main

# Install dependencies baru (jika ada)
composer install --no-dev --optimize-autoloader

# Jalankan migration (jika ada perubahan database)
php artisan migrate --force

# Clear dan cache ulang (WAJIB setiap update!)
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🚨 Troubleshooting

### Error: "500 Internal Server Error"

```bash
# Cek permission folder
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Cek log
tail -50 storage/logs/laravel.log
```

### Error: "APP_KEY is not set"

```bash
php artisan key:generate
php artisan config:cache
```

### Error: "Database connection failed"

```bash
# Test koneksi database
php artisan tinker
# Di tinker: DB::connection()->getPdo();
# Exit: exit

# Pastikan .env benar
cat .env | grep DB_
```

### Error: "Route [login] not defined"

```bash
php artisan route:clear
php artisan route:cache
```

### Assets (CSS/JS) Tidak Muncul

```bash
# Pastikan public/build ada
ls -la public/build

# Jika tidak ada, pull ulang dari GitHub
git pull origin main

# Atau build ulang di lokal dan push
```

### Storage Files Tidak Muncul

```bash
# Pastikan storage link ada
ls -la public/storage

# Jika tidak ada, buat ulang
php artisan storage:link
```

---

## 📝 Checklist Final

Setelah semua langkah selesai, pastikan:

- [ ] Aplikasi bisa diakses via domain
- [ ] Login berfungsi
- [ ] Database terhubung
- [ ] Assets (CSS/JS) muncul
- [ ] Storage link berfungsi
- [ ] Tidak ada error di console browser
- [ ] Log tidak ada error fatal

---

## 🎉 Selesai!

Aplikasi Laravel kamu sudah online di Hostinger!

**Tips:**
- Simpan informasi SSH di tempat aman
- Backup database secara berkala
- Monitor log untuk error
- Update secara berkala untuk security patches

---

**Panduan terkait:**
- `HOSTINGER_ENV_CONFIG.md` - Konfigurasi .env lengkap
- `ENV_QUICK_REFERENCE.md` - Quick reference .env

