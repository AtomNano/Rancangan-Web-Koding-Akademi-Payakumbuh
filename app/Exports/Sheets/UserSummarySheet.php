<?php

namespace App\Exports\Sheets;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserSummarySheet implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithTitle, WithStyles
{
    protected $role;

    public function __construct(string $role)
    {
        $this->role = $role;
    }

    public function query()
    {
        $query = User::query()
            ->withCount([
                'presensi' => function ($query) {
                    $query->where('status_kehadiran', 'hadir');
                }
            ])
            ->orderBy('name');

        if ($this->role !== 'all') {
            $query->where('role', $this->role);
        }

        return $query;
    }

    public function headings(): array
    {
        $headings = [
            'ID System',
            'User Code',
            'Nama',
            'Email',
            'Role',
            'Status',
            'No. Telepon',
            'Total Kehadiran',
            'Tanggal Daftar',
        ];

        if ($this->role === 'siswa' || $this->role === 'all') {
            $headings = array_merge($headings, [
                'Sekolah',
                'Kelas',
                'Hari Belajar',
            ]);
        }

        if ($this->role === 'guru' || $this->role === 'all') {
            $headings[] = 'Jumlah Kelas Mengajar';
        }

        return $headings;
    }

    public function map($user): array
    {
        $userCode = $user->student_id ?? ($user->kode_guru ?? ($user->kode_admin ?? '-'));

        $data = [
            $user->id,
            $userCode,
            $user->name,
            $user->email,
            ucfirst($user->role),
            $user->is_active ? 'Aktif' : 'Tidak Aktif',
            $user->no_telepon,
            $user->presensi_count . ' Kehadiran',
            $user->created_at->format('d M Y'),
        ];

        if ($this->role === 'siswa' || $this->role === 'all') {
            $siswaData = [
                $user->sekolah ?? ($this->role === 'all' ? '-' : ''),
                $user->enrolledClasses->pluck('nama_kelas')->implode(', ') ?: '-',
                is_array($user->hari_belajar) ? implode(', ', $user->hari_belajar) : '-',
            ];

            if ($this->role === 'all' && $user->role !== 'siswa') {
                $siswaData = array_fill(0, 3, '-');
            }

            $data = array_merge($data, $siswaData);
        }

        if ($this->role === 'guru' || $this->role === 'all') {
            $guruData = [
                $user->teachingClasses->count(),
            ];

            if ($this->role === 'all' && $user->role !== 'guru') {
                $guruData = [0];
            }

            $data = array_merge($data, $guruData);
        }

        return $data;
    }

    public function title(): string
    {
        return 'Ringkasan Pengguna';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
