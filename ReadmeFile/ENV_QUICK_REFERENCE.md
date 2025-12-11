# Quick Reference: Isi .env untuk Hostinger Deployment

## ⚡ Nilai Wajib Diisi (5 Menit Setup)

### 1. Application (WAJIB!)
```env
APP_ENV=production
APP_KEY=base64:xxxxx                    # Generate: php artisan key:generate
APP_DEBUG=false                         # ⚠️ JANGAN true di production!
APP_URL=https://domainkamu.com          # Ganti dengan domain Hostinger
```

### 2. Database (WAJIB!)
```env
DB_HOST=localhost                       # ⚠️ Gunakan 'localhost', bukan 127.0.0.1
DB_DATABASE=u974507379_codingacademi      # Dari hPanel → Databases
DB_USERNAME=u974507379_admincoding            # Dari hPanel → Databases
DB_PASSWORD=CodingAcademy2025       # Dari hPanel → Databases
```

### 3. Logging (Recommended)
```env
LOG_LEVEL=error                         # Bukan 'debug' untuk production
```

---

## 📋 Template Cepat (Copy-Paste)

```env
APP_NAME="Koding Akademi Payakumbuh"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://domainkamu.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

SESSION_DRIVER=database
CACHE_STORE=database
LOG_LEVEL=error
```

**Isi yang kosong:**
1. `APP_KEY` → Generate dengan `php artisan key:generate`
2. `APP_URL` → Domain Hostinger kamu
3. `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` → Dari hPanel

---

## 🔍 Cara Dapatkan Info Database

1. Login **hPanel Hostinger**
2. Buka **Databases** → **MySQL Databases**
3. Lihat database yang sudah dibuat
4. Copy: **Database Name**, **Username**, **Password**

---

## ✅ Checklist Cepat

- [ ] `APP_ENV=production` (bukan local)
- [ ] `APP_DEBUG=false` (bukan true)
- [ ] `APP_KEY` sudah di-generate
- [ ] `APP_URL` sudah diisi dengan domain
- [ ] `DB_HOST=localhost` (bukan 127.0.0.1)
- [ ] Database credentials sudah benar
- [ ] `LOG_LEVEL=error` (bukan debug)

---

## 🚨 Jangan Lupa!

Setelah edit `.env`, jalankan:
```bash
php artisan config:clear
php artisan config:cache
```

---

**Lihat panduan lengkap:** `HOSTINGER_ENV_CONFIG.md`




