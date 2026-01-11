# Quick Start: Restore User Terhapus

## Situasi

User tidak sengaja dihapus dan:
- ❌ Ingin restore user tersebut
- ❌ Ingin gunakan email-nya lagi untuk user baru
- ❌ Mendapat error "Duplicate email" saat membuat user baru

## Solusi

Pilihlah salah satu cara:

### Cara 1: Via Admin Web Panel (RECOMMENDED)

**Langkah-langkah:**

1. **Masuk Dashboard Admin**
   - URL: `/admin/dashboard`

2. **Ke Manajemen Pengguna**
   - Klik menu "Manajemen Pengguna"

3. **Klik tombol "Lihat Terhapus"** (warna kuning)
   - Akan melihat daftar user yang telah dihapus
   - Bisa filter by role (Admin, Guru, Siswa)
   - Bisa search by nama/email

4. **Pilih user yang mau di-restore**
   - Klik tombol "Pulihkan" 
   - Konfirmasi di dialog yang muncul

5. **✓ Done!**
   - User sudah aktif kembali
   - Email siap digunakan untuk user baru
   - Activity log tercatat otomatis

---

### Cara 2: Via Terminal (CLI)

**Command:**
```bash
php artisan app:restore-deleted-user user@example.com
```

**Contoh:**
```bash
$ php artisan app:restore-deleted-user admin@sekolah.com

✓ User berhasil di-restore!
Name: Admin Sekolah
Email: admin@sekolah.com
Role: admin

Email 'admin@sekolah.com' sekarang bisa digunakan untuk registrasi baru.
```

---

### Cara 3: Via PHP Tinker

**Command:**
```bash
php artisan tinker
```

**Script:**
```php
// 1. Lihat semua user yang terhapus
User::onlyTrashed()->get();

// 2. Cari user berdasarkan email
$user = User::onlyTrashed()->where('email', 'admin@example.com')->first();

// 3. Restore
$user->restore();

// 4. Jika siswa, restore juga enrollmentnya
if ($user->isSiswa()) {
    $user->enrollments()->where('status', 'inactive')->update(['status' => 'active']);
}

// 5. Verify
exit;
```

---

## Sebelum & Sesudah

### Sebelum Fix
```
User terhapus tapi email masih "terpakai"
↓
Coba buat user baru dengan email sama
↓
ERROR: Duplicate entry for email
↓
❌ Terjebak - tidak bisa pakai email lama, tidak bisa restore
```

### Sesudah Fix
```
User terhapus tapi email masih "terpakai"
↓
Klik "Lihat Terhapus" → Restore user
↓
✓ User aktif, enrollment aktif, email siap pakai
↓
Atau buat user baru dengan email yang sudah di-restore user lama
↓
✓ Email bisa digunakan
```

---

## FAQ

**Q: Apakah data user benar-benar hilang?**
A: Tidak. Ini adalah "soft delete" - data tetap ada di database tapi ditandai sebagai dihapus. Bisa di-restore kapan saja.

**Q: Bisa restore user dengan password lama?**
A: Ya, semua data (termasuk password) akan kembali normal. User bisa login dengan password lama.

**Q: Apakah enrollment siswa ikut di-restore?**
A: Ya, semua enrollment siswa yang inactive akan di-restore menjadi active.

**Q: Apakah ada log/history restore?**
A: Ya, setiap restore dicatat dalam activity log sistem untuk audit trail.

**Q: Bisa delete multiple user sekaligus?**
A: Saat ini hanya satu-satu. Bisa request untuk batch restore jika diperlukan.

**Q: Berapa lama user bisa di-restore?**
A: Unlimited. Selama di-soft delete (tidak di-delete permanent), bisa di-restore.

---

## Troubleshooting

### Error: "User tidak ditemukan"
```bash
php artisan app:restore-deleted-user nonexistent@example.com
# Error: User dengan email 'nonexistent@example.com' tidak ditemukan dalam data yang dihapus.
```
**Solusi:** Verify email address dari user yang benar-benar dihapus. 

Cek daftar user terhapus:
```bash
php artisan tinker
User::onlyTrashed()->pluck('email');
```

### Error: "SQLSTATE[23000]: Duplicate entry"
Jika masih dapat error duplicate setelah restore:
```bash
# Verify struktur database
php artisan db:table users
# Pastikan ada: users_email_deleted_at_unique di index section
```

Jika index belum berubah, jalankan migration:
```bash
php artisan migrate
```

---

## Contact & Support

Untuk issues atau pertanyaan:
1. Check documentation: `ReadmeFile/FIX_SOFT_DELETE_EMAIL_CONFLICT.md`
2. Check summary: `ReadmeFile/SOFT_DELETE_EMAIL_FIX_SUMMARY.md`
3. Report ke team development

---

**Last Updated:** 2 Jan 2026
**Status:** ✓ Production Ready
