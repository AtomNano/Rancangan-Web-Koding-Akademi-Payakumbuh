<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'description',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that performed the activity
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the model that was affected
     */
    public function model()
    {
        return $this->morphTo();
    }

    /**
     * Get activity icon based on action
     */
    public function getIconAttribute(): string
    {
        return match($this->action) {
            'create' => 'M7 11l5-5m0 0l5 5m-5-5v12',
            'update' => 'M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L16.732 3.732z',
            'delete' => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16',
            'approve' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
            'reject' => 'M6 18L18 6M6 6l12 12',
            'enroll' => 'M12 6v6m0 0v6m0-6h6m-6 0H6',
            'unenroll' => 'M18 12H6',
            default => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
        };
    }

    /**
     * Get activity color based on action
     */
    public function getColorAttribute(): string
    {
        return match($this->action) {
            'create' => 'blue',
            'update' => 'indigo',
            'delete' => 'red',
            'approve' => 'emerald',
            'reject' => 'red',
            'enroll' => 'emerald',
            'unenroll' => 'amber',
            default => 'slate',
        };
    }
}
