# BAB 3 - DESAIN SISTEM

## 3.1 Arsitektur Sistem

Sistem Informasi Manajemen Pembelajaran "Materi Online" dikembangkan menggunakan arsitektur **Client-Server berbasis Web**. Arsitektur ini dipilih karena kemudahan akses melalui browser tanpa instalasi tambahan dan kemudahan maintenance terpusat.

### 3.1.1 Komponen Utama Arsitektur

> **Gambar 3.1: Diagram Arsitektur Sistem Materi Online**
> ![Arsitektur Sistem](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\architecture_diagram.png)

**Penjelasan Layer:**
- **Presentation Layer**: Browser untuk Admin, Guru, dan Siswa mengakses sistem via HTTPS
- **Application Layer**: Web Server Apache dengan Laravel 11.x (Controllers, Models, Views)
- **Data Layer**: MySQL 8.0 untuk database relasional dan File Storage untuk PDF/Video

### 3.1.2 Teknologi yang Digunakan

| Komponen | Teknologi | Versi | Keterangan |
|----------|-----------|-------|------------|
| **Backend Framework** | Laravel | 11.x | PHP Framework dengan arsitektur MVC |
| **Frontend** | Blade + Bootstrap | 5.x | Template engine + CSS Framework |
| **Database** | MySQL | 8.0 | Relational Database Management System |
| **Web Server** | Apache | 2.4 | HTTP Server |
| **Bahasa** | PHP | 8.2 | Server-side scripting |
| **JavaScript** | Vanilla JS + jQuery | 3.x | Client-side interactivity |
| **Hosting** | Niagahoster | Business | Shared hosting dengan 30GB storage |

### 3.1.3 Deployment Diagram

> **Gambar 3.2: Deployment Diagram Sistem Materi Online**
> ![Deployment Diagram](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\deployment_diagram.png)

**Spesifikasi Hosting:**
- **Provider**: Niagahoster Business Plan
- **Domain**: materionline.coding-akademi.id
- **SSL**: Let's Encrypt (HTTPS)
- **Storage**: 30GB SSD
- **Uptime**: 99.9%

## 3.2 Desain Basis Data

### 3.2.1 Conceptual Design (Entity Relationship Diagram)

Sistem ini memiliki **8 tabel utama** dengan relasi sebagai berikut:

> **Gambar 3.3: Entity Relationship Diagram (ERD)**
> ![ERD Diagram](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\erd_diagram.png)

**Penjelasan Relasi:**
- **Users - Kelas**: Satu Guru dapat mengajar banyak Kelas (1:N via `guru_id`)
- **Kelas - Users (Siswa)**: Many-to-Many melalui tabel pivot `enrollments`
- **Kelas - Materis**: Satu Kelas memiliki banyak Materi (1:N)
- **Materis - Presensis**: Kehadiran dicatat per akses materi (1:N)
- **Users - Materis**: Satu Guru dapat upload banyak Materi (1:N via `uploaded_by`)
- **Materis - Materi_Progress**: Satu Materi dapat diakses banyak Siswa (1:N)

### 3.2.2 Logical Design (Struktur Tabel)

**Tabel 3.1: Struktur Tabel Users**

| Kolom | Tipe Data | Constraint | Keterangan |
|-------|-----------|------------|------------|
| id | BIGINT | PK, AUTO_INCREMENT | Primary Key |
| name | VARCHAR(255) | NOT NULL | Nama lengkap |
| email | VARCHAR(255) | UNIQUE, NOT NULL | Email login |
| password | VARCHAR(255) | NOT NULL | Password (hashed) |
| role | ENUM | NOT NULL | 'admin', 'guru', 'siswa' |
| is_active | BOOLEAN | DEFAULT true | Status aktif |
| tanggal_lahir | DATE | NULL | Tanggal lahir siswa |
| alamat | TEXT | NULL | Alamat lengkap |
| nomor_hp | VARCHAR(20) | NULL | Nomor telepon |
| created_at | TIMESTAMP | | Waktu dibuat |
| updated_at | TIMESTAMP | | Waktu diupdate |

**Tabel 3.2: Struktur Tabel Kelas**

| Kolom | Tipe Data | Constraint | Keterangan |
|-------|-----------|------------|------------|
| id | BIGINT | PK, AUTO_INCREMENT | Primary Key |
| nama | VARCHAR(255) | NOT NULL | Nama kelas (Coding/Desain/Robotik) |
| deskripsi | TEXT | NULL | Deskripsi kelas |
| guru_id | BIGINT | FK → users.id | Guru pengampu |
| created_at | TIMESTAMP | | Waktu dibuat |
| updated_at | TIMESTAMP | | Waktu diupdate |

**Tabel 3.3: Struktur Tabel Enrollments (Pivot)**

| Kolom | Tipe Data | Constraint | Keterangan |
|-------|-----------|------------|------------|
| id | BIGINT | PK, AUTO_INCREMENT | Primary Key |
| user_id | BIGINT | FK → users.id | Siswa |
| kelas_id | BIGINT | FK → kelas.id | Kelas |
| enrolled_at | TIMESTAMP | | Waktu enroll |

**Tabel 3.4: Struktur Tabel Materi**

| Kolom | Tipe Data | Constraint | Keterangan |
|-------|-----------|------------|------------|
| id | BIGINT | PK, AUTO_INCREMENT | Primary Key |
| judul | VARCHAR(255) | NOT NULL | Judul materi |
| deskripsi | TEXT | NULL | Deskripsi materi |
| file_path | VARCHAR(255) | NOT NULL | Path file (PDF/Video) |
| tipe | ENUM | NOT NULL | 'pdf', 'video', 'link' |
| status | ENUM | DEFAULT 'pending' | 'pending', 'approved', 'rejected' |
| kelas_id | BIGINT | FK → kelas.id | Kelas tujuan |
| uploaded_by | BIGINT | FK → users.id | Guru uploader |
| approved_by | BIGINT | FK → users.id, NULL | Admin approver |
| approved_at | TIMESTAMP | NULL | Waktu diapprove |
| created_at | TIMESTAMP | | Waktu dibuat |

**Tabel 3.5: Struktur Tabel Materi_Progress**

| Kolom | Tipe Data | Constraint | Keterangan |
|-------|-----------|------------|------------|
| id | BIGINT | PK, AUTO_INCREMENT | Primary Key |
| user_id | BIGINT | FK → users.id | Siswa |
| materi_id | BIGINT | FK → materi.id | Materi |
| current_page | INT | DEFAULT 0 | Halaman terakhir (PDF) |
| total_pages | INT | DEFAULT 0 | Total halaman |
| progress_percentage | DECIMAL(5,2) | DEFAULT 0 | Persentase progress |
| is_completed | BOOLEAN | DEFAULT false | Status selesai |
| last_read_at | TIMESTAMP | NULL | Waktu terakhir baca |

**Tabel 3.6: Struktur Tabel Pertemuan**

| Kolom | Tipe Data | Constraint | Keterangan |
|-------|-----------|------------|------------|
| id | BIGINT | PK, AUTO_INCREMENT | Primary Key |
| kelas_id | BIGINT | FK → kelas.id | Kelas |
| tanggal | DATE | NOT NULL | Tanggal pertemuan |
| topik | VARCHAR(255) | NOT NULL | Topik pertemuan |
| deskripsi | TEXT | NULL | Deskripsi pertemuan |
| created_at | TIMESTAMP | | Waktu dibuat |

**Tabel 3.7: Struktur Tabel Absens**

| Kolom | Tipe Data | Constraint | Keterangan |
|-------|-----------|------------|------------|
| id | BIGINT | PK, AUTO_INCREMENT | Primary Key |
| user_id | BIGINT | FK → users.id | Siswa |
| pertemuan_id | BIGINT | FK → pertemuan.id | Pertemuan |
| status | ENUM | NOT NULL | 'hadir', 'izin', 'sakit', 'alpha' |
| created_at | TIMESTAMP | | Waktu dicatat |

### 3.2.3 Physical Design (Implementasi MySQL)

Sistem menggunakan **MySQL 8.0** sebagai Database Management System (DBMS). Berikut adalah spesifikasi implementasi fisik database:

**Tabel 3.8: Spesifikasi Database**

| Aspek | Spesifikasi |
|-------|-------------|
| DBMS | MySQL 8.0 Community Edition |
| Engine | InnoDB (mendukung Foreign Key & Transaction) |
| Character Set | utf8mb4 (mendukung emoji & karakter unicode) |
| Collation | utf8mb4_unicode_ci |
| Storage | SSD 30GB (Niagahoster Business) |

**Tabel 3.9: Ringkasan Tabel Database**

| No | Nama Tabel | Jumlah Kolom | Primary Key | Foreign Keys | Fungsi |
|----|------------|--------------|-------------|--------------|--------|
| 1 | users | 20 | id | - | Menyimpan data Admin, Guru, Siswa |
| 2 | kelas | 8 | id | guru_id → users | Menyimpan data kelas pembelajaran |
| 3 | enrollments | 6 | id | user_id → users, kelas_id → kelas | Pivot siswa-kelas (N:M) |
| 4 | materis | 10 | id | kelas_id → kelas, uploaded_by → users | Menyimpan materi pembelajaran |
| 5 | materi_progress | 10 | id | user_id → users, materi_id → materis | Tracking progress belajar siswa |
| 6 | presensis | 7 | id | user_id → users, materi_id → materis | Mencatat kehadiran per materi |
| 7 | activity_logs | 12 | id | user_id → users | Log aktivitas untuk audit trail |
| 8 | sessions | 6 | id | user_id → users | Manajemen sesi pengguna |

**Aturan Integritas Referensial:**
- **ON DELETE CASCADE**: Jika parent record dihapus, child record ikut terhapus (enrollments, materis, presensis)
- **ON DELETE SET NULL**: Jika parent dihapus, foreign key diset NULL (kelas.guru_id)

## 3.3 Desain UML

Unified Modeling Language (UML) digunakan untuk memodelkan sistem secara visual. Pada bagian ini disajikan tiga jenis diagram UML yang menggambarkan perilaku dan struktur sistem.

### 3.3.1 Activity Diagram

Activity Diagram menggambarkan alur kerja (workflow) aktivitas dalam sistem dari awal hingga selesai. Diagram ini menunjukkan langkah-langkah yang dilakukan pengguna dan respons sistem secara berurutan.

#### A. Activity Diagram - Admin

> **Gambar 3.4: Activity Diagram Admin**
> ![Activity Diagram Admin](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\activity_admin.png)

**Penjelasan Alur:**

Diagram ini menggambarkan aktivitas yang dapat dilakukan oleh Admin setelah login ke sistem:

1. **Kelola Guru/Siswa**: Admin dapat menambah, mengubah, menghapus, dan mengaktifkan/menonaktifkan data pengguna (Guru dan Siswa) melalui menu Pengguna.

2. **Kelola Kelas**: Admin dapat membuat kelas baru, mendaftarkan siswa ke kelas (enroll), atau mengeluarkan siswa dari kelas (unenroll).

3. **Verifikasi Materi**: Ketika Guru mengupload materi, Admin mereview konten materi tersebut. Jika sesuai, Admin menyetujui (approve); jika tidak sesuai, Admin menolak (reject) dengan memberikan alasan penolakan.

4. **Pertemuan & Absensi**: Admin mencatat pertemuan kelas dan menginput kehadiran siswa per pertemuan.

5. **Export & Backup**: Admin dapat mengunduh laporan dalam format Excel dan melakukan backup database untuk keamanan data.

#### B. Activity Diagram - Guru

> **Gambar 3.5: Activity Diagram Guru**
> ![Activity Diagram Guru](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\activity_guru.png)

**Penjelasan Alur:**

Diagram ini menggambarkan aktivitas yang dapat dilakukan oleh Guru:

1. **Upload Materi**: Guru mengisi form (judul, deskripsi), memilih file PDF atau Video, lalu submit. Sistem menyimpan file dan mengubah status menjadi "pending" menunggu verifikasi Admin.

2. **Lihat Status Materi**: Guru dapat melihat daftar materi yang telah diupload beserta statusnya:
   - **Pending**: Menunggu verifikasi Admin
   - **Approved**: Sudah disetujui, dapat diakses siswa
   - **Rejected**: Ditolak, perlu diperbaiki

3. **Edit/Hapus Materi**: Guru dapat memperbaiki materi yang ditolak atau menghapus materi yang tidak diperlukan.

4. **Monitor Progress**: Guru dapat melihat persentase penyelesaian materi oleh setiap siswa di kelasnya.

#### C. Activity Diagram - Siswa

> **Gambar 3.6: Activity Diagram Siswa**
> ![Activity Diagram Siswa](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\activity_siswa.png)

**Penjelasan Alur:**

Diagram ini menggambarkan aktivitas pembelajaran Siswa:

1. **Login**: Siswa memasukkan email dan password. Jika valid, sistem menampilkan dashboard; jika tidak valid, ditampilkan pesan error.

2. **Lihat Kelas**: Siswa dapat melihat daftar kelas yang diikuti beserta progress bar yang menunjukkan persentase penyelesaian materi.

3. **Akses Materi**: Siswa memilih kelas, lalu memilih materi untuk dipelajari. Jika materi berupa PDF, sistem menampilkan PDF Viewer; jika Video, sistem menampilkan Video Player.

4. **Auto-Save Progress**: Saat membaca PDF, sistem secara otomatis menyimpan halaman terakhir yang dibaca sehingga siswa dapat melanjutkan dari halaman tersebut di lain waktu.

5. **Tandai Selesai**: Setelah selesai mempelajari materi, siswa mengklik tombol "Tandai Selesai" untuk mencatat bahwa materi telah dipelajari. Sistem akan memperbarui progress menjadi 100% dan mencatat kehadiran.

### 3.3.2 Sequence Diagram

Sequence Diagram menggambarkan urutan interaksi antar objek (aktor, controller, model, database) dalam sistem berdasarkan waktu. Diagram ini menunjukkan pesan yang dikirim antar objek untuk menyelesaikan suatu proses.

#### A. Sequence Diagram - Admin

> **Gambar 3.7: Sequence Diagram Admin**
> ![Sequence Diagram Admin](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\sequence_admin.png)

**Penjelasan Interaksi:**

Diagram ini menunjukkan urutan interaksi saat Admin memverifikasi materi:

1. Admin membuka halaman daftar materi pending melalui browser
2. Controller meminta data materi dengan status "pending" ke Model
3. Model menjalankan query SELECT ke database
4. Database mengembalikan daftar materi pending
5. Admin mereview dan memutuskan approve atau reject
6. Controller memperbarui status materi di database
7. Sistem mengirim notifikasi ke Guru terkait

#### B. Sequence Diagram - Guru

> **Gambar 3.8: Sequence Diagram Guru**
> ![Sequence Diagram Guru](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\sequence_guru.png)

**Penjelasan Interaksi:**

Diagram ini menunjukkan urutan interaksi saat Guru mengupload materi:

1. Guru mengisi form upload materi dan memilih file
2. Controller menyimpan file ke storage server
3. Controller menyimpan data materi ke database dengan status "pending"
4. Sistem mengirim notifikasi ke Admin bahwa ada materi baru menunggu verifikasi
5. Controller mengembalikan pesan sukses ke browser

#### C. Sequence Diagram - Siswa

> **Gambar 3.9: Sequence Diagram Siswa**
> ![Sequence Diagram Siswa](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\sequence_siswa.png)

**Penjelasan Interaksi:**

Diagram ini menunjukkan urutan interaksi saat Siswa mengakses dan mempelajari materi:

1. Siswa memilih kelas dan materi yang ingin dipelajari
2. Controller meminta data materi dan progress terakhir dari database
3. Sistem menampilkan materi dalam PDF Viewer atau Video Player
4. Saat siswa berpindah halaman PDF, browser mengirim request update progress via AJAX
5. Controller memperbarui current_page dan menghitung progress_percentage di database
6. Saat siswa mengklik "Tandai Selesai", sistem memperbarui is_completed=true dan mencatat kehadiran

### 3.3.3 Class Diagram

Class Diagram menggambarkan struktur statis sistem, yaitu entitas (tabel) dan hubungan (relasi) antar entitas dalam database. Diagram ini menunjukkan atribut setiap tabel dan kardinalitas hubungan antar tabel.

> **Gambar 3.10: Class Diagram E-Learning**
> ![Class Diagram](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\class_diagram.png)

**Penjelasan Entitas dan Relasi:**

| Entitas | Deskripsi | Relasi Utama |
|---------|-----------|--------------|
| **users** | Menyimpan data semua pengguna (Admin, Guru, Siswa) dengan atribut identitas, role, dan informasi pembayaran | Berelasi ke hampir semua tabel lain |
| **kelas** | Data kelas pembelajaran dengan nama, deskripsi, bidang (coding/design/robotic), dan guru pengampu | 1 Guru mengajar N Kelas |
| **enrollments** | Tabel pivot yang menghubungkan Siswa dengan Kelas (relasi Many-to-Many) | 1 Siswa dapat enroll ke N Kelas |
| **materis** | Materi pembelajaran berupa file PDF atau Video dengan status verifikasi | 1 Kelas memiliki N Materi |
| **materi_progress** | Mencatat progress belajar setiap Siswa per Materi (halaman terakhir, persentase, status selesai) | 1 Siswa memiliki N Progress |
| **presensis** | Mencatat kehadiran Siswa saat mengakses materi atau pertemuan | 1 Pertemuan memiliki N Kehadiran |
| **pertemuans** | Data pertemuan/sesi kelas dengan tanggal, topik, dan waktu | 1 Kelas memiliki N Pertemuan |
| **activity_logs** | Log aktivitas pengguna untuk audit trail (siapa melakukan apa dan kapan) | 1 User memiliki N Log |

## 3.4 Desain Antarmuka Pengguna (User Interface Design)

Desain antarmuka pengguna dibuat dengan mempertimbangkan kemudahan penggunaan dan estetika visual. Berikut adalah screenshot dari implementasi antarmuka sistem yang diorganisir berdasarkan fitur utama.

### 3.4.1 Prinsip Desain UI

Desain antarmuka sistem mengikuti prinsip:

1. **Child-Friendly**: Warna cerah dan navigasi sederhana untuk siswa anak-anak (usia 7-15 tahun)
2. **Responsive**: Layout yang menyesuaikan dengan berbagai ukuran layar (desktop, tablet)
3. **Konsisten**: Komponen UI yang seragam di seluruh halaman (button, card, form)
4. **Accessible**: Kontras warna yang baik dan ukuran font yang mudah dibaca

### 3.4.2 Halaman Publik

#### A. Landing Page

> **Gambar 3.11: Halaman Landing Page**
> ![Landing Page](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\ui_landing_page.png)

Halaman utama yang ditampilkan saat pertama kali mengakses sistem, menampilkan informasi tentang Coding Akademi Payakumbuh dengan desain menarik dan tombol "Login".

#### B. Halaman Login

> **Gambar 3.12: Halaman Login**
> ![Halaman Login](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\ui_login.png)

Form login dengan input email dan password. Semua role menggunakan halaman yang sama, sistem mengarahkan ke dashboard sesuai role.

### 3.4.3 Dashboard

#### A. Dashboard Admin

> **Gambar 3.13: Dashboard Admin**
> ![Dashboard Admin](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\ui_dashboard_admin.png)

Menampilkan statistik ringkasan (siswa, guru, kelas), notifikasi materi pending, dan log aktivitas terbaru.

#### B. Dashboard Guru

> **Gambar 3.14: Dashboard Guru**
> ![Dashboard Guru](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\ui_dashboard_guru.png)

Menampilkan daftar kelas yang diampu, status materi (approved/pending/rejected), dan akses ke monitoring progress siswa.

#### C. Dashboard Siswa

> **Gambar 3.15: Dashboard Siswa**
> ![Dashboard Siswa](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\ui_dashboard_siswa.png)

Tampilan ramah anak dengan daftar kelas yang diikuti, progress bar visual, dan status pembayaran.

### 3.4.4 Fitur Manajemen Pengguna (Admin)

#### A. Halaman Kelola Pengguna

> **Gambar 3.16: Halaman Kelola Pengguna**
> ![Kelola Pengguna](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\ui_kelola_pengguna.png)

Menampilkan daftar Guru dan Siswa dalam tabel dengan fitur pencarian, filter, dan tombol aksi (Edit, Hapus, Toggle Status).

#### B. Form Tambah Siswa

> **Gambar 3.17: Form Tambah Siswa**
> ![Form Tambah Siswa](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\ui_form_siswa.png)

Form lengkap dengan validasi input, date picker, dropdown provinsi/kota, dan field pembayaran.

### 3.4.5 Fitur Manajemen Kelas (Admin)

#### A. Daftar Kelas

> **Gambar 3.18: Halaman Daftar Kelas**
> ![Halaman Kelas](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\ui_kelas.png)

Menampilkan semua kelas dengan informasi lengkap: Nama Kelas, Bidang, Guru Pengampu, Jumlah Siswa, dan Status.

#### B. Detail Kelas

> **Gambar 3.19: Halaman Detail Kelas**
> ![Detail Kelas](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\ui_detail_kelas.png)

Menampilkan informasi lengkap kelas, daftar siswa yang terdaftar, dan daftar materi yang tersedia di kelas tersebut.

#### C. Enroll Siswa ke Kelas

> **Gambar 3.20: Form Daftarkan Siswa ke Kelas**
> ![Enroll Siswa](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\ui_enroll_siswa.png)

Form untuk mendaftarkan siswa ke kelas dengan pilihan durasi, quota pertemuan, dan tanggal mulai.

### 3.4.6 Fitur Manajemen Materi

#### A. Daftar Materi Pending (Admin)

> **Gambar 3.21: Halaman Materi Pending**
> ![Materi Pending](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\ui_materi_pending.png)

Menampilkan materi yang menunggu verifikasi Admin dengan tombol aksi Approve dan Reject.

#### B. Review Materi (Admin)

> **Gambar 3.22: Halaman Review Materi**
> ![Review Materi](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\ui_review_materi.png)

Preview konten materi dengan PDF Viewer, informasi detail, dan tombol Approve/Reject.

#### C. Upload Materi (Guru)

> **Gambar 3.23: Form Upload Materi**
> ![Form Upload Materi](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\ui_upload_materi.png)

Form upload dengan input judul, deskripsi, pilihan kelas, dan file upload (PDF/Video).

#### D. Manajemen Materi (Guru)

> **Gambar 3.24: Halaman Manajemen Materi Guru**
> ![Guru Materi](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\ui_guru_materi.png)

Daftar materi yang diupload Guru dengan status (pending/approved/rejected) dan tombol Edit/Hapus.

### 3.4.7 Fitur Pembelajaran Siswa

#### A. Daftar Kelas Siswa

> **Gambar 3.25: Halaman Kelas Siswa**
> ![Siswa Kelas](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\ui_siswa_kelas.png)

Menampilkan kelas yang diikuti siswa dengan progress bar dan materi yang tersedia.

#### B. Baca Materi PDF

> **Gambar 3.26: Halaman Baca Materi**
> ![Siswa Baca Materi](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\ui_siswa_materi.png)

PDF Viewer terintegrasi dengan navigasi halaman, progress bar, auto-save, dan tombol "Tandai Selesai".

#### C. Detail Progress Siswa

> **Gambar 3.27: Halaman Progress Siswa**
> ![Siswa Progress](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\ui_siswa_progress.png)

Menampilkan detail progress per materi dengan persentase dan status penyelesaian.

### 3.4.8 Fitur Monitoring Progress (Guru)

> **Gambar 3.28: Halaman Monitoring Progress Siswa**
> ![Guru Progress](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\ui_guru_progress.png)

Guru dapat melihat progress belajar setiap siswa dalam kelas yang diampu, termasuk persentase penyelesaian dan materi yang sudah dipelajari.

### 3.4.9 Fitur Pertemuan & Absensi

#### A. Daftar Pertemuan

> **Gambar 3.29: Halaman Daftar Pertemuan**
> ![Pertemuan](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\ui_pertemuan.png)

Menampilkan daftar pertemuan per kelas dengan tanggal, topik, dan status absensi.

#### B. Input Absensi

> **Gambar 3.30: Halaman Input Absensi**
> ![Input Absensi](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\ui_input_absen.png)

Daftar siswa dengan pilihan status kehadiran (Hadir, Izin, Sakit, Alpha) dan tombol Simpan.

### 3.4.10 Fitur Backup & Export (Admin)

> **Gambar 3.31: Halaman Backup Data**
> ![Backup](C:\Users\atom\.gemini\antigravity\brain\a3b650d6-13ed-4c9c-9d16-5e21e1581e1c\ui_backup.png)

Fitur backup database (SQL) dan download semua file materi (ZIP), serta export laporan dalam format Excel.

---

**Ringkasan Tampilan UI:**

| No | Fitur | Gambar | Role |
|----|-------|--------|------|
| 1 | Landing Page | 3.11 | Publik |
| 2 | Login | 3.12 | Publik |
| 3-5 | Dashboard | 3.13-3.15 | Admin, Guru, Siswa |
| 6-7 | Manajemen Pengguna | 3.16-3.17 | Admin |
| 8-10 | Manajemen Kelas | 3.18-3.20 | Admin |
| 11-14 | Manajemen Materi | 3.21-3.24 | Admin, Guru |
| 15-17 | Pembelajaran | 3.25-3.27 | Siswa |
| 18 | Monitoring Progress | 3.28 | Guru |
| 19-20 | Pertemuan & Absensi | 3.29-3.30 | Admin, Guru |
| 21 | Backup & Export | 3.31 | Admin |

