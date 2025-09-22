<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MateriProgress extends Model
{
    protected $fillable = [
        'user_id',
        'materi_id',
        'current_page',
        'total_pages',
        'progress_percentage',
        'is_completed',
        'last_read_at',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'last_read_at' => 'datetime',
        'progress_percentage' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function materi(): BelongsTo
    {
        return $this->belongsTo(Materi::class);
    }

    /**
     * Update progress for a specific page
     */
    public function updateProgress(int $currentPage, int $totalPages = null): void
    {
        $this->current_page = $currentPage;
        
        if ($totalPages) {
            $this->total_pages = $totalPages;
            $this->progress_percentage = round(($currentPage / $totalPages) * 100, 2);
            $this->is_completed = $currentPage >= $totalPages;
        }
        
        $this->last_read_at = now();
        $this->save();
    }

    /**
     * Mark as completed
     */
    public function markAsCompleted(): void
    {
        $this->is_completed = true;
        $this->progress_percentage = 100.00;
        $this->last_read_at = now();
        $this->save();
    }
}
