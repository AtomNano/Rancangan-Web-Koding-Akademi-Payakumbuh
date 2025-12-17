<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Materi;
use App\Models\Presensi;
use App\Models\MateriProgress;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GuruKelasController extends Controller
{
    /**
     * Check if guru has access to a class
     * Check both guru_id in kelas table AND enrollment in enrollments table
     */
    private function hasAccessToClass($user, $kelas)
    {
        // Check if guru is assigned via guru_id in kelas table
        // Handle null guru_id case
        $isAssignedAsGuru = $kelas->guru_id !== null && (int)$kelas->guru_id === (int)$user->id;
        
        // Check if guru is enrolled in this class
        $isEnrolled = Enrollment::where('user_id', $user->id)
            ->where('kelas_id', $kelas->id)
            ->exists();
        
        $isGuru = $user->role === 'guru';
        
        return $isAssignedAsGuru || $isEnrolled || $isGuru;
    }

    /**
     * Display a listing of classes taught by the guru
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get classes assigned to this guru via guru_id
        $kelas = Kelas::where('guru_id', $user->id)
            ->withCount('students')
            ->with('guru')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Also get classes where guru is enrolled (secondary method)
        $enrolledKelasIds = Enrollment::where('user_id', $user->id)
            ->pluck('kelas_id')
            ->toArray();
        
        if (!empty($enrolledKelasIds)) {
            $enrolledKelas = Kelas::whereIn('id', $enrolledKelasIds)
                ->where('guru_id', '!=', $user->id) // Don't duplicate classes already in $kelas
                ->withCount('students')
                ->with('guru')
                ->orderBy('created_at', 'desc')
                ->get();
            
            // Merge enrolled classes with assigned classes
            $kelas = $kelas->merge($enrolledKelas)->unique('id');
        }
        
        return view('guru.kelas.index', compact('kelas'));
    }

    /**
     * Display detailed information about a specific class
     */
    public function show($kelas)
    {
        $user = Auth::user();
        
        // Try to find kelas by ID (handle both route model binding and direct ID)
        if ($kelas instanceof Kelas) {
            $kelasModel = $kelas;
        } else {
            $kelasModel = Kelas::find($kelas);
            
            if (!$kelasModel) {
                $kelasModel = Kelas::where('nama_kelas', $kelas)->first();
            }
        }
        
        if (!$kelasModel) {
            abort(404, 'Kelas tidak ditemukan.');
        }
        
        $kelas = $kelasModel;
        
        $hasAccess = $this->hasAccessToClass($user, $kelas);
        
        if (!$hasAccess) {
            if ($user->role !== 'guru') {
                abort(403, 'Anda tidak diizinkan mengakses kelas ini.');
            }
        }
        
        // Get enrollment IDs
        $enrollmentIds = Enrollment::where('kelas_id', $kelas->id)
            ->pluck('user_id')
            ->toArray();
        
        $siswa = collect();
        if (!empty($enrollmentIds)) {
            $siswa = \App\Models\User::whereIn('id', $enrollmentIds)
                ->where('role', 'siswa')
                ->orderBy('name')
                ->get();
        }
        
        // Try relationship as fallback
        if ($siswa->isEmpty()) {
            try {
                $siswa = $kelas->students()
                    ->where('users.role', 'siswa')
                    ->orderBy('name')
                    ->get();
            } catch (\Exception $e) {
                // Silent fail
            }
        }
        
        if (!$siswa || !($siswa instanceof \Illuminate\Support\Collection)) {
            $siswa = collect();
        }

        // Get materials in this class uploaded by the logged-in teacher
        $isGuruAssigned = ($kelas->guru_id !== null && (int)$kelas->guru_id === (int)$user->id);
        $isGuruEnrolled = Enrollment::where('user_id', $user->id)
            ->where('kelas_id', $kelas->id)
            ->exists();
        
        $materi = collect();
        
        try {
            $materi = \App\Models\Materi::where('kelas_id', $kelas->id)
                ->where('uploaded_by', $user->id)
                ->whereNotNull('kelas_id')
                ->with(['uploadedBy', 'progress', 'presensi'])
                ->latest()
                ->get();
        } catch (\Exception $e) {
            // Silent fail
        }
        
        // Try relationship as fallback
        if ($materi->isEmpty()) {
            try {
                $materi = $kelas->materi()
                    ->where('uploaded_by', $user->id)
                    ->whereNotNull('kelas_id')
                    ->with(['uploadedBy', 'progress', 'presensi'])
                    ->latest()
                    ->get();
            } catch (\Exception $e) {
                // Silent fail
            }
        }
        
        // Try direct DB query if still empty
        if ($materi->isEmpty()) {
            try {
                $materiData = DB::table('materis')
                    ->where('kelas_id', $kelas->id)
                    ->where('uploaded_by', $user->id)
                    ->get();
                
                if ($materiData->isNotEmpty()) {
                    $materi = collect();
                    foreach ($materiData as $m) {
                        $materiModel = \App\Models\Materi::find($m->id);
                        if ($materiModel) {
                            $materi->push($materiModel);
                        }
                    }
                }
            } catch (\Exception $e) {
                // Silent fail
            }
        }
        
        if (!$materi || !($materi instanceof \Illuminate\Support\Collection)) {
            $materi = collect();
        }

        // Get progress data for all students - only for materials uploaded by this teacher
        $progressData = [];
        $materiIds = $materi->pluck('id')->toArray();
        
        // Get pertemuan IDs for this class
        $pertemuanIds = \App\Models\Pertemuan::where('kelas_id', $kelas->id)
            ->where('guru_id', $user->id)
            ->pluck('id')
            ->toArray();
        
        // Get attendance data - get all presensi records (both from materi and pertemuan)
        // Only show presensi from students in this class
        $presensi = collect();
        if ($siswa->isNotEmpty()) {
            $siswaIds = $siswa->pluck('id')->toArray();
            $allPresensi = [];
            
            // Get presensi from materi
            if (!empty($materiIds)) {
                $allPresensi = Presensi::whereIn('materi_id', $materiIds)
                    ->whereIn('user_id', $siswaIds) // Only students in this class
                    ->with(['user', 'materi'])
                    ->orderBy('tanggal_akses', 'desc')
                    ->get()
                    ->groupBy('materi_id')
                    ->toArray();
            }
            
            // Get presensi from pertemuan
            if (!empty($pertemuanIds)) {
                $pertemuanPresensi = Presensi::whereIn('pertemuan_id', $pertemuanIds)
                    ->whereIn('user_id', $siswaIds) // Only students in this class
                    ->with(['user', 'pertemuan'])
                    ->orderBy('tanggal_akses', 'desc')
                    ->get();
                
                foreach ($pertemuanPresensi as $p) {
                    $key = 'pertemuan_' . $p->pertemuan_id;
                    if (!isset($allPresensi[$key])) {
                        $allPresensi[$key] = [];
                    }
                    $allPresensi[$key][] = $p;
                }
            }
            
            $presensi = collect($allPresensi);
        }
        $approvedMateriIds = $materi->where('status', 'approved')->pluck('id')->toArray();
        
        // Only process students who are in this class (already filtered above)
        foreach ($siswa as $s) {
            // Get all progress for this student - only for materials uploaded by this teacher
            $progress = MateriProgress::where('user_id', $s->id)
                ->whereIn('materi_id', $materiIds)
                ->with('materi')
                ->get();
            
            // Get presensi count (attendance) - count from both materi AND pertemuan
            $presensiCountMateri = Presensi::where('user_id', $s->id)
                ->whereIn('materi_id', $materiIds)
                ->distinct()
                ->count('materi_id');
            
            $presensiCountPertemuan = Presensi::where('user_id', $s->id)
                ->whereIn('pertemuan_id', $pertemuanIds)
                ->count();
            
            $presensiCount = $presensiCountMateri + $presensiCountPertemuan;
            
            // Get completed materi count (only approved materials uploaded by this teacher)
            $completedMateri = MateriProgress::where('user_id', $s->id)
                ->whereIn('materi_id', $approvedMateriIds)
                ->where('is_completed', true)
                ->count();
            
            $progressData[$s->id] = [
                'siswa' => $s,
                'progress' => $progress,
                'presensi_count' => $presensiCount,
                'completed_materi' => $completedMateri,
                'total_materi' => count($approvedMateriIds),
            ];
        }

        // Get students who accessed each material (only for materials uploaded by this teacher)
        $materiAccess = [];
        foreach ($materi as $m) {
            // Get students who accessed this material (filter by students in this class)
            $siswaIds = $siswa->pluck('id')->toArray();
            $accessedPresensi = Presensi::where('materi_id', $m->id)
                ->whereIn('user_id', $siswaIds)
                ->with('user')
                ->get();
            
            $completedProgress = MateriProgress::where('materi_id', $m->id)
                ->whereIn('user_id', $siswaIds)
                ->where('is_completed', true)
                ->with('user')
                ->get();
            
            $materiAccess[$m->id] = [
                'materi' => $m,
                'accessed_by' => $accessedPresensi->pluck('user')->unique('id'),
                'completed_by' => $completedProgress->pluck('user')->unique('id'),
            ];
        }

        // Check if this class is assigned to the logged-in teacher
        $isGuruAssigned = ($kelas->guru_id !== null && (int)$kelas->guru_id === (int)$user->id);
        $isGuruEnrolled = Enrollment::where('user_id', $user->id)
            ->where('kelas_id', $kelas->id)
            ->exists();

        // Calculate total attendance counts from all presensi
        $siswaIds = $siswa->pluck('id')->toArray();
        $totalHadir = 0;
        $totalIzin = 0;
        $totalSakit = 0;
        $totalAlpha = 0;

        if (!empty($siswaIds)) {
            // Count from materi presensi
            if (!empty($materiIds)) {
                $materiPresensi = Presensi::whereIn('materi_id', $materiIds)
                    ->whereIn('user_id', $siswaIds)
                    ->get();

                $totalHadir += $materiPresensi->where('status_kehadiran', 'hadir')->count();
                $totalIzin += $materiPresensi->where('status_kehadiran', 'izin')->count();
                $totalSakit += $materiPresensi->where('status_kehadiran', 'sakit')->count();
                $totalAlpha += $materiPresensi->where('status_kehadiran', 'alpha')->count();
            }

            // Count from pertemuan presensi
            if (!empty($pertemuanIds)) {
                $pertemuanPresensi = Presensi::whereIn('pertemuan_id', $pertemuanIds)
                    ->whereIn('user_id', $siswaIds)
                    ->get();

                $totalHadir += $pertemuanPresensi->where('status_kehadiran', 'hadir')->count();
                $totalIzin += $pertemuanPresensi->where('status_kehadiran', 'izin')->count();
                $totalSakit += $pertemuanPresensi->where('status_kehadiran', 'sakit')->count();
                $totalAlpha += $pertemuanPresensi->where('status_kehadiran', 'alpha')->count();
            }
        }

        return view('guru.kelas.show', compact('kelas', 'siswa', 'materi', 'presensi', 'progressData', 'materiAccess', 'isGuruAssigned', 'isGuruEnrolled', 'totalHadir', 'totalIzin', 'totalSakit', 'totalAlpha', 'pertemuanIds'));
    }
}

