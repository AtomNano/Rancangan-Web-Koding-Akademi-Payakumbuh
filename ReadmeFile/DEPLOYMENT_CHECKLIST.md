# ✅ Deployment Checklist - Hostinger

Gunakan checklist ini untuk memastikan semua langkah deployment sudah dilakukan dengan benar.

---

## 📋 PRE-DEPLOYMENT (Lokal)

### Persiapan
- [ ] `.env` sudah dikonfigurasi untuk production
- [ ] Database sudah dibuat di hPanel Hostinger
- [ ] SSH Access sudah diaktifkan di hPanel
- [ ] Informasi SSH sudah dicatat (IP, Port, Username, Password)
- [ ] Repository sudah di-push ke GitHub

### Build Assets
- [ ] `npm install` sudah dijalankan
- [ ] `npm run build` sudah dijalankan
- [ ] Folder `public/build` sudah ada isinya
- [ ] File `public/build/manifest.json` ada

### Git
- [ ] `.gitignore` sudah benar (public/build tidak di-ignore)
- [ ] File `.env` tidak ter-commit ke Git
- [ ] Perubahan sudah di-commit
- [ ] Sudah di-push ke GitHub
- [ ] Folder `public/build` ada di GitHub repository

---

## 🔐 SSH SETUP

- [ ] SSH Access sudah diaktifkan di hPanel
- [ ] Koneksi SSH berhasil (test dengan `ssh -p PORT USER@IP`)
- [ ] Sudah masuk ke terminal server

---

## 📥 REPOSITORY SETUP

- [ ] Repository sudah di-clone ke server
- [ ] Folder `laravel_app` sudah ada
- [ ] Folder `public/build` ada di server (hasil clone)

---

## 📦 DEPENDENCIES

- [ ] `composer install --no-dev` sudah dijalankan
- [ ] Tidak ada error saat install composer
- [ ] Folder `vendor` sudah ada

---

## ⚙️ CONFIGURATION

- [ ] File `.env` sudah dibuat di server (dari `.env.example`)
- [ ] `APP_ENV=production` sudah di-set
- [ ] `APP_DEBUG=false` sudah di-set
- [ ] `APP_URL` sudah diisi dengan domain Hostinger
- [ ] `APP_KEY` sudah di-generate
- [ ] Database credentials sudah benar
- [ ] `DB_HOST=localhost` (bukan 127.0.0.1)

---

## 🗄️ DATABASE

- [ ] Database sudah dibuat di hPanel
- [ ] Migration sudah dijalankan (`php artisan migrate --force`)
- [ ] Tidak ada error migration
- [ ] Tabel-tabel sudah ada di database

---

## 🔗 SYMLINK & STORAGE

- [ ] Folder `public_html` sudah dihapus (atau di-backup)
- [ ] Symlink dari `public_html` ke `laravel_app/public` sudah dibuat
- [ ] Storage link sudah dibuat (`php artisan storage:link`)
- [ ] Symlink `public/storage` sudah ada

---

## ⚡ OPTIMIZATION

- [ ] `php artisan optimize:clear` sudah dijalankan
- [ ] `php artisan config:cache` sudah dijalankan
- [ ] `php artisan route:cache` sudah dijalankan
- [ ] `php artisan view:cache` sudah dijalankan

---

## ✅ VERIFICATION

### Aplikasi
- [ ] Website bisa diakses via domain
- [ ] Halaman utama muncul dengan benar
- [ ] Tidak ada error 500

### Assets
- [ ] CSS muncul (halaman tidak polos)
- [ ] JavaScript berfungsi
- [ ] Tidak ada error di console browser (F12)

### Database
- [ ] Login berfungsi
- [ ] Data bisa di-load
- [ ] Tidak ada error database connection

### Storage
- [ ] Upload file berfungsi (jika ada fitur upload)
- [ ] File yang di-upload bisa diakses
- [ ] Gambar muncul (jika ada)

### Logs
- [ ] Tidak ada error fatal di `storage/logs/laravel.log`
- [ ] Log level sudah di-set ke `error` (bukan debug)

---

## 🔒 SECURITY CHECK

- [ ] `APP_DEBUG=false` ✅
- [ ] `APP_ENV=production` ✅
- [ ] `LOG_LEVEL=error` (bukan debug) ✅
- [ ] File `.env` tidak ter-commit ke Git ✅
- [ ] Password database kuat ✅

---

## 📝 POST-DEPLOYMENT

- [ ] Informasi SSH sudah disimpan dengan aman
- [ ] Backup database sudah dibuat
- [ ] Dokumentasi deployment sudah dibaca
- [ ] Prosedur update sudah dipahami

---

## 🎯 QUICK TEST

Jalankan test cepat ini untuk memastikan semua berfungsi:

1. **Akses Homepage:** `https://domainkamu.com` ✅
2. **Test Login:** Login dengan user yang ada ✅
3. **Test Dashboard:** Dashboard muncul setelah login ✅
4. **Test Upload:** Upload file (jika ada fitur) ✅
5. **Test Console:** Buka F12, cek tidak ada error ✅

---

## 🚨 JIKA ADA YANG GAGAL

### Error 500
→ Cek: `storage/logs/laravel.log`
→ Pastikan: Permission folder storage dan bootstrap/cache

### Assets Tidak Muncul
→ Pastikan: `public/build` ada di server
→ Pastikan: Symlink `public_html` benar

### Database Error
→ Pastikan: Credentials di `.env` benar
→ Pastikan: Database sudah dibuat di hPanel

### Login Tidak Bisa
→ Pastikan: Migration sudah dijalankan
→ Pastikan: Tabel `users` ada di database

---

**Status Deployment:** ☐ Belum Mulai | ☐ Sedang Proses | ☐ Selesai

**Tanggal Deployment:** _______________

**Catatan:** 
_________________________________________________
_________________________________________________
_________________________________________________




