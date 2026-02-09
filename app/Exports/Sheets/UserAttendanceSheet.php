<?php

namespace App\Exports\Sheets;

use App\Models\Presensi;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserAttendanceSheet implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithTitle, WithStyles
{
    protected $role;

    public function __construct(string $role)
    {
        $this->role = $role;
    }

    public function query()
    {
        $query = Presensi::query()
            ->with(['user', 'pertemuan.kelas'])
            ->whereHas('user', function ($q) {
                if ($this->role !== 'all') {
                    $q->where('role', $this->role);
                }
            })
            ->orderBy('created_at', 'desc');

        return $query;
    }

    public function headings(): array
    {
        return [
            'ID System',
            'User Code',
            'Nama Pengguna',
            'Role',
            'Kelas',
            'Pertemuan',
            'Tanggal',
            'Status Kehadiran',
        ];
    }

    public function map($presensi): array
    {
        $user = $presensi->user;
        $userCode = $user ? ($user->student_id ?? ($user->kode_guru ?? ($user->kode_admin ?? '-'))) : '-';
        $role = $user ? ucfirst($user->role) : '-';
        $kelas = $presensi->pertemuan && $presensi->pertemuan->kelas ? $presensi->pertemuan->kelas->nama_kelas : '-';
        $pertemuan = $presensi->pertemuan ? $presensi->pertemuan->judul_pertemuan : '-';

        return [
            $user ? $user->id : '-',
            $userCode,
            $user ? $user->name : 'Deleted User',
            $role,
            $kelas,
            $pertemuan,
            $presensi->created_at->format('d M Y H:i'),
            ucfirst($presensi->status_kehadiran),
        ];
    }

    public function title(): string
    {
        return 'Riwayat Kehadiran';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
