<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Materi;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    /**
     * Display student dashboard with enrolled classes
     */
    public function dashboard()
    {
        $user = Auth::user();
        $enrolledClasses = $user->enrolledClasses()->withCount('materi')->get();
        
        return view('siswa.dashboard', compact('enrolledClasses'));
    }

    /**
     * Display materials for a specific class
     */
    public function showClass(Kelas $kelas)
    {
        $user = Auth::user();
        
        // Check if student is enrolled in this class
        if (!$user->enrolledClasses->contains($kelas)) {
            abort(403, 'Anda tidak terdaftar di kelas ini.');
        }

        $materi = $kelas->materi()
            ->where('status', 'approved')
            ->with('uploadedBy')
            ->paginate(10);

        return view('siswa.kelas.show', compact('kelas', 'materi'));
    }

    /**
     * Display a specific material
     */
    public function showMateri(Materi $materi)
    {
        $user = Auth::user();
        
        // Check if student is enrolled in the class
        if (!$user->enrolledClasses->contains($materi->kelas)) {
            abort(403, 'Anda tidak terdaftar di kelas ini.');
        }

        // Check if material is approved
        if (!$materi->isApproved()) {
            abort(403, 'Materi belum disetujui oleh admin.');
        }

        // Record attendance
        $this->recordAttendance($user, $materi);

        return view('siswa.materi.show', compact('materi'));
    }

    /**
     * Mark material as completed
     */
    public function completeMateri(Materi $materi)
    {
        $user = Auth::user();
        
        // Check if student is enrolled in the class
        if (!$user->enrolledClasses->contains($materi->kelas)) {
            abort(403, 'Anda tidak terdaftar di kelas ini.');
        }

        // Record completion (you might want to create a separate table for this)
        // For now, we'll just record attendance
        $this->recordAttendance($user, $materi);

        return redirect()->back()
            ->with('success', 'Materi berhasil ditandai sebagai selesai.');
    }

    /**
     * Show student progress for all classes
     */
    public function progress()
    {
        $user = Auth::user();
        $enrolledClasses = $user->enrolledClasses()->with('materi')->get();
        
        $progress = [];
        foreach ($enrolledClasses as $kelas) {
            $totalMateri = $kelas->materi()->where('status', 'approved')->count();
            $completedMateri = $this->getCompletedMateriCount($user, $kelas);
            
            $progress[] = [
                'kelas' => $kelas,
                'total_materi' => $totalMateri,
                'completed_materi' => $completedMateri,
                'percentage' => $totalMateri > 0 ? round(($completedMateri / $totalMateri) * 100, 2) : 0
            ];
        }

        return view('siswa.progress', compact('progress'));
    }

    /**
     * Record attendance for a material
     */
    private function recordAttendance($user, $materi)
    {
        $today = now()->toDateString();
        
        // Check if attendance already recorded for today
        $existingAttendance = Presensi::where('user_id', $user->id)
            ->where('materi_id', $materi->id)
            ->where('tanggal_akses', $today)
            ->first();

        if (!$existingAttendance) {
            Presensi::create([
                'user_id' => $user->id,
                'materi_id' => $materi->id,
                'status_kehadiran' => 'hadir',
                'tanggal_akses' => $today,
            ]);
        }
    }

    /**
     * Get completed materials count for a class
     */
    private function getCompletedMateriCount($user, $kelas)
    {
        // This is a simplified version. In a real application, you might want
        // to create a separate table to track material completion
        return Presensi::where('user_id', $user->id)
            ->whereHas('materi', function($query) use ($kelas) {
                $query->where('kelas_id', $kelas->id);
            })
            ->distinct('materi_id')
            ->count();
    }
}