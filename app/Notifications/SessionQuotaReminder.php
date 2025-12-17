<?php

namespace App\Notifications;

use App\Models\Enrollment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SessionQuotaReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(protected Enrollment $enrollment, protected int $remaining, protected int $target)
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $kelas = $this->enrollment->kelas?->nama_kelas ?? '-';
        $title = 'Sisa ' . $this->remaining . ' sesi untuk kelas ' . $kelas;

        return (new MailMessage)
            ->subject('Pengingat Kuota Sesi')
            ->line($title)
            ->line('Total kuota: ' . $this->target . ' sesi.')
            ->action('Lihat Kelas', route('dashboard'));
    }

    public function toArray(object $notifiable): array
    {
        $kelas = $this->enrollment->kelas?->nama_kelas ?? '-';

        return [
            'icon' => 'warning',
            'title' => 'Kuota sesi hampir habis',
            'message' => 'Sisa ' . $this->remaining . ' sesi untuk kelas ' . $kelas . ' (total ' . $this->target . ').',
            'url' => route('dashboard'),
            'kelas' => $kelas,
            'remaining' => $this->remaining,
            'target' => $this->target,
        ];
    }
}
