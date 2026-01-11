<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class RestoreDeletedUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:restore-deleted-user {email : Email dari user yang akan di-restore}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore user yang telah dihapus (soft delete) berdasarkan email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        // Cari user yang telah dihapus (soft deleted)
        $user = User::onlyTrashed()->where('email', $email)->first();
        
        if (!$user) {
            $this->error("User dengan email '{$email}' tidak ditemukan dalam data yang dihapus.");
            return Command::FAILURE;
        }
        
        // Restore user
        $user->restore();
        
        // Jika siswa, restore juga enrollmentnya
        if ($user->isSiswa()) {
            $enrollmentCount = $user->enrollments()->where('status', 'inactive')->update(['status' => 'active']);
            $this->line("<info>✓</info> <fg=green>Restored {$enrollmentCount} enrollment(s)</>");
        }
        
        $this->line('');
        $this->info("✓ User berhasil di-restore!");
        $this->line("<fg=cyan>Name:</> {$user->name}");
        $this->line("<fg=cyan>Email:</> {$user->email}");
        $this->line("<fg=cyan>Role:</> {$user->role}");
        $this->line('');
        $this->info("Email '{$email}' sekarang bisa digunakan untuk registrasi baru.");
        
        return Command::SUCCESS;
    }
}
