export const tourSteps = {
    siswa: [
        {
            element: '#dashboard-stats',
            popover: {
                title: 'Halo, Siswa!',
                description: 'Ini adalah dashboard utama Anda. Di sini Anda bisa melihat ringkasan status kelas dan materi Anda.',
                side: "bottom",
                align: 'start'
            }
        },
        {
            element: '#sidebar-nav',
            popover: {
                title: 'Navigasi Menu',
                description: 'Gunakan menu di samping untuk berpindah antar halaman dengan cepat.',
                side: "right",
                align: 'start'
            }
        },
        {
            element: 'a[href*="/siswa/kelas"]',
            popover: {
                title: 'Kelas Anda',
                description: 'Lihat daftar kelas yang Anda ikuti dan akses materi belajar di sini.',
                side: "right",
                align: 'start'
            }
        },
        {
            element: 'a[href*="progress"]',
            popover: {
                title: 'Progres Belajar',
                description: 'Pantau sejauh mana Anda sudah menyelesaikan materi pembelajaran.',
                side: "right",
                align: 'start'
            }
        },
        {
            element: '#notification-hub',
            popover: {
                title: 'Notifikasi',
                description: 'Cek pemberitahuan terbaru mengenai kelas atau informasi akademi di sini.',
                side: "bottom",
                align: 'end'
            }
        },
        {
            element: '#user-menu',
            popover: {
                title: 'Profil & Akun',
                description: 'Kelola profil Anda atau keluar dari aplikasi melalui menu ini.',
                side: "bottom",
                align: 'end'
            }
        }
    ],
    guru: [
        {
            element: '#dashboard-stats',
            popover: {
                title: 'Halo, Guru!',
                description: 'Dashboard Anda memberikan ringkasan tentang kelas yang Anda ajar dan materi yang perlu dikelola.',
                side: "bottom",
                align: 'start'
            }
        },
        {
            element: '#sidebar-nav',
            popover: {
                title: 'Menu Utama',
                description: 'Akses semua fungsi manajemen guru melalui bar samping ini.',
                side: "right",
                align: 'start'
            }
        },
        {
            element: 'a[href*="/guru/kelas"]',
            popover: {
                title: 'Manajemen Kelas',
                description: 'Kelola kelas, daftar siswa, dan rincian pertemuan di sini.',
                side: "right",
                align: 'start'
            }
        },
        {
            element: 'a[href*="/guru/materi"]',
            popover: {
                title: 'Materi Pembelajaran',
                description: 'Tambah atau perbarui materi yang akan dipelajari oleh siswa Anda.',
                side: "right",
                align: 'start'
            }
        },
        {
            element: 'a[href*="/guru/absen"]',
            popover: {
                title: 'Input Absensi',
                description: 'Jangan lupa untuk mengisi kehadiran siswa setiap pertemuan agar progres mereka tercatat.',
                side: "right",
                align: 'start'
            }
        },
        {
            element: '#notification-hub',
            popover: {
                title: 'Pusat Notifikasi',
                description: 'Dapatkan update instan mengenai aktivitas terbaru di sistem.',
                side: "bottom",
                align: 'end'
            }
        }
    ],
    admin: [
        {
            element: '#dashboard-stats',
            popover: {
                title: 'Selamat Datang, Admin',
                description: 'Pusat kendali Koding Akademi. Lihat statistik keseluruhan sistem secara real-time di sini.',
                side: "bottom",
                align: 'start'
            }
        },
        {
            element: '#sidebar-nav',
            popover: {
                title: 'Navigasi Admin',
                description: 'Semua fitur manajemen utama (Pengguna, Kelas, Materi) dapat diakses dari sini.',
                side: "right",
                align: 'start'
            }
        },
        {
            element: 'a[href*="/admin/users"]',
            popover: {
                title: 'Manajemen Pengguna',
                description: 'Pusat pengelolaan akun Siswa, Guru, Admin, dan CS. Anda bisa menambah atau mengedit data di sini.',
                side: "right",
                align: 'start'
            }
        },
        {
            element: 'a[href*="/admin/backup"]',
            popover: {
                title: 'Backup & Keamanan',
                description: 'Lakukan pencadangan database atau ekspor data penting secara berkala untuk keamanan data.',
                side: "right",
                align: 'start'
            }
        },
        {
            element: '#notification-hub',
            popover: {
                title: 'Notifikasi Sistem',
                description: 'Pantau peringatan sistem atau aktivitas penting melalui ikon lonceng ini.',
                side: "bottom",
                align: 'end'
            }
        },
        {
            element: '#user-menu',
            popover: {
                title: 'Pengaturan Akun',
                description: 'Ubah password atau informasi profil Admin Anda di sini.',
                side: "bottom",
                align: 'end'
            }
        }
    ],
    cs: [
        {
            element: '#cs-search-form',
            popover: {
                title: 'Cari Siswa Cepat',
                description: 'Gunakan kolom pencarian ini untuk menemukan data siswa dengan cepat tanpa harus ke menu daftar siswa.',
                side: "bottom",
                align: 'start'
            }
        },
        {
            element: '#sidebar-nav',
            popover: {
                title: 'Navigasi CS',
                description: 'Akses cepat ke daftar siswa dan log aktivitas melalui bar samping.',
                side: "right",
                align: 'start'
            }
        },
        {
            element: 'a[href*="/cs/siswa/create"]',
            popover: {
                title: 'Pendaftaran Siswa',
                description: 'Daftarkan siswa baru dengan mudah melalui formulir pendaftaran ini.',
                side: "right",
                align: 'start'
            }
        },
        {
            element: '#recent-students-table',
            popover: {
                title: 'Tabel Siswa Terbaru',
                description: 'Pantau pendaftaran terbaru yang masuk ke sistem secara langsung.',
                side: "top",
                align: 'start'
            }
        },
        {
            element: 'a[href*="/cs/logs"]',
            popover: {
                title: 'Riwayat Aktivitas',
                description: 'Lihat catatan aktivitas pendaftaran dan perubahan data yang telah dilakukan.',
                side: "right",
                align: 'start'
            }
        },
        {
            element: '#user-menu',
            popover: {
                title: 'Menu Akun',
                description: 'Kelola sesi login dan profil CS Anda di sini.',
                side: "bottom",
                align: 'end'
            }
        }
    ]
};
