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
        Schema::table('materis', function (Blueprint $table) {
            if (!Schema::hasColumn('materis', 'deskripsi')) {
                $table->text('deskripsi')->nullable();
            }
            if (!Schema::hasColumn('materis', 'file_type')) {
                $table->string('file_type')->default('pdf');
            }
            if (!Schema::hasColumn('materis', 'uploaded_by')) {
                $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materis', function (Blueprint $table) {
            if (Schema::hasColumn('materis', 'deskripsi')) {
                $table->dropColumn('deskripsi');
            }
            if (Schema::hasColumn('materis', 'file_type')) {
                $table->dropColumn('file_type');
            }
            if (Schema::hasColumn('materis', 'uploaded_by')) {
                $table->dropForeign(['uploaded_by']);
                $table->dropColumn('uploaded_by');
            }
        });
    }
};
