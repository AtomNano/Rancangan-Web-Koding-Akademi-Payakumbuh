<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Materi; // Import Materi model

class MaterialVerificationReminder extends Notification
{
    use Queueable;

    protected $materi;

    /**
     * Create a new notification instance.
     */
    public function __construct(Materi $materi)
    {
        $this->materi = $materi;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail']; // For now, only mail. Database notification can be added later if needed.
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = route('guru.materi.show', $this->materi->id);

        return (new MailMessage)
                    ->subject('Pengingat Verifikasi Materi: ' . $this->materi->judul)
                    ->greeting('Halo ' . $notifiable->name . ',')
                    ->line('Materi Anda "' . $this->materi->judul . '" masih dalam status menunggu verifikasi dari admin.')
                    ->line('Mohon bersabar, admin kami akan segera memverifikasi materi Anda. Jika Anda merasa ada kesalahan atau ingin memperbarui materi, Anda dapat melihat detailnya di bawah ini.')
                    ->action('Lihat Detail Materi', $url)
                    ->line('Terima kasih atas kontribusi Anda di Coding Academy!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'materi_id' => $this->materi->id,
            'materi_judul' => $this->materi->judul,
            'message' => 'Materi Anda "' . $this->materi->judul . '" masih menunggu verifikasi.',
            'url' => route('guru.materi.show', $this->materi->id),
        ];
    }
}
