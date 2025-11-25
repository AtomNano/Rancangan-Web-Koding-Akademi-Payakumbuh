# 🚀 QUICK START - Fix Upload File Besar

## ⚡ Solusi Paling Cepat (Windows)

### Langkah 1: Jalankan Script PowerShell

1. **Buka PowerShell sebagai Administrator**
   - Tekan `Win + X`
   - Pilih "Windows PowerShell (Admin)" atau "Terminal (Admin)"

2. **Masuk ke folder project:**
   ```powershell
   cd "C:\Users\atom\Documents\GitHub\Rancangan-Web-Koding-Akademi-Payakumbuh\CodingAkademi"
   ```

3. **Jalankan script:**
   ```powershell
   .\fix-upload-limits.ps1
   ```

4. **Jika muncul error tentang execution policy:**
   ```powershell
   Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
   ```
   Kemudian jalankan script lagi.

### Langkah 2: Restart Apache

1. **Buka XAMPP/WAMP Control Panel**
2. **Klik "Stop" pada Apache**
3. **Tunggu beberapa detik**
4. **Klik "Start" pada Apache**

### Langkah 3: Verifikasi

1. **Buka browser**
2. **Akses:** `http://localhost/check-upload-config.php`
3. **Pastikan semua status menunjukkan "✓ OK"**

### Langkah 4: Test Upload

1. **Login sebagai Guru**
2. **Coba upload file ~10MB**
3. **Pastikan tidak ada error**

---

## 🎯 Jika Script Tidak Bisa Dijalankan

### Manual Fix (5 Menit)

1. **Buka file php.ini:**
   - XAMPP: `C:\xampp\php\php.ini`
   - WAMP: `C:\wamp\bin\php\php8.x\php.ini`

2. **Tekan Ctrl+F** dan cari:
   - `upload_max_filesize` → Ubah menjadi `100M`
   - `post_max_size` → Ubah menjadi `100M`
   - `max_execution_time` → Ubah menjadi `300`
   - `memory_limit` → Ubah menjadi `256M`

3. **Save** (Ctrl+S)

4. **Restart Apache** dari Control Panel

5. **Selesai!** ✅

---

## 📋 Checklist

- [ ] Script dijalankan atau php.ini sudah diubah
- [ ] Apache sudah di-restart
- [ ] Konfigurasi sudah diverifikasi dengan check-upload-config.php
- [ ] Upload file besar sudah berhasil di-test
- [ ] File check-upload-config.php dan phpinfo.php sudah dihapus (keamanan)

---

## 🆘 Masih Error?

**Cek dengan:**
```
http://localhost/check-upload-config.php
```

**Pastikan:**
- `upload_max_filesize` = 100M
- `post_max_size` = 100M

**Jika masih 8M:**
1. Pastikan file php.ini yang benar sudah diubah
2. Pastikan Apache sudah di-restart
3. Cek apakah ada multiple PHP installation
4. Cek dengan: `php --ini` di command prompt

---

**Selamat! Upload file besar sekarang sudah bisa! 🎉**

