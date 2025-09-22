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
        Schema::create('materi_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('materi_id')->constrained()->onDelete('cascade');
            $table->integer('current_page')->default(1);
            $table->integer('total_pages')->nullable();
            $table->decimal('progress_percentage', 5, 2)->default(0.00);
            $table->boolean('is_completed')->default(false);
            $table->timestamp('last_read_at')->nullable();
            $table->timestamps();
            
            // Ensure unique combination of user and materi
            $table->unique(['user_id', 'materi_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materi_progress');
    }
};
