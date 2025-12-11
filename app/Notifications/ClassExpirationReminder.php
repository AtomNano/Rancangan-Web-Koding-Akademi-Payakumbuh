<?php

namespace App\Notifications;

use App\Models\Enrollment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClassExpirationReminder extends Notification implements ShouldQueue
{
    use Queueable;

    protected $enrollment;
    protected $daysUntil;

    /**
     * Create a new notification instance.
     */
    public function __construct(Enrollment $enrollment, int $daysUntil)
    {
        $this->enrollment = $enrollment;
        $this->daysUntil = $daysUntil;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database']; // Store in the database
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $expirationDate = $this->enrollment->getExpirationDate()->format('d F Y');
        $line = 'Kelas Anda "' . $this->enrollment->kelas->nama_kelas . '" akan berakhir dalam ' . $this->daysUntil . ' hari pada tanggal ' . $expirationDate . '.';

        if ($this->daysUntil == 0) {
            $line = 'Kelas Anda "' . $this->enrollment->kelas->nama_kelas . '" berakhir hari ini!';
        } elseif ($this->daysUntil == 1) {
            $line = 'Kelas Anda "' . $this->enrollment->kelas->nama_kelas . '" akan berakhir besok!';
        }

        return (new MailMessage)
                    ->subject('Pengingat Kelas Akan Berakhir')
                    ->greeting('Halo ' . $notifiable->name . ',')
                    ->line($line)
                    ->action('Lihat Kelas Saya', route('dashboard'))
                    ->line('Segera perpanjang atau selesaikan progres Anda. Terima kasih!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $expirationDate = $this->enrollment->getExpirationDate()->format('d F Y');
        $message = 'Kelas ' . $this->enrollment->kelas->nama_kelas . ' akan berakhir dalam ' . $this->daysUntil . ' hari.';

        if ($this->daysUntil == 0) {
            $message = 'Kelas ' . $this->enrollment->kelas->nama_kelas . ' berakhir hari ini!';
        } elseif ($this->daysUntil == 1) {
            $message = 'Kelas ' . $this->enrollment->kelas->nama_kelas . ' akan berakhir besok!';
        }

        return [
            'icon' => 'warning', // 'success', 'error', 'info'
            'title' => 'Kelas Akan Berakhir',
            'message' => $message,
            'url' => route('dashboard'),
            'expiration_date' => $expirationDate,
        ];
    }
}
