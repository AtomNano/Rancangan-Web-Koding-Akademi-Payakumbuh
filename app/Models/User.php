<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'id_siswa',
        'kode_admin',
        'kode_guru',
        'tanggal_pendaftaran',
        'sekolah',
        'bidang_ajar',
        'hari_belajar',
        'durasi',
        'metode_pembayaran',
        'biaya_pendaftaran',
        'biaya_angsuran',
        'total_biaya',
        'status_promo',
        'discount_type',
        'discount_value',
        'total_setelah_diskon',
        'no_telepon',
        'alamat',
        'tanggal_lahir',
        'jenis_kelamin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'tanggal_pendaftaran' => 'date',
            'tanggal_lahir' => 'date',
            'hari_belajar' => 'array',
            'bidang_ajar' => 'array',
            'biaya_pendaftaran' => 'decimal:2',
            'biaya_angsuran' => 'decimal:2',
            'total_biaya' => 'decimal:2',
            'discount_value' => 'decimal:2',
            'total_setelah_diskon' => 'decimal:2',
        ];
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class);
    }

    public function materiProgress()
    {
        return $this->hasMany(MateriProgress::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isGuru()
    {
        return $this->role === 'guru';
    }

    public function isSiswa()
    {
        return $this->role === 'siswa';
    }

    public function enrolledClasses()
    {
        return $this->belongsToMany(Kelas::class, 'enrollments', 'user_id', 'kelas_id')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    /**
     * Get the user's active status, considering their role and enrollment duration.
     *
     * @return bool
     */
    public function getIsActiveAttribute()
    {
        // Admins and teachers are always considered active.
        if (!$this->isSiswa()) {
            return true;
        }

        $enrollments = $this->enrollments()
            ->whereIn('status', ['active', 'expiring'])
            ->get();

        if ($enrollments->isEmpty()) {
            return false;
        }

        foreach ($enrollments as $enrollment) {
            // If quota-based, ensure there are remaining sessions
            $target = $enrollment->calculateTargetSessions();
            $attended = $enrollment->sessions_attended ?? 0;

            if ($target) {
                if ($attended < $target) {
                    return true;
                }
                continue;
            }

            // Fallback to date-based expiration when no target is defined
            $expirationDate = $enrollment->getExpirationDate();

            if (!$expirationDate || \Carbon\Carbon::now()->lte($expirationDate)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Generate ID Siswa otomatis dengan format: NNN-KK-MMYYYY
     * KK  = kode kelas numerik berurutan (berdasar id kelas, 2 digit)
     * NNN = nomor urut siswa 3 digit per bulan per kelas
     * Contoh: 001-01-122025
     */
    public static function generateIdSiswa($kelasId = null)
    {
        $now = \Carbon\Carbon::now();
        $monthYear = $now->format('mY');

        // Gunakan kode kelas numerik berurutan berdasarkan id kelas (zero-padded 3 digit)
        $kelasCode = '00';
        if ($kelasId) {
            $kelas = Kelas::find($kelasId);
            if ($kelas) {
                $kelasCode = str_pad((string) $kelas->id, 2, '0', STR_PAD_LEFT);
            }
        }

        // Hitung jumlah siswa yang sudah terdaftar di bulan/tahun ini dengan kode kelas yang sama
        $count = User::where('role', 'siswa')
            ->where('id_siswa', 'like', "%-{$kelasCode}-{$monthYear}")
            ->count();

        // Format nomor urut dengan leading zero (3 digit)
        $nextNumber = str_pad($count + 1, 3, '0', STR_PAD_LEFT);

        return "{$nextNumber}-{$kelasCode}-{$monthYear}";
    }

    /**
     * Generate kode Admin otomatis
     * Format: ADMIN-NNNN (Contoh: ADMIN-0001)
     */
    public static function generateKodeAdmin()
    {
        $count = User::where('role', 'admin')->whereNotNull('kode_admin')->count();
        $nextNumber = str_pad($count + 1, 4, '0', STR_PAD_LEFT);
        return "ADMIN-{$nextNumber}";
    }

    /**
     * Generate kode Guru otomatis
     * Format: GURU-NNNN (Contoh: GURU-0001)
     */
    public static function generateKodeGuru()
    {
        $count = User::where('role', 'guru')->whereNotNull('kode_guru')->count();
        $nextNumber = str_pad($count + 1, 4, '0', STR_PAD_LEFT);
        return "GURU-{$nextNumber}";
    }
}
