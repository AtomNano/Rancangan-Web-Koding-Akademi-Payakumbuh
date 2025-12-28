# User Story Sprint Planning
## E-Learning Coding Akademi Payakumbuh

> **Total: 49 User Stories | 4 Sprints | 100% Complete**

---

## Summary

| Sprint | Focus | Stories | Status |
|--------|-------|---------|--------|
| Sprint 1 | Core Authentication & Basic CRUD | 20 | ✅ 100% |
| Sprint 2 | Advanced CRUD & Profile | 13 | ✅ 100% |
| Sprint 3 | Learning Features & Progress | 10 | ✅ 100% |
| Sprint 4 | Reports, Backup & Notifications | 6 | ✅ 100% |

---

## SPRINT 1: Core Authentication & Basic CRUD

### PENGGUNA (UMUM)

| # | ID | User Story | Acceptance Criteria | Status |
|---|-----|------------|---------------------|--------|
| 1 | US0001 | Login ke sistem menggunakan email dan kata sandi | 1. Halaman login menampilkan kolom email dan kata sandi. 2. Sistem memvalidasi email dan kata sandi. 3. Jika valid, diarahkan ke dashboard sesuai role. 4. Jika tidak valid, muncul pesan error. | ✅ Selesai |
| 2 | US0002 | Logout dari sistem dengan aman | 1. Terdapat tombol "Logout" yang mudah diakses. 2. Setelah diklik, sesi pengguna berakhir. 3. Pengguna diarahkan ke halaman login. | ✅ Selesai |
| 3 | US0003 | Melihat dashboard utama setelah login | 1. Admin: Menampilkan statistik (guru, siswa, kelas). 2. Guru: Menampilkan daftar kelas yang diajar. 3. Siswa: Menampilkan daftar kelas yang diikuti. | ✅ Selesai |

### ADMIN

| # | ID | User Story | Acceptance Criteria | Status |
|---|-----|------------|---------------------|--------|
| 4 | US1001 | Melihat daftar Guru | 1. Admin mengakses halaman manajemen Guru. 2. Menampilkan daftar Guru (Nama, Email, Bidang Ajar). | ✅ Selesai |
| 5 | US1002 | Menambah data Guru baru | 1. Terdapat tombol "Tambah Guru". 2. Form: Nama, Email, Kata Sandi Awal. 3. Data Guru baru muncul di daftar. | ✅ Selesai |
| 6 | US1003 | Melihat daftar Siswa | 1. Admin mengakses halaman manajemen Siswa. 2. Menampilkan daftar Siswa (Nama, Email, NIS). | ✅ Selesai |
| 7 | US1004 | Menambah data Siswa baru | 1. Terdapat tombol "Tambah Siswa". 2. Form: Nama, Email, Kata Sandi Awal. 3. Data Siswa baru muncul di daftar. | ✅ Selesai |
| 8 | US1005 | Membuat kelas baru | 1. Form: Nama Kelas, Deskripsi, Guru Pengampu. 2. Kelas baru muncul dalam daftar kelas. | ✅ Selesai |
| 9 | US1006 | Mendaftarkan (enroll) siswa ke kelas | 1. Di halaman detail kelas, ada fitur "Daftarkan Siswa". 2. Admin bisa memilih satu atau lebih siswa. | ✅ Selesai |
| 10 | US1007 | Mengeluarkan (unenroll) siswa dari kelas | 1. Tombol "Keluarkan" pada setiap siswa di daftar kelas. 2. Konfirmasi sebelum unenroll. | ✅ Selesai |
| 11 | US1008 | Melihat daftar materi menunggu verifikasi | 1. Admin mengakses halaman "Verifikasi Materi". 2. Menampilkan daftar materi berstatus "Pending". | ✅ Selesai |
| 12 | US1009 | Menyetujui materi (approve) | 1. Terdapat tombol "Setujui". 2. Status materi berubah menjadi "Approved". | ✅ Selesai |
| 13 | US1010 | Membuat pertemuan baru untuk kelas | 1. Form: Tanggal, Pertemuan ke-, Topik, Deskripsi. 2. Pertemuan baru muncul di daftar. | ✅ Selesai |
| 14 | US1011 | Mengedit informasi pertemuan | 1. Opsi "Edit" pada setiap pertemuan. 2. Admin dapat mengubah tanggal, topik, deskripsi. | ✅ Selesai |
| 15 | US1012 | Menghapus pertemuan | 1. Opsi "Hapus" pada setiap pertemuan. 2. Konfirmasi sebelum menghapus. | ✅ Selesai |
| 16 | US1013 | Menginput absensi siswa per pertemuan | 1. Form input status: Hadir, Izin, Sakit, Alpha. 2. Simpan presensi untuk semua siswa. | ✅ Selesai |

### GURU

| # | ID | User Story | Acceptance Criteria | Status |
|---|-----|------------|---------------------|--------|
| 17 | US2001 | Menambahkan materi pembelajaran (PDF/Video) | 1. Guru memilih kelas tujuan. 2. Form unggah materi. 3. Status otomatis "Pending". | ✅ Selesai |
| 18 | US2002 | Melihat daftar dan status materi yang diunggah | 1. Halaman daftar materi. 2. Setiap materi menampilkan status (Pending/Approved/Rejected). | ✅ Selesai |

### SISWA

| # | ID | User Story | Acceptance Criteria | Status |
|---|-----|------------|---------------------|--------|
| 19 | US3001 | Melihat daftar kelas yang diikuti | 1. Dashboard siswa menampilkan daftar kelas yang diikuti. | ✅ Selesai |
| 20 | US3002 | Mengakses materi di dalam kelas | 1. Siswa dapat mengklik kelas. 2. Menampilkan daftar materi approved. | ✅ Selesai |

---

## SPRINT 2: Advanced CRUD & Profile

### PENGGUNA (UMUM)

| # | ID | User Story | Acceptance Criteria | Status |
|---|-----|------------|---------------------|--------|
| 21 | US0004 | Mengubah kata sandi | 1. Menu "Ubah Kata Sandi" di profil. 2. Validasi kata sandi lama. | ✅ Selesai |
| 22 | US0005 | Reset kata sandi jika lupa | 1. Link "Lupa Kata Sandi?" di login. 2. Sistem kirim link reset ke email. | ✅ Selesai |
| 23 | US0006 | Melihat Landing Page | 1. Landing Page menampilkan info Coding Academy. 2. Foto/dokumentasi kegiatan. | ✅ Selesai |
| 24 | US0007 | Menerima notifikasi tentang aktivitas | 1. Notifikasi di dashboard. 2. Dapat ditandai sebagai sudah dibaca. | ✅ Selesai |

### ADMIN

| # | ID | User Story | Acceptance Criteria | Status |
|---|-----|------------|---------------------|--------|
| 25 | US1014 | Mengedit data Guru yang sudah ada | 1. Opsi "Edit" pada data Guru. 2. Admin dapat mengubah data. | ✅ Selesai |
| 26 | US1015 | Menghapus data Guru | 1. Opsi "Hapus" pada data Guru. 2. Konfirmasi sebelum menghapus. | ✅ Selesai |
| 27 | US1016 | Mengedit data Siswa yang sudah ada | 1. Opsi "Edit" pada data Siswa. 2. Admin dapat mengubah data. | ✅ Selesai |
| 28 | US1017 | Menghapus data Siswa | 1. Opsi "Hapus" pada data Siswa. 2. Konfirmasi sebelum menghapus. | ✅ Selesai |
| 29 | US1018 | Mengubah detail kelas (edit) | 1. Opsi "Edit" pada daftar kelas. 2. Ubah Nama, Deskripsi, atau Guru. | ✅ Selesai |
| 30 | US1019 | Menolak materi yang tidak sesuai | 1. Tombol "Tolak" untuk setiap materi. 2. Input alasan penolakan. | ✅ Selesai |

### GURU

| # | ID | User Story | Acceptance Criteria | Status |
|---|-----|------------|---------------------|--------|
| 31 | US2003 | Melihat daftar hadir siswa | 1. Guru akses halaman kehadiran. 2. Menampilkan status kehadiran per pertemuan. | ✅ Selesai |
| 32 | US2004 | Memantau progres belajar siswa | 1. Halaman "Pemantauan Progres". 2. Tabel progres penyelesaian materi. | ✅ Selesai |

### SISWA

| # | ID | User Story | Acceptance Criteria | Status |
|---|-----|------------|---------------------|--------|
| 33 | US3003 | Melihat progress bar kemajuan belajar | 1. Progress bar visual per kelas. 2. Diperbarui otomatis saat materi selesai. | ✅ Selesai |

---

## SPRINT 3: Learning Features & Progress

### ADMIN

| # | ID | User Story | Acceptance Criteria | Status |
|---|-----|------------|---------------------|--------|
| 34 | US1020 | Menghapus kelas | 1. Opsi "Hapus" pada daftar kelas. 2. Konfirmasi sebelum menghapus. | ✅ Selesai |
| 35 | US1021 | Mengaktifkan/menonaktifkan pengguna | 1. Tombol toggle status (Aktif/Nonaktif). 2. Pengguna tidak aktif tidak bisa login. | ✅ Selesai |
| 36 | US1022 | Menampilkan history/riwayat siswa | 1. Menampilkan tanggal dan waktu aktivitas. 2. Jenis dan detail aktivitas. | ✅ Selesai |
| 37 | US1023 | Export absensi kelas ke Excel | 1. Tombol "Export Absensi". 2. Generate file Excel. 3. File otomatis terdownload. | ✅ Selesai |
| 38 | US1024 | Export learning log siswa ke Excel | 1. Tombol "Export Learning Log". 2. Generate file Excel. 3. File otomatis terdownload. | ✅ Selesai |

### GURU

| # | ID | User Story | Acceptance Criteria | Status |
|---|-----|------------|---------------------|--------|
| 39 | US2005 | Mengedit materi yang pernah diunggah | 1. Opsi "Edit" untuk materi Pending/Rejected. 2. Materi yang diedit kembali berstatus "Pending". | ✅ Selesai |
| 40 | US2006 | Menghapus materi yang tidak relevan | 1. Opsi "Hapus" pada materi. 2. Konfirmasi sebelum penghapusan. | ✅ Selesai |
| 41 | US2007 | Mendapatkan laporan kehadiran otomatis | 1. Halaman "Laporan Kehadiran". 2. Filter berdasarkan kelas dan periode. | ✅ Selesai |

### SISWA

| # | ID | User Story | Acceptance Criteria | Status |
|---|-----|------------|---------------------|--------|
| 42 | US3004 | Progress membaca PDF tersimpan otomatis | 1. Saat ganti halaman PDF, progress tersimpan otomatis (AJAX). 2. Melanjutkan dari halaman terakhir. | ✅ Selesai |
| 43 | US3005 | Melihat status pembayaran di profil | 1. Informasi status pembayaran (Lunas/Belum Lunas) di profil. | ✅ Selesai |

---

## SPRINT 4: Reports, Backup & Notifications

### ADMIN

| # | ID | User Story | Acceptance Criteria | Status |
|---|-----|------------|---------------------|--------|
| 44 | US1025 | Mengirim notifikasi pengingat kepada guru | 1. Tombol "Kirim Pengingat" di halaman verifikasi. 2. Sistem mengirim notifikasi ke guru. | ✅ Selesai |
| 45 | US1026 | Melihat laporan presensi keseluruhan | 1. Menu Laporan Presensi. 2. Filter berdasarkan kelas, guru, atau rentang waktu. | ✅ Selesai |
| 46 | US1027 | Melakukan backup data (database, export users) | 1. Menu "Backup Data" di dashboard admin. 2. Admin dapat backup manual dan mengunduh. | ✅ Selesai |
| 47 | US1028 | Export log aktivitas ke Excel | 1. Tombol "Export Log Aktivitas". 2. Generate file Excel. 3. File otomatis terdownload. | ✅ Selesai |
| 48 | US1029 | Download semua materi dalam satu file ZIP | 1. Tombol "Download Semua Materi". 2. Sistem compress semua file menjadi ZIP. | ✅ Selesai |

### SISWA

| # | ID | User Story | Acceptance Criteria | Status |
|---|-----|------------|---------------------|--------|
| 49 | US3006 | Melihat notifikasi jika kelas akan berakhir | 1. Notifikasi di dashboard beberapa hari sebelum kelas berakhir. 2. Info nama kelas dan tanggal berakhir. | ✅ Selesai |

---

## Statistics

### By Module
| Module | Total |
|--------|-------|
| Pengguna (Umum) | 7 |
| Admin | 29 |
| Guru | 7 |
| Siswa | 6 |
| **Total** | **49** |

### By Sprint
| Sprint | Total |
|--------|-------|
| Sprint 1 | 20 |
| Sprint 2 | 13 |
| Sprint 3 | 10 |
| Sprint 4 | 6 |
| **Total** | **49** |

---

**Last Updated:** December 28, 2025  
**Project:** E-Learning Coding Akademi Payakumbuh  
**Status:** ✅ 100% Complete
