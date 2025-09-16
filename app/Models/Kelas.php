<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    public function materi()
    {
        return $this->hasMany(Materi::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
