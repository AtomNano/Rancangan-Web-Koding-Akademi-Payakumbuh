# Panduan Testing Fitur PDF Viewer & Pelacakan Progres

## 🚀 Cara Testing Fitur Lengkap

### 1. Persiapan Data
```bash
# Jalankan seeder untuk data sample
php artisan db:seed --class=MateriProgressSeeder

# Pastikan server berjalan
php artisan serve
```

### 2. Testing Progress Bar Dashboard

#### Langkah-langkah:
1. **Login sebagai siswa** menggunakan quick login:
   - Buka: `http://localhost:8000/quick-login/siswa`
   - Atau login manual dengan email: `siswa@example.com`

2. **Lihat Dashboard Siswa**:
   - Progress bar sekarang akan menampilkan persentase yang sebenarnya
   - Data diambil dari tabel `materi_progress`
   - Menampilkan "X dari Y materi selesai"

3. **Klik "Lihat Detail"** untuk halaman progress lengkap:
   - Menampilkan rata-rata progres membaca
   - Statistik materi selesai, total, tersisa, dan sedang dibaca

### 3. Testing PDF Viewer

#### Langkah-langkah:
1. **Buka kelas** dari dashboard siswa
2. **Klik "Buka Materi"** pada materi PDF
3. **Test fitur PDF viewer**:
   - ✅ Navigasi halaman (sebelumnya/selanjutnya)
   - ✅ Zoom in/out (50% - 200%)
   - ✅ Progress bar otomatis terupdate
   - ✅ Tombol download PDF
   - ✅ Responsif di mobile

4. **Test pelacakan progres**:
   - ✅ Ubah halaman → progres tersimpan otomatis
   - ✅ Refresh halaman → kembali ke halaman terakhir
   - ✅ Klik "Tandai Selesai" → status berubah

### 4. Testing Indikator Progres di Daftar Materi

#### Langkah-langkah:
1. **Kembali ke daftar kelas**
2. **Lihat indikator progres**:
   - ✅ Progress bar visual dengan persentase
   - ✅ Status "Selesai" untuk materi 100%
   - ✅ Status "X% Selesai" untuk materi yang sedang dibaca
   - ✅ Informasi "Terakhir dibaca: Halaman X dari Y"
   - ✅ Tombol "Lanjutkan" untuk materi yang sudah dimulai

### 5. Testing untuk Guru & Admin

#### Langkah-langkah:
1. **Login sebagai guru**: `http://localhost:8000/quick-login/guru`
2. **Buka detail materi** → PDF viewer tersedia
3. **Login sebagai admin**: `http://localhost:8000/quick-login/admin`
4. **Buka detail materi** → PDF viewer tersedia

## 📊 Data Sample yang Dihasilkan

Seeder akan membuat data sample dengan:
- **30% chance** materi selesai (100%)
- **70% chance** materi sedang dibaca (1-75%)
- **Random halaman** terakhir dibaca
- **Random total halaman** (10-25 halaman)

## 🔍 Verifikasi Fitur

### Dashboard Siswa
- [ ] Progress bar menampilkan persentase yang benar
- [ ] Informasi "X dari Y materi selesai" muncul
- [ ] Animasi progress bar smooth

### PDF Viewer
- [ ] PDF terbuka di iframe, bukan download
- [ ] Kontrol navigasi berfungsi
- [ ] Zoom controls berfungsi
- [ ] Progress bar terupdate real-time
- [ ] Tombol "Tandai Selesai" berfungsi

### Daftar Materi
- [ ] Indikator progres visual muncul
- [ ] Status "Selesai" untuk materi 100%
- [ ] Status progres untuk materi yang sedang dibaca
- [ ] Informasi halaman terakhir dibaca
- [ ] Tombol "Lanjutkan" untuk materi yang sudah dimulai

### API Endpoints
- [ ] `POST /siswa/materi/{id}/progress` - Update progres
- [ ] `GET /siswa/materi/{id}/progress` - Get progres
- [ ] `POST /siswa/materi/{id}/mark-completed` - Tandai selesai

## 🐛 Troubleshooting

### Progress Bar Tidak Update
1. Cek apakah ada data di tabel `materi_progress`
2. Pastikan siswa terdaftar di kelas materi
3. Pastikan materi status 'approved'

### PDF Viewer Tidak Muncul
1. Pastikan file PDF ada di storage
2. Cek permission file storage
3. Pastikan file_type = 'pdf'

### Data Tidak Konsisten
1. Jalankan seeder ulang: `php artisan db:seed --class=MateriProgressSeeder`
2. Clear cache: `php artisan cache:clear`
3. Rebuild assets: `npm run build`

## 📱 Testing Mobile Responsiveness

1. Buka developer tools (F12)
2. Switch ke mobile view
3. Test PDF viewer di mobile:
   - Kontrol navigasi tetap berfungsi
   - Progress bar responsive
   - Touch controls bekerja

## ✅ Checklist Final

- [ ] Dashboard menampilkan progres yang akurat
- [ ] PDF viewer berfungsi di semua role
- [ ] Pelacakan progres real-time
- [ ] Indikator visual di daftar materi
- [ ] Responsif di mobile dan desktop
- [ ] API endpoints berfungsi
- [ ] Data persisten di database
