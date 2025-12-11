# Troubleshooting: Tombol Download & Delete Tidak Muncul

## Penyebab Umum

### 1. Belum Ada Backup
**Gejala:** Tabel riwayat cadangan kosong, hanya muncul "Tidak ada riwayat cadangan."

**Solusi:**
1. Klik tombol **"Buat Cadangan Manual"** di bagian atas halaman
2. Tunggu beberapa saat hingga backup selesai
3. Refresh halaman (F5)
4. Tombol download dan delete akan muncul di setiap backup

### 2. Cache Belum Di-clear
**Gejala:** Perubahan kode belum terlihat

**Solusi:**
```bash
# Di server (via SSH)
cd ~/laravel_app
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

### 3. Backup Kosong atau Error
**Gejala:** Backup ada di tabel tapi tombol tidak muncul

**Solusi:**
1. Cek log error: `storage/logs/laravel.log`
2. Pastikan permission folder backup benar:
   ```bash
   chmod -R 775 storage/app
   chmod -R 775 storage/app/private
   ```

## Cara Test

### Step 1: Buat Backup
1. Login sebagai Admin
2. Buka menu **Cadangan Data**
3. Klik **"Buat Cadangan Manual"**
4. Tunggu hingga muncul pesan sukses

### Step 2: Verifikasi Tombol
1. Refresh halaman (F5)
2. Di tabel "Riwayat Cadangan", harus ada:
   - Kolom "Tanggal & Waktu"
   - Kolom "Tipe" (Manual/Otomatis)
   - Kolom "Ukuran"
   - Kolom "Status" (Berhasil)
   - **Kolom "Aksi"** dengan 2 tombol:
     - Ikon download (panah ke bawah, warna biru)
     - Ikon delete (trash, warna merah)

### Step 3: Test Download
1. Klik ikon download (ikon panah ke bawah)
2. File ZIP harus terunduh ke komputer

### Step 4: Test Delete
1. Klik ikon delete (ikon trash)
2. Konfirmasi penghapusan
3. Backup harus terhapus dari tabel

## Jika Masih Tidak Muncul

### Cek Browser Console
1. Buka Developer Tools (F12)
2. Tab Console
3. Cek apakah ada error JavaScript

### Cek Network Tab
1. Buka Developer Tools (F12)
2. Tab Network
3. Refresh halaman
4. Cek apakah route `backup` load dengan benar

### Cek Route
```bash
# Di server (via SSH)
php artisan route:list | grep backup
```

Harus muncul:
- `GET admin/backup`
- `GET admin/backup/create`
- `GET admin/backup/download/{filename}`
- `DELETE admin/backup/delete/{filename}`

## Verifikasi File

Pastikan file berikut sudah ter-update:
- ✅ `app/Http/Controllers/Admin/BackupController.php` - Method download() dan delete() ada
- ✅ `routes/web.php` - Route download dan delete terdaftar
- ✅ `resources/views/admin/backup/index.blade.php` - Tombol download dan delete ada di view

## Status
✅ **FIXED** - Tombol download dan delete sudah ditambahkan dengan pengecekan yang lebih aman.



