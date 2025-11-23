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
        return $this->status === 'active';
    }

    /**
     * Calculate the expiration date for this enrollment based on user's registration date and duration
     * 
     * @return \Carbon\Carbon|null
     */
    public function getExpirationDate()
    {
        $user = $this->user;
        
        if (!$user || !$user->tanggal_pendaftaran || !$user->durasi) {
            return null;
        }

        // Parse the duration string to get the number of months
        $months = (int) filter_var($user->durasi, FILTER_SANITIZE_NUMBER_INT);
        if ($months <= 0) {
            return null;
        }

        // Calculate the expiration date
        return \Carbon\Carbon::parse($user->tanggal_pendaftaran)->addMonths($months);
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
