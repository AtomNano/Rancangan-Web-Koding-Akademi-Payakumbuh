<?php

namespace App\Exports;

use App\Models\Kelas;
use App\Models\User;
use App\Models\Enrollment;
use App\Models\Presensi;
use App\Models\Pertemuan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentLearningLogExport implements FromArray, WithStyles
{
    public function __construct(protected Kelas $kelas, protected User $user)
    {
    }

    public function array(): array
    {
        $rows = [];

        $enrollment = Enrollment::where('kelas_id', $this->kelas->id)
            ->where('user_id', $this->user->id)
            ->first();

        $rows[] = ['Subject', $this->kelas->nama_kelas];
        $rows[] = ['Nama Murid', $this->user->name];
        $rows[] = ['Tanggal Bergabung', optional(optional($enrollment)->start_date)->format('d/m/Y')];
        $rows[] = []; // spacer

        $rows[] = ['Pertemuan', 'Tanggal Belajar', 'Nama Mentor', 'Materi'];

        // Ambil presensi siswa pada kelas ini, join ke pertemuan + materi + guru
        $presensis = Presensi::where('user_id', $this->user->id)
            ->whereHas('pertemuan', function ($q) {
                $q->where('kelas_id', $this->kelas->id);
            })
            ->with(['pertemuan.guru', 'pertemuan.materi'])
            ->get()
            ->sortBy(function ($p) {
                $tanggal = optional($p->pertemuan)->tanggal_pertemuan;
                return $tanggal ? $tanggal->timestamp : PHP_INT_MAX;
            })
            ->values();

        $i = 1;
        foreach ($presensis as $p) {
            $pertemuan = $p->pertemuan; 
            if (!$pertemuan) continue;
            $tanggal = optional($pertemuan->tanggal_pertemuan)->format('d/m/Y');
            $mentor = optional($pertemuan->guru)->name ?: '';
            $materiJudul = optional($pertemuan->materi)->judul ?: '';
            $rows[] = [
                'Pertemuan ' . $i,
                $tanggal,
                $mentor,
                $materiJudul,
            ];
            $i++;
        }

        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        // Bold the header row for the table (row 5)
        $sheet->getStyle('A5:D5')->getFont()->setBold(true);
        return [];
    }
}
