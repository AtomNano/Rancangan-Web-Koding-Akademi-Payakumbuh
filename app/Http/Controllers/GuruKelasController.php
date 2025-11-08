<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Materi;
use App\Models\Presensi;
use App\Models\MateriProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruKelasController extends Controller
{
    /**
     * Display a listing of classes taught by the guru
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get classes where guru is assigned via enrollment OR via guru_id
        $enrolledKelas = $user->enrolledClasses()->withCount('students')->get();
        $assignedKelas = Kelas::where('guru_id', $user->id)->withCount('students')->get();
        
        // Merge and remove duplicates
        $kelas = $enrolledKelas->merge($assignedKelas)->unique('id');
        
        return view('guru.kelas.index', compact('kelas'));
    }

    /**
     * Display detailed information about a specific class
     */
    public function show(Kelas $kelas)
    {
        $user = Auth::user();
        
        // Check if guru is assigned to this class via enrollment OR via guru_id
        $isEnrolled = $user->enrolledClasses->contains($kelas);
        $isAssigned = $kelas->guru_id === $user->id;
        
        if (!$isEnrolled && !$isAssigned) {
            abort(403, 'Anda tidak diizinkan mengakses kelas ini.');
        }

        // Get all students in this class
        $siswa = $kelas->students()
            ->where('users.role', 'siswa')
            ->with(['enrollments' => function($query) use ($kelas) {
                $query->where('kelas_id', $kelas->id);
            }])
            ->get();

        // Get all materials in this class (only materials uploaded by this guru)
        $materi = $kelas->materi()
            ->where('uploaded_by', $user->id)
            ->with(['progress', 'presensi'])
            ->latest()
            ->get();

        // Get attendance data
        $presensi = Presensi::whereIn('materi_id', $materi->pluck('id'))
            ->with(['user', 'materi'])
            ->latest('tanggal_akses')
            ->get()
            ->groupBy('materi_id');

        // Get progress data for all students
        $progressData = [];
        foreach ($siswa as $s) {
            $progressData[$s->id] = [
                'siswa' => $s,
                'progress' => MateriProgress::where('user_id', $s->id)
                    ->whereIn('materi_id', $materi->pluck('id'))
                    ->with('materi')
                    ->get(),
                'presensi_count' => Presensi::where('user_id', $s->id)
                    ->whereIn('materi_id', $materi->pluck('id'))
                    ->count(),
                'completed_materi' => MateriProgress::where('user_id', $s->id)
                    ->whereIn('materi_id', $materi->pluck('id'))
                    ->where('is_completed', true)
                    ->count(),
            ];
        }

        // Get students who accessed each material
        $materiAccess = [];
        foreach ($materi as $m) {
            $materiAccess[$m->id] = [
                'materi' => $m,
                'accessed_by' => Presensi::where('materi_id', $m->id)
                    ->with('user')
                    ->get()
                    ->pluck('user')
                    ->unique('id'),
                'completed_by' => MateriProgress::where('materi_id', $m->id)
                    ->where('is_completed', true)
                    ->with('user')
                    ->get()
                    ->pluck('user')
                    ->unique('id'),
            ];
        }

        return view('guru.kelas.show', compact('kelas', 'siswa', 'materi', 'presensi', 'progressData', 'materiAccess'));
    }
}

