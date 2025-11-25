# Quick Deploy Guide - Railway.app (Paling Mudah)

Panduan cepat deploy ke Railway.app untuk testing development.

## ⚡ Langkah Cepat (5 Menit)

### 1. Push ke GitHub
```bash
git add .
git commit -m "Ready for deployment"
git push origin main
```

### 2. Setup Railway

1. **Daftar & Login**
   - Buka https://railway.app
   - Klik "Start a New Project"
   - Login dengan GitHub
   - Klik "Deploy from GitHub repo"
   - Pilih repository Anda

2. **Railway akan otomatis:**
   - Detect Laravel project
   - Setup build process
   - Deploy aplikasi

### 3. Setup Database

1. Klik "New" → "Database" → "Add MySQL"
2. Railway akan membuat database otomatis
3. Copy connection details

### 4. Setup Environment Variables

Klik pada web service → Tab "Variables" → Tambahkan:

```env
APP_NAME="Materi Online"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.railway.app

# Database (isi dari database yang baru dibuat)
DB_CONNECTION=mysql
DB_HOST=containers-us-west-xxx.railway.app
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=xxxxx

# Generate APP_KEY di local, lalu copy ke sini
APP_KEY=base64:xxxxx

# Turnstile (jika digunakan)
TURNSTILE_SITE_KEY=your_site_key
TURNSTILE_SECRET_KEY=your_secret_key
```

### 5. Generate APP_KEY

**Di local computer:**
```bash
php artisan key:generate --show
```

Copy hasilnya ke `APP_KEY` di Railway environment variables.

### 6. Setup Build Commands

Klik service → Settings → Deploy:

**Build Command:**
```bash
composer install --no-dev --optimize-autoloader && npm ci && npm run build
```

**Start Command:**
```bash
php artisan migrate --force && php artisan storage:link && php artisan serve --host=0.0.0.0 --port=$PORT
```

### 7. Deploy

- Railway akan auto-deploy dari GitHub
- Atau klik "Deploy" manual
- Tunggu hingga selesai (2-5 menit)

### 8. Setup Domain

1. Klik service → Settings → Networking
2. Klik "Generate Domain"
3. Copy domain yang diberikan (contoh: `your-app.up.railway.app`)
4. Update `APP_URL` di environment variables dengan domain ini

### 9. Test Aplikasi

Buka domain yang diberikan di browser. Aplikasi seharusnya sudah berjalan!

---

## 🔧 Troubleshooting Cepat

### Aplikasi Error 500
- Check logs di Railway dashboard
- Pastikan `APP_KEY` sudah di-set
- Pastikan database connection benar

### Database Error
- Pastikan database sudah dibuat
- Check environment variables DB_* sudah benar
- Pastikan migration sudah jalan: `php artisan migrate --force`

### Assets tidak muncul
- Pastikan `npm run build` sudah jalan di build command
- Check folder `public/build` ada isinya

### Storage files tidak muncul
- Jalankan di Railway shell: `php artisan storage:link`
- Atau tambahkan di start command

---

## 💡 Tips

1. **Auto-deploy**: Setiap push ke GitHub akan auto-deploy
2. **Logs**: Check logs real-time di Railway dashboard
3. **Database**: Railway MySQL gratis untuk development
4. **Sleep**: Free tier sleep setelah 7 hari tidak aktif
5. **Credit**: Railway beri $5 credit gratis per bulan

---

## 📝 Checklist

- [ ] Repository sudah di GitHub
- [ ] Railway account sudah dibuat
- [ ] Database MySQL sudah dibuat
- [ ] Environment variables sudah di-set
- [ ] APP_KEY sudah di-generate
- [ ] Build & Start commands sudah di-set
- [ ] Deploy berhasil
- [ ] Domain sudah di-generate
- [ ] Aplikasi bisa diakses

---

## 🚀 Next Steps

Setelah deploy berhasil:
1. Test semua fitur aplikasi
2. Setup custom domain (opsional)
3. Monitor resource usage
4. Setup backup database (opsional)

Selamat! Aplikasi Anda sudah online! 🎉

