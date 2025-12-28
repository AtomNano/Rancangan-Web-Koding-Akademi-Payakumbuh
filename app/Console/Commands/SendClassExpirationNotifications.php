<?php

namespace App\Console\Commands;

use App\Models\Enrollment;
use App\Models\User;
use App\Notifications\ClassExpirationReminder;
use Illuminate\Console\Command;

class SendClassExpirationNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:class-expiration 
                            {--days=7 : Number of days before expiration to notify}
                            {--force : Force send even if notification exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifications to students whose class enrollments are about to expire';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $daysBefore = (int) $this->option('days');
        $force = $this->option('force');

        $this->info("Checking enrollments expiring within {$daysBefore} days...");

        // Get all active enrollments
        $enrollments = Enrollment::with(['user', 'kelas'])
            ->whereIn('status', ['active', 'expiring'])
            ->whereHas('user', function ($query) {
                $query->where('role', 'siswa');
            })
            ->get();

        $notificationsSent = 0;
        $skipped = 0;

        foreach ($enrollments as $enrollment) {
            $expirationDate = $enrollment->getExpirationDate();
            $daysUntil = $enrollment->getDaysUntilExpiration();

            // Skip if no expiration date or already expired
            if ($expirationDate === null || $daysUntil === null || $daysUntil < 0) {
                continue;
            }

            // Only notify if within the threshold
            if ($daysUntil > $daysBefore) {
                continue;
            }

            $user = $enrollment->user;

            if (!$user) {
                continue;
            }

            // Check if notification already sent (unless force mode)
            if (!$force) {
                $recentNotification = $user->unreadNotifications()
                    ->where('type', ClassExpirationReminder::class)
                    ->where('data->expiration_date', $expirationDate->format('d F Y'))
                    ->exists();

                if ($recentNotification) {
                    $skipped++;
                    continue;
                }
            }

            // Send notification
            $user->notify(new ClassExpirationReminder($enrollment, $daysUntil));
            $notificationsSent++;

            $this->line("  ✓ Notified {$user->name} - {$enrollment->kelas->nama_kelas} ({$daysUntil} days remaining)");
        }

        $this->newLine();
        $this->info("Done! Sent {$notificationsSent} notifications, skipped {$skipped} (already notified).");

        return Command::SUCCESS;
    }
}
