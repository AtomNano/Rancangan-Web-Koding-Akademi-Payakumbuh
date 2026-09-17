# DETAIL LENGKAP ISI FORM - MANUAL PENGGUNAAN SISTEM

## BAGIAN ADMIN

### 1. FORM TAMBAH GURU

**Langkah-langkah:**
1. Klik tombol **"+ Tambah Guru"**
2. Isi form dengan detail berikut:

**Field yang harus diisi:**

| No | Nama Field | Keterangan | Contoh | Wajib |
|----|-----------|------------|---------|-------|
| 1 | **Nama Lengkap** | Nama lengkap guru sesuai identitas | Budi Santoso, S.Pd | ✅ Ya |
| 2 | **Email** | Email aktif untuk login ke sistem | budi.santoso@email.com | ✅ Ya |
| 3 | **Kode Guru** | Akan di-generate otomatis oleh sistem | GURU-0001 | ❌ Otomatis |
| 4 | **No. Telepon / WhatsApp** | Nomor telepon dengan format +62 | +62 81234567890 | ⚠️ Opsional |
| 5 | **Kelas yang Diajar** | Pilih satu atau lebih kelas (checkbox) | Web Development, Python, UI/UX | ✅ Ya (min. 1) |
| 6 | **Kata Sandi** | Password untuk login (minimal 8 karakter) | ********** | ✅ Ya |
| 7 | **Konfirmasi Kata Sandi** | Ulangi password yang sama | ********** | ✅ Ya |

**Catatan Penting:**
- Kode Guru akan otomatis dibuat dengan format: **GURU-NNNN** (contoh: GURU-0001, GURU-0002)
- Nomor telepon harus diisi tanpa angka 0 di depan (contoh: 81234567890, bukan 081234567890)
- Password minimal 8 karakter dan harus sama dengan konfirmasi password
- Guru dapat mengajar lebih dari satu kelas

3. Klik tombol **"Simpan"**
4. Sistem akan menampilkan notifikasi sukses dan kembali ke halaman daftar guru

---

### 2. FORM TAMBAH SISWA

**Langkah-langkah:**
1. Klik tombol **"+ Tambah Siswa"**
2. Isi form dengan detail berikut:

#### **A. INFORMASI DASAR**

| No | Nama Field | Keterangan | Contoh | Wajib |
|----|-----------|------------|---------|-------|
| 1 | **Nama Lengkap** | Nama lengkap siswa sesuai identitas | Ahmad Rizki Pratama | ✅ Ya |
| 2 | **Email** | Email aktif untuk login | ahmad.rizki@email.com | ✅ Ya |
| 3 | **ID Siswa** | Akan di-generate otomatis | 001-01-122025 | ❌ Otomatis |
| 4 | **No. Telepon / WhatsApp** | Format: +62 tanpa 0 di depan | +62 81234567890 | ⚠️ Opsional |
| 5 | **Tanggal Lahir** | Pilih dari kalender (minimal 5 tahun yang lalu) | 15 Januari 2010 | ⚠️ Opsional |
| 6 | **Jenis Kelamin** | Pilih: Laki-laki atau Perempuan | Laki-laki | ⚠️ Opsional |

#### **B. ALAMAT LENGKAP**

| No | Nama Field | Keterangan | Contoh | Wajib |
|----|-----------|------------|---------|-------|
| 7 | **Jalan / Nama Jalan** | Nama jalan dan nomor rumah | Jl. Sudirman No. 123 | ⚠️ Opsional |
| 8 | **Provinsi** | Pilih dari dropdown | Sumatera Barat | ⚠️ Opsional |
| 9 | **Kota / Kabupaten** | Akan muncul setelah pilih provinsi | Kota Payakumbuh | ⚠️ Opsional |
| 10 | **Kecamatan** | Akan muncul setelah pilih kota | Payakumbuh Barat | ⚠️ Opsional |
| 11 | **Kelurahan / Desa** | Akan muncul setelah pilih kecamatan | Balai Nan Duo | ⚠️ Opsional |

**Catatan:** Alamat lengkap akan otomatis terbentuk dari kombinasi semua field di atas.

#### **C. INFORMASI AKADEMIK**

| No | Nama Field | Keterangan | Contoh | Wajib |
|----|-----------|------------|---------|-------|
| 12 | **Tanggal Pendaftaran** | Tanggal siswa mendaftar | 28 Desember 2025 | ✅ Ya |
| 13 | **Nama Sekolah** | Sekolah formal siswa saat ini | SD Negeri 01 Payakumbuh | ✅ Ya |
| 14 | **Kelas** | Pilih dari dropdown (SD/SMP/SMA/Umum/Mahasiswa) | Kelas 5 SD | ✅ Ya |
| 15 | **Bidang Ajar (Kelas)** | Pilih kelas yang diikuti (checkbox, bisa lebih dari 1) | Web Development, Python | ✅ Ya (min. 1) |
| 16 | **Durasi Program** | Pilih: 1 Bulan, 3 Bulan, 6 Bulan, atau 12 Bulan | 3 Bulan | ✅ Ya |
| 17 | **Tanggal Mulai Paket Sesi** | Tanggal sesi pertama dimulai | 1 Januari 2026 | ✅ Ya |
| 18 | **Kuota Sesi per Bulan** | Pilih: 4x atau 8x per bulan | 8x per bulan | ✅ Ya |
| 19 | **Target Total Sesi** | Otomatis dihitung (Durasi × Kuota) | 24 sesi (3 bulan × 8x) | ❌ Otomatis |
| 20 | **Hari Belajar** | Pilih hari (checkbox, bisa lebih dari 1) | Senin, Rabu, Jumat | ⚠️ Opsional |
| 21 | **Status Pendaftaran** | Pilih: Aktif atau Tidak Aktif | Aktif | ✅ Ya |

**Catatan:**
- Target total sesi akan otomatis dihitung: **Durasi (bulan) × Kuota per bulan**
- Contoh: 3 Bulan × 8x = 24 sesi total
- Akun akan otomatis nonaktif setelah target sesi tercapai

#### **D. INFORMASI PEMBAYARAN**

| No | Nama Field | Keterangan | Contoh | Wajib |
|----|-----------|------------|---------|-------|
| 22 | **Metode Pembayaran** | Pilih: Transfer Bank atau Tunai (Cash) | Transfer Bank | ⚠️ Opsional |
| 23 | **Status Promo / Diskon** | Pilih jika ada promo | Promo Early Bird | ⚠️ Opsional |
| 24 | **Biaya Pendaftaran** | Biaya sekali bayar di awal | Rp. 150.000 | ⚠️ Opsional |
| 25 | **Biaya Angsuran** | Biaya per periode | Rp. 1.250.000 | ⚠️ Opsional |
| 26 | **Total Biaya** | Otomatis: Pendaftaran + Angsuran | Rp. 1.400.000 | ❌ Otomatis |
| 27 | **Tipe Diskon** | Pilih: Persentase (%) atau Potongan Tetap (Rp) | Persentase (%) | ⚠️ Opsional |
| 28 | **Nilai Diskon** | Masukkan nilai diskon | 10 (untuk 10%) | ⚠️ Opsional |
| 29 | **Total Setelah Diskon** | Otomatis dihitung setelah diskon | Rp. 1.260.000 | ❌ Otomatis |

**Contoh Perhitungan Diskon:**
- **Tipe: Persentase (%)**, Nilai: 10
  - Total: Rp. 1.400.000
  - Diskon: Rp. 1.400.000 × 10% = Rp. 140.000
  - **Total Setelah Diskon: Rp. 1.260.000**

- **Tipe: Potongan Tetap (Rp)**, Nilai: 200000
  - Total: Rp. 1.400.000
  - Diskon: Rp. 200.000
  - **Total Setelah Diskon: Rp. 1.200.000**

#### **E. INFORMASI MASUK (LOGIN)**

| No | Nama Field | Keterangan | Contoh | Wajib |
|----|-----------|------------|---------|-------|
| 30 | **Kata Sandi** | Password untuk login (minimal 8 karakter) | ********** | ✅ Ya |
| 31 | **Konfirmasi Kata Sandi** | Ulangi password yang sama | ********** | ✅ Ya |

3. Klik tombol **"Simpan"**
4. Sistem akan menampilkan notifikasi sukses dan kembali ke halaman daftar siswa

---

### 3. FORM TAMBAH KELAS

**Langkah-langkah:**
1. Klik tombol **"+ Buat Kelas Baru"**
2. Isi form dengan detail berikut:

| No | Nama Field | Keterangan | Contoh | Wajib |
|----|-----------|------------|---------|-------|
| 1 | **Nama Kelas** | Nama kelas yang deskriptif | Web Development Dasar | ✅ Ya |
| 2 | **Guru Pengajar** | Pilih guru dari dropdown | Budi Santoso, S.Pd | ✅ Ya |
| 3 | **Bidang** | Pilih: Coding, Desain, Robotik, Umum, atau Mahasiswa | Coding | ✅ Ya |
| 4 | **Deskripsi** | Penjelasan singkat tentang kelas | Belajar HTML, CSS, JavaScript untuk pemula | ✅ Ya |

3. Klik tombol **"Simpan Kelas"**
4. Sistem akan membuat kelas baru dan kembali ke halaman daftar kelas

---

### 4. FORM TAMBAH PERTEMUAN

**Langkah-langkah:**
1. Buka detail kelas
2. Klik tab **"Pertemuan"**
3. Klik tombol **"+ Tambah Pertemuan"**
4. Isi form dengan detail berikut:

| No | Nama Field | Keterangan | Contoh | Wajib |
|----|-----------|------------|---------|-------|
| 1 | **Tanggal** | Tanggal pertemuan dilaksanakan | 5 Januari 2026 | ✅ Ya |
| 2 | **Pertemuan Ke-** | Nomor urut pertemuan | 1, 2, 3, dst. | ✅ Ya |
| 3 | **Topik** | Topik yang akan dibahas | Pengenalan HTML | ✅ Ya |
| 4 | **Deskripsi** | Detail materi yang akan dipelajari | Mempelajari tag dasar HTML, struktur dokumen, dan elemen-elemen penting | ✅ Ya |

5. Klik tombol **"Simpan"**
6. Pertemuan baru akan muncul di daftar pertemuan kelas

---

### 5. FORM INPUT ABSENSI

**Langkah-langkah:**
1. Buka pertemuan yang ingin diinput absensinya
2. Akan tampil daftar semua siswa yang terdaftar di kelas
3. Untuk setiap siswa, pilih status kehadiran:

| Status | Kode | Keterangan |
|--------|------|------------|
| **Hadir** | H | Siswa hadir mengikuti pertemuan |
| **Izin** | I | Siswa tidak hadir dengan izin |
| **Sakit** | S | Siswa tidak hadir karena sakit |
| **Alpha** | A | Siswa tidak hadir tanpa keterangan |

4. Klik tombol **"Simpan Presensi"**
5. Data absensi akan tersimpan dan dapat dilihat di laporan

---

### 6. FORM MENDAFTARKAN SISWA KE KELAS (ENROLL)

**Langkah-langkah:**
1. Buka detail kelas dengan klik nama kelas
2. Klik tab **"Daftar Siswa"** atau tombol **"Daftarkan Siswa"**
3. Pilih satu atau lebih siswa dari daftar (checkbox)
4. Klik tombol **"Enroll"**
5. Siswa yang dipilih akan terdaftar di kelas tersebut

**Catatan:**
- Siswa yang sudah terdaftar tidak akan muncul di daftar
- Anda bisa mendaftarkan beberapa siswa sekaligus

---

## RINGKASAN FIELD WAJIB vs OPSIONAL

### Form Tambah Guru
- **Wajib (5):** Nama, Email, Kelas yang Diajar, Password, Konfirmasi Password
- **Opsional (1):** No. Telepon
- **Otomatis (1):** Kode Guru

### Form Tambah Siswa
- **Wajib (13):** Nama, Email, Nama Sekolah, Kelas Sekolah, Bidang Ajar, Durasi Program, Tanggal Mulai, Kuota Sesi, Status Pendaftaran, Tanggal Pendaftaran, Password, Konfirmasi Password
- **Opsional (17):** No. Telepon, Tanggal Lahir, Jenis Kelamin, Alamat (5 field), Hari Belajar, Metode Pembayaran, Status Promo, Biaya Pendaftaran, Biaya Angsuran, Tipe Diskon, Nilai Diskon
- **Otomatis (4):** ID Siswa, Target Total Sesi, Total Biaya, Total Setelah Diskon

### Form Tambah Kelas
- **Wajib (4):** Nama Kelas, Guru Pengajar, Bidang, Deskripsi

### Form Tambah Pertemuan
- **Wajib (4):** Tanggal, Pertemuan Ke-, Topik, Deskripsi
