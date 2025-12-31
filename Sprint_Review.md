# Sprint Review - E-Learning Coding Akademi Payakumbuh

> **Periode Proyek:** 22 September - 28 November 2025 | **4 Sprints | 49 User Stories | 100% Complete**

---

## SPRINT 1 - Core Authentication & Basic CRUD
**Durasi:** 4 Minggu (22 September - 17 Oktober 2025) | **20 User Stories**

| No | Kode | User Story | Acceptance Criteria | Status Penyelesaian | Status Penerimaan | Keterangan |
|----|------|------------|---------------------|---------------------|-------------------|------------|
| 1 | US0001 | Login ke sistem | Pelanggan dan admin dapat login menggunakan email dan password. Sistem memvalidasi kredensial dan mengarahkan ke dashboard sesuai role. | 3 | Ya | Fitur login untuk semua role (Admin, Guru, Siswa) berjalan dengan baik. Validasi kredensial berhasil dan redirect ke dashboard sesuai role. |
| 2 | US0002 | Logout dari sistem | Pengguna dapat logout dengan aman. Terdapat tombol logout, sesi berakhir, dan diarahkan ke halaman login. | 3 | Ya | Fitur logout berfungsi dengan baik. Sesi pengguna berakhir dan diarahkan kembali ke halaman login. |
| 3 | US0003 | Melihat dashboard utama | Admin melihat statistik (guru, siswa, kelas). Guru melihat daftar kelas yang diajar. Siswa melihat daftar kelas yang diikuti. | 3 | Ya | Dashboard untuk ketiga role berhasil menampilkan informasi yang relevan dan real-time. |
| 4 | US1001 | Melihat daftar Guru | Admin dapat mengakses halaman manajemen Guru dan melihat daftar Guru (Nama, Email, Bidang Ajar). | 3 | Ya | Admin dapat melihat daftar Guru lengkap dengan informasi detail. |
| 5 | US1002 | Menambah data Guru baru | Admin dapat menambah Guru baru melalui form (Nama, Email, Kata Sandi Awal). Data Guru muncul di daftar. | 3 | Ya | Admin berhasil menambahkan Guru baru dan data tersimpan dengan baik di database. |
| 6 | US1003 | Melihat daftar Siswa | Admin dapat mengakses halaman manajemen Siswa dan melihat daftar Siswa (Nama, Email, NIS). | 3 | Ya | Admin dapat melihat daftar Siswa lengkap dengan informasi detail. |
| 7 | US1004 | Menambah data Siswa baru | Admin dapat menambah Siswa baru melalui form (Nama, Email, Kata Sandi Awal). Data Siswa muncul di daftar. | 3 | Ya | Admin berhasil menambahkan Siswa baru. Terdapat perbaikan pada form input di minggu ke-3. |
| 8 | US1005 | Membuat kelas baru | Admin dapat membuat kelas baru dengan form (Nama Kelas, Deskripsi, Guru Pengampu). Kelas muncul dalam daftar. | 3 | Ya | Admin berhasil membuat kelas baru dengan informasi lengkap. |
| 9 | US1006 | Mendaftarkan siswa ke kelas (enroll) | Di halaman detail kelas, Admin dapat memilih satu atau lebih siswa untuk didaftarkan ke kelas. | 3 | Ya | Fitur enroll siswa berfungsi dengan baik. Admin dapat mendaftarkan multiple siswa sekaligus. |
| 10 | US1007 | Mengeluarkan siswa dari kelas (unenroll) | Admin dapat mengeluarkan siswa dari kelas dengan tombol "Keluarkan" dan konfirmasi. | 3 | Ya | Fitur unenroll berhasil diimplementasikan dengan konfirmasi yang jelas. |
| 11 | US1008 | Melihat daftar materi menunggu verifikasi | Admin dapat mengakses halaman "Verifikasi Materi" dan melihat daftar materi berstatus "Pending". | 3 | Ya | Admin dapat melihat semua materi yang menunggu verifikasi dengan status yang jelas. |
| 12 | US1009 | Menyetujui materi (approve) | Admin dapat menyetujui materi dengan tombol "Setujui". Status materi berubah menjadi "Approved". | 3 | Ya | Fitur approve materi berfungsi dengan baik. Status materi terupdate otomatis. |
| 13 | US1010 | Membuat pertemuan baru untuk kelas | Admin dapat membuat pertemuan dengan form (Tanggal, Pertemuan ke-, Topik, Deskripsi). | 3 | Ya | Pertemuan dapat dibuat dan ditampilkan dengan baik di daftar pertemuan kelas. |
| 14 | US1011 | Mengedit informasi pertemuan | Admin dapat mengedit pertemuan (tanggal, topik, deskripsi) melalui opsi "Edit". | 3 | Ya | Fitur edit pertemuan berfungsi dengan baik dan perubahan tersimpan. |
| 15 | US1012 | Menghapus pertemuan | Admin dapat menghapus pertemuan dengan opsi "Hapus" setelah konfirmasi. | 3 | Ya | Fitur hapus pertemuan berhasil dengan konfirmasi untuk mencegah penghapusan tidak sengaja. |
| 16 | US1013 | Menginput absensi siswa per pertemuan | Admin dapat menginput status absensi (Hadir, Izin, Sakit, Alpha) dan menyimpan untuk semua siswa. | 3 | Ya | Fitur input absensi berfungsi dengan baik. Data absensi tersimpan dan dapat dilihat kembali. |
| 17 | US2001 | Menambahkan materi pembelajaran | Guru dapat menambahkan materi (PDF/Video), memilih kelas tujuan. Status otomatis "Pending". | 3 | Ya | Guru berhasil mengunggah materi pembelajaran. File tersimpan dan masuk ke daftar pending. |
| 18 | US2002 | Melihat daftar dan status materi | Guru dapat melihat daftar semua materi yang diunggah dengan status (Pending/Approved/Rejected). | 3 | Ya | Guru dapat melihat status materi dengan jelas dan update real-time. |
| 19 | US3001 | Melihat daftar kelas yang diikuti | Dashboard siswa menampilkan daftar kelas yang sedang diikuti. | 3 | Ya | Siswa dapat melihat semua kelas yang diikuti dengan informasi lengkap. |
| 20 | US3002 | Mengakses materi di dalam kelas | Siswa dapat mengklik kelas dan melihat daftar materi yang sudah approved. | 3 | Ya | Siswa dapat mengakses dan membaca materi pembelajaran yang telah disetujui Admin. |

---

## SPRINT 2 - Advanced CRUD & Profile
**Durasi:** 2 Minggu (20 Oktober - 31 Oktober 2025) | **13 User Stories**

| No | Kode | User Story | Acceptance Criteria | Status Penyelesaian | Status Penerimaan | Keterangan |
|----|------|------------|---------------------|---------------------|-------------------|------------|
| 21 | US0004 | Mengubah kata sandi | Pengguna dapat mengubah kata sandi melalui menu "Ubah Kata Sandi" di profil dengan validasi kata sandi lama. | 3 | Ya | Fitur ubah kata sandi berfungsi dengan baik. Validasi kata sandi lama berhasil. |
| 22 | US0005 | Reset kata sandi jika lupa | Terdapat link "Lupa Kata Sandi?" di halaman login. Sistem mengirim link reset ke email. | 3 | Ya | Fitur reset password berhasil diimplementasikan. Email reset password terkirim dengan baik. |
| 23 | US0006 | Melihat Landing Page | Landing Page menampilkan informasi Coding Academy dan foto/dokumentasi kegiatan. | 3 | Ya | Landing page informatif dengan desain yang menarik dan informasi lengkap tentang Coding Academy. |
| 24 | US0007 | Menerima notifikasi tentang aktivitas | Notifikasi muncul di dashboard dan dapat ditandai sebagai sudah dibaca. | 3 | Ya | Sistem notifikasi berfungsi dengan baik. Pengguna dapat melihat dan menandai notifikasi sebagai dibaca. |
| 25 | US1014 | Mengedit data Guru yang sudah ada | Admin dapat mengubah data Guru melalui opsi "Edit". | 3 | Ya | Admin berhasil mengedit data Guru dan perubahan tersimpan dengan baik. |
| 26 | US1015 | Menghapus data Guru | Admin dapat menghapus data Guru dengan opsi "Hapus" setelah konfirmasi. | 3 | Ya | Fitur hapus Guru berfungsi dengan konfirmasi yang jelas untuk keamanan data. |
| 27 | US1016 | Mengedit data Siswa yang sudah ada | Admin dapat mengubah data Siswa melalui opsi "Edit". | 3 | Ya | Admin berhasil mengedit data Siswa dan perubahan tersimpan dengan baik. |
| 28 | US1017 | Menghapus data Siswa | Admin dapat menghapus data Siswa dengan opsi "Hapus" setelah konfirmasi. | 3 | Ya | Fitur hapus Siswa berfungsi dengan konfirmasi yang jelas untuk keamanan data. |
| 29 | US1018 | Mengubah detail kelas (edit) | Admin dapat mengubah Nama Kelas, Deskripsi, atau Guru Pengampu melalui opsi "Edit" pada daftar kelas. | 3 | Ya | Fitur edit kelas berfungsi dengan baik. Admin dapat mengubah detail kelas termasuk mengganti guru pengampu. |
| 30 | US1019 | Menolak materi yang tidak sesuai | Admin dapat menolak materi dengan tombol "Tolak" dan input alasan penolakan. | 3 | Ya | Admin dapat menolak materi dengan alasan yang jelas. Guru dapat melihat alasan penolakan. |
| 31 | US2003 | Melihat daftar hadir siswa | Guru dapat mengakses halaman kehadiran dan melihat status kehadiran per pertemuan. | 3 | Ya | Guru dapat melihat daftar hadir siswa dengan detail per pertemuan. |
| 32 | US2004 | Memantau progres belajar siswa | Guru dapat melihat pemantauan progres melalui tabel progres penyelesaian materi di halaman "Pemantauan Progres". | 3 | Ya | Guru dapat memantau progres belajar setiap siswa dengan visualisasi yang jelas. |
| 33 | US3003 | Melihat progress bar kemajuan belajar | Progress bar visual per kelas diperbarui otomatis saat materi selesai dipelajari. | 3 | Ya | Progress bar berfungsi dengan baik dan update secara otomatis sesuai penyelesaian materi. |

---

## SPRINT 3 - Learning Features & Progress
**Durasi:** 2 Minggu (3 November - 13 November 2025) | **10 User Stories**

| No | Kode | User Story | Acceptance Criteria | Status Penyelesaian | Status Penerimaan | Keterangan |
|----|------|------------|---------------------|---------------------|-------------------|------------|
| 34 | US1020 | Menghapus kelas | Admin dapat menghapus kelas melalui opsi "Hapus" pada daftar kelas setelah konfirmasi. | 3 | Ya | Fitur hapus kelas berfungsi dengan konfirmasi yang jelas. Data terkait kelas juga ditangani dengan baik. |
| 35 | US1021 | Mengaktifkan/menonaktifkan pengguna | Admin dapat toggle status pengguna (Aktif/Nonaktif). Pengguna tidak aktif tidak dapat login. | 3 | Ya | Fitur toggle status berfungsi dengan baik. Pengguna nonaktif tidak dapat login ke sistem. |
| 36 | US1022 | Menampilkan history/riwayat siswa | Sistem menampilkan tanggal, waktu, jenis, dan detail aktivitas siswa. | 3 | Ya | History aktivitas siswa tersimpan dan dapat ditampilkan dengan detail waktu dan jenis aktivitas. |
| 37 | US1023 | Export absensi kelas ke Excel | Admin dapat export absensi dengan tombol "Export Absensi". File Excel otomatis terdownload. | 3 | Ya | Fitur export absensi ke Excel berfungsi dengan baik. File dapat diunduh dan dibuka dengan normal. |
| 38 | US1024 | Export learning log siswa ke Excel | Admin dapat export learning log dengan tombol "Export Learning Log". File Excel otomatis terdownload. | 3 | Ya | Fitur export learning log berfungsi dengan baik. Data lengkap tersedia dalam file Excel. |
| 39 | US2005 | Mengedit materi yang pernah diunggah | Guru dapat mengedit materi yang berstatus Pending/Rejected. Materi yang diedit kembali berstatus "Pending". | 3 | Ya | Guru dapat mengedit materi dan materi akan masuk kembali ke antrian verifikasi. |
| 40 | US2006 | Menghapus materi yang tidak relevan | Guru dapat menghapus materi melalui opsi "Hapus" setelah konfirmasi. | 3 | Ya | Guru dapat menghapus materi dengan konfirmasi yang jelas untuk mencegah penghapusan tidak sengaja. |
| 41 | US2007 | Mendapatkan laporan kehadiran otomatis | Guru dapat melihat laporan kehadiran di halaman "Laporan Kehadiran" dengan filter berdasarkan kelas dan periode. | 3 | Ya | Laporan kehadiran otomatis tersedia dengan filter yang memudahkan Guru melihat data specific. |
| 42 | US3004 | Progress membaca PDF tersimpan otomatis | Saat ganti halaman PDF, progress tersimpan otomatis (AJAX). Sistem melanjutkan dari halaman terakhir. | 3 | Ya | Auto-save progress PDF berfungsi dengan baik menggunakan AJAX. Siswa dapat melanjutkan dari posisi terakhir. |
| 43 | US3005 | Melihat status pembayaran di profil | Siswa dapat melihat informasi status pembayaran (Lunas/Belum Lunas) di halaman profil. | 3 | Ya | Status pembayaran ditampilkan dengan jelas di profil siswa. |

---

## SPRINT 4 - Reports, Backup & Notifications
**Durasi:** 2 Minggu (17 November - 28 November 2025) | **6 User Stories**

| No | Kode | User Story | Acceptance Criteria | Status Penyelesaian | Status Penerimaan | Keterangan |
|----|------|------------|---------------------|---------------------|-------------------|------------|
| 44 | US1025 | Mengirim notifikasi pengingat kepada guru | Admin dapat mengirim pengingat melalui tombol "Kirim Pengingat" di halaman verifikasi. Sistem mengirim notifikasi ke guru. | 3 | Ya | Fitur kirim pengingat ke guru berfungsi dengan baik. Notifikasi terkirim dan diterima oleh guru. |
| 45 | US1026 | Melihat laporan presensi keseluruhan | Admin dapat melihat laporan presensi di menu "Laporan Presensi" dengan filter berdasarkan kelas, guru, atau rentang waktu. | 3 | Ya | Laporan presensi keseluruhan tersedia dengan filter yang lengkap dan data yang akurat. |
| 46 | US1027 | Melakukan backup data | Admin dapat melakukan backup manual dan mengunduh file backup melalui menu "Backup Data" di dashboard admin. | 3 | Ya | Fitur backup data berfungsi dengan baik. Admin dapat backup dan download file database. |
| 47 | US1028 | Export log aktivitas ke Excel | Admin dapat export log aktivitas dengan tombol "Export Log Aktivitas". File Excel otomatis terdownload. | 3 | Ya | Fitur export log aktivitas berfungsi dengan baik. File Excel berisi semua aktivitas sistem yang tercatat. |
| 48 | US1029 | Download semua materi dalam satu file ZIP | Admin dapat download semua materi dengan tombol "Download Semua Materi". Sistem compress semua file menjadi ZIP. | 3 | Ya | Fitur download ZIP berhasil. Semua materi tercompress dan dapat diunduh dalam satu file. |
| 49 | US3006 | Melihat notifikasi jika kelas akan berakhir | Siswa melihat notifikasi di dashboard beberapa hari sebelum kelas berakhir dengan info nama kelas dan tanggal berakhir. | 3 | Ya | Notifikasi pengingat kelas berakhir berfungsi dengan baik. Siswa mendapat reminder tepat waktu. |

---

## Ringkasan Keseluruhan

### Statistik Penyelesaian

| Metrik | Detail |
|--------|--------|
| **Total User Stories** | 49 |
| **User Stories Selesai** | 49 (100%) |
| **User Stories Diterima** | 49 (100%) |
| **Total Sprint** | 4 Sprint |
| **Durasi Proyek** | 10 Minggu (22 Sep - 28 Nov 2025) |

### Distribusi User Stories per Sprint

| Sprint | Jumlah US | Status | Tingkat Penerimaan |
|--------|-----------|--------|-------------------|
| Sprint 1 | 20 | ✅ Complete | 100% (20/20) |
| Sprint 2 | 13 | ✅ Complete | 100% (13/13) |
| Sprint 3 | 10 | ✅ Complete | 100% (10/10) |
| Sprint 4 | 6 | ✅ Complete | 100% (6/6) |
| **Total** | **49** | **✅ Complete** | **100% (49/49)** |

### Distribusi User Stories per Role

| Role | Jumlah User Stories | Persentase |
|------|---------------------|------------|
| Admin | 29 | 59.2% |
| Guru | 7 | 14.3% |
| Siswa | 6 | 12.2% |
| Pengguna (Umum) | 7 | 14.3% |
| **Total** | **49** | **100%** |

### Fitur-Fitur Utama yang Berhasil Diselesaikan

#### 1. **Modul Autentikasi & Keamanan**
- ✅ Login/Logout untuk semua role
- ✅ Reset password via email
- ✅ Ubah kata sandi
- ✅ Aktivasi/Deaktivasi pengguna

#### 2. **Manajemen Pengguna (Admin)**
- ✅ CRUD Guru (Create, Read, Update, Delete)
- ✅ CRUD Siswa (Create, Read, Update, Delete)
- ✅ Toggle status aktif/nonaktif pengguna

#### 3. **Manajemen Kelas (Admin)**
- ✅ CRUD Kelas
- ✅ Enroll/Unenroll siswa ke kelas
- ✅ Manajemen pertemuan kelas
- ✅ Input absensi siswa

#### 4. **Manajemen Materi (Admin & Guru)**
- ✅ Upload materi (PDF/Video) oleh Guru
- ✅ Verifikasi materi oleh Admin (Approve/Reject)
- ✅ Edit dan hapus materi oleh Guru
- ✅ Status tracking materi (Pending/Approved/Rejected)

#### 5. **Pembelajaran & Progress (Siswa)**
- ✅ Akses materi pembelajaran
- ✅ Auto-save progress PDF
- ✅ Progress bar kemajuan belajar
- ✅ Lihat status pembayaran
- ✅ Notifikasi kelas berakhir

#### 6. **Monitoring & Reporting (Admin & Guru)**
- ✅ Dashboard dengan statistik real-time
- ✅ Laporan kehadiran siswa
- ✅ Monitoring progres belajar
- ✅ History aktivitas siswa
- ✅ Export data ke Excel (Absensi, Learning Log, Log Aktivitas)

#### 7. **Backup & Notifikasi**
- ✅ Backup database manual
- ✅ Download semua materi dalam ZIP
- ✅ Sistem notifikasi untuk semua role
- ✅ Pengingat otomatis untuk guru

#### 8. **Landing Page & UI**
- ✅ Landing page informatif
- ✅ Dashboard untuk 3 role berbeda
- ✅ UI responsif dan user-friendly

### Catatan Penting

1. **Semua user stories berhasil diselesaikan** dengan status penerimaan 100%.
2. **Tidak ada user stories yang ditolak** atau memerlukan perbaikan major di akhir sprint.
3. **Testing menyeluruh** dilakukan di setiap sprint dengan regression testing.
4. **Dokumentasi lengkap** tersedia untuk semua fitur yang dikembangkan.
5. **Final demo berhasil** dilakukan dengan baik untuk semua stakeholder.

### Keterangan Level Penyelesaian

**Level 3** = Fitur selesai sepenuhnya, berfungsi dengan baik, telah diuji, dan diterima oleh stakeholder.

---

**Tanggal Review:** 30 Desember 2025  
**Project:** E-Learning Coding Akademi Payakumbuh  
**Status:** ✅ All Sprints Successfully Completed  
**Team:** Luthfi (Backend & Admin), Faris (Frontend & Siswa), Wili (Guru & Testing), Zidan (Data & CRUD)  
**Achievement:** 49/49 User Stories Completed & Accepted (100%)
