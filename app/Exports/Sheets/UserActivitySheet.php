<?php

namespace App\Exports\Sheets;

use App\Models\ActivityLog;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserActivitySheet implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithTitle, WithStyles
{
    protected $role;

    public function __construct(string $role)
    {
        $this->role = $role;
    }

    public function query()
    {
        $query = ActivityLog::query()
            ->with(['user'])
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
            'Waktu',
            'Aktivitas',
            'Deskripsi',
            'IP Address',
        ];
    }

    public function map($log): array
    {
        $user = $log->user;
        $userCode = $user ? ($user->student_id ?? ($user->kode_guru ?? ($user->kode_admin ?? '-'))) : '-';
        $role = $user ? ucfirst($user->role) : '-';

        return [
            $user ? $user->id : '-',
            $userCode,
            $user ? $user->name : 'System/Guest',
            $role,
            $log->created_at->format('d M Y H:i:s'),
            ucfirst($log->action),
            $log->description,
            $log->ip_address,
        ];
    }

    // Correction: In LogsExport we saw 'level', 'message', 'url', 'method'.
    // The user asked "dia ngapain aja", so 'message' and 'url'/'method' might be relevant.
    // Let's stick to a clean report: Waktu, Aktivitas (Message), Detail (URL/Method if needed).
    // Let's check ActivityLog model content again from previous context.
    // "level", "message", "url", "method", "ip_address", "user_agent".

    // Refined map:
    // Waktu: created_at
    // Aktivitas: message
    // Detail: method . ' ' . url

    public function title(): string
    {
        return 'Riwayat Aktivitas';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
