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
        Schema::table('enrollments', function (Blueprint $table) {
            $table->date('start_date')->nullable()->after('status');
            $table->unsignedSmallInteger('duration_months')->nullable()->after('start_date');
            $table->unsignedSmallInteger('monthly_quota')->nullable()->after('duration_months');
            $table->unsignedSmallInteger('target_sessions')->nullable()->after('monthly_quota');
            $table->unsignedSmallInteger('sessions_attended')->default(0)->after('target_sessions');
            $table->timestamp('last_session_notified_at')->nullable()->after('sessions_attended');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropColumn([
                'start_date',
                'duration_months',
                'monthly_quota',
                'target_sessions',
                'sessions_attended',
                'last_session_notified_at',
            ]);
        });
    }
};
