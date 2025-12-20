# Panduan Deploy Laravel ke cPanel Niagahoster

## 📋 Persiapan Sebelum Deploy

### 1. Pastikan Project Siap
```bash
# Update dependencies
composer install --optimize-autoloader --no-dev

# Compile assets
npm run build

# Clear cache lokal
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### 2. File yang Perlu Disiapkan
- ✅ Semua file project Laravel
- ✅ Database export (.sql)
- ✅ File .env production

---

## 🚀 Langkah Deploy ke cPanel Niagahoster

### **LANGKAH 1: Login cPanel**
1. Login ke https://panel.niagahoster.co.id
2. Pilih hosting Anda
3. Klik **cPanel** untuk masuk

---

### **LANGKAH 2: Upload File Laravel**

#### Via File Manager (Recommended untuk file besar):

1. **Buka File Manager** di cPanel
2. **Buat folder sementara** di root (contoh: `laravel_temp`)
3. **Upload file ZIP** project Anda ke folder `laravel_temp`
4. **Extract ZIP** (klik kanan > Extract)

#### Via Git Deployment (Lebih mudah untuk update):

1. **Buka Terminal** di cPanel
2. Clone repository:
```bash
cd ~
git clone https://github.com/YOUR_USERNAME/YOUR_REPO.git laravel_temp
```

---

### **LANGKAH 3: Setup Struktur Folder**

cPanel Niagahoster struktur:
```
/home/username/               # Root home directory
├── public_html/              # Document root (untuk public Laravel)
├── laravel_temp/             # Folder upload temporary
└── laravel_app/              # Laravel application (BUAT INI)
```

**Pindahkan file Laravel:**

1. Buka **Terminal** di cPanel
2. Jalankan perintah:

```bash
# Pindah ke home directory
cd ~

# Buat folder laravel_app (jika belum ada)
mkdir -p laravel_app

# Pindahkan semua file KECUALI public
rsync -av --exclude='public' laravel_temp/ laravel_app/

# Pindahkan isi folder public ke public_html
rsync -av laravel_temp/public/ public_html/

# Hapus folder temporary
rm -rf laravel_temp
```

---

### **LANGKAH 4: Edit File index.php**

Edit file `public_html/index.php`:

```php
<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Update path ke vendor dan bootstrap
require __DIR__.'/../laravel_app/vendor/autoload.php';

$app = require_once __DIR__.'/../laravel_app/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
```

---

### **LANGKAH 5: Setup Database**

1. **Buka phpMyAdmin** di cPanel
2. **Buat Database Baru**:
   - Nama: `username_codingacademy` (sesuaikan)
3. **Import database**:
   - Pilih database yang baru dibuat
   - Klik **Import**
   - Upload file `codingacademi.sql`
   - Klik **Go**

---

### **LANGKAH 6: Konfigurasi .env**

1. Copy file `.env.example` menjadi `.env`:
```bash
cd ~/laravel_app
cp .env.example .env
```

2. Edit file `.env`:
```bash
nano .env
# atau gunakan File Manager cPanel
```

3. Isi konfigurasi:
```env
APP_NAME="Coding Academy"
APP_ENV=production
APP_KEY=  # akan di-generate nanti
APP_DEBUG=false
APP_URL=https://yourdomain.com

LOG_CHANNEL=stack
LOG_LEVEL=error

# Database - PENTING!
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=username_codingacademy  # Nama database cPanel
DB_USERNAME=username_codingacademy  # Username database cPanel
DB_PASSWORD=your_database_password  # Password database cPanel

# Session & Cache
SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=database

# Mail Configuration (optional, untuk email)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"

# Cloudflare Turnstile (jika pakai)
TURNSTILE_SITE_KEY=your_site_key
TURNSTILE_SECRET_KEY=your_secret_key
```

---

### **LANGKAH 7: Set Permission & Generate Key**

Jalankan di Terminal cPanel:

```bash
cd ~/laravel_app

# Generate APP_KEY
php artisan key:generate

# Set permission
chmod -R 755 storage bootstrap/cache
find storage -type f -exec chmod 644 {} \;
find storage -type d -exec chmod 755 {} \;

# Create symbolic link untuk storage
cd ~/public_html
ln -s ../laravel_app/storage/app/public storage

# Clear dan cache config
cd ~/laravel_app
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

### **LANGKAH 8: Setup .htaccess**

Pastikan file `public_html/.htaccess` ada dan berisi:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

# Security Headers
<IfModule mod_headers.c>
    Header set X-Content-Type-Options "nosniff"
    Header set X-Frame-Options "SAMEORIGIN"
    Header set X-XSS-Protection "1; mode=block"
</IfModule>

# PHP Settings
<IfModule mod_php7.c>
    php_value upload_max_filesize 64M
    php_value post_max_size 64M
    php_value max_execution_time 300
    php_value max_input_time 300
</IfModule>
```

---

### **LANGKAH 9: Setup PHP Version**

1. Buka **Select PHP Version** di cPanel
2. Pilih **PHP 8.1** atau **PHP 8.2**
3. Enable extensions yang diperlukan:
   - ✅ mbstring
   - ✅ openssl
   - ✅ pdo
   - ✅ pdo_mysql
   - ✅ tokenizer
   - ✅ xml
   - ✅ ctype
   - ✅ json
   - ✅ bcmath
   - ✅ fileinfo
   - ✅ gd
   - ✅ zip

---

### **LANGKAH 10: Migrasi Database (jika perlu)**

Jika Anda tidak import SQL tapi ingin migrate:

```bash
cd ~/laravel_app

# Run migrations
php artisan migrate --force

# Seed database (jika ada)
php artisan db:seed --force
```

---

### **LANGKAH 11: Setup Cron Job (untuk Queue & Schedule)**

1. Buka **Cron Jobs** di cPanel
2. Tambah cron job baru:

**Untuk Laravel Scheduler:**
```
* * * * * cd /home/username/laravel_app && php artisan schedule:run >> /dev/null 2>&1
```

**Untuk Queue Worker (optional):**
```
* * * * * cd /home/username/laravel_app && php artisan queue:work --stop-when-empty >> /dev/null 2>&1
```

---

## 🔧 Troubleshooting

### Error: "Whoops, looks like something went wrong"

**Solusi:**
```bash
cd ~/laravel_app

# Check logs
tail -f storage/logs/laravel.log

# Clear semua cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Cache ulang (production)
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

### Error: "500 Internal Server Error"

**Solusi:**
1. Check file permission:
```bash
chmod -R 755 ~/laravel_app/storage
chmod -R 755 ~/laravel_app/bootstrap/cache
```

2. Check `.htaccess` ada di `public_html/`

3. Check error log di cPanel > Error Log

---

### Upload File Gagal / File Terlalu Besar

**Solusi - Edit php.ini di cPanel:**

1. Buka **MultiPHP INI Editor** di cPanel
2. Edit untuk domain Anda:
```ini
upload_max_filesize = 64M
post_max_size = 64M
max_execution_time = 300
memory_limit = 256M
```

---

### Database Connection Error

**Solusi:**
1. Pastikan kredensial database di `.env` benar
2. Database host biasanya `localhost`
3. Username dan database name harus sama dengan yang dibuat di cPanel
4. Test connection:
```bash
cd ~/laravel_app
php artisan tinker
DB::connection()->getPdo();
```

---

### Assets (CSS/JS) Tidak Load

**Solusi:**
1. Pastikan `APP_URL` di `.env` benar
2. Check symbolic link storage:
```bash
cd ~/public_html
ls -la | grep storage
# Jika tidak ada, buat ulang:
ln -s ../laravel_app/storage/app/public storage
```

3. Build ulang assets:
```bash
cd ~/laravel_app
npm run build
# Copy hasil build ke public_html
rsync -av public/build/ ~/public_html/build/
```

---

## 📝 Checklist Sebelum Go Live

- [ ] APP_DEBUG=false di .env
- [ ] APP_URL sudah benar
- [ ] Database sudah diimport dan terisi
- [ ] Storage permission sudah benar (755)
- [ ] Symbolic link storage sudah dibuat
- [ ] PHP version 8.1+ sudah aktif
- [ ] Extensions PHP sudah diaktifkan
- [ ] .htaccess sudah ada di public_html
- [ ] Config sudah di-cache
- [ ] Test semua fitur utama
- [ ] Test upload file
- [ ] Test login admin/guru/siswa
- [ ] SSL/HTTPS sudah aktif

---

## 🔄 Update/Deploy Versi Baru

Untuk update project di masa depan:

```bash
# Masuk ke Terminal cPanel

cd ~/laravel_app

# Backup dulu
cp -r ~/laravel_app ~/laravel_app_backup_$(date +%Y%m%d)

# Pull changes dari Git (jika pakai Git)
git pull origin main

# Atau upload file baru dan extract

# Update dependencies
composer install --optimize-autoloader --no-dev

# Run migrations (jika ada perubahan database)
php artisan migrate --force

# Clear dan cache ulang
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

# Update assets jika ada perubahan
rsync -av public/build/ ~/public_html/build/
rsync -av public/images/ ~/public_html/images/
```

---

## 🆘 Kontak Support

Jika ada masalah:
1. Check error log: `storage/logs/laravel.log`
2. Check cPanel error log: cPanel > Metrics > Errors
3. Hubungi support Niagahoster jika masalah hosting
4. Stack Overflow / Laravel Forum untuk masalah kode

---

## 📚 Referensi Tambahan

- [Laravel Deployment Documentation](https://laravel.com/docs/10.x/deployment)
- [Niagahoster Knowledge Base](https://www.niagahoster.co.id/kb/)
- [cPanel Documentation](https://docs.cpanel.net/)

---

**Good luck dengan deployment! 🚀**
