<?php

namespace App\Exports;

use App\Exports\Sheets\UserActivitySheet;
use App\Exports\Sheets\UserAttendanceSheet;
use App\Exports\Sheets\UserSummarySheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UsersExport implements WithMultipleSheets
{
    use Exportable;

    protected $role;

    public function __construct(string $role)
    {
        $this->role = $role;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        // Sheet 1: Ringkasan Pengguna (Summary)
        $sheets[] = new UserSummarySheet($this->role);

        // Sheet 2: Riwayat Kehadiran (Attendance)
        if ($this->role === 'siswa' || $this->role === 'all') {
            $sheets[] = new UserAttendanceSheet($this->role);
        }

        // Sheet 3: Riwayat Aktivitas (Activity Log)
        $sheets[] = new UserActivitySheet($this->role);

        return $sheets;
    }
}
