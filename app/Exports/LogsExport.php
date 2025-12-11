<?php

namespace App\Exports;

use App\Models\ActivityLog;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LogsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    public function query()
    {
        // Order by the most recent logs
        return ActivityLog::query()->orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Level',
            'Pesan',
            'URL',
            'Metode',
            'IP Address',
            'User Agent',
            'User ID',
            'Nama User',
            'Timestamp',
        ];
    }

    public function map($log): array
    {
        return [
            $log->id,
            $log->level,
            $log->message,
            $log->url,
            $log->method,
            $log->ip_address,
            $log->user_agent,
            $log->user_id,
            $log->user ? $log->user->name : 'N/A',
            $log->created_at->toDateTimeString(),
        ];
    }
}
