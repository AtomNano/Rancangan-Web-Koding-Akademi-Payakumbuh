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

        // Check if the student has any enrollment record with 'active' status.
        // This is the manual override by the admin.
        $hasActiveEnrollment = $this->enrollments()->where('status', 'active')->exists();

        if (!$hasActiveEnrollment) {
            return false;
        }

        // Now, check if the active period has expired.
        $registrationDate = $this->tanggal_pendaftaran;
        $duration = $this->durasi; // e.g., "3 Bulan", "6 Bulan", "12 Bulan"

        if (!$registrationDate || !$duration) {
            // If essential data is missing, they cannot be active.
            return false;
        }

        // Parse the duration string to get the number of months.
        $months = (int) filter_var($duration, FILTER_SANITIZE_NUMBER_INT);
        if ($months <= 0) {
            return false;
        }

        // Calculate the expiration date.
        $expirationDate = \Carbon\Carbon::parse($registrationDate)->addMonths($months);

        // The user is active if today is before or on the expiration date.
        return \Carbon\Carbon::now()->lte($expirationDate);
    }
}
