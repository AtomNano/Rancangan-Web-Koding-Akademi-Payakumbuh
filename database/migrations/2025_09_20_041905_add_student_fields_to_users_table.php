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
            // Only add columns if they don't already exist
            if (!Schema::hasColumn('users', 'no_telepon')) {
                $table->string('no_telepon')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'tanggal_lahir')) {
                $table->date('tanggal_lahir')->nullable()->after('no_telepon');
            }
            if (!Schema::hasColumn('users', 'jenis_kelamin')) {
                $table->string('jenis_kelamin')->nullable()->after('tanggal_lahir');
            }
            if (!Schema::hasColumn('users', 'alamat')) {
                $table->text('alamat')->nullable()->after('jenis_kelamin');
            }
            if (!Schema::hasColumn('users', 'tanggal_pendaftaran')) {
                $table->date('tanggal_pendaftaran')->nullable()->after('alamat');
            }
            if (!Schema::hasColumn('users', 'sekolah')) {
                $table->string('sekolah')->nullable()->after('tanggal_pendaftaran');
            }
            if (!Schema::hasColumn('users', 'bidang_ajar')) {
                $table->string('bidang_ajar')->nullable()->after('sekolah');
            }
            if (!Schema::hasColumn('users', 'durasi')) {
                $table->string('durasi')->nullable()->after('bidang_ajar');
            }
            if (!Schema::hasColumn('users', 'hari_belajar')) {
                $table->json('hari_belajar')->nullable()->after('durasi');
            }
            if (!Schema::hasColumn('users', 'metode_pembayaran')) {
                $table->string('metode_pembayaran')->nullable()->after('hari_belajar');
            }
            if (!Schema::hasColumn('users', 'status_promo')) {
                $table->string('status_promo')->nullable()->after('metode_pembayaran');
            }
            if (!Schema::hasColumn('users', 'biaya_pendaftaran')) {
                $table->decimal('biaya_pendaftaran', 15, 2)->nullable()->after('status_promo');
            }
            if (!Schema::hasColumn('users', 'biaya_angsuran')) {
                $table->decimal('biaya_angsuran', 15, 2)->nullable()->after('biaya_pendaftaran');
            }
            if (!Schema::hasColumn('users', 'total_biaya')) {
                $table->decimal('total_biaya', 15, 2)->nullable()->after('biaya_angsuran');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = [
                'no_telepon', 'tanggal_lahir', 'jenis_kelamin', 'alamat',
                'tanggal_pendaftaran', 'sekolah', 'bidang_ajar', 'durasi',
                'hari_belajar', 'metode_pembayaran', 'status_promo',
                'biaya_pendaftaran', 'biaya_angsuran', 'total_biaya'
            ];
            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};