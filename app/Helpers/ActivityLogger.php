<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    /**
     * Log an activity
     */
    public static function log(string $action, string $description, $model = null, ?array $oldValues = null, ?array $newValues = null): ?ActivityLog
    {
        $user = Auth::user();
        
        if (!$user) {
            return null;
        }

        return ActivityLog::create([
            'user_id' => $user->id,
            'action' => $action,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model ? $model->id : null,
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    /**
     * Log user creation
     */
    public static function logUserCreated($user): ?ActivityLog
    {
        return self::log(
            'create',
            "Membuat pengguna baru: {$user->name} ({$user->email}) dengan role {$user->role}",
            $user
        );
    }

    /**
     * Log user update
     */
    public static function logUserUpdated($user, ?array $oldValues = null, ?array $newValues = null): ?ActivityLog
    {
        return self::log(
            'update',
            "Memperbarui pengguna: {$user->name} ({$user->email})",
            $user,
            $oldValues,
            $newValues
        );
    }

    /**
     * Log user deletion
     */
    public static function logUserDeleted($user): ?ActivityLog
    {
        return self::log(
            'delete',
            "Menghapus pengguna: {$user->name} ({$user->email})",
            $user
        );
    }

    /**
     * Log class creation
     */
    public static function logClassCreated($kelas): ?ActivityLog
    {
        return self::log(
            'create',
            "Membuat kelas baru: {$kelas->nama_kelas}",
            $kelas
        );
    }

    /**
     * Log class update
     */
    public static function logClassUpdated($kelas, ?array $oldValues = null, ?array $newValues = null): ?ActivityLog
    {
        return self::log(
            'update',
            "Memperbarui kelas: {$kelas->nama_kelas}",
            $kelas,
            $oldValues,
            $newValues
        );
    }

    /**
     * Log class deletion
     */
    public static function logClassDeleted($kelas): ?ActivityLog
    {
        return self::log(
            'delete',
            "Menghapus kelas: {$kelas->nama_kelas}",
            $kelas
        );
    }

    /**
     * Log material approval
     */
    public static function logMaterialApproved($materi): ?ActivityLog
    {
        $uploaderName = $materi->uploadedBy ? $materi->uploadedBy->name : 'N/A';
        return self::log(
            'approve',
            "Menyetujui materi: {$materi->judul} oleh {$uploaderName}",
            $materi
        );
    }

    /**
     * Log material rejection
     */
    public static function logMaterialRejected($materi): ?ActivityLog
    {
        $uploaderName = $materi->uploadedBy ? $materi->uploadedBy->name : 'N/A';
        return self::log(
            'reject',
            "Menolak materi: {$materi->judul} oleh {$uploaderName}",
            $materi
        );
    }

    /**
     * Log student enrollment
     */
    public static function logStudentEnrolled($kelas, $user): ?ActivityLog
    {
        return self::log(
            'enroll',
            "Mendaftarkan siswa {$user->name} ke kelas {$kelas->nama_kelas}",
            $kelas
        );
    }

    /**
     * Log student unenrollment
     */
    public static function logStudentUnenrolled($kelas, $user): ?ActivityLog
    {
        return self::log(
            'unenroll',
            "Mengeluarkan siswa {$user->name} dari kelas {$kelas->nama_kelas}",
            $kelas
        );
    }

    /**
     * Log backup creation
     */
    public static function logBackupCreated(): ?ActivityLog
    {
        return self::log(
            'create',
            "Membuat cadangan data manual",
            null
        );
    }

    /**
     * Log material reminder sent
     */
    public static function logMaterialReminderSent($materi, $adminUser): ?ActivityLog
    {
        $uploaderName = $materi->uploadedBy ? $materi->uploadedBy->name : 'N/A';
        return self::log(
            'reminder',
            "Admin ({$adminUser->name}) mengirim pengingat verifikasi untuk materi: {$materi->judul} kepada {$uploaderName}",
            $materi
        );
    }
}

