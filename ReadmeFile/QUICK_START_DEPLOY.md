# 🚀 Quick Start: Deployment ke Hostinger

Ringkasan cepat langkah-langkah deployment setelah `.env` siap.

---

## ⚡ Langkah Cepat (15 Menit)

### 1️⃣ Di Komputer Lokal (5 menit)

```powershell
# Jalankan script helper (atau manual)
.\deploy-local.ps1

# Atau manual:
npm run build
git add .
git commit -m "Ready for Hostinger deployment"
git push origin main
```

**Verifikasi:**
- Buka GitHub, pastikan `public/build` ada di repository

---

### 2️⃣ Setup SSH di Hostinger (2 menit)

1. Login **hPanel** → **Advanced** → **SSH Access**
2. **Enable SSH** (jika belum)
3. **Catat:** IP, Port (65002), Username, Password

---

### 3️⃣ Clone Repository di Server (3 menit)

```bash
# Masuk SSH
ssh -p 65002 u1234567@ip-server-kamu

# Clone repo
git clone https://github.com/AtomNano/Rancangan-Web-Koding-Akademi-Payakumbuh.git laravel_app
cd laravel_app
```

---

### 4️⃣ Install & Setup (5 menit)

```bash
# Install dependencies
composer install --optimize-autoloader --no-dev

# Setup .env
cp .env.example .env
nano .env
# Isi: APP_ENV=production, APP_DEBUG=false, APP_URL, Database credentials

# Generate key
php artisan key:generate

# Migrate database
php artisan migrate --force
```

---

### 5️⃣ Setup Symlink (2 menit)

```bash
# Keluar dari folder
cd ~/domains/domainkamu.com

# Hapus public_html lama
rm -rf public_html

# Buat symlink
ln -s ~/laravel_app/public public_html

# Kembali ke app
cd ~/laravel_app

# Storage link
php artisan storage:link
```

---

### 6️⃣ Optimize (1 menit)

```bash
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## ✅ Selesai!

Buka browser: `https://domainkamu.com`

---

## 📚 Panduan Lengkap

- **Langkah detail:** `HOSTINGER_DEPLOYMENT_STEPS.md`
- **Checklist:** `DEPLOYMENT_CHECKLIST.md`
- **Konfigurasi .env:** `HOSTINGER_ENV_CONFIG.md`

---

## 🔄 Update Nanti

**Lokal:**
```powershell
npm run build
git add .
git commit -m "Update"
git push origin main
```

**Server:**
```bash
cd ~/laravel_app
git pull origin main
composer install --no-dev
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Atau gunakan script: `bash deploy-server.sh`

---

## 🚨 Troubleshooting Cepat

**Error 500:**
```bash
chmod -R 775 storage bootstrap/cache
tail -50 storage/logs/laravel.log
```

**Assets tidak muncul:**
- Pastikan `public/build` ada di server
- Pull ulang: `git pull origin main`

**Database error:**
- Pastikan `DB_HOST=localhost` (bukan 127.0.0.1)
- Cek credentials di `.env`

---

**Selamat Deploy! 🎉**




