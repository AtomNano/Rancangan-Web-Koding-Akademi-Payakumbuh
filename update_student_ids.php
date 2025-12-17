<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

echo "\n=== Assigning Student IDs ===\n";

$students = User::where('role', 'siswa')->withoutTrashed()->get();
foreach ($students as $index => $student) {
    // Format: X-YY-MMYYYY (no leading zeros)
    $studentId = ($index + 1) . '-01-122025';
    $student->student_id = $studentId;
    $student->save();
    echo "✓ Assigned: {$student->name} -> {$studentId}\n";
}

echo "\n=== Verifying Student IDs ===\n";

// Query directly with withoutTrashed to bypass soft deletes
$verified = User::where('role', 'siswa')
    ->withoutTrashed()
    ->orderBy('id')
    ->select('id', 'name', 'student_id', 'role')
    ->get();

foreach ($verified as $student) {
    $studentId = $student->student_id ?? 'NULL';
    echo "- ID:{$student->id}, Name: {$student->name}, StudentID: {$studentId}\n";
}

echo "\nTotal students: " . $verified->count() . "\n";
?>


