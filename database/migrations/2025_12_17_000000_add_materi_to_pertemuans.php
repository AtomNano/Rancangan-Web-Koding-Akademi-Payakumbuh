<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pertemuans', function (Blueprint $table) {
            // Add materi as text column
            if (!Schema::hasColumn('pertemuans', 'materi')) {
                $table->string('materi')->nullable()->after('waktu_selesai');
            }
            
            // Drop materi_id if it exists (switching from FK to text)
            if (Schema::hasColumn('pertemuans', 'materi_id')) {
                $table->dropForeign(['materi_id']);
                $table->dropColumn('materi_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pertemuans', function (Blueprint $table) {
            if (Schema::hasColumn('pertemuans', 'materi')) {
                $table->dropColumn('materi');
            }
        });
    }
};
