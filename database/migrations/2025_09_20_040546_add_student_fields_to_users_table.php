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
            // Student-specific fields
            $table->date('tanggal_pendaftaran')->nullable();
            $table->string('sekolah')->nullable();
            $table->string('bidang_ajar')->nullable(); // Robotic, Coding, etc.
            $table->json('hari_belajar')->nullable(); // Array of study days
            $table->string('durasi')->nullable(); // 3 Bulan, etc.
            $table->enum('metode_pembayaran', ['transfer', 'cash'])->nullable();
            $table->decimal('biaya_pendaftaran', 10, 2)->nullable();
            $table->decimal('biaya_angsuran', 10, 2)->nullable();
            $table->decimal('total_biaya', 10, 2)->nullable();
            $table->string('status_promo')->nullable(); // Free Siblings Promo, etc.
            $table->string('no_telepon')->nullable();
            $table->text('alamat')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'tanggal_pendaftaran',
                'sekolah',
                'bidang_ajar',
                'hari_belajar',
                'durasi',
                'metode_pembayaran',
                'biaya_pendaftaran',
                'biaya_angsuran',
                'total_biaya',
                'status_promo',
                'no_telepon',
                'alamat',
                'tanggal_lahir',
                'jenis_kelamin'
            ]);
        });
    }
};