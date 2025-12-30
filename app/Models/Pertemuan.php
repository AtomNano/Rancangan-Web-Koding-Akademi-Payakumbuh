<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertemuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kelas_id',
        'judul_pertemuan',
        'deskripsi',
        'tanggal_pertemuan',
        'waktu_mulai',
        'waktu_selesai',
        'guru_id',
        'materi_id',
        'materi',
    ];

    protected $casts = [
        'tanggal_pertemuan' => 'date',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'materi_id');
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class);
    }

    public function siswa()
    {
        return $this->hasManyThrough(User::class, Presensi::class, 'pertemuan_id', 'id', 'id', 'user_id')
            ->where('users.role', 'siswa')
            ->distinct();
    }
}
