# Konfigurasi .env untuk Deployment Hostinger

Panduan lengkap mengisi file `.env` untuk deployment Laravel ke Hostinger Shared Hosting.

## 🔴 Nilai Wajib Diisi (Critical)

### 1. Application Settings
```env
APP_NAME="Koding Akademi Payakumbuh"
APP_ENV=production                    # ⚠️ WAJIB: ubah dari 'local' ke 'production'
APP_KEY=base64:xxxxx                  # ⚠️ WAJIB: generate dengan 'php artisan key:generate'
APP_DEBUG=false                       # ⚠️ WAJIB: ubah dari 'true' ke 'false' (security!)
APP_URL=https://domainkamu.com        # ⚠️ WAJIB: ganti dengan domain Hostinger kamu
```

### 2. Database Configuration
```env
DB_CONNECTION=mysql
DB_HOST=localhost                     # ⚠️ WAJIB: biasanya 'localhost' di Hostinger (bukan 127.0.0.1)
DB_PORT=3306
DB_DATABASE=u1234567_codingakademi    # ⚠️ WAJIB: nama database dari hPanel
DB_USERNAME=u1234567_dbuser           # ⚠️ WAJIB: username database dari hPanel
DB_PASSWORD=password_database_kamu    # ⚠️ WAJIB: password database dari hPanel
```

**Cara mendapatkan info database:**
1. Login ke hPanel Hostinger
2. Buka **Databases** → **MySQL Databases**
3. Lihat informasi database yang sudah dibuat
4. Format biasanya: `u[angka]_[nama]` untuk database dan username

### 3. Session & Cache
```env
SESSION_DRIVER=database               # ✅ Recommended untuk production
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

CACHE_STORE=database                  # ✅ Recommended untuk shared hosting
QUEUE_CONNECTION=database
```

---

## 🟡 Nilai Opsional (Bisa Dibiarkan Default)

### Locale Settings
```env
APP_LOCALE=id                         # Opsional: ubah ke 'id' untuk Bahasa Indonesia
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US
```

### Logging
```env
LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error                       # ✅ Recommended: 'error' untuk production (bukan 'debug')
```

### Mail Configuration (Jika Menggunakan Email)
```env
MAIL_MAILER=smtp                     # Jika ingin kirim email
MAIL_HOST=smtp.hostinger.com         # SMTP Hostinger
MAIL_PORT=465                         # Port SSL
MAIL_USERNAME=noreply@domainkamu.com # Email dari Hostinger
MAIL_PASSWORD=password_email          # Password email
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="noreply@domainkamu.com"
MAIL_FROM_NAME="${APP_NAME}"
```

**Cara setup email di Hostinger:**
1. hPanel → **Email** → **Email Accounts**
2. Buat email account baru
3. Gunakan credentials tersebut di `.env`

---

## 🟢 Nilai yang Bisa Dibiarkan Kosong/Default

### Redis & Memcached (Tidak Perlu untuk Shared Hosting)
```env
REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
MEMCACHED_HOST=127.0.0.1
```

### AWS S3 (Jika Tidak Menggunakan)
```env
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false
```

### Vite (Sudah di-build, tidak perlu di server)
```env
VITE_APP_NAME="${APP_NAME}"
```

---

## 📋 Template Lengkap untuk Hostinger

Copy template ini dan isi bagian yang ditandai dengan `[ISI_DISINI]`:

```env
APP_NAME="Koding Akademi Payakumbuh"
APP_ENV=production
APP_KEY=[GENERATE_DENGAN_PHP_ARTISAN_KEY_GENERATE]
APP_DEBUG=false
APP_URL=https://[DOMAIN_KAMU].com

APP_LOCALE=id
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
PHP_CLI_SERVER_WORKERS=4
BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=[NAMA_DATABASE_DARI_HPANEL]
DB_USERNAME=[USERNAME_DATABASE_DARI_HPANEL]
DB_PASSWORD=[PASSWORD_DATABASE_DARI_HPANEL]

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database
CACHE_STORE=database

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
MEMCACHED_HOST=127.0.0.1

MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"
```

---

## ⚠️ Checklist Sebelum Deploy

### 1. Generate APP_KEY
**Jalankan di server via SSH:**
```bash
php artisan key:generate
```
Atau generate di local dan copy hasilnya:
```bash
php artisan key:generate --show
```

### 2. Pastikan Database Sudah Dibuat
- Login hPanel → Databases → MySQL Databases
- Buat database baru jika belum ada
- Catat: Database Name, Username, Password

### 3. Pastikan APP_DEBUG=false
**JANGAN PERNAH** set `APP_DEBUG=true` di production! Ini akan expose error details ke public.

### 4. Pastikan APP_URL Benar
- Gunakan `https://` (bukan `http://`)
- Gunakan domain lengkap (contoh: `https://codingakademi.com`)

### 5. Test Koneksi Database
Setelah setup `.env`, test koneksi:
```bash
php artisan migrate:status
```

---

## 🔒 Security Checklist

- [ ] `APP_DEBUG=false` ✅
- [ ] `APP_ENV=production` ✅
- [ ] `APP_KEY` sudah di-generate ✅
- [ ] Password database kuat ✅
- [ ] File `.env` tidak di-commit ke Git ✅
- [ ] `LOG_LEVEL=error` (bukan debug) ✅

---

## 🚨 Common Mistakes

### ❌ JANGAN:
1. **APP_DEBUG=true** di production → Security risk!
2. **DB_HOST=127.0.0.1** → Gunakan `localhost` untuk Hostinger
3. **APP_KEY kosong** → Aplikasi tidak akan jalan
4. **APP_URL masih localhost** → Link/URL akan broken
5. **Password database salah** → Migration akan gagal

### ✅ HARUS:
1. Generate `APP_KEY` baru untuk production
2. Set `APP_DEBUG=false`
3. Set `APP_ENV=production`
4. Gunakan `localhost` untuk `DB_HOST` (bukan 127.0.0.1)
5. Test koneksi database sebelum deploy

---

## 📞 Troubleshooting

### Error: "No application encryption key has been specified"
```bash
php artisan key:generate
```

### Error: "SQLSTATE[HY000] [2002] Connection refused"
- Check `DB_HOST` harus `localhost` (bukan 127.0.0.1)
- Check username/password database benar
- Pastikan database sudah dibuat di hPanel

### Error: "The stream or file could not be opened"
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Error: "Route [login] not defined"
```bash
php artisan config:clear
php artisan route:clear
php artisan cache:clear
```

---

## 📝 Catatan Penting

1. **Jangan commit `.env` ke Git** - File ini sudah ada di `.gitignore`
2. **Backup `.env` lokal** - Simpan copy untuk development
3. **Gunakan password manager** - Untuk menyimpan credentials dengan aman
4. **Update secara berkala** - Review konfigurasi setiap beberapa bulan

---

## 🔄 Update Environment Variables

Setelah mengubah `.env` di server, selalu jalankan:
```bash
php artisan config:clear
php artisan cache:clear
php artisan config:cache
```

---

**Selamat Deploy! 🚀**

