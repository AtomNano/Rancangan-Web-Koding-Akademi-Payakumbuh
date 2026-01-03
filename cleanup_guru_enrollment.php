<?php
/**
 * Clean up enrollments for users with role GURU/ADMIN
 * Guru and Admin should NOT be enrolled as students
 * Run: php cleanup_guru_enrollment.php
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Enrollment;

echo "=== CLEANUP GURU/ADMIN ENROLLMENTS ===\n\n";

// Find all guru and admin users
$guruAdminUsers = User::whereIn('role', ['guru', 'admin'])->get();

echo "Found " . $guruAdminUsers->count() . " guru/admin users\n\n";

$deletedCount = 0;

foreach ($guruAdminUsers as $user) {
    $enrollments = $user->enrollments;
    
    if ($enrollments->count() > 0) {
        echo "User: {$user->name} (Role: {$user->role})\n";
        echo "  - Enrolled in " . $enrollments->count() . " class(es)\n";
        
        foreach ($enrollments as $enrollment) {
            echo "    * Kelas ID: {$enrollment->kelas_id}\n";
            $enrollment->delete();
            $deletedCount++;
        }
        
        echo "  ✓ Removed all enrollments\n\n";
    }
}

echo "\n=== CLEANUP COMPLETE ===\n";
echo "Total enrollments deleted: {$deletedCount}\n";
echo "\nNow only SISWA users can be enrolled in classes.\n";
echo "GURU and ADMIN are no longer enrolled as students.\n";
