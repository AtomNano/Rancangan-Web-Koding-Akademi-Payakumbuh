<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'materi_id',
        'status_kehadiran',
        'tanggal_akses',
    ];

    protected $casts = [
        'tanggal_akses' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function materi()
    {
        return $this->belongsTo(Materi::class);
    }

    public function isPresent()
    {
        return $this->status_kehadiran === 'hadir';
    }
}
