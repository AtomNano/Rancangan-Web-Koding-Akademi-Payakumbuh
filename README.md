# Materi Online - Platform E-Learning -v2.1

Platform E-Learning "Materi Online" adalah sistem pembelajaran digital yang dirancang untuk mendukung proses belajar mengajar antara Admin, Guru, dan Siswa. Aplikasi ini dibangun menggunakan framework Laravel dengan antarmuka yang modern dan responsif.

## Fitur Utama

Platform ini memiliki tiga hak akses utama dengan fungsionalitas yang berbeda: di web ini 



### 1. Panel Admin
- **Manajemen Pengguna:** Mendaftarkan, mengubah, dan menghapus data Guru dan Siswa.
- **Manajemen Kelas:** Membuat, mengubah, dan menghapus kelas pembelajaran.
- **Manajemen Pendaftaran:** Menempatkan (enroll) Siswa ke dalam kelas yang sesuai.
- **Verifikasi Materi:** Meninjau dan menyetujui materi yang diunggah oleh Guru sebelum dipublikasikan.
- **Backup Data:** Melakukan pencadangan data secara berkala untuk keamanan.

### 2. Panel Guru
- **Manajemen Materi:** Mengunggah dan mengelola materi pembelajaran seperti modul (dokumen/PDF), video, dan tugas.
- **Pemantauan Progres Siswa:** Memantau kemajuan belajar setiap Siswa di kelas yang diampu.
- **Visualisasi Data:** Melihat data dan statistik terkait aktivitas pembelajaran Siswa.

### 3. Panel Siswa
- **Akses Kelas:** Mengakses semua kelas di mana Siswa terdaftar.
- **Akses Materi:** Mempelajari materi yang telah diverifikasi oleh Admin.
- **Progress Pembelajaran:** Melihat progres belajar melalui *progress bar* dan rekam jejak materi yang telah dipelajari.

## Teknologi yang Digunakan

- **Backend:** Laravel 11
- **Frontend:** Blade Templates & Tailwind CSS
- **Database:** MySQL (atau database lain yang didukung Laravel)
- **Autentikasi:** Laravel Breeze

## Panduan Instalasi

Berikut adalah langkah-langkah untuk menginstal dan menjalankan proyek ini di lingkungan lokal:

1.  **Clone Repository**
    ```bash
    git clone https://github.com/username/nama-repository.git
    cd nama-repository
    ```

2.  **Install Dependensi Composer**
    ```bash
    composer install
    ```

3.  **Install Dependensi NPM**
    ```bash
    npm install
    ```

4.  **Salin File Environment**
    Salin file `.env.example` menjadi `.env`.
    ```bash
    copy .env.example .env
    ```

5.  **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

6.  **Konfigurasi Database**
    Buka file `.env` dan sesuaikan konfigurasi database Anda:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database_anda
    DB_USERNAME=username_db_anda
    DB_PASSWORD=password_db_anda
    ```

7.  **Jalankan Migrasi Database**
    Perintah ini akan membuat semua tabel yang dibutuhkan, termasuk tabel untuk pengguna, kelas, materi, dll.
    ```bash
    php artisan migrate:fresh
    ```

8.  **Jalankan Aset Frontend**
    Compile aset frontend seperti CSS dan JavaScript.
    ```bash
    npm run dev
    ```

9.  **Jalankan Server Development**
    Jalankan server lokal Laravel. Secara default, aplikasi akan berjalan di `http://127.0.0.1:8000`.
    ```bash
    php artisan serve
    ```

10.  **Jalan Storage Link Untuk menyambung Data**

    ```bash
    php artisan storage:link
    ```

## Penggunaan

Setelah instalasi selesai, Anda dapat mengakses aplikasi melalui browser. Halaman utama akan menampilkan landing page.

- **Login:** Gunakan tombol "Masuk" untuk menuju halaman login. Anda dapat login sebagai Admin, Guru, atau Siswa sesuai dengan data yang ada di database.
- **Dashboard:** Setelah login, Anda akan diarahkan ke dashboard yang sesuai dengan hak akses Anda.