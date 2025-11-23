<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materi extends Model
{
    use HasFactory, SoftDeletes;

    // Explicitly set table name to match migration
    protected $table = 'materis';

    protected $fillable = [
        'judul',
        'deskripsi',
        'file_path',
        'file_type',
        'kelas_id',
        'status',
        'uploaded_by',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class);
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function progress()
    {
        return $this->hasMany(MateriProgress::class);
    }

    public function userProgress($userId)
    {
        return $this->progress()->where('user_id', $userId)->first();
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isVideoLink()
    {
        return $this->file_type === 'video' && filter_var($this->file_path, FILTER_VALIDATE_URL);
    }

    public function getYoutubeVideoIdAttribute()
    {
        if (!$this->isVideoLink() || empty($this->file_path)) {
            return null;
        }

        $url = $this->file_path;

        if (preg_match('/youtu\.be\/([^?]+)/', $url, $matches)) {
            return $matches[1];
        }

        if (preg_match('/youtube\.com\/(?:embed|shorts)\/([^?]+)/', $url, $matches)) {
            return $matches[1];
        }

        $query = parse_url($url, PHP_URL_QUERY);
        if ($query) {
            parse_str($query, $params);
            if (!empty($params['v'])) {
                return $params['v'];
            }
        }

        return null;
    }

    public function getYoutubeEmbedUrlAttribute()
    {
        if (!$this->isVideoLink()) {
            return null;
        }

        $videoId = $this->youtube_video_id;
        if ($videoId) {
            return 'https://www.youtube.com/embed/' . $videoId;
        }

        return $this->file_path;
    }

    /**
     * Retrieve the model for route model binding.
     * This ensures route model binding works correctly.
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? $this->getRouteKeyName(), $value)->first();
    }
}
