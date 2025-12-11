<?php

namespace App\Notifications;

use App\Models\Materi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMaterialForVerification extends Notification implements ShouldQueue
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
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $teacherName = $this->materi->uploadedBy ? $this->materi->uploadedBy->name : 'N/A';
        
        return [
            'icon' => 'upload',
            'title' => 'Materi Baru Menunggu Verifikasi',
            'message' => $teacherName . ' telah mengunggah materi baru: "' . $this->materi->judul . '".',
            'url' => route('admin.materi.show', $this->materi->id),
        ];
    }
}
