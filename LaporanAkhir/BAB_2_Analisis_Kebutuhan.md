# BAB 2 - ANALISIS KEBUTUHAN

## 2.1 Proses Bisnis

### 2.1.1 Proses Bisnis Sistem yang Sedang Berjalan (As-Is System)

Proses bisnis yang berjalan saat ini di Coding Academy Payakumbuh masih didominasi oleh penanganan manual dan penggunaan alat yang tidak terintegrasi. Berdasarkan observasi dan wawancara, alur kerja saat ini adalah sebagai berikut:

1.  **Pendaftaran & Administrasi:** Calon siswa mendaftar melalui formulir kertas atau chat WhatsApp. Data siswa dicatat ulang oleh admin ke dalam buku induk atau file spreadsheet yang terpisah dari data keuangan.
2.  **Pembayaran:** Orang tua mengirim bukti transfer via WhatsApp. Admin memverifikasi mutasi rekening bank secara manual, lalu mencatat status lunas di buku/Excel. Tidak ada notifikasi otomatis jika masa pembayaran habis.
3.  **Distribusi Materi:** Guru menyimpan file materi di laptop pribadi atau *Google Drive* pribadi. Materi dibagikan link-nya melalui grup WhatsApp kelas. Hal ini menyebabkan materi sering terkubur chat, link kadaluarsa, atau siswa lupa mengunduh.
4.  **Proses Belajar:** Siswa belajar secara mandiri di rumah tanpa panduan urutan yang jelas. Guru tidak memiliki mekanisme untuk mengetahui apakah siswa sudah membaca materi atau menonton video.
5.  **Presensi:** Absensi dilakukan dengan memanggil nama siswa saat kelas tatap muka atau checklist manual di grup WA untuk kelas online. Rekapitulasi absensi bulanan memakan waktu lama.

*(Gambar Flowchart As-Is dapat dilihat pada diagram berikut)*
> **Gambar 2.1: Flowchart Proses Bisnis Saat Ini (As-Is)**
> ![Flowchart As-Is](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\flowasis.puml)

**Kelemahan Proses Berjalan:**
*   Data tidak terpusat (Redundansi dan risiko hilang).
*   Distribusi materi tidak terstruktur (Rawan *human error*).
*   Monitoring kemajuan siswa sulit dilakukan.
*   Waktu administrasi yang tinggi untuk hal rutin (absensi, cek pembayaran).

### 2.1.2 Proses Bisnis Sistem yang Dikembangkan (To-Be System)

Sistem **"Materi Online"** yang dikembangkan menawarkan alur kerja baru yang terintegrasi:

1.  **Manajemen Data Terpusat:** Admin menginput data siswa dan guru ke dalam sistem satu kali. Data profil, alamat, dan status pembayaran tersimpan dalam basis data yang aman.
2.  **Manajemen Pembayaran Terintegrasi:** Admin memverifikasi bukti bayar di sistem, dan status siswa otomatis berubah menjadi "Aktif". Siswa mendapat notifikasi pengingat pembayaran otomatis.
3.  **Distribusi Materi Terstruktur:** Guru mengunggah materi ke sistem. Materi masuk antrean "Menunggu Verifikasi". Admin menyetujui materi. Materi yang sudah disetujui otomatis tampil di akun siswa.
4.  **Sistem Belajar & Tracking:** Siswa mengakses materi secara berurutan. Sistem mencatat progres (misal: tombol "Selesai Baca"). Progres ditampilkan visual (*progress bar*). Materi baru dapat diseting terkunci (*locked*) hingga waktu tertentu atau syarat terpenuhi.
5.  **Otomasi Presensi:** Kehadiran siswa dicatat otomatis oleh sistem saat mereka login dan mengakses kelas pada jadwal yang ditentukan.

*(Gambar Flowchart To-Be dapat dilihat pada diagram berikut)*
> **Gambar 2.2: Flowchart Proses Bisnis Usulan (To-Be)**
> ![Flowchart To-Be](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\flowcharttobe.puml)

**Manfaat Sistem Usulan:**
*   Efisiensi administrasi hingga 100% (Paperless).
*   Kontrol kualitas materi melalui verifikasi admin.
*   Transparansi progres belajar bagi guru dan siswa.
*   Validasi data yang lebih akurat (validasi tanggal lahir, wilayah).

## 2.2 Karakteristik Pengguna

Sistem ini dirancang untuk digunakan oleh tiga aktor utama dengan karakteristik sebagai berikut:

| Jenis Pengguna | Tugas dan Tanggung Jawab | Kemampuan Teknis |
| :--- | :--- | :--- |
| **Admin** | Mengelola data master (Siswa, Guru, Kelas), memverifikasi materi ajar, memvalidasi pembayaran, dan memantau keseluruhan sistem. | **Menengah.** Dapat mengoperasikan aplikasi web, manajemen file, dan pemahaman dasar administrasi sistem. |
| **Guru** | Mengunggah materi pembelajaran, membuat jadwal pertemuan, memantau absensi dan progres belajar siswa di kelas yang diampu. | **Menengah.** Terbiasa dengan penggunaan browser, upload/download file, dan aplikasi produktivitas. |
| **Siswa** | Mengakses materi pembelajaran, melihat progres belajar mandiri, dan mengelola profil pribadi. | **Dasar.** Mampu melakukan login dan navigasi website sederhana. Target usia anak-anak hingga remaja. |

## 2.3 Kebutuhan Fungsional (Functional Requirements)

Berikut adalah kebutuhan fungsional sistem yang telah diidentifikasi dan diberi kode FR (*Functional Requirement*):

**Aktor: Semua Pengguna**
*   **FR-01:** Pengguna dapat melakukan login menggunakan email dan password.
*   **FR-02:** Pengguna dapat melakukan logout dari sistem.
*   **FR-03:** Pengguna dapat mengubah profil pribadi dan password.

**Aktor: Admin**
*   **FR-04:** Admin dapat mengelola (Tambah, Ubah, Hapus) data Guru.
*   **FR-05:** Admin dapat mengelola (Tambah, Ubah, Hapus) data Siswa dengan validasi input (Tanggal lahir, Alamat via dropdown).
*   **FR-06:** Admin dapat mengelola (Tambah, Ubah, Hapus) data Kelas (Coding, Desain, Robotik).
*   **FR-07:** Admin dapat mendaftarkan (*enroll*) siswa ke dalam kelas tertentu.
*   **FR-08:** Admin dapat melihat daftar materi yang diunggah Guru dengan status "Pending".
*   **FR-09:** Admin dapat memverifikasi materi (Approve/Reject).
*   **FR-10:** Admin dapat memverifikasi bukti pembayaran siswa dan mengubah status menjadi "Aktif".
*   **FR-11:** Admin dapat mengelola promo pembayaran.
*   **FR-12:** Admin dapat melakukan backup data materi dan database.

**Aktor: Guru**
*   **FR-13:** Guru dapat melihat daftar kelas yang diampu (hanya kelas sendiri).
*   **FR-14:** Guru dapat mengunggah materi pembelajaran (PDF, Video, Link).
*   **FR-15:** Guru dapat melihat daftar siswa dan kehadiran mereka.
*   **FR-16:** Guru dapat melihat monitoring progres belajar siswa (tabel penyelesaian materi).

**Aktor: Siswa**
*   **FR-17:** Siswa dapat melihat daftar kelas yang diikuti.
*   **FR-18:** Siswa dapat mengakses materi yang berstatus "Approved".
*   **FR-19:** Siswa dapat melihat status pembayaran (Aktif/Non-Aktif/Jatuh Tempo).
*   **FR-20:** Siswa dapat melihat progress bar kemajuan belajar.
*   **FR-21:** Siswa dapat menandai materi PDF sebagai "Sudah Dibaca".

## 2.4 Kebutuhan Non-Fungsional (Non-Functional Requirements)

*   **NFR-01 (Kinerja):** Sistem harus dapat memuat halaman utama dalam waktu kurang dari 3 detik pada koneksi internet standar (4G/Wifi).
*   **NFR-02 (Kinerja):** Sistem mampu menangani minimal 20 pengguna yang mengakses secara bersamaan (*concurrent users*).
*   **NFR-03 (Aksesibilitas):** Antarmuka sistem harus responsif dan dapat diakses dengan baik melalui perangkat Komputer/Laptop (resolusi min. 1366x768) dan Tablet.
*   **NFR-04 (Keamanan):** Password pengguna harus disimpan dalam bentuk terenkripsi (hashing).
*   **NFR-05 (Keamanan):** Halaman manajemen (Admin/Guru) harus terlindungi dari akses tanpa login (*unauthorized access*).
*   **NFR-06 (Desain):** Antarmuka pengguna (*User Interface*) menggunakan warna cerah dan tata letak yang ramah anak (*child-friendly*).
*   **NFR-07 (Ketersediaan):** Sistem harus memiliki *uptime* minimal 99% selama jam operasional kursus.

## 2.5 Diagram Use Case

Diagram Use Case menggambarkan interaksi antara aktor (Admin, Guru, Siswa) dengan fitur-fitur utama dalam sistem "Materi Online".

> **Gambar 2.3: Diagram Use Case Sistem Materi Online**
> ![Use Case Diagram](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\usecase_diagram.jpeg)

**Deskripsi Aktor & Use Case:**
*   **Admin** berinteraksi dengan use case manajemen data master, verifikasi materi, dan validasi pembayaran.
*   **Guru** berinteraksi dengan use case manajemen konten/materi dan monitoring kelas.
*   **Siswa** berinteraksi dengan use case pembelajaran (akses materi) dan profil.

## 2.6 Product Backlog

Tabel berikut menyajikan Product Backlog lengkap yang berisi 49 User Stories yang telah diprioritaskan untuk pengembangan 4 Sprint.

### A. Pengguna Umum - 7 Use Cases

| ID | User Story | Prioritas | Sprint |
| :--- | :--- | :--- | :--- |
| US0001 | Sebagai User, saya ingin login menggunakan email dan password | High | 1 |
| US0002 | Sebagai User, saya ingin logout dengan aman | Medium | 1 |
| US0003 | Sebagai User, saya ingin melihat dashboard sesuai role saya | High | 1 |
| US0004 | Sebagai User, saya ingin mengubah password dengan validasi | Medium | 2 |
| US0005 | Sebagai User, saya ingin reset password jika lupa | Medium | 2 |
| US0006 | Sebagai User, saya ingin melihat Landing Page informasi | Low | 2 |
| US0007 | Sebagai User, saya ingin menerima notifikasi aktivitas | Medium | 2 |

### B. Admin - 29 Use Cases

**B.1. Manajemen Pengguna**

| ID | User Story | Prioritas | Sprint |
| :--- | :--- | :--- | :--- |
| US1001 | Sebagai Admin, saya ingin melihat daftar Guru | High | 1 |
| US1002 | Sebagai Admin, saya ingin menambah data Guru baru | High | 1 |
| US1003 | Sebagai Admin, saya ingin melihat daftar Siswa | High | 1 |
| US1004 | Sebagai Admin, saya ingin menambah data Siswa baru | High | 1 |
| US1014 | Sebagai Admin, saya ingin mengedit data Guru | Medium | 2 |
| US1015 | Sebagai Admin, saya ingin menghapus data Guru | Medium | 2 |
| US1016 | Sebagai Admin, saya ingin mengedit data Siswa | Medium | 2 |
| US1017 | Sebagai Admin, saya ingin menghapus data Siswa | Medium | 2 |
| US1021 | Sebagai Admin, saya ingin toggle status Aktif/Nonaktif user | Medium | 3 |

**B.2. Manajemen Kelas**

| ID | User Story | Prioritas | Sprint |
| :--- | :--- | :--- | :--- |
| US1005 | Sebagai Admin, saya ingin membuat kelas baru | High | 1 |
| US1006 | Sebagai Admin, saya ingin enroll siswa ke kelas | High | 1 |
| US1007 | Sebagai Admin, saya ingin unenroll siswa dari kelas | Medium | 1 |
| US1018 | Sebagai Admin, saya ingin mengubah detail kelas | Medium | 2 |
| US1020 | Sebagai Admin, saya ingin menghapus kelas | Low | 3 |

**B.3. Verifikasi Materi**

| ID | User Story | Prioritas | Sprint |
| :--- | :--- | :--- | :--- |
| US1008 | Sebagai Admin, saya ingin melihat materi pending | High | 1 |
| US1009 | Sebagai Admin, saya ingin menyetujui (approve) materi | High | 1 |
| US1019 | Sebagai Admin, saya ingin menolak (reject) materi | Medium | 2 |
| US1025 | Sebagai Admin, saya ingin kirim reminder ke guru | Low | 4 |

**B.4. Manajemen Pertemuan & Absensi**

| ID | User Story | Prioritas | Sprint |
| :--- | :--- | :--- | :--- |
| US1010 | Sebagai Admin, saya ingin membuat pertemuan baru | High | 1 |
| US1011 | Sebagai Admin, saya ingin mengedit pertemuan | Medium | 1 |
| US1012 | Sebagai Admin, saya ingin menghapus pertemuan | Medium | 1 |
| US1013 | Sebagai Admin, saya ingin input absensi siswa | High | 1 |

**B.5. Laporan & Export**

| ID | User Story | Prioritas | Sprint |
| :--- | :--- | :--- | :--- |
| US1022 | Sebagai Admin, saya ingin melihat history aktivitas siswa | Medium | 3 |
| US1023 | Sebagai Admin, saya ingin export absensi ke Excel | Low | 3 |
| US1024 | Sebagai Admin, saya ingin export learning log ke Excel | Low | 3 |
| US1026 | Sebagai Admin, saya ingin melihat laporan presensi keseluruhan | Medium | 4 |
| US1028 | Sebagai Admin, saya ingin export log aktivitas ke Excel | Low | 4 |

**B.6. Backup & Data Management**

| ID | User Story | Prioritas | Sprint |
| :--- | :--- | :--- | :--- |
| US1027 | Sebagai Admin, saya ingin backup data sistem | Low | 4 |
| US1029 | Sebagai Admin, saya ingin download semua materi dalam ZIP | Low | 4 |

### C. Guru - 7 Use Cases

**C.1. Manajemen Materi**

| ID | User Story | Prioritas | Sprint |
| :--- | :--- | :--- | :--- |
| US2001 | Sebagai Guru, saya ingin upload materi PDF/Video/Link | High | 1 |
| US2002 | Sebagai Guru, saya ingin melihat status materi saya | High | 1 |
| US2005 | Sebagai Guru, saya ingin mengedit materi Pending/Rejected | Medium | 3 |
| US2006 | Sebagai Guru, saya ingin menghapus materi | Medium | 3 |

**C.2. Monitoring Siswa**

| ID | User Story | Prioritas | Sprint |
| :--- | :--- | :--- | :--- |
| US2003 | Sebagai Guru, saya ingin melihat daftar hadir siswa | Medium | 2 |
| US2004 | Sebagai Guru, saya ingin monitor progres belajar siswa | Medium | 2 |
| US2007 | Sebagai Guru, saya ingin melihat laporan kehadiran | Medium | 3 |

### D. Siswa - 6 Use Cases

**D.1. Akses Pembelajaran**

| ID | User Story | Prioritas | Sprint |
| :--- | :--- | :--- | :--- |
| US3001 | Sebagai Siswa, saya ingin melihat daftar kelas yang diikuti | High | 1 |
| US3002 | Sebagai Siswa, saya ingin mengakses materi yang sudah approved | High | 1 |

**D.2. Progress & Status**

| ID | User Story | Prioritas | Sprint |
| :--- | :--- | :--- | :--- |
| US3003 | Sebagai Siswa, saya ingin melihat progress bar belajar | Medium | 2 |
| US3004 | Sebagai Siswa, saya ingin progress PDF tersimpan otomatis | Medium | 3 |
| US3005 | Sebagai Siswa, saya ingin melihat status pembayaran | Medium | 3 |
| US3006 | Sebagai Siswa, saya ingin dapat notifikasi kelas berakhir | Low | 4 |

---

**Ringkasan Product Backlog:**

| Sprint | Jumlah User Stories | Fokus Utama |
|--------|---------------------|-------------|
| Sprint 1 | 20 | Core Authentication & Basic CRUD |
| Sprint 2 | 13 | Advanced CRUD & Profile Management |
| Sprint 3 | 10 | Learning Features & Progress Tracking |
| Sprint 4 | 6 | Reports, Backup & Notifications |
| **Total** | **49** | **100% Completed** ✅ |

