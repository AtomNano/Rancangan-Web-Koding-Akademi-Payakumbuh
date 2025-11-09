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
            ->with(['uploadedBy', 'progress' => function($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->paginate(10);

        return view('siswa.kelas.show', compact('kelas', 'materi'));
    }

    /**
     * Display a specific material
     */
    public function showMateri($materi)
    {
        $user = Auth::user();
        
        // Handle route model binding or direct ID
        if ($materi instanceof Materi) {
            $materiModel = $materi;
        } else {
            $materiModel = Materi::find($materi);
        }
        
        if (!$materiModel) {
            abort(404, 'Materi tidak ditemukan.');
        }
        
        $materiModel->load(['kelas', 'uploadedBy']);
        
        // Check if student is enrolled in the class
        // Use enrollment check instead of relationship
        $isEnrolled = \App\Models\Enrollment::where('user_id', $user->id)
            ->where('kelas_id', $materiModel->kelas_id)
            ->exists();
        
        if (!$isEnrolled) {
            abort(403, 'Anda tidak terdaftar di kelas ini.');
        }

        // Check if material is approved
        if (!$materiModel->isApproved()) {
            abort(403, 'Materi belum disetujui oleh admin.');
        }

        // Record attendance
        $this->recordAttendance($user, $materiModel);

        return view('siswa.materi.show', ['materi' => $materiModel]);
    }

    /**
     * Mark material as completed
     */
    public function completeMateri($materi)
    {
        $user = Auth::user();
        
        // Handle route model binding or direct ID
        if ($materi instanceof Materi) {
            $materiModel = $materi;
        } else {
            $materiModel = Materi::find($materi);
        }
        
        if (!$materiModel) {
            abort(404, 'Materi tidak ditemukan.');
        }
        
        // Check if student is enrolled in the class
        $isEnrolled = \App\Models\Enrollment::where('user_id', $user->id)
            ->where('kelas_id', $materiModel->kelas_id)
            ->exists();
        
        if (!$isEnrolled) {
            abort(403, 'Anda tidak terdaftar di kelas ini.');
        }

        // Record completion (you might want to create a separate table for this)
        // For now, we'll just record attendance
        $this->recordAttendance($user, $materiModel);

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
            
            // Hitung materi yang sudah selesai berdasarkan MateriProgress
            $completedMateri = \App\Models\MateriProgress::where('user_id', $user->id)
                ->whereHas('materi', function($query) use ($kelas) {
                    $query->where('kelas_id', $kelas->id)->where('status', 'approved');
                })
                ->where('is_completed', true)
                ->count();
            
            // Hitung rata-rata progres dari semua materi yang sudah dibaca
            $progressData = \App\Models\MateriProgress::where('user_id', $user->id)
                ->whereHas('materi', function($query) use ($kelas) {
                    $query->where('kelas_id', $kelas->id)->where('status', 'approved');
                })
                ->get();
            
            $averageProgress = 0;
            if ($progressData->count() > 0) {
                $averageProgress = $progressData->avg('progress_percentage');
            }
            
            // Gunakan rata-rata progres jika ada, jika tidak gunakan persentase materi selesai
            $percentage = $totalMateri > 0 ? 
                ($progressData->count() > 0 ? round($averageProgress, 1) : round(($completedMateri / $totalMateri) * 100, 1)) : 0;
            
            $progress[] = [
                'kelas' => $kelas,
                'total_materi' => $totalMateri,
                'completed_materi' => $completedMateri,
                'percentage' => $percentage,
                'average_progress' => round($averageProgress, 1),
                'materi_with_progress' => $progressData->count()
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