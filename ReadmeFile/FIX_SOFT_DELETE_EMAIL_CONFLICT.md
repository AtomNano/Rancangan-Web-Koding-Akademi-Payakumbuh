# Solusi: Email Conflict pada User yang Terhapus (Soft Delete)

## Masalah

Sistem menggunakan **Soft Delete** untuk user, artinya ketika user dihapus, data masih ada di database (kolom `deleted_at` diisi dengan timestamp). Sebelumnya, tabel `users` memiliki constraint `UNIQUE` pada kolom `email` saja. Ini menyebabkan masalah:

1. User tidak sengaja dihapus tapi datanya masih ada di database
2. Saat mencoba menambah user baru dengan email yang sama → **ERROR: Duplicate email**
3. Tidak bisa restore user atau menggunakan email tersebut lagi

## Solusi Yang Diterapkan

### 1. **Migration: Fix Email Unique with Soft Delete**
File: `database/migrations/2026_01_02_211447_fix_email_unique_with_soft_delete_to_users_table.php`

**Perubahan:**
```sql
-- Sebelumnya:
UNIQUE KEY `users_email_unique` (`email`)

-- Setelah fix:
UNIQUE KEY `users_email_deleted_at_unique` (`email`, `deleted_at`)
```

**Keuntungan:**
- Email yang sama bisa digunakan jika user sebelumnya sudah dihapus (deleted_at NOT NULL)
- Email tetap unik untuk user yang aktif (deleted_at IS NULL)
- Memungkinkan multiple "deleted" users dengan email yang sama

### 2. **UserController: Restore & View Deleted Users**

#### Method `showDeleted()`
- Menampilkan semua user yang telah dihapus
- Bisa difilter berdasarkan role
- Bisa dicari berdasarkan nama atau email

#### Method `restore()`
- Restore user yang telah dihapus
- Jika user adalah siswa, enrollment yang inactive akan di-activate kembali
- Log activity dicatat

### 3. **Routes**
```php
Route::get('users-deleted', [UserController::class, 'showDeleted'])->name('users.deleted');
Route::post('users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
```

### 4. **View: Deleted Users**
File: `resources/views/admin/users/deleted.blade.php`

Menampilkan tabel user yang telah dihapus dengan:
- Nama, Email, Role, Waktu dihapus
- Tombol untuk restore user
- Filter berdasarkan role
- Search functionality

### 5. **Artisan Command**
File: `app/Console/Commands/RestoreDeletedUser.php`

Untuk restore user via terminal:
```bash
php artisan app:restore-deleted-user user@example.com
```

## Cara Menggunakan

### Via Web Admin Panel

1. **Lihat user yang terhapus:**
   - Masuk ke Admin Dashboard → Manajemen Pengguna
   - Klik tombol "Lihat Terhapus" (kuning)

2. **Restore user:**
   - Pilih user yang ingin di-restore
   - Klik tombol "Pulihkan"
   - Konfirmasi pada dialog yang muncul
   - Email siap digunakan kembali untuk registrasi baru

### Via Artisan Command

```bash
# Restore user berdasarkan email
php artisan app:restore-deleted-user admin@example.com

# Output contoh:
# ✓ User berhasil di-restore!
# Name: Admin User
# Email: admin@example.com
# Role: admin
#
# Email 'admin@example.com' sekarang bisa digunakan untuk registrasi baru.
```

### Via Tinker (PHP Interactive Shell)

```php
php artisan tinker

# Lihat semua user yang dihapus
User::onlyTrashed()->get();

# Restore user berdasarkan email
$user = User::onlyTrashed()->where('email', 'user@example.com')->first();
$user->restore();

# Jika siswa, restore enrollmentnya
if ($user->isSiswa()) {
    $user->enrollments()->where('status', 'inactive')->update(['status' => 'active']);
}
```

## Validasi Form untuk Registrasi

Sudah di-update di `UserController@store()`:

```php
'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->whereNull('deleted_at')]
```

Validasi ini memastikan email hanya unik untuk user yang tidak dihapus (`deleted_at IS NULL`).

## Database Schema

### Sebelum Fix
```
UNIQUE KEY `users_email_unique` (`email`)
```

### Sesudah Fix
```
UNIQUE KEY `users_email_deleted_at_unique` (`email`, `deleted_at`)
```

### Cara Kerjanya
| email | deleted_at | Status | Notes |
|-------|-----------|--------|-------|
| user@example.com | NULL | ✓ Unik | User aktif |
| user@example.com | 2026-01-02 | ✓ Unik | User terhapus (bisa reuse email) |
| user@example.com | NULL | ✗ Error | Duplikasi - tidak boleh (soft delete aktif) |
| admin@example.com | NULL | ✓ Unik | User baru aktif |

## Log Activity

Setiap restore user akan dicatat dalam activity log sistem.

## Testing

Untuk test di development:

```bash
# 1. Buat user baru
php artisan tinker
$user = User::create(['name' => 'Test', 'email' => 'test@example.com', 'password' => Hash::make('password'), 'role' => 'siswa']);

# 2. Hapus user
$user->delete();

# 3. Coba buat user baru dengan email sama (harus berhasil sekarang)
$user2 = User::create(['name' => 'Test 2', 'email' => 'test@example.com', 'password' => Hash::make('password'), 'role' => 'siswa']);
# ✓ Berhasil!

# 4. Restore user pertama
$user->restore();

# 5. Coba buat user baru dengan email sama (seharusnya error)
$user3 = User::create(['name' => 'Test 3', 'email' => 'test@example.com', 'password' => Hash::make('password'), 'role' => 'siswa']);
# ✗ Error: Duplicate entry (karena $user sudah di-restore)
```

## Files yang Diubah

1. ✅ `database/migrations/2026_01_02_211447_fix_email_unique_with_soft_delete_to_users_table.php` - Baru
2. ✅ `app/Http/Controllers/UserController.php` - Edit (tambah method restore & showDeleted)
3. ✅ `resources/views/admin/users/deleted.blade.php` - Baru
4. ✅ `resources/views/admin/users/index.blade.php` - Edit (tambah tombol "Lihat Terhapus")
5. ✅ `routes/web.php` - Edit (tambah 2 route baru)
6. ✅ `app/Console/Commands/RestoreDeletedUser.php` - Baru

## Kesimpulan

Solusi ini memungkinkan:
- ✅ User yang tidak sengaja dihapus bisa di-restore
- ✅ Email bisa digunakan kembali untuk registrasi baru
- ✅ Data historis tetap tersimpan (soft delete)
- ✅ Interface user-friendly untuk manage deleted users
- ✅ Command line interface untuk automation
