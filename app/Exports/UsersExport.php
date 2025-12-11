<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UsersExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $role;

    public function __construct(string $role)
    {
        $this->role = $role;
    }

    public function query()
    {
        return User::query()->where('role', $this->role)->orderBy('name');
    }

    public function headings(): array
    {
        $headings = [
            'ID',
            'Nama',
            'Email',
            'Role',
            'Status',
            'No. Telepon',
            'Tanggal Daftar',
        ];

        if ($this->role === 'siswa') {
            $headings = array_merge($headings, [
                'Sekolah',
                'Kelas yang Diikuti',
                'Hari Belajar',
                'Durasi Program',
                'Alamat',
                'Metode Pembayaran',
                'Status Promo',
                'Total Biaya',
                'Total Setelah Diskon',
            ]);
        } elseif ($this->role === 'guru') {
            $headings[] = 'Kelas yang Diajar';
        }

        return $headings;
    }

    public function map($user): array
    {
        $data = [
            $user->id,
            $user->name,
            $user->email,
            ucfirst($user->role),
            $user->is_active ? 'Aktif' : 'Tidak Aktif',
            $user->no_telepon,
            $user->created_at->format('d M Y'),
        ];

        if ($this->role === 'siswa') {
            $data = array_merge($data, [
                $user->sekolah,
                is_array($user->bidang_ajar) ? implode(', ', $user->bidang_ajar) : '',
                is_array($user->hari_belajar) ? implode(', ', $user->hari_belajar) : '',
                $user->durasi,
                $user->alamat,
                $user->metode_pembayaran,
                $user->status_promo,
                $user->total_biaya,
                $user->total_setelah_diskon,
            ]);
        } elseif ($this->role === 'guru') {
            $data[] = is_array($user->bidang_ajar) ? implode(', ', $user->bidang_ajar) : '';
        }

        return $data;
    }
}
