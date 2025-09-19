<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kelas',
        'deskripsi',
        'bidang',
        'status',
    ];

    public function materi()
    {
        return $this->hasMany(Materi::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'kelas_id', 'user_id')
                    ->withPivot('status')
                    ->withTimestamps();
    }
}
