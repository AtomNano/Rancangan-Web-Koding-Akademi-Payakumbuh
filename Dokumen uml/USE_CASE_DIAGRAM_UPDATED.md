# Use Case Diagram - E-Learning Coding Payakumbuh (Updated)

## Ringkasan Analisis Proyek

Setelah menganalisis seluruh file di proyek, berikut adalah **fitur-fitur aktual** yang diimplementasikan:

---

## 🎯 Aktor dan Use Cases Terverifikasi

### **1. ADMIN** (Administrator/Pengurus)

#### A. Manajemen Dashboard
- ✅ **Melihat Dashboard Admin**
  - Melihat statistik: total pengguna, guru, siswa, kelas
  - Melihat siswa aktif/tidak aktif
  - Melihat materi pending/approved
  - Melihat recent activity logs

#### B. Manajemen Pengguna (User Management)
- ✅ **Mengelola Data Guru dan Siswa** (CRUD Users)
  - Create: Mendaftarkan guru dan siswa baru
  - Read: Melihat daftar semua users
  - Update: Mengubah data guru dan siswa
  - Delete: Menghapus data pengguna
- ✅ **Mengaktifkan/Menonaktifkan Akun**
  - Activate user account
  - Deactivate user account

#### C. Manajemen Kelas (Class Management)
- ✅ **Mengelola Kelas** (CRUD Kelas)
  - Create: Membuat kelas baru
  - Read: Melihat daftar kelas
  - Update: Mengubah informasi kelas
  - Delete: Menghapus kelas
- ✅ **Mengelola Enrollment Siswa ke Kelas**
  - Enroll: Mendaftarkan siswa ke kelas tertentu
  - Unenroll: Mengeluarkan siswa dari kelas
- ✅ **Export Data Kehadiran Kelas**
  - Export attendance data per kelas
- ✅ **Export Learning Log Siswa**
  - Export data log pembelajaran siswa per kelas

#### D. Manajemen Pertemuan (Meeting/Session Management)
- ✅ **Mengelola Pertemuan Kelas**
  - Select kelas untuk pertemuan
  - Create: Membuat pertemuan baru untuk kelas
  - Read: Melihat daftar pertemuan per kelas
  - Update: Mengubah data pertemuan
  - Delete: Menghapus pertemuan
  - View: Melihat detail pertemuan
- ✅ **Mengelola Absensi Pertemuan**
  - Store absen: Merekam kehadiran siswa per pertemuan
  - View absen detail: Melihat detail kehadiran per pertemuan
- ✅ **Melihat Progress Siswa per Pertemuan**
  - Tracking student progress in sessions

#### E. Verifikasi dan Manajemen Materi
- ✅ **Memverifikasi Materi Pembelajaran**
  - View: Melihat daftar materi pending dan approved
  - Approve: Menyetujui materi yang diupload guru
  - Reject: Menolak materi dengan alasan
  - Remind: Mengirim reminder ke guru
  - Download: Mengunduh file materi untuk review
  - View Detail: Melihat detail lengkap materi

#### F. Backup dan Export Data
- ✅ **Membuat Backup Data**
  - Export Users: Export data pengguna (Excel/CSV)
  - Export Logs: Export activity logs
  - Database Backup: Backup database MySQL
  - Download All Materials: Download semua file materi

#### G. Notifikasi
- ✅ **Mengirim Notifikasi**
  - Notifikasi persetujuan materi
  - Notifikasi pembayaran/enrollment
  - View notifications
  - Mark notifications as read
  - Mark all notifications as read

---

### **2. GURU** (Teacher)

#### A. Manajemen Dashboard Guru
- ✅ **Melihat Dashboard Guru**
  - View assigned classes
  - View material statistics (total, pending, approved)
  - View enrolled classes

#### B. Manajemen Materi Pembelajaran
- ✅ **Mengelola Materi** (CRUD Materials)
  - Create: Mengunggah materi baru (PDF, dokumen, video)
  - Read: Melihat daftar materi yang diupload
  - Update: Mengubah materi
  - Delete: Menghapus materi
  - Download: Mengunduh materi
  - View: Melihat detail materi dan status verifikasi

#### C. Manajemen Kelas Guru
- ✅ **Melihat Kelas yang Diampu**
  - View: Melihat daftar kelas yang diampu
  - Show: Melihat detail kelas dan daftar siswa
- ✅ **Export Learning Log Siswa**
  - Export student learning logs per class

#### D. Manajemen Pertemuan dan Absensi
- ✅ **Mengelola Pertemuan Kelas**
  - Index: Melihat daftar pertemuan
  - Create: Membuat pertemuan baru
  - Show: Melihat detail pertemuan
  - Update: Mengubah pertemuan
  - Delete: Menghapus pertemuan
- ✅ **Mengelola Absensi (Attendance Flow)**
  - Attendance Index: Pilih kelas untuk absensi
  - Select Pertemuan: Pilih pertemuan untuk input absensi
  - Store Absen: Menyimpan data kehadiran siswa
  - View Absen Detail: Melihat detail kehadiran per pertemuan

#### E. Monitoring Progress Siswa
- ✅ **Memantau Progress Siswa**
  - View student progress per class
  - Track material completion
  - View learning statistics

#### F. Notifikasi
- ✅ **Menerima Notifikasi**
  - Notifikasi status verifikasi materi
  - View notifications
  - Mark as read

---

### **3. SISWA** (Student)

#### A. Dashboard Siswa
- ✅ **Melihat Dashboard Siswa**
  - View enrolled classes
  - View material count per class
  - Receive class expiration reminders

#### B. Akses Kelas dan Materi
- ✅ **Mengakses Kelas yang Diikuti**
  - View: Melihat daftar kelas yang diikuti (enrolled classes)
  - Show: Melihat detail kelas dan materi di dalamnya
- ✅ **Mengakses Materi Pembelajaran**
  - View: Melihat daftar materi yang approved
  - Show: Membuka dan mempelajari materi
  - Download: Mengunduh materi untuk offline learning

#### C. Progress Pembelajaran
- ✅ **Menandai Materi Selesai**
  - Complete materi: Menandai materi sebagai selesai dipelajari
  - Mark completed: Menyelesaikan materi PDF
- ✅ **Melacak Progress Pembelajaran**
  - View progress: Melihat progress bar pembelajaran
  - Update progress: Update progress reading PDF (percentage)
  - Get progress: Mengambil data progress materi
  - View learning history

#### D. Absensi
- ✅ **Submit Absensi**
  - Submit absen per materi/pertemuan

#### E. Notifikasi
- ✅ **Menerima Notifikasi**
  - Notifikasi materi baru
  - Notifikasi kelas akan expired
  - View notifications
  - Mark as read

---

### **4. SISTEM** (System Features)

#### A. Autentikasi
- ✅ **Login**
  - Login dengan email & password
  - Login menggunakan Google OAuth
  - Role-based redirect (admin/guru/siswa)
- ✅ **Logout**
- ✅ **Password Management**
  - Update password
  - Confirm password

#### B. Profile Management
- ✅ **Mengelola Profil**
  - Edit profile
  - Update profile information

---

## 📊 Perbaikan Use Case Diagram

### **Temuan Perbedaan dengan Diagram Lama:**

#### ❌ **Fitur di Diagram Lama yang TIDAK Ada di Implementasi:**
1. "Mengakses Akun" - terlalu generik, seharusnya "Login/Autentikasi"
2. "Keluar Dari Sistem" - terlalu formal, lebih tepat "Logout"

#### ✅ **Fitur di Implementasi yang TIDAK Ada di Diagram Lama:**
1. **Admin:**
   - Mengelola Pertemuan (Session Management) ⭐
   - Mengelola Absensi Pertemuan ⭐
   - Export Data Kehadiran ⭐
   - Export Learning Log Siswa ⭐
   - Melihat Progress Siswa per Pertemuan ⭐
   - Mengaktifkan/Menonaktifkan Akun Pengguna ⭐
   - Activity Log Monitoring ⭐

2. **Guru:**
   - Mengelola Pertemuan Kelas ⭐
   - Input Absensi Siswa ⭐
   - Melihat Daftar Siswa per Kelas ⭐
   - Export Learning Log Siswa ⭐

3. **Siswa:**
   - Submit Absensi ⭐
   - Update Progress PDF Reading (dengan percentage tracking) ⭐
   - Menerima Notifikasi Kelas Expiration ⭐

4. **Sistem:**
   - Google OAuth Login ⭐
   - Profile Management ⭐
   - Notification System (All roles) ⭐

---

## 🎨 Rekomendasi Use Case Diagram yang Diperbaiki

### **Struktur yang Disarankan:**

```
┌─────────────────────────────────────────────────────────────────────┐
│           E-Learning Coding Akademi Payakumbuh                      │
│                    Use Case Diagram v2.0                            │
└─────────────────────────────────────────────────────────────────────┘

Aktor: ADMIN
├── Autentikasi
│   ├── Login (include: Google OAuth)
│   └── Logout
│
├── Manajemen Pengguna
│   ├── Mengelola Data Guru dan Siswa (CRUD)
│   ├── Mengaktifkan Akun
│   └── Menonaktifkan Akun
│
├── Manajemen Kelas
│   ├── Mengelola Kelas (CRUD)
│   ├── Enroll Siswa ke Kelas
│   ├── Unenroll Siswa dari Kelas
│   └── Export Data Kehadiran Kelas
│
├── Manajemen Pertemuan ⭐ [BARU]
│   ├── Membuat Pertemuan
│   ├── Mengelola Pertemuan (View/Edit/Delete)
│   ├── Mengelola Absensi Pertemuan
│   └── Melihat Detail Absensi
│
├── Verifikasi Materi
│   ├── Melihat Daftar Materi (Pending/Approved)
│   ├── Menyetujui Materi
│   ├── Menolak Materi
│   ├── Mengirim Reminder ke Guru
│   └── Download Materi untuk Review
│
├── Monitoring
│   ├── Melihat Dashboard & Statistik
│   ├── Melihat Activity Logs ⭐ [BARU]
│   ├── Melihat Progress Siswa ⭐ [BARU]
│   └── Export Learning Log Siswa ⭐ [BARU]
│
├── Backup Data
│   ├── Export Data Pengguna
│   ├── Export Activity Logs
│   ├── Backup Database
│   └── Download Semua Materi
│
└── Notifikasi
    ├── Melihat Notifikasi
    └── Menandai Notifikasi Dibaca


Aktor: GURU
├── Autentikasi
│   ├── Login (include: Google OAuth)
│   └── Logout
│
├── Manajemen Materi
│   ├── Mengunggah Materi Baru
│   ├── Mengelola Materi (View/Edit/Delete)
│   ├── Download Materi
│   └── Melihat Status Verifikasi
│
├── Manajemen Pertemuan ⭐ [BARU]
│   ├── Membuat Pertemuan Kelas
│   ├── Mengelola Pertemuan (View/Edit/Delete)
│   ├── Input Absensi Siswa ⭐
│   └── Melihat Detail Kehadiran ⭐
│
├── Manajemen Kelas
│   ├── Melihat Kelas yang Diampu
│   ├── Melihat Daftar Siswa ⭐ [BARU]
│   └── Export Learning Log Siswa ⭐ [BARU]
│
├── Monitoring
│   ├── Melihat Dashboard Guru
│   ├── Memantau Progress Siswa
│   └── Melihat Statistik Pembelajaran
│
└── Notifikasi
    ├── Melihat Notifikasi Verifikasi
    └── Menandai Notifikasi Dibaca


Aktor: SISWA
├── Autentikasi
│   ├── Login (include: Google OAuth)
│   └── Logout
│
├── Akses Kelas
│   ├── Melihat Daftar Kelas yang Diikuti
│   └── Melihat Detail Kelas
│
├── Akses Materi
│   ├── Melihat Daftar Materi
│   ├── Membuka Materi Pembelajaran
│   └── Download Materi
│
├── Progress Pembelajaran
│   ├── Menandai Materi Selesai
│   ├── Update Progress Membaca PDF ⭐ [BARU]
│   └── Melihat Progress Bar & History
│
├── Absensi ⭐ [BARU]
│   └── Submit Absensi Pertemuan
│
├── Monitoring
│   └── Melihat Dashboard & Progress
│
└── Notifikasi
    ├── Menerima Notifikasi Materi Baru
    ├── Menerima Notifikasi Kelas Expiration ⭐ [BARU]
    └── Menandai Notifikasi Dibaca


Include Relationships:
- Login → Google OAuth Authentication
- Mengelola Data → Mengaktifkan/Menonaktifkan Akun
- Verifikasi Materi → Kirim Notifikasi
- Membuat Pertemuan → Input Absensi
```

---

## 📝 Penjelasan Perubahan

### **1. Fitur Baru yang Ditambahkan:**

#### **Manajemen Pertemuan & Absensi** ⭐
- Fitur ini **sangat penting** dan diimplementasikan lengkap
- Admin dan Guru bisa mengelola pertemuan per kelas
- Sistem absensi terintegrasi dengan pertemuan
- Export kehadiran tersedia

#### **Monitoring & Analytics** ⭐
- Activity logs untuk tracking aktivitas pengguna
- Export learning logs siswa
- Progress tracking yang detail

#### **Google OAuth** ⭐
- Implementasi login dengan Google sudah ada di routes/auth.php

#### **Notification System** ⭐
- Sistem notifikasi lengkap untuk semua role
- Expiration reminder untuk siswa

### **2. Penyesuaian Istilah:**

| Diagram Lama | Diagram Baru | Alasan |
|--------------|--------------|--------|
| "Mengakses Akun" | "Login/Autentikasi" | Lebih spesifik dan sesuai implementasi |
| "Keluar Dari Sistem" | "Logout" | Terminology standar dalam web app |
| "Mengelola data guru dan siswa" | "Mengelola Data Guru dan Siswa (CRUD)" | Lebih eksplisit |
| "Memverifikasi Materi" | "Verifikasi Materi (Approve/Reject)" | Menunjukkan aksi spesifik |

### **3. Pengelompokan Use Case:**

Untuk memudahkan pemahaman, use case dikelompokkan menjadi:
- **Autentikasi** - Login/Logout
- **Manajemen** - CRUD operations
- **Monitoring** - View statistics & progress
- **Notifikasi** - Notification system
- **Backup** - Data export & backup (khusus Admin)

---

## 🔧 File dan Routes yang Dianalisis

### Routes:
- ✅ `routes/web.php` - Main application routes
- ✅ `routes/auth.php` - Authentication routes (including Google OAuth)

### Controllers:
- ✅ `UserController.php` - User management
- ✅ `KelasController.php` - Class management
- ✅ `GuruKelasController.php` - Teacher class view
- ✅ `MateriController.php` - Material management
- ✅ `MateriProgressController.php` - PDF progress tracking
- ✅ `SiswaController.php` - Student features
- ✅ `DashboardController.php` - Dashboard for all roles
- ✅ `NotificationController.php` - Notification system
- ✅ `Admin/PertemuanController.php` - Admin meeting management
- ✅ `Guru/PertemuanController.php` - Teacher meeting management
- ✅ `Admin/BackupController.php` - Backup features

### Models:
- ✅ `User.php` - User with roles
- ✅ `Kelas.php` - Class
- ✅ `Materi.php` - Learning materials
- ✅ `MateriProgress.php` - Material progress tracking
- ✅ `Enrollment.php` - Class enrollment
- ✅ `Pertemuan.php` - Meeting/Session
- ✅ `Presensi.php` - Attendance
- ✅ `ActivityLog.php` - Activity logging

---

## ✅ Kesimpulan

Use case diagram yang Anda berikan **cukup baik secara umum**, tetapi **tidak mencakup beberapa fitur penting** yang sudah diimplementasikan:

### **Fitur yang Hilang dalam Diagram Lama:**
1. ❌ Manajemen Pertemuan & Absensi (sangat penting!)
2. ❌ Google OAuth Login
3. ❌ Aktivasi/Deaktivasi Akun
4. ❌ Export Data & Backup Database
5. ❌ Progress PDF Tracking
6. ❌ Notification System
7. ❌ Activity Logging

### **Rekomendasi:**
✅ Gunakan diagram yang telah saya perbaiki di atas untuk dokumentasi akhir proyek
✅ Tambahkan fitur-fitur yang ditandai ⭐ [BARU]
✅ Kelompokkan use case berdasarkan kategori untuk kemudahan membaca
✅ Gunakan notasi "include" dan "extend" untuk relationship antar use case

---

## 📄 File Terkait

- **Dokumentasi ini:** `USE_CASE_DIAGRAM_UPDATED.md`
- **README Project:** `README.md`
- **Dokumentasi Lengkap:** `ReadmeFile/DOKUMENTASI_LENGKAP_SISTEM_KELAS.md`

---

**Dibuat pada:** 27 Desember 2025  
**Versi:** 2.0  
**Status:** ✅ Verified & Updated
