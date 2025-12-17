<?php

namespace App\Exports;

use App\Models\Kelas;
use App\Models\Pertemuan;
use App\Models\Presensi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KelasAttendanceExport implements FromArray, WithHeadings, WithStyles
{
    public function __construct(protected Kelas $kelas)
    {
    }

    public function headings(): array
    {
        $pertemuans = $this->getPertemuans();
        $headers = ['No', 'Nama'];

        foreach ($pertemuans as $index => $pertemuan) {
            $headers[] = 'Meet ' . ($index + 1);
        }

        return $headers;
    }

    public function array(): array
    {
        $pertemuans = $this->getPertemuans();
        $students = $this->kelas->students()->orderBy('name')->get();
        $pertemuanIds = $pertemuans->pluck('id');
        $studentIds = $students->pluck('id');

        $presensiMap = Presensi::whereIn('pertemuan_id', $pertemuanIds)
            ->whereIn('user_id', $studentIds)
            ->get()
            ->keyBy(function ($item) {
                return $item->user_id . '-' . $item->pertemuan_id;
            });

        $rows = [];

        // Tanggal row
        $dateRow = ['', 'Tanggal'];
        foreach ($pertemuans as $pertemuan) {
            $dateRow[] = optional($pertemuan->tanggal_pertemuan)->format('d/m/Y');
        }
        $rows[] = $dateRow;

        // Student rows
        foreach ($students as $index => $student) {
            $row = [$index + 1, $student->name];

            foreach ($pertemuans as $pertemuan) {
                $key = $student->id . '-' . $pertemuan->id;
                $status = $presensiMap[$key]->status_kehadiran ?? null;
                $row[] = $this->statusSymbol($status);
            }

            $rows[] = $row;
        }

        // Total hadir per pertemuan
        $totalRow = ['', 'TOTAL HADIR'];
        foreach ($pertemuans as $pertemuan) {
            $hadirCount = $presensiMap->filter(fn ($item) => $item->pertemuan_id === $pertemuan->id && $item->status_kehadiran === 'hadir')->count();
            $totalRow[] = $hadirCount;
        }
        $rows[] = $totalRow;

        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        // Bold headings + total row
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->getFont()->setBold(true);
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A' . $lastRow . ':' . $sheet->getHighestColumn() . $lastRow)->getFont()->setBold(true);

        return [];
    }

    private function getPertemuans(): Collection
    {
        return Pertemuan::where('kelas_id', $this->kelas->id)
            ->orderBy('tanggal_pertemuan')
            ->orderBy('waktu_mulai')
            ->get();
    }

    private function statusSymbol(?string $status): string
    {
        return match ($status) {
            'hadir' => 'H',
            'izin' => 'I',
            'sakit' => 'S',
            'alpha' => 'A',
            default => '',
        };
    }
}
