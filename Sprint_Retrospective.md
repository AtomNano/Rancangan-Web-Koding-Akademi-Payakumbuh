# Sprint Retrospective - E-Learning Coding Akademi Payakumbuh

> **Periode Proyek:** 22 September - 28 November 2025 | **4 Sprints | 10 Minggu | 4 Tim Members | 49 User Stories**

---

## Informasi Tim

| Nama | Role | Area Fokus |
|------|------|------------|
| Luthfi | Backend & Admin | Authentication, Admin Management, Backend Development |
| Faris | Frontend & Siswa | Dashboard, Student Flow, Frontend Development |
| Wili | Guru & Testing | Teacher Flow, Testing, Quality Assurance |
| Zidan | Data & CRUD | Database, CRUD Operations, Integration |

---

## SPRINT 1 - Core Authentication & Basic CRUD
**Durasi:** 4 Minggu (22 September - 17 Oktober 2025) | **20 User Stories**

### 1. Apa yang berjalan baik

1. Tim berhasil menyelesaikan seluruh fitur inti pada Sprint 1, mencakup sistem autentikasi (login/logout) dan manajemen pengguna dasar.
2. Fitur manajemen pengguna (Guru dan Siswa) oleh Admin sudah berfungsi dengan baik, termasuk fitur tambah, edit, dan hapus data.
3. Sistem manajemen kelas berhasil diimplementasikan dengan fitur membuat kelas baru dan mendaftarkan (enroll) siswa ke kelas.
4. Fitur verifikasi materi pembelajaran oleh Admin sudah berjalan sesuai dengan alur bisnis yang direncanakan.
5. Dashboard untuk tiga role (Admin, Guru, Siswa) sudah menampilkan informasi yang relevan sesuai dengan kebutuhan masing-masing pengguna.
6. Guru dapat menambahkan materi pembelajaran (PDF/Video) dan melihat status verifikasi materi yang diunggah.
7. Siswa dapat mengakses daftar kelas yang diikuti dan melihat materi yang sudah disetujui Admin.
8. Fitur manajemen pertemuan dan input absensi siswa sudah berhasil diimplementasikan dan berfungsi dengan baik.
9. Kolaborasi tim berjalan lancar dengan pembagian tugas yang jelas berdasarkan area fokus masing-masing anggota.
10. Dokumentasi activity diagram, sequence diagram, dan data model sudah diselesaikan dengan baik di awal sprint.
11. Testing dan regression testing dilakukan secara menyeluruh di akhir sprint untuk memastikan stabilitas sistem.

### 2. Apa yang belum berjalan baik

1. Beberapa bug ditemukan pada fitur alur Guru yang memerlukan perbaikan UI dan frontend di minggu ke-2.
2. Proses implementasi coding memakan waktu lebih lama dari yang diperkirakan, terutama untuk fitur yang kompleks seperti manajemen kelas dan verifikasi materi.
3. Pengujian masih terbatas pada alur utama di minggu-minggu awal, sehingga beberapa bug baru ditemukan setelah fitur dijalankan.
4. Koordinasi antara backend dan frontend terkadang mengalami kendala sinkronisasi, terutama pada fitur yang memerlukan integrasi kompleks.
5. Dokumentasi kode masih kurang lengkap di beberapa bagian, sehingga menyulitkan pada saat debugging.

### 3. Peningkatan apa yang bisa dilakukan

1. Melakukan pengujian lebih awal dan lebih menyeluruh pada setiap user story sebelum menandai sebagai selesai.
2. Meningkatkan komunikasi antara tim backend dan frontend untuk memastikan API dan integrasi berjalan lancar.
3. Menambahkan dokumentasi kode yang lebih lengkap, terutama untuk fungsi-fungsi kompleks.
4. Melakukan code review secara berkala untuk mendeteksi potensi bug lebih awal.
5. Menyediakan waktu buffer di akhir sprint untuk regression testing dan bug fixing.
6. Membuat checklist testing yang lebih detail untuk setiap fitur yang dikembangkan.

---

## SPRINT 2 - Advanced CRUD & Profile
**Durasi:** 2 Minggu (20 Oktober - 31 Oktober 2025) | **13 User Stories**

### 1. Apa yang berjalan baik

1. Fitur ubah kata sandi dan reset password berhasil diimplementasikan dengan mekanisme validasi yang baik.
2. Landing page berhasil dibuat dengan tampilan yang informatif menampilkan informasi Coding Academy.
3. Fitur notifikasi aktivitas sudah berfungsi dan dapat ditandai sebagai sudah dibaca oleh pengguna.
4. Admin dapat mengedit dan menghapus data Guru dan Siswa dengan konfirmasi yang jelas sebelum menghapus.
5. Fitur edit detail kelas sudah berjalan dengan baik, memungkinkan Admin mengubah nama, deskripsi, atau guru pengampu.
6. Admin dapat menolak materi yang tidak sesuai dengan input alasan penolakan yang jelas.
7. Guru dapat melihat daftar hadir siswa dan memantau progres belajar siswa di kelas yang diampu.
8. Siswa dapat melihat progress bar kemajuan belajar yang diperbarui secara otomatis.
9. Sprint lebih pendek (2 minggu) membuat tim lebih fokus dan efisien dalam menyelesaikan fitur.
10. Regression testing dilakukan lebih teratur dan menyeluruh dibandingkan Sprint 1.

### 2. Apa yang belum berjalan baik

1. Fitur reset password sempat mengalami kendala pada proses pengiriman link reset ke email.
2. Tampilan UI pada beberapa halaman masih perlu penyesuaian untuk konsistensi desain.
3. Beberapa fitur CRUD masih memerlukan optimasi query database untuk meningkatkan performa.
4. Dokumentasi API belum lengkap, sehingga menyulitkan testing di beberapa endpoint.
5. Notifikasi real-time belum sepenuhnya optimal, masih memerlukan refresh halaman di beberapa kondisi.

### 3. Peningkatan apa yang bisa dilakukan

1. Melakukan pengujian email secara lebih menyeluruh dengan berbagai skenario untuk fitur reset password.
2. Membuat design system yang konsisten untuk memudahkan pengembangan UI yang seragam.
3. Melakukan optimasi query database, terutama untuk fitur-fitur yang menampilkan data dalam jumlah besar.
4. Membuat dokumentasi API yang lengkap menggunakan tools seperti Postman atau Swagger.
5. Meningkatkan implementasi notifikasi real-time menggunakan teknologi seperti WebSocket atau pusher.
6. Melakukan UI/UX review secara berkala untuk memastikan konsistensi tampilan antar halaman.

---

## SPRINT 3 - Learning Features & Progress
**Durasi:** 2 Minggu (3 November - 13 November 2025) | **10 User Stories**

### 1. Apa yang berjalan baik

1. Admin dapat menghapus kelas dengan proses konfirmasi yang jelas untuk mencegah penghapusan tidak sengaja.
2. Fitur toggle status pengguna (Aktif/Nonaktif) berhasil diimplementasikan, pengguna tidak aktif tidak dapat login ke sistem.
3. Sistem menampilkan history/riwayat aktivitas siswa dengan detail waktu, jenis, dan detail aktivitas.
4. Fitur export absensi dan learning log ke Excel sudah berfungsi dengan baik dan file otomatis terdownload.
5. Guru dapat mengedit dan menghapus materi yang pernah diunggah dengan alur yang jelas.
6. Laporan kehadiran otomatis untuk Guru sudah tersedia dengan filter berdasarkan kelas dan periode.
7. Fitur auto-save progress membaca PDF untuk siswa sudah berfungsi dengan baik menggunakan AJAX.
8. Siswa dapat melihat status pembayaran di profil dengan informasi yang jelas (Lunas/Belum Lunas).
9. Bug fixing dilakukan dengan efektif di akhir sprint sebelum Sprint Review.
10. Sprint Review berjalan lancar dengan demo yang berhasil menampilkan semua fitur yang dikembangkan.

### 2. Apa yang belum berjalan baik

1. Fitur auto-save progress PDF sempat mengalami kendala pada koneksi internet yang lambat.
2. Export data ke Excel terkadang membutuhkan waktu yang lama untuk data dalam jumlah besar.
3. History/riwayat siswa belum menampilkan filter berdasarkan rentang waktu atau jenis aktivitas.
4. Beberapa bug ditemukan saat regression testing yang memerlukan perbaikan mendadak.
5. Tampilan laporan kehadiran masih perlu diperbaiki agar lebih mudah dibaca dan dipahami.

### 3. Peningkatan apa yang bisa dilakukan

1. Menambahkan loading indicator dan feedback yang jelas saat proses auto-save sedang berlangsung.
2. Mengoptimalkan proses export data dengan implementasi background job atau queue system.
3. Menambahkan fitur filter dan search pada halaman history/riwayat untuk memudahkan pencarian data.
4. Meningkatkan cakupan automated testing untuk mengurangi bug yang terlewat pada regression testing.
5. Memperbaiki tampilan laporan dengan visualisasi data yang lebih baik, seperti grafik atau chart.
6. Melakukan performance testing untuk mengidentifikasi bottleneck pada sistem.

---

## SPRINT 4 - Reports, Backup & Notifications
**Durasi:** 2 Minggu (17 November - 28 November 2025) | **6 User Stories**

### 1. Apa yang berjalan baik

1. Admin dapat mengirim notifikasi pengingat kepada guru dengan sistem yang berfungsi dengan baik.
2. Laporan presensi keseluruhan sudah tersedia dengan filter berdasarkan kelas, guru, dan rentang waktu.
3. Fitur backup data (database dan export users) berhasil diimplementasikan dengan proses backup manual yang mudah.
4. Export log aktivitas ke Excel sudah berfungsi dan file otomatis terdownload setelah proses selesai.
5. Fitur download semua materi dalam satu file ZIP berhasil diimplementasikan dan berfungsi dengan baik.
6. Siswa menerima notifikasi jika kelas akan berakhir beberapa hari sebelumnya dengan informasi yang jelas.
7. Full regression testing dilakukan secara menyeluruh di minggu terakhir untuk memastikan semua fitur berfungsi dengan baik.
8. Bug fixing dan polishing dilakukan dengan efektif untuk mempersiapkan final demo.
9. Final Sprint Review berjalan dengan sangat baik dengan demo lengkap dari semua role (Admin, Guru, Siswa).
10. Project Retrospective dilakukan dengan baik dan menghasilkan insight berharga untuk pengembangan selanjutnya.
11. Dokumentasi proyek sudah lengkap dan siap untuk diserahkan.

### 2. Apa yang belum berjalan baik

1. Proses compress file ZIP untuk download semua materi memerlukan waktu yang cukup lama untuk data yang besar.
2. Notifikasi pengingat masih menggunakan sistem manual, belum ada scheduled notification otomatis.
3. Backup data masih bersifat manual, belum ada automated backup secara berkala.
4. Beberapa laporan masih memerlukan penyesuaian tampilan untuk lebih user-friendly.
5. Performance sistem menurun saat jumlah data sudah cukup besar, terutama pada fitur export dan download.

### 3. Peningkatan apa yang bisa dilakukan

1. Mengimplementasikan background job atau queue system untuk proses compress file ZIP agar tidak mengganggu performa sistem.
2. Menambahkan fitur scheduled notification menggunakan Laravel Scheduler untuk pengingat otomatis.
3. Mengimplementasikan automated backup secara berkala dengan penjadwalan harian atau mingguan.
4. Melakukan UI/UX improvement pada tampilan laporan untuk meningkatkan user experience.
5. Melakukan performance optimization dan database indexing untuk meningkatkan kecepatan query.
6. Menambahkan caching mechanism untuk data yang sering diakses namun jarang berubah.
7. Melakukan load testing untuk mengidentifikasi batasan sistem dan area yang perlu optimasi.

---

## Ringkasan Keseluruhan Proyek

### Pencapaian Utama
- ✅ **100% User Stories Completed** - Semua 49 user stories berhasil diselesaikan
- ✅ **4 Sprint Selesai Tepat Waktu** - 10 minggu development tanpa delay signifikan
- ✅ **3 Role System** - Admin, Guru, dan Siswa dengan fitur lengkap
- ✅ **Sistem Pembelajaran Lengkap** - Dari manajemen pengguna hingga tracking progress
- ✅ **Testing Menyeluruh** - Regression testing dilakukan di setiap sprint
- ✅ **Dokumentasi Lengkap** - Activity diagram, sequence diagram, dan user manual

### Statistik Proyek
| Metrik | Jumlah |
|--------|--------|
| Total Sprint | 4 Sprint |
| Durasi Proyek | 10 Minggu |
| Total User Stories | 49 Stories |
| Total Daily Scrum Entries | 196 Entries |
| Team Members | 4 Orang |
| Success Rate | 100% |

### Pembelajaran Penting
1. **Komunikasi Tim** - Komunikasi yang baik antara backend dan frontend sangat krusial untuk kesuksesan proyek.
2. **Testing Early** - Pengujian yang dilakukan lebih awal dapat mengurangi bug di tahap akhir.
3. **Documentation** - Dokumentasi yang baik memudahkan debugging dan maintenance.
4. **Sprint Duration** - Sprint 2-4 yang lebih pendek (2 minggu) membuat tim lebih fokus dan produktif.
5. **Regression Testing** - Sangat penting untuk memastikan fitur lama tidak rusak saat menambah fitur baru.
6. **Performance** - Optimasi performa harus dipertimbangkan sejak awal, terutama untuk data besar.

### Rekomendasi untuk Proyek Selanjutnya
1. Implementasi automated testing (unit test, integration test) sejak awal proyek.
2. Setup CI/CD pipeline untuk otomasi deployment dan testing.
3. Gunakan monitoring tools untuk tracking performa aplikasi di production.
4. Implementasi feature flag untuk memudahkan rollout fitur baru.
5. Buat design system yang konsisten sejak awal untuk memudahkan development UI.
6. Alokasikan waktu khusus untuk technical debt dan refactoring di setiap sprint.

---

**Tanggal Dibuat:** 30 Desember 2025  
**Project:** E-Learning Coding Akademi Payakumbuh  
**Status:** ✅ Project Complete - All Sprints Successful  
**Team:** Luthfi, Faris, Wili, Zidan
