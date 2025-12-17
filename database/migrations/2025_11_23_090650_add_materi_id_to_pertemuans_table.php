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
            $table->foreignId('materi_id')->nullable()->after('guru_id')->constrained('materis')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pertemuans', function (Blueprint $table) {
            // Check if foreign key exists before dropping
            $indexName = 'pertemuans_materi_id_foreign';
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $doctrineTable = $sm->introspectTable('pertemuans');
            
            if ($doctrineTable->hasForeignKey($indexName)) {
                $table->dropForeign(['materi_id']);
            }
            
            if (Schema::hasColumn('pertemuans', 'materi_id')) {
                $table->dropColumn('materi_id');
            }
        });
    }
};
