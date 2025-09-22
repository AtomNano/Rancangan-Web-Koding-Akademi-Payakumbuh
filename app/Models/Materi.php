<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

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
        return $this->belongsTo(Kelas::class);
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
}
