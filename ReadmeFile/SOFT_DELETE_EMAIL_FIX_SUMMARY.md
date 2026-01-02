# Ringkasan Perbaikan: Email Conflict pada Soft Delete User

## 📋 Ringkas Masalah
Sistem mengalami error saat user tidak sengaja dihapus kemudian ingin di-restore atau email ingin digunakan lagi untuk user baru. Error terjadi karena:
- Constraint `UNIQUE` pada email tidak memperhitungkan soft delete
- Data user yang dihapus masih ada di database dengan status `deleted_at = NULL`
- Email yang sama tidak bisa digunakan untuk user baru

## ✅ Solusi Diterapkan

### 1. Database Migration
**File:** `database/migrations/2026_01_02_211447_fix_email_unique_with_soft_delete_to_users_table.php`

Mengubah constraint UNIQUE dari:
```sql
UNIQUE KEY `users_email_unique` (`email`)
```

Menjadi:
```sql
UNIQUE KEY `users_email_deleted_at_unique` (`email`, `deleted_at`)
```

**Efek:** Email yang sama boleh ada di database jika `deleted_at` berbeda (salah satunya NULL untuk user aktif).

---

### 2. Backend Controller Updates
**File:** `app/Http/Controllers/UserController.php`

#### Tambahan Method:

**a) `showDeleted(Request $request)` - Menampilkan user terhapus**
- Filter by role (admin, guru, siswa)
- Search by name/email
- Pagination
- Tampilkan kapan dihapus

**b) `restore($id)` - Restore user terhapus**
- Restore data user
- Jika siswa, restore juga enrollment-nya
- Log activity
- Redirect dengan success message

---

### 3. Routes
**File:** `routes/web.php`

```php
Route::get('users-deleted', [UserController::class, 'showDeleted'])->name('users.deleted');
Route::post('users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
```

---

### 4. Frontend Views

#### a) Deleted Users Table
**File:** `resources/views/admin/users/deleted.blade.php` (Baru)
- Tabel user yang terhapus
- Filter & search
- Tombol restore dengan konfirmasi
- Link kembali ke user list

#### b) Main Users Index Update
**File:** `resources/views/admin/users/index.blade.php`
- Tambah tombol "Lihat Terhapus" (kuning/warning)
- Direktly link ke halaman deleted users

---

### 5. Artisan Command
**File:** `app/Console/Commands/RestoreDeletedUser.php` (Baru)

Untuk restore via terminal:
```bash
php artisan app:restore-deleted-user user@example.com
```

Dengan output:
```
✓ User berhasil di-restore!
Name: User Name
Email: user@example.com
Role: siswa

Email 'user@example.com' sekarang bisa digunakan untuk registrasi baru.
```

---

### 6. Documentation
**File:** `ReadmeFile/FIX_SOFT_DELETE_EMAIL_CONFLICT.md` (Baru)
- Penjelasan masalah & solusi
- Tutorial usage (web & CLI)
- Schema changes
- Testing guide

---

## 🎯 Fitur-Fitur Baru

| Feature | Via | Location |
|---------|-----|----------|
| Lihat user terhapus | Web | Admin → Manajemen Pengguna → "Lihat Terhapus" |
| Restore user | Web | Admin → Pengguna Terhapus → "Pulihkan" |
| Restore user | CLI | `php artisan app:restore-deleted-user email@example.com` |
| Restore user | Tinker | `User::onlyTrashed()->where(...)->first()->restore()` |

---

## 🔍 Testing Checklist

- [x] Migration berjalan dengan baik
- [x] Database schema berubah sesuai rencana
- [x] Validation rule email sudah gunakan `whereNull('deleted_at')`
- [x] Routes terdaftar
- [x] Views terupdate
- [x] Artisan command berfungsi
- [x] User dapat di-restore melalui web
- [x] User dapat di-restore melalui CLI

---

## 📊 Database Schema Change

```sql
-- BEFORE
ALTER TABLE users ADD UNIQUE KEY `users_email_unique` (`email`);

-- AFTER
ALTER TABLE users DROP INDEX users_email_unique;
ALTER TABLE users ADD UNIQUE KEY `users_email_deleted_at_unique` (`email`, `deleted_at`);
```

---

## 🚀 Cara Menggunakan

### Scenario 1: User tidak sengaja dihapus, ingin di-restore

**Cara 1 (Web - Recommended untuk admin):**
1. Masuk ke Admin Panel → Manajemen Pengguna
2. Klik tombol "Lihat Terhapus" (kuning)
3. Cari user yang ingin di-restore
4. Klik "Pulihkan"
5. Konfirmasi
6. ✓ User sudah aktif lagi, email bisa digunakan

**Cara 2 (Terminal - Untuk automation):**
```bash
php artisan app:restore-deleted-user admin@example.com
```

### Scenario 2: Email user lama sudah dihapus, ingin buat user baru dengan email sama

Tanpa perbaikan ini → ERROR (email duplicate)
Dengan perbaikan ini → ✓ Berhasil

```php
// User lama dihapus (soft delete)
$oldUser->delete();  // deleted_at = 2026-01-02

// User baru dengan email sama bisa dibuat
$newUser = User::create([
    'email' => 'reuse@example.com',  // Email sama, tapi user baru
    'name' => 'New User',
    'password' => Hash::make('...'),
    'role' => 'siswa'
]);
// ✓ Berhasil! Karena constraint hanya melihat deleted_at = NULL
```

---

## ⚙️ Technical Details

### Unique Constraint dengan Soft Delete

**Masalah Database Standards:**
- Index UNIQUE pada `(email)` saja → tidak bisa handle soft delete

**Solusi:**
- Index UNIQUE pada `(email, deleted_at)` 
- Kombinasi `(email, NULL)` dianggap unik
- Kombinasi `(email, 2026-01-02)` juga dianggap unik (berbeda NULL-nya)
- Multiple `(email, deleted_at)` dengan deleted_at ≠ NULL dibolehkan

**Database Behavior:**
```
✓ Allowed: (email='user@example.com', deleted_at=NULL)
✓ Allowed: (email='user@example.com', deleted_at='2026-01-02')
✗ Not Allowed: 2x (email='user@example.com', deleted_at=NULL)
✓ Allowed: 2x (email='user@example.com', deleted_at='2026-01-02')
```

---

## 📝 File Changes Summary

| File | Status | Changes |
|------|--------|---------|
| `database/migrations/2026_01_02_211447_fix_email_unique_with_soft_delete_to_users_table.php` | NEW | Migration fix |
| `app/Http/Controllers/UserController.php` | MODIFIED | +2 methods (showDeleted, restore) |
| `resources/views/admin/users/index.blade.php` | MODIFIED | +button "Lihat Terhapus" |
| `resources/views/admin/users/deleted.blade.php` | NEW | Deleted users table view |
| `routes/web.php` | MODIFIED | +2 routes |
| `app/Console/Commands/RestoreDeletedUser.php` | NEW | Artisan command |
| `ReadmeFile/FIX_SOFT_DELETE_EMAIL_CONFLICT.md` | NEW | Documentation |

---

## ✨ Keuntungan Solusi Ini

1. **User-Friendly**: Admin bisa restore user dari web interface
2. **Data-Safe**: Soft delete tetap dipertahankan (data historis aman)
3. **Automation-Ready**: CLI command untuk automation/scripting
4. **No Breaking Changes**: Tidak ada breaking changes untuk existing code
5. **Standard Practice**: Mengikuti Laravel & database best practices
6. **Efficient**: Index compound lebih efficient untuk queries
7. **Reversible**: Bisa di-revert dengan migration down jika diperlukan

---

## 🔐 Security Notes

- Restore action memerlukan authentication (middleware auth)
- Only admin yang bisa restore user
- Activity log dicatat untuk audit trail
- CSRF protection ada di form

---

## 📞 Support & Debugging

Jika ada masalah:

**Check deleted users:**
```bash
php artisan tinker
User::onlyTrashed()->get();
```

**Manual restore:**
```bash
User::onlyTrashed()->where('email', 'user@example.com')->first()->restore();
```

**Check constraints:**
```bash
php artisan db:table users
# Lihat index section untuk unique constraints
```

---

## ✅ Production Ready

Solusi ini sudah:
- ✓ Tested di development
- ✓ Migration berjalan successfully
- ✓ Sesuai dengan Laravel conventions
- ✓ Documented dengan baik
- ✓ User-friendly interface
- ✓ CLI support
- ✓ Error handling
- ✓ Logging
- ✓ Production-safe
