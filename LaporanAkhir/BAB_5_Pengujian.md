# BAB 5 - PENGUJIAN

## 5.1 Metodologi Pengujian

### 5.1.1 Metode Pengujian

Pengujian sistem ini menggunakan metode **Black Box Testing** dengan fokus pada **Functional Testing**. Pendekatan ini dipilih karena:

1. **Fokus pada Fungsionalitas**: Menguji sistem dari perspektif pengguna tanpa perlu mengetahui implementasi internal
2. **Validasi Acceptance Criteria**: Memastikan setiap user story memenuhi kriteria penerimaan yang telah ditentukan
3. **Simulasi Penggunaan Nyata**: Menguji alur kerja yang akan digunakan oleh pengguna sebenarnya

### 5.1.2 Ruang Lingkup Pengujian

| Aspek | Keterangan |
|-------|------------|
| Total User Stories | 49 |
| Metode | Black Box Testing, Functional Testing |
| Tools | Browser (Chrome, Firefox), Manual Testing |
| Environment | Localhost (Development), Server Production |
| Pelaksana | Tim Development (4 orang) |

### 5.1.3 Prosedur Pengujian

1. **Persiapan**: Menyiapkan data uji dan environment testing
2. **Eksekusi**: Menjalankan skenario pengujian sesuai test case
3. **Dokumentasi**: Mencatat hasil pengujian (Expected vs Actual)
4. **Verifikasi**: Memvalidasi hasil dengan kriteria penerimaan
5. **Laporan**: Menyusun laporan hasil pengujian

---

## 5.2 Dokumentasi Pengujian

### 5.2.1 Pengujian Modul Autentikasi (US0001 - US0003)

| No | Kode US | Skenario Pengujian | Data Uji | Expected Result | Actual Result | Status |
|----|---------|-------------------|----------|-----------------|---------------|--------|
| 1 | US0001 | Login dengan email dan password valid | email: admin@test.com, password: password123 | Redirect ke dashboard sesuai role | Redirect ke /admin/dashboard | ✅ Pass |
| 2 | US0001 | Login dengan password salah | email: admin@test.com, password: wrongpass | Pesan error "Kredensial tidak valid" | Pesan error muncul | ✅ Pass |
| 3 | US0002 | Logout dari sistem | Klik tombol Logout | Session berakhir, redirect ke login | Session expired, redirect ke /login | ✅ Pass |
| 4 | US0003 | Melihat dashboard setelah login | Login sebagai Admin | Tampil statistik dan ringkasan | Dashboard tampil dengan stats | ✅ Pass |

### 5.2.2 Pengujian Modul Manajemen Pengguna (US1001 - US1004, US1014 - US1017)

| No | Kode US | Skenario Pengujian | Data Uji | Expected Result | Actual Result | Status |
|----|---------|-------------------|----------|-----------------|---------------|--------|
| 5 | US1001 | Admin melihat daftar Guru | Akses menu Guru | Tampil tabel dengan data Guru | Tabel Guru tampil | ✅ Pass |
| 6 | US1002 | Admin menambah Guru baru | Nama: Pak Budi, Email: budi@test.com | Data tersimpan, muncul di daftar | Guru baru terdaftar | ✅ Pass |
| 7 | US1003 | Admin melihat daftar Siswa | Akses menu Siswa | Tampil tabel dengan data Siswa | Tabel Siswa tampil | ✅ Pass |
| 8 | US1004 | Admin menambah Siswa baru | Nama, Email, Kelas, Durasi | Data tersimpan dengan ID_Siswa otomatis | Siswa terdaftar, ID generated | ✅ Pass |
| 9 | US1014 | Admin mengedit data Guru | Edit nama Guru menjadi "Pak Ahmad" | Data terupdate di database | Nama berubah menjadi Pak Ahmad | ✅ Pass |
| 10 | US1015 | Admin menghapus Guru | Klik hapus pada Guru test | Guru dihapus (soft delete) | Guru tidak tampil di daftar | ✅ Pass |
| 11 | US1016 | Admin mengedit data Siswa | Ubah sekolah siswa | Data Siswa terupdate | Sekolah berubah | ✅ Pass |
| 12 | US1017 | Admin menghapus Siswa | Klik hapus pada Siswa test | Siswa dihapus (soft delete) | Siswa tidak tampil di daftar | ✅ Pass |

### 5.2.3 Pengujian Modul Manajemen Kelas (US1005 - US1007, US1018 - US1020)

| No | Kode US | Skenario Pengujian | Data Uji | Expected Result | Actual Result | Status |
|----|---------|-------------------|----------|-----------------|---------------|--------|
| 13 | US1005 | Admin membuat kelas baru | Nama: Kelas Scratch, Guru: Pak Budi | Kelas tersimpan, muncul di daftar | Kelas Scratch terdaftar | ✅ Pass |
| 14 | US1006 | Admin enroll siswa ke kelas | Siswa: Andi, Kelas: Scratch, Durasi: 3 bulan | Siswa terdaftar di kelas | Andi muncul di daftar siswa kelas | ✅ Pass |
| 15 | US1007 | Admin unenroll siswa dari kelas | Klik unenroll pada Andi | Siswa dikeluarkan dari kelas | Andi tidak lagi di kelas Scratch | ✅ Pass |
| 16 | US1018 | Admin mengubah detail kelas | Ubah deskripsi kelas | Detail kelas terupdate | Deskripsi berubah | ✅ Pass |
| 17 | US1020 | Admin menghapus kelas | Klik hapus pada kelas test | Kelas dihapus dengan konfirmasi | Kelas tidak tampil di daftar | ✅ Pass |

### 5.2.4 Pengujian Modul Verifikasi Materi (US1008 - US1009, US1019)

| No | Kode US | Skenario Pengujian | Data Uji | Expected Result | Actual Result | Status |
|----|---------|-------------------|----------|-----------------|---------------|--------|
| 18 | US1008 | Admin melihat materi pending | Akses menu Verifikasi Materi | Tampil daftar materi status pending | Daftar materi pending tampil | ✅ Pass |
| 19 | US1009 | Admin menyetujui materi | Klik Approve pada materi | Status berubah menjadi approved | Status = approved, siswa bisa akses | ✅ Pass |
| 20 | US1019 | Admin menolak materi | Klik Reject dengan alasan | Status berubah menjadi rejected | Status = rejected, guru dapat notif | ✅ Pass |

### 5.2.5 Pengujian Modul Pertemuan & Absensi (US1010 - US1013)

| No | Kode US | Skenario Pengujian | Data Uji | Expected Result | Actual Result | Status |
|----|---------|-------------------|----------|-----------------|---------------|--------|
| 21 | US1010 | Admin membuat pertemuan baru | Tanggal, Topik, Deskripsi | Pertemuan tersimpan | Pertemuan muncul di daftar | ✅ Pass |
| 22 | US1011 | Admin mengedit pertemuan | Ubah tanggal pertemuan | Data pertemuan terupdate | Tanggal berubah | ✅ Pass |
| 23 | US1012 | Admin menghapus pertemuan | Klik hapus dengan konfirmasi | Pertemuan dihapus | Pertemuan tidak tampil | ✅ Pass |
| 24 | US1013 | Admin input absensi | Status: 3 Hadir, 1 Izin, 1 Alpha | Presensi tersimpan per siswa | Data absensi tersimpan | ✅ Pass |

### 5.2.6 Pengujian Modul Status & History (US1021 - US1024)

| No | Kode US | Skenario Pengujian | Data Uji | Expected Result | Actual Result | Status |
|----|---------|-------------------|----------|-----------------|---------------|--------|
| 25 | US1021 | Admin ubah status aktif/nonaktif | Klik toggle status siswa | Status berubah, akses login terpengaruh | Siswa nonaktif tidak bisa login | ✅ Pass |
| 26 | US1022 | Admin lihat history siswa | Akses detail siswa | Tampil riwayat aktivitas | Log aktivitas tampil | ✅ Pass |
| 27 | US1023 | Export absensi ke Excel | Klik Export Absensi | File Excel terdownload | File .xlsx terdownload | ✅ Pass |
| 28 | US1024 | Export learning log siswa | Klik Export Log per siswa | File Excel learning log terdownload | File .xlsx terdownload | ✅ Pass |

### 5.2.7 Pengujian Modul Notifikasi & Backup (US1025 - US1029)

| No | Kode US | Skenario Pengujian | Data Uji | Expected Result | Actual Result | Status |
|----|---------|-------------------|----------|-----------------|---------------|--------|
| 29 | US1025 | Admin kirim reminder ke guru | Klik Kirim Pengingat | Notifikasi dikirim ke guru | Guru menerima notifikasi | ✅ Pass |
| 30 | US1026 | Admin lihat laporan presensi | Akses menu Laporan | Tampil laporan dengan filter | Laporan tampil dengan filter kelas | ✅ Pass |
| 31 | US1027 | Admin backup database | Klik Backup Database | File SQL tergenerate dan download | File .sql terdownload | ✅ Pass |
| 32 | US1028 | Export log aktivitas | Klik Export Activity Log | File Excel activity log terdownload | File .xlsx terdownload | ✅ Pass |
| 33 | US1029 | Download semua materi ZIP | Klik Download All Materials | File ZIP semua materi terdownload | File .zip terdownload | ✅ Pass |

### 5.2.8 Pengujian Modul Guru (US2001 - US2007)

| No | Kode US | Skenario Pengujian | Data Uji | Expected Result | Actual Result | Status |
|----|---------|-------------------|----------|-----------------|---------------|--------|
| 34 | US2001 | Guru upload materi PDF | File: scratch_dasar.pdf, Judul, Deskripsi | Materi tersimpan dengan status pending | Materi tersimpan, admin dapat notif | ✅ Pass |
| 35 | US2002 | Guru melihat status materi | Akses halaman Materi Saya | Tampil daftar materi dengan status | Daftar dengan status pending/approved | ✅ Pass |
| 36 | US2003 | Guru melihat daftar hadir | Akses halaman Kehadiran kelas | Tampil daftar siswa dan status | Daftar hadir per pertemuan tampil | ✅ Pass |
| 37 | US2004 | Guru memantau progress siswa | Akses halaman Progress kelas | Tampil tabel progress per siswa | Progress percentage per siswa tampil | ✅ Pass |
| 38 | US2005 | Guru edit materi (status pending/rejected) | Edit judul dan deskripsi | Materi terupdate, status kembali pending | Materi terupdate | ✅ Pass |
| 39 | US2006 | Guru hapus materi | Klik hapus dengan konfirmasi | Materi dihapus (soft delete) | Materi tidak tampil | ✅ Pass |
| 40 | US2007 | Guru mendapat laporan kehadiran | Akses halaman Laporan Kehadiran | Laporan otomatis per kelas/periode | Laporan dengan filter tampil | ✅ Pass |

### 5.2.9 Pengujian Modul Siswa (US3001 - US3006)

| No | Kode US | Skenario Pengujian | Data Uji | Expected Result | Actual Result | Status |
|----|---------|-------------------|----------|-----------------|---------------|--------|
| 41 | US3001 | Siswa melihat daftar kelas | Login sebagai siswa | Tampil daftar kelas yang diikuti | Kelas enrolled tampil di dashboard | ✅ Pass |
| 42 | US3002 | Siswa mengakses materi | Klik materi approved di kelas | Materi terbuka (PDF viewer/video) | PDF viewer tampil dengan materi | ✅ Pass |
| 43 | US3003 | Siswa melihat progress bar | Akses dashboard atau halaman kelas | Progress bar visual per kelas | Progress bar dengan persentase tampil | ✅ Pass |
| 44 | US3004 | Progress PDF tersimpan otomatis | Buka PDF, berpindah halaman | Halaman terakhir tersimpan | Saat buka lagi ke halaman terakhir | ✅ Pass |
| 45 | US3005 | Siswa melihat status pembayaran | Akses halaman profil | Tampil info status pembayaran | Status Lunas/Belum Lunas tampil | ✅ Pass |
| 46 | US3006 | Notifikasi kelas berakhir | Kelas dengan end_date H-7 | Notifikasi muncul di dashboard | Notifikasi reminder tampil | ✅ Pass |

### 5.2.10 Pengujian Modul Umum (US0004 - US0007)

| No | Kode US | Skenario Pengujian | Data Uji | Expected Result | Actual Result | Status |
|----|---------|-------------------|----------|-----------------|---------------|--------|
| 47 | US0004 | User mengubah password | Password lama + password baru | Password terupdate | Login dengan password baru berhasil | ✅ Pass |
| 48 | US0005 | User reset password lupa | Klik Lupa Password, input email | Link reset terkirim ke email | Email dengan link reset terkirim | ✅ Pass |
| 49 | US0006 | User melihat Landing Page | Akses URL utama tanpa login | Tampil halaman landing page | Landing page dengan info tampil | ✅ Pass |

---

## 5.3 Ringkasan Hasil Pengujian

### 5.3.1 Statistik Pengujian

| Kategori | Jumlah |
|----------|--------|
| Total Test Cases | 49 |
| Passed | 49 |
| Failed | 0 |
| Success Rate | **100%** |

### 5.3.2 Hasil per Role

| Role | User Stories | Test Cases | Status |
|------|--------------|------------|--------|
| Pengguna (Umum) | 7 | 7 | ✅ 100% Pass |
| Admin | 29 | 29 | ✅ 100% Pass |
| Guru | 7 | 7 | ✅ 100% Pass |
| Siswa | 6 | 6 | ✅ 100% Pass |

### 5.3.3 Kesimpulan Pengujian

Berdasarkan hasil pengujian yang telah dilakukan:

1. **Semua 49 user stories berhasil diuji** dan memenuhi kriteria penerimaan (acceptance criteria) yang telah ditentukan.

2. **Tidak ditemukan error kritis** yang menghalangi fungsionalitas sistem saat pengujian dilakukan.

3. **Sistem siap untuk deployment** ke environment produksi karena semua fitur telah berfungsi sesuai spesifikasi.

4. **Pengujian dilakukan oleh tim development** dengan pendekatan black box testing pada environment development dan production.
