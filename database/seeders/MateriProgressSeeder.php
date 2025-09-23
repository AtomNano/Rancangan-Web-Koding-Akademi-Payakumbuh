<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Materi;
use App\Models\MateriProgress;

class MateriProgressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil siswa pertama
        $siswa = User::where('role', 'siswa')->first();
        
        if (!$siswa) {
            $this->command->info('No student found. Please create a student user first.');
            return;
        }

        // Ambil semua materi yang approved
        $materi = Materi::where('status', 'approved')->get();
        
        if ($materi->isEmpty()) {
            $this->command->info('No approved materials found. Please create some materials first.');
            return;
        }

        // Buat sample progress data
        foreach ($materi as $m) {
            // Pastikan siswa terdaftar di kelas materi tersebut
            if ($siswa->enrolledClasses->contains($m->kelas)) {
                // Cek apakah sudah ada progress untuk materi ini
                $existingProgress = MateriProgress::where('user_id', $siswa->id)
                    ->where('materi_id', $m->id)
                    ->first();
                
                if (!$existingProgress) {
                    $isCompleted = fake()->boolean(30); // 30% chance of completion
                    $currentPage = $isCompleted ? fake()->numberBetween(10, 20) : fake()->numberBetween(1, 15);
                    $totalPages = fake()->numberBetween(10, 25);
                    $progressPercentage = $isCompleted ? 100.00 : round(($currentPage / $totalPages) * 100, 2);
                    
                    MateriProgress::create([
                        'user_id' => $siswa->id,
                        'materi_id' => $m->id,
                        'current_page' => $currentPage,
                        'total_pages' => $totalPages,
                        'progress_percentage' => $progressPercentage,
                        'is_completed' => $isCompleted,
                        'last_read_at' => fake()->dateTimeBetween('-30 days', 'now'),
                    ]);
                }
            }
        }

        $this->command->info('Sample progress data created successfully!');
    }
}
