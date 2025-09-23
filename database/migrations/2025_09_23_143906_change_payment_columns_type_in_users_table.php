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
            $table->bigInteger('biaya_pendaftaran')->nullable()->change();
            $table->bigInteger('biaya_angsuran')->nullable()->change();
            $table->bigInteger('total_biaya')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('biaya_pendaftaran')->nullable()->change();
            $table->integer('biaya_angsuran')->nullable()->change();
            $table->integer('total_biaya')->nullable()->change();
        });
    }
};
