# Panduan Deploy Laravel ke Vercel

## ⚠️ PENTING: Batasan Vercel untuk Laravel

Vercel dirancang untuk **frontend frameworks** dan **serverless functions**, bukan untuk aplikasi PHP full-stack seperti Laravel. Ada beberapa batasan penting:

### Batasan Utama:
1. **Tidak ada persistent file storage** - File upload harus disimpan di external storage (S3, Cloudinary, dll)
2. **Serverless functions** - Setiap request adalah function terpisah, tidak ada state persistence
3. **Database harus external** - Tidak bisa menggunakan database lokal, harus menggunakan database cloud
4. **Artisan commands terbatas** - Tidak bisa menjalankan `php artisan migrate` langsung, harus via external service
5. **Storage links** - Harus menggunakan external storage untuk file uploads

### Rekomendasi:
Jika aplikasi Anda memerlukan:
- File uploads
- Database operations yang kompleks
- Background jobs
- Scheduled tasks

**Pertimbangkan platform lain seperti:**
- **Railway.app** (paling mudah untuk Laravel)
- **Render.com** (gratis, tapi sleep setelah 15 menit)
- **Fly.io** (tidak sleep, performa bagus)

---

## Langkah-langkah Deploy ke Vercel

### Prasyarat

1. **Akun Vercel** - Daftar di https://vercel.com
2. **GitHub Repository** - Project harus sudah di GitHub
3. **Database Cloud** - Setup database di Railway, PlanetScale, atau Supabase
4. **Storage Cloud** - Setup S3, Cloudinary, atau storage service lain untuk file uploads

### Langkah 1: Persiapan Database

Karena Vercel tidak support database lokal, Anda perlu database cloud:

**Opsi 1: Railway (Recommended)**
1. Daftar di https://railway.app
2. Buat MySQL database
3. Copy connection string

**Opsi 2: PlanetScale**
1. Daftar di https://planetscale.com
2. Buat database MySQL
3. Copy connection string

**Opsi 3: Supabase**
1. Daftar di https://supabase.com
2. Buat PostgreSQL database
3. Update `DB_CONNECTION=pgsql` di environment variables

### Langkah 2: Setup Storage untuk File Uploads

Karena Vercel tidak punya persistent storage, semua file upload harus ke cloud:

**Opsi 1: AWS S3**
```bash
composer require league/flysystem-aws-s3-v3 "^3.0"
```

**Opsi 2: Cloudinary**
```bash
composer require cloudinary-labs/cloudinary-laravel
```

**Opsi 3: DigitalOcean Spaces**
```bash
composer require league/flysystem-s3-v3
```

### Langkah 3: Konfigurasi Environment Variables

Sebelum deploy, siapkan environment variables berikut di Vercel:

```env
APP_NAME="Materi Online"
APP_ENV=production
APP_KEY=base64:... # Generate dengan: php artisan key:generate --show
APP_DEBUG=false
APP_URL=https://your-app.vercel.app

# Database (gunakan connection string dari cloud database)
DB_CONNECTION=mysql
DB_HOST=your-db-host.railway.app
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Storage (jika menggunakan S3)
AWS_ACCESS_KEY_ID=your_access_key
AWS_SECRET_ACCESS_KEY=your_secret_key
AWS_DEFAULT_REGION=ap-southeast-1
AWS_BUCKET=your-bucket-name
AWS_USE_PATH_STYLE_ENDPOINT=false

# Session (gunakan database atau Redis)
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Cache (gunakan Redis atau database)
CACHE_DRIVER=database

# Queue (gunakan database atau Redis)
QUEUE_CONNECTION=database

# Mail (gunakan SMTP atau service seperti Mailgun)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"

# Turnstile (jika digunakan)
TURNSTILE_SITE_KEY=your-site-key
TURNSTILE_SECRET_KEY=your-secret-key
```

### Langkah 4: Update Konfigurasi Laravel

#### Update `config/filesystems.php`

Jika menggunakan S3, pastikan konfigurasi sudah benar:

```php
'disks' => [
    's3' => [
        'driver' => 's3',
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION'),
        'bucket' => env('AWS_BUCKET'),
        'url' => env('AWS_URL'),
        'endpoint' => env('AWS_ENDPOINT'),
        'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        'throw' => false,
    ],
],
```

#### Update Storage untuk menggunakan S3

Di controller yang handle file upload, pastikan menggunakan disk S3:

```php
$path = $request->file('file')->store('uploads', 's3');
```

### Langkah 5: Deploy ke Vercel

#### Metode 1: Via Vercel Dashboard (Recommended)

1. **Login ke Vercel**
   - Kunjungi https://vercel.com
   - Login dengan GitHub account

2. **Import Project**
   - Klik "Add New..." → "Project"
   - Pilih repository GitHub Anda
   - Vercel akan auto-detect Laravel

3. **Konfigurasi Build Settings**
   - **Framework Preset**: Other
   - **Root Directory**: `./` (root project)
   - **Build Command**: 
     ```bash
     composer install --no-dev --optimize-autoloader && npm ci && npm run build
     ```
   - **Output Directory**: `public` (tidak digunakan untuk Laravel, tapi harus diisi)
   - **Install Command**: (kosongkan, sudah di build command)

4. **Environment Variables**
   - Klik "Environment Variables"
   - Tambahkan semua environment variables dari Langkah 3
   - Pastikan untuk Production, Preview, dan Development

5. **Deploy**
   - Klik "Deploy"
   - Tunggu proses build selesai
   - Setelah selesai, Anda akan dapat URL seperti `https://your-app.vercel.app`

#### Metode 2: Via Vercel CLI

1. **Install Vercel CLI**
   ```bash
   npm i -g vercel
   ```

2. **Login**
   ```bash
   vercel login
   ```

3. **Deploy**
   ```bash
   vercel
   ```

4. **Set Environment Variables**
   ```bash
   vercel env add APP_KEY
   vercel env add DB_HOST
   # ... dan seterusnya
   ```

5. **Production Deploy**
   ```bash
   vercel --prod
   ```

### Langkah 6: Setup Database Migration

Karena Vercel tidak support running artisan commands langsung, Anda perlu:

**Opsi 1: Run Migration via Local Machine**
```bash
# Set environment variables di local .env dengan connection string production
php artisan migrate --force
```

**Opsi 2: Setup Migration Service**
- Gunakan GitHub Actions untuk run migration
- Atau gunakan service seperti Laravel Forge untuk run migration

**Opsi 3: Run Migration via Vercel Function (Temporary)**
Buat route khusus untuk migration (HAPUS SETELAH SELESAI!):

```php
// routes/web.php (HAPUS SETELAH MIGRATION!)
Route::get('/run-migration', function() {
    if (app()->environment('production')) {
        Artisan::call('migrate', ['--force' => true]);
        return 'Migration completed';
    }
    return 'Not in production';
})->middleware('auth');
```

### Langkah 7: Setup Storage Link (Jika Masih Menggunakan Local Storage)

Jika masih ada file yang perlu di-link dari storage:

**Gunakan External Storage (Recommended)**
- Pindahkan semua file ke S3/Cloudinary
- Update semua reference ke external storage

**Atau Setup Storage Link via Function**
Buat route temporary untuk create storage link:

```php
// routes/web.php (HAPUS SETELAH SELESAI!)
Route::get('/setup-storage', function() {
    Artisan::call('storage:link');
    return 'Storage link created';
})->middleware('auth');
```

---

## Troubleshooting

### Error: "APP_KEY is not set"
```bash
# Generate key di local
php artisan key:generate --show

# Copy hasilnya ke Vercel environment variables
```

### Error: "Database connection failed"
- Pastikan database cloud sudah dibuat
- Check environment variables DB_* sudah benar
- Pastikan database host accessible dari internet
- Check firewall/security settings database

### Error: "Storage link failed"
- Gunakan external storage (S3/Cloudinary) untuk semua file uploads
- Jangan gunakan local storage di Vercel

### Error: "File upload failed"
- Pastikan sudah setup external storage (S3/Cloudinary)
- Update controller untuk menggunakan disk external
- Check file size limits di Vercel (max 4.5MB untuk serverless functions)

### Error: "Route not found"
- Pastikan `vercel.json` sudah benar
- Check `api/index.php` sudah ada
- Pastikan semua routes di-route ke `api/index.php`

### Error: "Composer install failed"
- Pastikan `composer.json` valid
- Check PHP version compatibility (Vercel support PHP 8.1+)
- Pastikan semua dependencies bisa di-install

---

## Best Practices untuk Laravel di Vercel

1. **Gunakan External Storage**
   - Jangan gunakan local storage
   - Gunakan S3, Cloudinary, atau storage service lain

2. **Gunakan External Database**
   - Jangan gunakan SQLite
   - Gunakan MySQL/PostgreSQL cloud

3. **Optimize Dependencies**
   - Gunakan `--no-dev` untuk production
   - Hapus dependencies yang tidak digunakan

4. **Cache Configuration**
   - Enable config cache: `php artisan config:cache`
   - Enable route cache: `php artisan route:cache`
   - Enable view cache: `php artisan view:cache`

5. **Monitor Performance**
   - Vercel free tier punya limits
   - Monitor function execution time
   - Optimize queries dan code

6. **Handle Background Jobs**
   - Gunakan external queue service (Redis, database)
   - Atau gunakan Vercel Cron Jobs untuk scheduled tasks

---

## Alternatif Platform yang Lebih Cocok untuk Laravel

Jika Anda mengalami kesulitan dengan Vercel, pertimbangkan:

### 1. Railway.app ⭐ (Paling Direkomendasikan)
- Mudah setup
- Support Laravel native
- Database MySQL gratis
- Auto-deploy dari GitHub
- **Guide**: Lihat `DEPLOYMENT_GUIDE.md`

### 2. Render.com
- Gratis selamanya
- PostgreSQL gratis
- Auto-deploy dari GitHub
- **Guide**: Lihat `DEPLOYMENT_GUIDE.md`

### 3. Fly.io
- Tidak sleep
- Performa bagus
- Support Laravel native
- **Guide**: Lihat `DEPLOYMENT_GUIDE.md`

---

## Link Berguna

- [Vercel Documentation](https://vercel.com/docs)
- [Vercel PHP Runtime](https://vercel.com/docs/runtimes/php)
- [Laravel Deployment](https://laravel.com/docs/deployment)
- [Railway Documentation](https://docs.railway.app)
- [Render Documentation](https://render.com/docs)

---

## Catatan Penting

⚠️ **Vercel tidak ideal untuk Laravel full-stack applications**. Jika aplikasi Anda memerlukan:
- File uploads yang banyak
- Database operations yang kompleks
- Background jobs
- Scheduled tasks
- Persistent storage

**Sangat disarankan menggunakan Railway, Render, atau Fly.io** yang lebih cocok untuk Laravel.

Vercel lebih cocok untuk:
- Next.js applications
- Static sites
- Serverless APIs yang sederhana
- Frontend-only applications

