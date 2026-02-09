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
            'User',
            'Action',
            'Description',
            'Model Type',
            'Model ID',
            'IP Address',
            'User Agent',
            'Timestamp',
        ];
    }

    public function map($log): array
    {
        return [
            $log->id,
            $log->user ? $log->user->name . ' (' . $log->user->email . ')' : 'System',
            ucfirst($log->action),
            $log->description,
            $log->model_type,
            $log->model_id,
            $log->ip_address,
            $log->user_agent,
            $log->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
