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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('action'); // create, update, delete, approve, reject, etc.
            $table->string('model_type')->nullable(); // User, Kelas, Materi, etc.
            $table->unsignedBigInteger('model_id')->nullable(); // ID dari model yang terlibat
            $table->text('description'); // Deskripsi aktivitas
            $table->json('old_values')->nullable(); // Nilai lama (untuk update)
            $table->json('new_values')->nullable(); // Nilai baru (untuk update)
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'created_at']);
            $table->index(['model_type', 'model_id']);
            $table->index('action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
