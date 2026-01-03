# LAMPIRAN - DOKUMENTASI SCRUM

## A. Pengelolaan Proyek Berbasis Scrum

### A.1 Pembagian Peran dan Tanggung Jawab Tim Scrum

| Nama Anggota | Scrum Role | Tanggung Jawab Utama |
|--------------|------------|---------------------|
| Muhammad Luthfi Naldi | Development Team | Backend development, Admin features |
| Andrean Willian Syach | Development Team | Frontend development, Siswa features |
| Faris Muhammad Taufik | Development Team | UI/UX, Integration |
| Thilal Said Zaidan | Development Team | Database, Guru features |

### A.2 Pengaturan Waktu dan Perencanaan Sprint

**Durasi Proyek:** 14 Minggu (22 September - 24 Desember 2025)

| Sprint | Durasi | Periode | Jumlah US | Status |
|--------|--------|---------|-----------|--------|
| Sprint 1 | 4 minggu | 22 Sep - 17 Okt | 20 | ✅ 100% |
| Sprint 2 | 2 minggu | 20 Okt - 31 Okt | 13 | ✅ 100% |
| Sprint 3 | 5 minggu | 3 Nov - 3 Des | 10 | ✅ 100% |
| Sprint 4 | 3 minggu | 4 Des - 24 Des | 6 | ✅ 100% |
| **Total** | **14 minggu** | | **49** | **100%** |

### A.3 Mekanisme Komunikasi Internal Tim

**Daily Scrum Meeting:**
- Frekuensi: Setiap hari kerja
- Format: What did I do yesterday? What will I do today? Any obstacles?
- Media: Physical meeting, video recording
- Evidence: 317 daily scrum records dengan video dokumentasi

### A.4 Mekanisme Komunikasi dengan Klien

- Sprint Review setiap akhir sprint
- Demo sistem yang sudah selesai
- Feedback langsung dari stakeholder
- Wawancara kebutuhan di awal proyek

---

## B. Rangkuman Pelaksanaan Sprint

### B.1 Sprint 1: Core Authentication & Basic CRUD

**Periode:** 22 September - 17 Oktober 2025 (4 minggu)

**Sprint Goal:** Membangun fitur inti autentikasi dan CRUD dasar

**Sprint Backlog:**

| ID | User Story | Status |
|----|------------|--------|
| US0001 | Login ke sistem | ✅ Done |
| US0002 | Logout dari sistem | ✅ Done |
| US0003 | Melihat dashboard | ✅ Done |
| US1001 | Admin melihat daftar Guru | ✅ Done |
| US1002 | Admin menambah Guru | ✅ Done |
| US1003 | Admin melihat daftar Siswa | ✅ Done |
| US1004 | Admin menambah Siswa | ✅ Done |
| US1005 | Admin membuat kelas | ✅ Done |
| US1006 | Admin enroll siswa | ✅ Done |
| US1007 | Admin unenroll siswa | ✅ Done |
| US1008 | Admin lihat materi pending | ✅ Done |
| US1009 | Admin approve materi | ✅ Done |
| US1010 | Admin buat pertemuan | ✅ Done |
| US1011 | Admin edit pertemuan | ✅ Done |
| US1012 | Admin hapus pertemuan | ✅ Done |
| US1013 | Admin input absensi | ✅ Done |
| US2001 | Guru upload materi | ✅ Done |
| US2002 | Guru lihat status materi | ✅ Done |
| US3001 | Siswa lihat kelas | ✅ Done |
| US3002 | Siswa akses materi | ✅ Done |

**Hasil:** 20/20 User Stories selesai (100%)

**Sprint Retrospective:**
- **Berjalan Baik:** Kolaborasi tim, dokumentasi UML lengkap
- **Perlu Perbaikan:** Testing perlu lebih awal, dokumentasi kode
- **Action Items:** Code review berkala, buffer time untuk testing

---

### B.2 Sprint 2: Advanced CRUD & Profile

**Periode:** 20 Oktober - 31 Oktober 2025 (2 minggu)

**Sprint Goal:** Fitur advanced CRUD dan manajemen profil

**Sprint Backlog:**

| ID | User Story | Status |
|----|------------|--------|
| US0004 | Mengubah password | ✅ Done |
| US0005 | Reset password | ✅ Done |
| US0006 | Landing page | ✅ Done |
| US0007 | Notifikasi aktivitas | ✅ Done |
| US1014 | Admin edit Guru | ✅ Done |
| US1015 | Admin hapus Guru | ✅ Done |
| US1016 | Admin edit Siswa | ✅ Done |
| US1017 | Admin hapus Siswa | ✅ Done |
| US1018 | Admin edit kelas | ✅ Done |
| US1019 | Admin reject materi | ✅ Done |
| US2003 | Guru lihat kehadiran | ✅ Done |
| US2004 | Guru monitor progress | ✅ Done |
| US3003 | Siswa progress bar | ✅ Done |

**Hasil:** 13/13 User Stories selesai (100%)

**Sprint Retrospective:**
- **Berjalan Baik:** Sprint lebih fokus, regression testing teratur
- **Perlu Perbaikan:** Query optimization, dokumentasi API
- **Action Items:** Design system konsisten, notification improvement

---

### B.3 Sprint 3: Learning Features & Reports

**Periode:** 3 November - 3 Desember 2025 (5 minggu)

**Sprint Goal:** Learning features dan progress tracking

**Sprint Backlog:**

| ID | User Story | Status |
|----|------------|--------|
| US1020 | Admin hapus kelas | ✅ Done |
| US1021 | Admin toggle status user | ✅ Done |
| US1022 | Admin lihat history siswa | ✅ Done |
| US1023 | Export absensi Excel | ✅ Done |
| US1024 | Export learning log | ✅ Done |
| US2005 | Guru edit materi | ✅ Done |
| US2006 | Guru hapus materi | ✅ Done |
| US2007 | Guru laporan kehadiran | ✅ Done |
| US3004 | Auto-save PDF progress | ✅ Done |
| US3005 | Status pembayaran | ✅ Done |

**Hasil:** 10/10 User Stories selesai (100%)

**Sprint Retrospective:**
- **Berjalan Baik:** Bug fixing efektif, Sprint Review sukses
- **Perlu Perbaikan:** Performance untuk data besar
- **Action Items:** Loading indicators, queue system, filters

---

### B.4 Sprint 4: Reports, Backup & Polish

**Periode:** 4 Desember - 24 Desember 2025 (3 minggu)

**Sprint Goal:** Reports, backup, dan polishing

**Sprint Backlog:**

| ID | User Story | Status |
|----|------------|--------|
| US1025 | Notifikasi reminder | ✅ Done |
| US1026 | Laporan presensi | ✅ Done |
| US1027 | Backup database | ✅ Done |
| US1028 | Export activity log | ✅ Done |
| US1029 | Download ZIP materi | ✅ Done |
| US3006 | Notifikasi kelas berakhir | ✅ Done |

**Hasil:** 6/6 User Stories selesai (100%)

**Sprint Retrospective:**
- **Berjalan Baik:** Dokumentasi lengkap, final review sukses
- **Perlu Perbaikan:** Background jobs, automated backup
- **Action Items:** Scheduled tasks, performance optimization

---

## C. Rangkuman Release

### C.1 Release 1 (MVP)

**Tanggal:** 21 November 2025

**Sprint Pembentuk:** Sprint 1, 2, 3

**Tujuan Release:** MVP sistem e-learning dengan fitur inti lengkap

**Fitur yang Dirilis:**
- Autentikasi (Login/Logout)
- Manajemen Pengguna (CRUD Guru/Siswa)
- Manajemen Kelas (CRUD + Enroll/Unenroll)
- Manajemen Materi (Upload, Verifikasi, Akses)
- Progress Tracking
- Export Reports (Absensi, Learning Log)

**Hasil Pengujian:**
- ✅ 43 User Stories tested (100% pass)
- ✅ Functional testing passed
- ✅ Integration testing passed

**Status:** ✅ Ready untuk production deployment

---

### C.2 Release 2 (Final Release)

**Tanggal:** 20 Desember 2025

**Sprint Pembentuk:** Sprint 4

**Tujuan Release:** Sistem final dengan fitur lengkap dan polish

**Fitur Tambahan:**
- Backup database
- Download ZIP materi
- Laporan presensi keseluruhan
- Notifikasi reminder
- Export log aktivitas

**Hasil Pengujian:**
- ✅ 49 User Stories tested (100% pass)
- ✅ Full regression testing passed
- ✅ Performance testing passed

**Umpan Balik:** Sistem lengkap, dokumentasi baik, siap digunakan

**Status:** ✅ Final Release - Production Ready

---

## D. Ringkasan Statistik Proyek

| Metrik | Nilai |
|--------|-------|
| Total Sprint | 4 |
| Total User Stories | 49 |
| User Stories Selesai | 49 (100%) |
| Total Release | 2 |
| Daily Scrum Records | 317 |
| Tim Development | 4 orang |
| Durasi Proyek | 14 minggu |
| Acceptance Rate | 100% |
