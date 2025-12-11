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
            $table->string('discount_type')->nullable()->after('status_promo');
            $table->decimal('discount_value', 15, 2)->nullable()->after('discount_type');
            $table->decimal('total_setelah_diskon', 15, 2)->nullable()->after('discount_value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['discount_type', 'discount_value', 'total_setelah_diskon']);
        });
    }
};
