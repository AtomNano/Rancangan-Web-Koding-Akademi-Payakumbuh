<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kelas_id',
        'status',
        'start_date',
        'duration_months',
        'monthly_quota',
        'target_sessions',
        'sessions_attended',
        'last_session_notified_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'last_session_notified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function isActive()
    {
        return in_array($this->status, ['active', 'expiring'], true);
    }

    public function calculateTargetSessions(): ?int
    {
        if (!empty($this->target_sessions)) {
            return (int) $this->target_sessions;
        }

        $months = $this->duration_months ?: 0;
        $quota = $this->monthly_quota ?: 0;

        if ($months <= 0 || $quota <= 0) {
            return null; // unlimited / not set
        }

        return (int) ($months * $quota);
    }

    public function computeSessionsAttended(): int
    {
        return \App\Models\Presensi::where('user_id', $this->user_id)
            ->where('status_kehadiran', 'hadir')
            ->whereHas('pertemuan', function ($query) {
                $query->where('kelas_id', $this->kelas_id);
            })
            ->count();
    }

    public function getSessionsRemainingAttribute(): ?int
    {
        $target = $this->calculateTargetSessions();

        if (!$target) {
            return null; // unlimited / not configured
        }

        $attended = $this->sessions_attended ?? 0;

        return max(0, $target - $attended);
    }

    public function hasRemainingSessions(): bool
    {
        $target = $this->calculateTargetSessions();

        if (!$target) {
            return true; // unlimited / not configured
        }

        return ($this->sessions_attended ?? 0) < $target;
    }

    public function syncSessionProgress(int $expiringThreshold = 1): array
    {
        $target = $this->calculateTargetSessions();
        $attended = $this->computeSessionsAttended();

        $originalStatus = $this->status;
        $status = $originalStatus;

        if ($target) {
            $remaining = max(0, $target - $attended);

            if ($remaining <= 0) {
                $status = 'inactive';
            } elseif ($remaining <= $expiringThreshold) {
                $status = 'expiring';
            } else {
                $status = 'active';
            }
        }

        $this->sessions_attended = $attended;
        $this->target_sessions = $target ?? $this->target_sessions;
        $this->status = $status;
        $this->save();

        return [
            'target' => $target,
            'attended' => $attended,
            'status_changed' => $originalStatus !== $status,
            'remaining' => $target ? max(0, $target - $attended) : null,
        ];
    }

    public function needsQuotaReminder(int $threshold = 1): bool
    {
        $target = $this->calculateTargetSessions();

        if (!$target) {
            return false;
        }

        $remaining = max(0, $target - ($this->sessions_attended ?? 0));

        if ($remaining > $threshold) {
            return false;
        }

        if (!$this->last_session_notified_at) {
            return true;
        }

        // Avoid spamming: notify once per day at most
        return $this->last_session_notified_at->lt(now()->startOfDay());
    }

    public function markQuotaNotified(): void
    {
        $this->last_session_notified_at = now();
        $this->save();
    }

    /**
     * Calculate the expiration date for this enrollment based on start_date/duration or fallback to user's registration date.
     *
     * @return \Carbon\Carbon|null
     */
    public function getExpirationDate()
    {
        $startDate = $this->start_date ?? $this->user?->tanggal_pendaftaran;
        $months = $this->duration_months ?? filter_var($this->user?->durasi, FILTER_SANITIZE_NUMBER_INT);
        
        // Ensure $months is an integer
        $months = (int) $months;

        if (!$startDate || !$months || $months <= 0) {
            return null;
        }

        return \Carbon\Carbon::parse($startDate)->addMonths($months);
    }

    /**
     * Get the number of days until expiration
     *
     * @return int|null
     */
    public function getDaysUntilExpiration()
    {
        $expirationDate = $this->getExpirationDate();

        if (!$expirationDate) {
            return null;
        }

        return now()->diffInDays($expirationDate, false);
    }

    /**
     * Check if enrollment is expiring soon (within specified days)
     *
     * @param int $daysBefore
     * @return bool
     */
    public function isExpiringSoon($daysBefore = 7)
    {
        $daysUntil = $this->getDaysUntilExpiration();

        if ($daysUntil === null) {
            return false;
        }

        // Expiring soon if between 0 and $daysBefore days
        return $daysUntil >= 0 && $daysUntil <= $daysBefore;
    }
}
