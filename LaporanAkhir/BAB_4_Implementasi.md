    # BAB 4 - IMPLEMENTASI

## 4.1 Lingkungan Implementasi

### 4.1.1 Lingkungan Pengembangan (Development)

Pengembangan sistem dilakukan menggunakan perangkat dan teknologi sebagai berikut:

**Perangkat Keras (Hardware):**
- Komputer/Laptop dengan spesifikasi minimal:
  - Processor: Intel Core i5 atau setara
  - RAM: 8 GB
  - Storage: SSD 256 GB
  - Display: 14" atau lebih

**Perangkat Lunak (Software):**

| Komponen | Teknologi |
|----------|-----------|
| Sistem Operasi | Windows 10/11 |
| Bahasa Pemrograman | PHP dan JavaScript |
| Framework Backend | Laravel 10.x |
| Framework Frontend | Bootstrap 5.x |
| Database Management System | MySQL 8.0 |
| Web Server | Apache (melalui XAMPP/Laragon) |
| Web Browser | Google Chrome |
| Text Editor / IDE | Visual Studio Code |
| Version Control | Git (GitHub) |
| Package Manager | Composer, NPM |

### 4.1.2 Lingkungan Produksi (Production)

**Hosting & Domain:**

| Komponen | Spesifikasi | Biaya (per tahun) |
|----------|-------------|-------------------|
| Hosting | Niagahoster - Unlimited Web Hosting | Rp 250.000 |
| Domain | codingakademi-payakumbuh.com | Rp 150.000 |
| SSL | Let's Encrypt (Free) | Gratis |

**Spesifikasi Server:**
- OS: Ubuntu 22.04 LTS
- Web Server: Apache 2.4 / Nginx
- PHP: 8.2 (FPM)
- MySQL: 8.0
- RAM: 1 GB (shared hosting)
- Storage: Unlimited (shared)

### 4.1.3 Arsitektur Deployment

Sistem menggunakan arsitektur **Client-Server** dengan deployment pada web hosting Niagahoster. Arsitektur deployment terdiri dari beberapa komponen utama:

1. **Client Layer**: Pengguna mengakses sistem melalui web browser (Chrome, Firefox, Safari) dari perangkat desktop, laptop, atau tablet. Komunikasi menggunakan protokol HTTPS untuk keamanan data.

2. **Web Server Layer**: Apache web server menerima request dari client dan meneruskan ke PHP-FPM untuk diproses. File statis (CSS, JavaScript, gambar) dilayani langsung oleh Apache.

3. **Application Layer**: Aplikasi Laravel memproses business logic, termasuk Controllers untuk menangani request, Models untuk interaksi database, dan Views untuk rendering halaman.

4. **Database Layer**: MySQL database menyimpan semua data sistem termasuk data pengguna, kelas, materi, pertemuan, dan presensi.

5. **Storage Layer**: File materi (PDF, video) disimpan di penyimpanan server dengan path yang tercatat di database.

---

## 4.2 Implementasi Modul

Berikut adalah implementasi sistem berdasarkan modul-modul utama yang telah dirancang.

### 4.2.1 Implementasi Modul Autentikasi

**1. Nama Modul**
Modul Autentikasi

**2. Fungsi Utama Modul**
Modul ini digunakan untuk mengelola proses autentikasi pengguna sistem. Fungsi utamanya meliputi:
- Pengguna dapat login ke sistem menggunakan email dan kata sandi (US0001)
- Pengguna dapat logout dari sistem dengan aman (US0002)
- Pengguna dapat melihat dashboard utama setelah login (US0003)

**3. Cara Kerja Modul**

a. **Proses Login:**
- Pengguna mengakses halaman login sistem
- Pengguna memasukkan email dan password pada form yang tersedia
- Sistem memvalidasi kredensial dengan database
- Jika valid, sistem membuat session dan mengarahkan ke dashboard sesuai role:
  - Admin → `/admin/dashboard`
  - Guru → `/guru/dashboard`
  - Siswa → `/siswa/dashboard`
- Jika tidak valid, sistem menampilkan pesan error

b. **Proses Logout:**
- Pengguna mengklik tombol Logout di navbar
- Sistem menghapus session pengguna
- Sistem mengarahkan pengguna ke halaman login

c. **Validasi & Integrasi:**
- Sistem memvalidasi format email yang dimasukkan
- Password dienkripsi menggunakan bcrypt
- Modul ini terintegrasi dengan middleware untuk proteksi route berdasarkan role

**Potongan Kode Penting:**
```php
// AuthenticatedSessionController.php
public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();
    $request->session()->regenerate();
    
    return redirect()->intended(route('dashboard'));
}

public function destroy(Request $request): RedirectResponse
{
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    return redirect('/');
}
```

**4. Keterkaitan Modul dengan Kebutuhan Fungsional**
Mendukung US0001 untuk login sistem, US0002 untuk logout aman, dan US0003 untuk menampilkan dashboard sesuai role. Memastikan keamanan akses sistem dan pembatasan fitur berdasarkan peran pengguna.

---

### 4.2.2 Implementasi Modul Manajemen Pengguna

**1. Nama Modul**
Modul Manajemen Pengguna

**2. Fungsi Utama Modul**
Modul ini digunakan oleh Admin untuk mengelola data Guru dan Siswa. Fungsi utamanya meliputi:
- Admin dapat melihat daftar Guru (US1001)
- Admin dapat menambah data Guru baru (US1002)
- Admin dapat melihat daftar Siswa (US1003)
- Admin dapat menambah data Siswa baru (US1004)
- Admin dapat mengedit data Guru/Siswa (US1014, US1016)
- Admin dapat menghapus data Guru/Siswa (US1015, US1017)
- Admin dapat mengubah status aktif/nonaktif pengguna (US1021)
- Admin dapat melihat history siswa (US1022)

**3. Cara Kerja Modul**

a. **Admin – Melihat Daftar Pengguna:**
- Admin login ke dashboard dan memilih menu Guru atau Siswa
- Sistem menampilkan daftar pengguna dalam bentuk tabel dengan pagination
- Admin dapat melakukan filter berdasarkan status atau pencarian nama

b. **Admin – Menambah Pengguna Baru:**
- Admin mengklik tombol "Tambah Guru/Siswa"
- Sistem menampilkan form input data pengguna
- Untuk Siswa, admin mengisi data lengkap termasuk kelas, durasi, dan pembayaran
- Sistem menggenerate ID unik otomatis:
  - Siswa: `NNN-KK-MMYYYY` (contoh: 001-01-122025)
  - Guru: `GURU-NNNN` (contoh: GURU-0001)
- Data tersimpan ke database

c. **Admin – Edit dan Hapus Pengguna:**
- Admin mengklik ikon Edit pada baris pengguna
- Sistem menampilkan form dengan data yang sudah terisi
- Admin mengubah data dan menyimpan perubahan
- Untuk hapus, sistem menggunakan soft delete agar data tidak hilang permanen

d. **Validasi & Integrasi:**
- Sistem memvalidasi email harus unik
- Password minimal 8 karakter
- Modul ini terintegrasi dengan modul Kelas untuk enrollment siswa

**Potongan Kode Penting:**
```php
// User.php - Generate ID Siswa
public static function generateIdSiswa($kelasId = null)
{
    $now = \Carbon\Carbon::now();
    $monthYear = $now->format('mY');
    
    $kelasCode = '00';
    if ($kelasId) {
        $kelas = Kelas::find($kelasId);
        if ($kelas) {
            $kelasCode = str_pad((string) $kelas->id, 2, '0', STR_PAD_LEFT);
        }
    }
    
    $count = User::where('role', 'siswa')
        ->where('id_siswa', 'like', "%-{$kelasCode}-{$monthYear}")
        ->count();
    
    $nextNumber = str_pad($count + 1, 3, '0', STR_PAD_LEFT);
    
    return "{$nextNumber}-{$kelasCode}-{$monthYear}";
}
```

**4. Keterkaitan Modul dengan Kebutuhan Fungsional**
Mendukung US1001-US1004, US1014-US1017, US1021, dan US1022. Memungkinkan admin mengelola seluruh pengguna sistem dengan CRUD lengkap serta tracking aktivitas siswa.

---

### 4.2.3 Implementasi Modul Manajemen Kelas

**1. Nama Modul**
Modul Manajemen Kelas

**2. Fungsi Utama Modul**
Modul ini digunakan oleh Admin untuk mengelola kelas dan pendaftaran siswa. Fungsi utamanya meliputi:
- Admin dapat membuat kelas baru (US1005)
- Admin dapat mendaftarkan siswa ke kelas (US1006)
- Admin dapat mengeluarkan siswa dari kelas (US1007)
- Admin dapat mengubah detail kelas (US1018)
- Admin dapat menghapus kelas (US1020)

**3. Cara Kerja Modul**

a. **Admin – Membuat Kelas Baru:**
- Admin memilih menu Kelas dan klik "Tambah Kelas"
- Admin mengisi nama kelas, deskripsi, dan menentukan Guru pengampu
- Sistem menyimpan kelas dengan status "active"
- Kelas muncul di daftar dan siap untuk enrollmentAndt siswa

b. **Admin – Enroll Siswa ke Kelas:**
- Admin membuka detail kelas dan klik "Daftarkan Siswa"
- Sistem menampilkan daftar siswa yang belum terdaftar di kelas tersebut
- Admin memilih siswa dan mengisi:
  - Tanggal mulai program
  - Durasi program (1/3/6/12 bulan)
  - Quota pertemuan per bulan (4/8 kali)
- Sistem menghitung target sesi: durasi × quota
- Data enrollment tersimpan di tabel `enrollments`

c. **Admin – Unenroll Siswa:**
- Admin membuka detail kelas dan melihat daftar siswa terdaftar
- Admin mengklik tombol "Keluarkan" pada siswa tertentu
- Sistem menampilkan konfirmasi
- Jika dikonfirmasi, enrollment dihapus

d. **Validasi & Integrasi:**
- Satu siswa hanya bisa enroll sekali per kelas
- Modul terintegrasi dengan modul Absensi untuk tracking quota sesi

**Potongan Kode Penting:**
```php
// Enrollment.php - Menghitung Target Sesi
public function calculateTargetSessions(): ?int
{
    if (!empty($this->target_sessions)) {
        return (int) $this->target_sessions;
    }

    $months = $this->duration_months ?: 0;
    $quota = $this->monthly_quota ?: 0;

    if ($months <= 0 || $quota <= 0) {
        return null;
    }

    return (int) ($months * $quota);
}
```

**4. Keterkaitan Modul dengan Kebutuhan Fungsional**
Mendukung US1005-US1007, US1018, dan US1020. Memungkinkan admin mengorganisir struktur kelas dan mengelola pendaftaran siswa dengan quota sesi yang terukur.

---

### 4.2.4 Implementasi Modul Manajemen Materi

**1. Nama Modul**
Modul Manajemen Materi

**2. Fungsi Utama Modul**
Modul ini digunakan untuk mengelola materi pembelajaran dengan workflow verifikasi. Fungsi utamanya meliputi:
- Admin dapat melihat daftar materi pending (US1008)
- Admin dapat menyetujui materi (US1009)
- Admin dapat menolak materi (US1019)
- Guru dapat menambahkan materi (US2001)
- Guru dapat melihat status materi (US2002)
- Guru dapat mengedit materi (US2005)
- Guru dapat menghapus materi (US2006)
- Siswa dapat mengakses materi approved (US3002)

**3. Cara Kerja Modul**

a. **Guru – Upload Materi:**
- Guru login dan memilih menu "Tambah Materi"
- Guru memilih kelas tujuan materi
- Guru mengisi judul dan deskripsi materi
- Guru upload file PDF atau input link YouTube
- Sistem menyimpan materi dengan status "pending"
- Notifikasi otomatis dikirim ke semua Admin

b. **Admin – Verifikasi Materi:**
- Admin login dan melihat badge notifikasi materi pending
- Admin mengakses menu "Verifikasi Materi"
- Admin melihat daftar materi berstatus pending
- Admin dapat preview konten materi sebelum verifikasi
- Admin klik "Approve" untuk menyetujui atau "Reject" dengan alasan
- Status materi berubah menjadi "approved" atau "rejected"

c. **Siswa – Mengakses Materi:**
- Siswa login dan membuka kelas yang diikuti
- Sistem menampilkan daftar materi yang sudah approved
- Siswa mengklik materi untuk membuka PDF viewer atau video player
- Progress membaca PDF tercatat otomatis

d. **Validasi & Integrasi:**
- Siswa hanya bisa mengakses materi dari kelas yang diikuti
- Materi rejected bisa diedit dan disubmit ulang oleh Guru
- Terintegrasi dengan modul Progress Tracking

**Potongan Kode Penting:**
```php
// MateriController.php - Upload Materi
$materi = Materi::create([
    'judul' => $validated['judul'],
    'deskripsi' => $validated['deskripsi'],
    'file_path' => $filePath,
    'file_type' => $validated['file_type'],
    'kelas_id' => $validated['kelas_id'],
    'uploaded_by' => auth()->id(),
    'status' => 'pending',
]);

// Notify all admins
$admins = User::where('role', 'admin')->get();
Notification::send($admins, new NewMaterialForVerification($materi));

// Approve Materi
public function approve(Materi $materi)
{
    $materi->update(['status' => 'approved']);
    ActivityLogger::logMaterialApproved($materi);
    
    return redirect()->back()->with('success', 'Materi berhasil disetujui.');
}
```

**4. Keterkaitan Modul dengan Kebutuhan Fungsional**
Mendukung US1008, US1009, US1019 untuk Admin, US2001-US2002, US2005-US2006 untuk Guru, dan US3002 untuk Siswa. Menjamin kualitas materi melalui proses verifikasi sebelum dapat diakses siswa.

---

### 4.2.5 Implementasi Modul Progress Tracking

**1. Nama Modul**
Modul Progress Tracking

**2. Fungsi Utama Modul**
Modul ini digunakan untuk melacak kemajuan belajar siswa secara otomatis. Fungsi utamanya meliputi:
- Siswa dapat melihat progress bar kemajuan belajar (US3003)
- Progress membaca PDF tersimpan otomatis (US3004)
- Guru dapat memantau progress siswa (US2004)

**3. Cara Kerja Modul**

a. **Siswa – Membaca Materi PDF:**
- Siswa membuka materi PDF di dalam sistem
- PDF viewer terintegrasi menampilkan dokumen
- Saat siswa berpindah halaman, sistem mencatat halaman terakhir
- Progress disimpan otomatis ke database (auto-save)
- Persentase dihitung: (halaman_terakhir / total_halaman) × 100%

b. **Siswa – Melihat Progress Bar:**
- Siswa melihat dashboard atau halaman kelas
- Sistem menampilkan progress bar visual untuk setiap kelas
- Warna progress bar berubah sesuai persentase (merah → kuning → hijau)
- Siswa dapat klik "Tandai Selesai" jika sudah menyelesaikan materi

c. **Guru – Monitoring Progress:**
- Guru login dan memilih menu "Progress Siswa"
- Sistem menampilkan tabel progress per siswa per materi
- Guru dapat melihat halaman terakhir yang dibaca siswa
- Guru dapat mengidentifikasi siswa yang perlu perhatian khusus

d. **Validasi & Integrasi:**
- Progress hanya tercatat untuk materi yang approved
- Siswa harus enrolled di kelas untuk akses materi
- Terintegrasi dengan modul Materi dan modul Kelas

**Potongan Kode Penting:**
```php
// MateriProgressController.php - Update Progress
public function updateProgress(Request $request, Materi $materi): JsonResponse
{
    $progress = MateriProgress::firstOrCreate(
        [
            'user_id' => Auth::id(),
            'materi_id' => $materi->id,
        ],
        [
            'current_page' => 1,
            'total_pages' => $request->total_pages,
            'progress_percentage' => 0.00,
            'is_completed' => false,
        ]
    );

    $progress->updateProgress(
        $request->current_page,
        $request->total_pages ?? $progress->total_pages
    );

    return response()->json([
        'success' => true,
        'progress' => [
            'current_page' => $progress->current_page,
            'progress_percentage' => $progress->progress_percentage,
            'is_completed' => $progress->is_completed,
        ]
    ]);
}
```

**4. Keterkaitan Modul dengan Kebutuhan Fungsional**
Mendukung US3003 dan US3004 untuk siswa, serta US2004 untuk guru. Memberikan visibilitas kemajuan belajar secara real-time dan membantu guru mengidentifikasi siswa yang membutuhkan perhatian.

---

### 4.2.6 Implementasi Modul Pertemuan

**1. Nama Modul**
Modul Pertemuan

**2. Fungsi Utama Modul**
Modul ini digunakan untuk mengelola jadwal pertemuan kelas. Fungsi utamanya meliputi:
- Admin dapat membuat pertemuan baru (US1010)
- Admin dapat mengedit pertemuan (US1011)
- Admin dapat menghapus pertemuan (US1012)

**3. Cara Kerja Modul**

a. **Admin – Membuat Pertemuan:**
- Admin memilih kelas dari daftar kelas
- Admin klik "Tambah Pertemuan"
- Admin mengisi form:
  - Tanggal pertemuan
  - Judul/Topik pertemuan
  - Waktu mulai dan selesai
  - Guru yang mengajar
  - Deskripsi (opsional)
- Pertemuan tersimpan dan muncul di daftar

b. **Admin – Edit dan Hapus Pertemuan:**
- Admin melihat daftar pertemuan per kelas
- Admin mengklik ikon Edit untuk mengubah data
- Admin mengklik ikon Hapus dengan konfirmasi untuk menghapus
- Perubahan tersimpan ke database

c. **Validasi & Integrasi:**
- Waktu selesai harus setelah waktu mulai
- Pertemuan terintegrasi dengan modul Absensi untuk input kehadiran

**Potongan Kode Penting:**
```php
// PertemuanController.php - Create Pertemuan
$pertemuan = Pertemuan::create([
    'kelas_id' => $kelas->id,
    'guru_id' => $validated['guru_id'],
    'judul_pertemuan' => $validated['judul_pertemuan'],
    'deskripsi' => $validated['deskripsi'] ?? null,
    'tanggal_pertemuan' => $validated['tanggal_pertemuan'],
    'waktu_mulai' => $validated['waktu_mulai'] ?? null,
    'waktu_selesai' => $validated['waktu_selesai'] ?? null,
]);
```

**4. Keterkaitan Modul dengan Kebutuhan Fungsional**
Mendukung US1010, US1011, dan US1012. Memungkinkan admin mengorganisir jadwal pembelajaran dan menyediakan data pertemuan untuk input absensi.

---

### 4.2.7 Implementasi Modul Absensi

**1. Nama Modul**
Modul Absensi

**2. Fungsi Utama Modul**
Modul ini digunakan untuk mencatat kehadiran siswa per pertemuan. Fungsi utamanya meliputi:
- Admin dapat menginput absensi siswa (US1013)
- Guru dapat melihat daftar hadir siswa (US2003)
- Guru dapat mendapatkan laporan kehadiran (US2007)

**3. Cara Kerja Modul**

a. **Admin – Input Absensi:**
- Admin memilih pertemuan dari daftar
- Sistem menampilkan semua siswa yang enrolled di kelas tersebut
- Admin memilih status kehadiran untuk setiap siswa:
  - **H** (Hadir) - menambah sessions_attended
  - **I** (Izin)
  - **S** (Sakit)
  - **A** (Alpha/Tanpa Keterangan)
- Admin klik "Simpan Absensi"
- Sistem menyimpan data dan update quota sesi siswa

b. **Guru – Melihat Daftar Hadir:**
- Guru login dan memilih kelas yang diajar
- Guru melihat daftar pertemuan dan klik untuk melihat detail
- Sistem menampilkan daftar siswa dengan status kehadiran
- Guru dapat melihat statistik kehadiran per siswa

c. **Notifikasi Quota:**
- Saat siswa hanya tersisa 1 sesi, sistem mengirim notifikasi
- Notifikasi dikirim ke siswa dan guru pengampu
- Admin dapat melihat siswa yang mendekati habis quota

d. **Validasi & Integrasi:**
- Satu siswa hanya bisa diabsen sekali per pertemuan
- Hanya status "Hadir" yang menambah counter sessions_attended
- Terintegrasi dengan modul Kelas untuk tracking quota

**Potongan Kode Penting:**
```php
// PertemuanController.php - Store Absen
foreach ($validated['absen'] as $absenData) {
    Presensi::updateOrCreate(
        [
            'pertemuan_id' => $pertemuan->id,
            'user_id' => $absenData['user_id'],
        ],
        [
            'status_kehadiran' => $absenData['status_kehadiran'],
            'tanggal_akses' => now(),
        ]
    );
}

// Sync session progress untuk update quota
$enrollment->syncSessionProgress(1);
```

**4. Keterkaitan Modul dengan Kebutuhan Fungsional**
Mendukung US1013 untuk admin, serta US2003 dan US2007 untuk guru. Mencatat kehadiran siswa secara akurat dan memberikan laporan untuk evaluasi pembelajaran.

---

### 4.2.8 Implementasi Modul Notifikasi

**1. Nama Modul**
Modul Notifikasi

**2. Fungsi Utama Modul**
Modul ini digunakan untuk mengirimkan notifikasi kepada pengguna. Fungsi utamanya meliputi:
- Pengguna dapat menerima notifikasi aktivitas (US0007)
- Admin dapat mengirim reminder ke guru (US1025)
- Siswa dapat melihat notifikasi kelas berakhir (US3006)

**3. Cara Kerja Modul**

a. **Notifikasi Otomatis:**
- Sistem mendeteksi event yang memerlukan notifikasi:
  - Materi baru menunggu verifikasi → notifikasi ke Admin
  - Materi disetujui/ditolak → notifikasi ke Guru
  - Quota sesi hampir habis → notifikasi ke Siswa dan Guru
  - Kelas akan berakhir (H-7) → notifikasi ke Siswa
- Notifikasi tersimpan di database
- Badge counter muncul di navbar

b. **Admin – Kirim Reminder:**
- Admin membuka halaman Verifikasi Materi
- Pada materi pending, admin klik "Kirim Pengingat"
- Sistem mengirim notifikasi ke Guru pengunggah materi
- Log aktivitas tercatat

c. **Pengguna – Membaca Notifikasi:**
- Pengguna mengklik ikon notifikasi di navbar
- Dropdown menampilkan notifikasi terbaru
- Pengguna klik notifikasi untuk melihat detail
- Notifikasi ditandai sebagai sudah dibaca

d. **Validasi & Integrasi:**
- Notifikasi duplikat dicegah dengan pengecekan waktu
- Terintegrasi dengan semua modul utama sistem

**Potongan Kode Penting:**
```php
// NewMaterialForVerification.php - Notification Class
public function toDatabase($notifiable)
{
    return [
        'materi_id' => $this->materi->id,
        'judul' => $this->materi->judul,
        'message' => "Materi baru '{$this->materi->judul}' menunggu verifikasi.",
        'uploaded_by' => $this->materi->uploadedBy->name,
        'kelas' => $this->materi->kelas->nama_kelas,
    ];
}
```

**4. Keterkaitan Modul dengan Kebutuhan Fungsional**
Mendukung US0007 untuk notifikasi aktivitas, US1025 untuk admin mengirim reminder, dan US3006 untuk notifikasi kelas berakhir. Memastikan komunikasi yang efektif antar pengguna sistem.

---

### 4.2.9 Implementasi Modul Backup & Export

**1. Nama Modul**
Modul Backup & Export

**2. Fungsi Utama Modul**
Modul ini digunakan oleh Admin untuk backup data dan export laporan. Fungsi utamanya meliputi:
- Admin dapat export absensi ke Excel (US1023)
- Admin dapat export learning log siswa (US1024)
- Admin dapat melihat laporan presensi (US1026)
- Admin dapat melakukan backup database (US1027)
- Admin dapat export log aktivitas (US1028)
- Admin dapat download semua materi dalam ZIP (US1029)

**3. Cara Kerja Modul**

a. **Admin – Export Absensi ke Excel:**
- Admin membuka halaman detail kelas
- Admin klik tombol "Export Absensi"
- Sistem menggenerate file Excel dengan data:
  - Nama siswa, tanggal pertemuan, status kehadiran, statistik
- File terdownload otomatis

b. **Admin – Export Learning Log:**
- Admin membuka detail siswa
- Admin klik "Export Learning Log"
- Sistem menggenerate file Excel berisi:
  - Riwayat pertemuan, materi yang diakses, progress

c. **Admin – Backup Database:**
- Admin mengakses menu Backup
- Admin klik "Backup Database"
- Sistem menjalankan mysqldump untuk export SQL
- File .sql terdownload untuk disimpan

d. **Admin – Download Semua Materi:**
- Admin klik "Download Semua Materi"
- Sistem mengkompres semua file materi menjadi ZIP
- File ZIP terdownload

e. **Validasi & Integrasi:**
- Backup hanya bisa dilakukan oleh Admin
- File export menggunakan format standar (Excel, SQL, ZIP)

**Potongan Kode Penting:**
```php
// BackupController.php - Backup Database
public function backupDatabase()
{
    $databaseName = config('database.connections.mysql.database');
    $fileName = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
    $path = storage_path('app/backups/' . $fileName);
    
    $command = sprintf(
        'mysqldump -u%s -p%s %s > %s',
        config('database.connections.mysql.username'),
        config('database.connections.mysql.password'),
        $databaseName,
        $path
    );
    
    exec($command);
    
    return response()->download($path, $fileName);
}
```

**4. Keterkaitan Modul dengan Kebutuhan Fungsional**
Mendukung US1023, US1024, US1026, US1027, US1028, dan US1029. Memberikan kemampuan admin untuk backup data, export laporan, dan mengunduh materi untuk keperluan arsip atau migrasi sistem.
