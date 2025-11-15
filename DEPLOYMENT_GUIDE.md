# Panduan Deploy Laravel ke Hosting Gratis

Panduan lengkap untuk deploy aplikasi Laravel ke platform hosting gratis untuk testing development.

## Platform Hosting Gratis yang Direkomendasikan

### 1. **Railway.app** ⭐ (Paling Direkomendasikan)
- **Free Tier**: $5 credit gratis per bulan
- **Keuntungan**: 
  - Mudah digunakan
  - Auto-deploy dari GitHub
  - Database MySQL/PostgreSQL gratis
  - SSL otomatis
  - Custom domain gratis
- **Kekurangan**: 
  - Credit habis setelah $5, perlu upgrade
  - Aplikasi sleep setelah 7 hari tidak aktif (free tier)

### 2. **Render.com**
- **Free Tier**: Gratis selamanya
- **Keuntungan**:
  - Gratis untuk web service
  - PostgreSQL gratis
  - Auto-deploy dari GitHub
  - SSL otomatis
- **Kekurangan**:
  - Aplikasi sleep setelah 15 menit tidak aktif
  - Perlu upgrade untuk database MySQL (PostgreSQL gratis)

### 3. **Fly.io**
- **Free Tier**: 3 shared-cpu-1x VMs gratis
- **Keuntungan**:
  - Tidak sleep
  - Performa bagus
  - CLI tools yang powerful
- **Kekurangan**:
  - Setup lebih kompleks
  - Perlu install Fly CLI

---

## Metode 1: Deploy ke Railway.app (Paling Mudah)

### Langkah 1: Persiapan Repository

1. **Pastikan project sudah di GitHub**
   ```bash
   git init
   git add .
   git commit -m "Initial commit"
   git remote add origin https://github.com/username/repo-name.git
   git push -u origin main
   ```

2. **Buat file `Procfile` di root project** (opsional, Railway auto-detect Laravel)
   ```
   web: php artisan serve --host=0.0.0.0 --port=$PORT
   ```

### Langkah 2: Setup Railway

1. **Daftar di Railway**
   - Kunjungi https://railway.app
   - Sign up dengan GitHub account
   - Klik "New Project"
   - Pilih "Deploy from GitHub repo"
   - Pilih repository Anda

2. **Konfigurasi Environment Variables**
   - Klik pada service yang baru dibuat
   - Pergi ke tab "Variables"
   - Tambahkan variabel berikut:
   ```env
   APP_NAME="Materi Online"
   APP_ENV=production
   APP_KEY=                    # Generate dengan: php artisan key:generate
   APP_DEBUG=false
   APP_URL=https://your-app.railway.app
   
   DB_CONNECTION=mysql
   DB_HOST=                    # Akan diisi otomatis setelah setup database
   DB_PORT=3306
   DB_DATABASE=                # Akan diisi otomatis
   DB_USERNAME=                # Akan diisi otomatis
   DB_PASSWORD=                # Akan diisi otomatis
   
   TURNSTILE_SITE_KEY=         # Jika menggunakan Turnstile
   TURNSTILE_SECRET_KEY=       # Jika menggunakan Turnstile
   ```

3. **Setup Database MySQL**
   - Klik "New" → "Database" → "Add MySQL"
   - Railway akan otomatis membuat database
   - Copy connection string dan update environment variables

4. **Generate APP_KEY**
   - Klik pada service → tab "Deployments"
   - Klik "Deploy" untuk trigger deployment pertama
   - Setelah deploy, buka "Logs" dan jalankan:
   ```bash
   php artisan key:generate
   ```
   - Copy APP_KEY yang dihasilkan ke environment variables

5. **Setup Build & Deploy Commands**
   - Klik service → Settings → "Deploy"
   - Set Build Command:
   ```bash
   composer install --no-dev --optimize-autoloader && npm ci && npm run build
   ```
   - Set Start Command:
   ```bash
   php artisan migrate --force && php artisan storage:link && php artisan serve --host=0.0.0.0 --port=$PORT
   ```

6. **Deploy**
   - Railway akan otomatis deploy setiap kali ada push ke GitHub
   - Atau klik "Deploy" manual

### Langkah 3: Setup Domain (Opsional)

1. Klik service → Settings → "Networking"
2. Klik "Generate Domain" untuk mendapatkan domain gratis
3. Atau tambahkan custom domain Anda

---

## Metode 2: Deploy ke Render.com

### Langkah 1: Persiapan

1. **Buat file `render.yaml` di root project:**
   ```yaml
   services:
     - type: web
       name: materi-online
       env: php
       buildCommand: composer install --no-dev --optimize-autoloader && npm ci && npm run build
       startCommand: php artisan serve --host=0.0.0.0 --port=$PORT
       envVars:
         - key: APP_ENV
           value: production
         - key: APP_DEBUG
           value: false
         - key: LOG_LEVEL
           value: error
   
     - type: pspg
       name: materi-online-db
       plan: free
       databaseName: materi_online
       databaseUser: materi_online_user
   ```

2. **Buat file `.render-build.sh` di root project:**
   ```bash
   #!/usr/bin/env bash
   set -e
   
   composer install --no-dev --optimize-autoloader
   npm ci
   npm run build
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

### Langkah 2: Setup Render

1. **Daftar di Render**
   - Kunjungi https://render.com
   - Sign up dengan GitHub account
   - Klik "New +" → "Blueprint"
   - Connect GitHub repository
   - Render akan auto-detect `render.yaml`

2. **Konfigurasi Environment Variables**
   - Setelah blueprint dibuat, klik pada web service
   - Pergi ke "Environment"
   - Tambahkan variabel yang sama seperti Railway

3. **Setup Database**
   - Database PostgreSQL akan dibuat otomatis dari blueprint
   - Update `DB_CONNECTION=mysql` menjadi `DB_CONNECTION=pgsql` di environment variables
   - Atau buat MySQL database manual (perlu upgrade)

4. **Deploy**
   - Render akan auto-deploy dari GitHub
   - Setelah deploy, jalankan migration via "Shell":
   ```bash
   php artisan migrate --force
   php artisan storage:link
   ```

---

## Metode 3: Deploy ke Fly.io

### Langkah 1: Install Fly CLI

**Windows (PowerShell):**
```powershell
iwr https://fly.io/install.ps1 -useb | iex
```

**Mac/Linux:**
```bash
curl -L https://fly.io/install.sh | sh
```

### Langkah 2: Setup Fly.io

1. **Login ke Fly.io**
   ```bash
   fly auth login
   ```

2. **Inisialisasi project**
   ```bash
   fly launch
   ```
   - Pilih region terdekat
   - Pilih "PostgreSQL" untuk database (gratis)
   - Atau skip dan setup database manual

3. **Buat file `fly.toml`** (akan dibuat otomatis, edit jika perlu):
   ```toml
   app = "materi-online"
   primary_region = "sin"  # Singapore, pilih yang terdekat
   
   [build]
     builder = "paketobuildpacks/builder:base"
   
   [http_service]
     internal_port = 8080
     force_https = true
     auto_stop_machines = false
     auto_start_machines = true
     min_machines_running = 1
     processes = ["app"]
   
   [[services]]
     protocol = "tcp"
     internal_port = 8080
   
     [[services.ports]]
       port = 80
       handlers = ["http"]
       force_https = true
   
     [[services.ports]]
       port = 443
       handlers = ["tls", "http"]
   ```

4. **Buat file `Dockerfile`** (opsional, Fly bisa auto-detect Laravel):
   ```dockerfile
   FROM php:8.2-fpm
   
   # Install dependencies
   RUN apt-get update && apt-get install -y \
       git curl libpng-dev libonig-dev libxml2-dev zip unzip \
       && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd
   
   # Install Composer
   COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
   
   WORKDIR /var/www
   
   COPY . .
   RUN composer install --no-dev --optimize-autoloader
   RUN npm ci && npm run build
   
   EXPOSE 8080
   CMD php artisan serve --host=0.0.0.0 --port=8080
   ```

5. **Setup Secrets (Environment Variables)**
   ```bash
   fly secrets set APP_KEY="your-app-key-here"
   fly secrets set DB_CONNECTION=mysql
   fly secrets set DB_HOST=your-db-host
   # ... dan seterusnya
   ```

6. **Deploy**
   ```bash
   fly deploy
   ```

---

## Checklist Sebelum Deploy

### ✅ Persiapan Code

- [ ] Pastikan `.env` tidak di-commit (ada di `.gitignore`)
- [ ] Update `APP_ENV=production` dan `APP_DEBUG=false` di production
- [ ] Generate `APP_KEY` baru untuk production
- [ ] Pastikan semua migration sudah siap
- [ ] Build assets frontend (`npm run build`)
- [ ] Test aplikasi di local dengan environment production

### ✅ Database

- [ ] Backup database local (jika ada data penting)
- [ ] Pastikan semua migration bisa dijalankan
- [ ] Siapkan seeder jika perlu data awal

### ✅ Storage & Files

- [ ] Pastikan `storage:link` sudah dijalankan
- [ ] Upload file besar ke cloud storage (S3, Cloudinary) jika perlu
- [ ] Pastikan permission folder storage benar

### ✅ Security

- [ ] Update `APP_URL` dengan domain production
- [ ] Setup Turnstile keys untuk production domain
- [ ] Review environment variables yang sensitif
- [ ] Pastikan tidak ada credential hardcoded

---

## Troubleshooting

### Error: "APP_KEY is not set"
```bash
# Generate key di local
php artisan key:generate --show

# Copy hasilnya ke environment variables di platform
```

### Error: "Database connection failed"
- Pastikan database sudah dibuat
- Check environment variables DB_* sudah benar
- Pastikan database host accessible dari platform

### Error: "Storage link failed"
```bash
# Jalankan di platform shell/console
php artisan storage:link
```

### Error: "Migration failed"
```bash
# Jalankan manual di platform shell
php artisan migrate --force
```

### Aplikasi Sleep (Render)
- Render free tier sleep setelah 15 menit tidak aktif
- Pertama kali akses akan butuh waktu ~30 detik untuk wake up
- Upgrade ke paid plan untuk menghindari sleep

---

## Rekomendasi untuk Development Testing

**Untuk testing cepat:**
- Gunakan **Railway.app** (paling mudah, setup cepat)

**Untuk testing jangka panjang:**
- Gunakan **Render.com** (gratis selamanya, tapi sleep)
- Atau **Fly.io** (tidak sleep, lebih stabil)

**Untuk production:**
- Pertimbangkan upgrade ke paid plan
- Atau gunakan hosting khusus Laravel seperti Laravel Forge, Ploi, atau DigitalOcean App Platform

---

## Tips & Best Practices

1. **Gunakan GitHub Actions untuk CI/CD** (opsional)
2. **Setup monitoring** dengan tools seperti Sentry (free tier)
3. **Backup database** secara berkala
4. **Gunakan environment-specific config** untuk development vs production
5. **Monitor resource usage** di dashboard platform
6. **Setup custom domain** untuk branding yang lebih baik

---

## Link Berguna

- [Railway Documentation](https://docs.railway.app)
- [Render Documentation](https://render.com/docs)
- [Fly.io Documentation](https://fly.io/docs)
- [Laravel Deployment](https://laravel.com/docs/deployment)

