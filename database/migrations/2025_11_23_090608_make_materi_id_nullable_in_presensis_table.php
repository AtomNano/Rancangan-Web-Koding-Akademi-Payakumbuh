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
        Schema::table('presensis', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['materi_id']);
            // Make materi_id nullable
            $table->foreignId('materi_id')->nullable()->change();
            // Re-add foreign key with nullable
            $table->foreign('materi_id')->references('id')->on('materis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presensis', function (Blueprint $table) {
            // Drop foreign key
            $table->dropForeign(['materi_id']);
            // Make materi_id not nullable again
            $table->foreignId('materi_id')->nullable(false)->change();
            // Re-add foreign key
            $table->foreign('materi_id')->references('id')->on('materis')->onDelete('cascade');
        });
    }
};
