<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('kode_cs')->nullable()->after('kode_guru');
        });

        // Update role enum to include 'cs' if using MySQL/MariaDB
        // Note: Laravel doesn't have native enum modification, so we use raw SQL
        try {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'guru', 'siswa', 'cs') NOT NULL DEFAULT 'siswa'");
        } catch (\Exception $e) {
            // If the column is not an enum or database doesn't support it, skip
            // This is fine for SQLite or if role is already a string
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('kode_cs');
        });

        // Revert role enum
        try {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'guru', 'siswa') NOT NULL DEFAULT 'siswa'");
        } catch (\Exception $e) {
            // Skip if not applicable
        }
    }
};
