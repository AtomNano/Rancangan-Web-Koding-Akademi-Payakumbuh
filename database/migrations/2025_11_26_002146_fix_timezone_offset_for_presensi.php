<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix timezone offset: add 7 hours to all tanggal_akses in presensis table
        // This converts UTC times to Asia/Jakarta times (UTC+7)
        DB::statement('UPDATE presensis SET tanggal_akses = DATE_ADD(tanggal_akses, INTERVAL 7 HOUR)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse the fix: subtract 7 hours
        DB::statement('UPDATE presensis SET tanggal_akses = DATE_SUB(tanggal_akses, INTERVAL 7 HOUR)');
    }
};
