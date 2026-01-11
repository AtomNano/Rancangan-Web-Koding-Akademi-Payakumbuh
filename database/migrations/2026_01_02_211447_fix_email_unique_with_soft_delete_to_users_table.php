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
        Schema::table('users', function (Blueprint $table) {
            // Drop the existing unique constraint
            $table->dropUnique(['email']);
            
            // Add a new unique constraint that only applies to non-deleted users
            // This uses a partial/conditional unique index
            $table->unique(['email', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the new unique constraint
            $table->dropUnique(['email', 'deleted_at']);
            
            // Restore the original unique constraint
            $table->unique(['email']);
        });
    }
};
