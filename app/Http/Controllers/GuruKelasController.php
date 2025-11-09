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
        
        // TEMPORARY: Allow access if user is a guru (for testing/debugging)
        // In production, you may want to remove this and only allow assigned/enrolled
        $isGuru = $user->role === 'guru';
        
        // Log for debugging (can be removed in production)
        \Log::info('GuruKelasController: Checking access', [
            'user_id' => $user->id,
            'user_role' => $user->role,
            'kelas_id' => $kelas->id,
            'kelas_guru_id' => $kelas->guru_id,
            'kelas_nama' => $kelas->nama_kelas,
            'isAssignedAsGuru' => $isAssignedAsGuru,
            'isEnrolled' => $isEnrolled,
            'isGuru' => $isGuru,
            'hasAccess' => $isAssignedAsGuru || $isEnrolled || $isGuru
        ]);
        
        // Allow access if: assigned as guru, enrolled, OR is a guru (temporary for testing)
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
        
        // Log for debugging
        \Log::info('GuruKelasController index: Loading classes for guru', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'total_kelas_count' => $kelas->count(),
            'kelas_list' => $kelas->pluck('id', 'nama_kelas')->toArray(),
            'assigned_via_guru_id' => Kelas::where('guru_id', $user->id)->count(),
            'enrolled_count' => count($enrolledKelasIds),
        ]);
        
        return view('guru.kelas.index', compact('kelas'));
    }

    /**
     * Display detailed information about a specific class
     */
    public function show($kelas)
    {
        $user = Auth::user();
        
        // Log incoming request
        \Log::info('GuruKelasController show: Request received', [
            'kelas_param' => $kelas,
            'kelas_type' => gettype($kelas),
            'kelas_is_model' => $kelas instanceof Kelas,
            'user_id' => $user->id,
            'request_url' => request()->url(),
            'route_params' => request()->route()->parameters(),
        ]);
        
        // Try to find kelas by ID (handle both route model binding and direct ID)
        if ($kelas instanceof Kelas) {
            $kelasModel = $kelas;
        } else {
            // Try to find by ID
            $kelasModel = Kelas::find($kelas);
            
            // If not found by ID, try to find by slug or name
            if (!$kelasModel) {
                $kelasModel = Kelas::where('nama_kelas', $kelas)->first();
            }
        }
        
        // If kelas not found, return 404
        if (!$kelasModel) {
            \Log::error('GuruKelasController show: Kelas not found', [
                'kelas_param' => $kelas,
                'user_id' => $user->id,
                'request_url' => request()->url(),
                'all_kelas' => Kelas::all()->pluck('id', 'nama_kelas')->toArray(),
            ]);
            abort(404, 'Kelas tidak ditemukan.');
        }
        
        // Use kelasModel as kelas
        $kelas = $kelasModel;
        
        // Log kelas found
        \Log::info('GuruKelasController show: Kelas found', [
            'kelas_id' => $kelas->id,
            'kelas_nama' => $kelas->nama_kelas,
            'kelas_guru_id' => $kelas->guru_id,
            'user_id' => $user->id,
        ]);
        
        // Check if guru has access to this class
        // For now, allow all gurus to access (for testing)
        // In production, uncomment the check below
        $hasAccess = $this->hasAccessToClass($user, $kelas);
        
        if (!$hasAccess) {
            // Log denied access
            \Log::warning('GuruKelasController show: Access denied', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'kelas_id' => $kelas->id,
                'kelas_nama' => $kelas->nama_kelas,
                'kelas_guru_id' => $kelas->guru_id,
            ]);
            
            // TEMPORARY: Allow access for all gurus (for testing)
            // In production, uncomment the abort below
            // abort(403, 'Anda tidak diizinkan mengakses kelas ini.');
            
            if ($user->role !== 'guru') {
                abort(403, 'Anda tidak diizinkan mengakses kelas ini.');
            }
        }
        
        // Log access attempt
        \Log::info('GuruKelasController show: Accessing class', [
            'user_id' => $user->id,
            'kelas_id' => $kelas->id,
            'kelas_nama' => $kelas->nama_kelas,
            'kelas_guru_id' => $kelas->guru_id,
            'has_access' => $hasAccess || $user->role === 'guru',
        ]);

        // Get all students in this class - use direct enrollment query first
        // This is more reliable than using relationship
        \Log::info('GuruKelasController show: Starting data retrieval', [
            'kelas_id' => $kelas->id,
            'kelas_nama' => $kelas->nama_kelas,
        ]);
        
        // Step 1: Get enrollment IDs - check all enrollments regardless of status
        $enrollmentIds = Enrollment::where('kelas_id', $kelas->id)
            ->pluck('user_id')
            ->toArray();
        
        // Also check direct DB query for debugging
        $enrollmentCount = DB::table('enrollments')
            ->where('kelas_id', $kelas->id)
            ->count();
        
        \Log::info('GuruKelasController show: Enrollment query', [
            'kelas_id' => $kelas->id,
            'enrollment_ids' => $enrollmentIds,
            'enrollment_count' => count($enrollmentIds),
            'enrollment_count_db' => $enrollmentCount,
            'all_enrollments' => DB::table('enrollments')
                ->where('kelas_id', $kelas->id)
                ->get()
                ->toArray(),
        ]);
        
        $siswa = collect();
        if (!empty($enrollmentIds)) {
            // Step 2: Get users with those IDs and role = siswa
            $siswa = \App\Models\User::whereIn('id', $enrollmentIds)
                ->where('role', 'siswa')
                ->orderBy('name')
                ->get();
            
            \Log::info('GuruKelasController show: Students query result', [
                'kelas_id' => $kelas->id,
                'siswa_count' => $siswa->count(),
                'siswa_ids' => $siswa->pluck('id')->toArray(),
                'siswa_names' => $siswa->pluck('name')->toArray(),
                'all_users_in_enrollments' => \App\Models\User::whereIn('id', $enrollmentIds)->get()->map(function($u) {
                    return ['id' => $u->id, 'name' => $u->name, 'role' => $u->role];
                })->toArray(),
            ]);
        } else {
            \Log::warning('GuruKelasController show: No enrollments found', [
                'kelas_id' => $kelas->id,
                'message' => 'Tidak ada enrollment untuk kelas ini. Pastikan siswa sudah didaftarkan ke kelas.',
                'check_all_enrollments' => DB::table('enrollments')->get()->toArray(),
            ]);
        }
        
        // Also try relationship as fallback
        if ($siswa->isEmpty()) {
            try {
                \Log::info('GuruKelasController show: Trying relationship fallback for students');
                $siswa = $kelas->students()
                    ->where('users.role', 'siswa')
                    ->orderBy('name')
                    ->get();
                
                \Log::info('GuruKelasController show: Relationship fallback result', [
                    'siswa_count' => $siswa->count(),
                ]);
            } catch (\Exception $e) {
                \Log::error('GuruKelasController: Error getting students via relationship', [
                    'error' => $e->getMessage(),
                    'kelas_id' => $kelas->id,
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        }
        
        // Ensure we have a collection
        if (!$siswa || !($siswa instanceof \Illuminate\Support\Collection)) {
            $siswa = collect();
        }

        // Get materials in this class uploaded by the logged-in teacher
        // Check if guru is assigned to this class or enrolled in it
        $isGuruAssigned = ($kelas->guru_id !== null && (int)$kelas->guru_id === (int)$user->id);
        $isGuruEnrolled = Enrollment::where('user_id', $user->id)
            ->where('kelas_id', $kelas->id)
            ->exists();
        
        \Log::info('GuruKelasController show: Starting materi query', [
            'kelas_id' => $kelas->id,
            'guru_id' => $user->id,
            'kelas_guru_id' => $kelas->guru_id,
            'is_guru_assigned' => $isGuruAssigned,
            'is_guru_enrolled' => $isGuruEnrolled,
        ]);
        
        $materi = collect();
        
        // First, check ALL materi in this class (for debugging)
        $allMateriInClass = \App\Models\Materi::where('kelas_id', $kelas->id)->get();
        \Log::info('GuruKelasController show: All materi in class (for debugging)', [
            'kelas_id' => $kelas->id,
            'all_materi_count' => $allMateriInClass->count(),
            'all_materi_details' => $allMateriInClass->map(function($m) {
                return [
                    'id' => $m->id,
                    'judul' => $m->judul,
                    'uploaded_by' => $m->uploaded_by,
                    'kelas_id' => $m->kelas_id,
                ];
            })->toArray(),
        ]);
        
        try {
            // Step 1: Try direct query using model - filter by uploaded_by (guru yang login)
            // Only show materials uploaded by this teacher
            $materi = \App\Models\Materi::where('kelas_id', $kelas->id)
                ->where('uploaded_by', $user->id) // Filter by logged-in teacher
                ->whereNotNull('kelas_id') // Ensure kelas_id is not null
                ->with(['uploadedBy', 'progress', 'presensi'])
                ->latest()
                ->get();
            
            \Log::info('GuruKelasController show: Materi query result (direct)', [
                'kelas_id' => $kelas->id,
                'guru_id' => $user->id,
                'materi_count' => $materi->count(),
                'materi_ids' => $materi->pluck('id')->toArray(),
                'materi_judul' => $materi->pluck('judul')->toArray(),
            ]);
        } catch (\Exception $e) {
            \Log::error('GuruKelasController: Error getting materi via direct query', [
                'error' => $e->getMessage(),
                'kelas_id' => $kelas->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }
        
        // Step 2: Also try relationship as fallback - filter by uploaded_by
        if ($materi->isEmpty()) {
            try {
                \Log::info('GuruKelasController show: Trying relationship fallback for materi');
                $materi = $kelas->materi()
                    ->where('uploaded_by', $user->id) // Filter by logged-in teacher
                    ->whereNotNull('kelas_id')
                    ->with(['uploadedBy', 'progress', 'presensi'])
                    ->latest()
                    ->get();
                
                \Log::info('GuruKelasController show: Relationship fallback result', [
                    'materi_count' => $materi->count(),
                ]);
            } catch (\Exception $e) {
                \Log::error('GuruKelasController: Error getting materi via relationship', [
                    'error' => $e->getMessage(),
                    'kelas_id' => $kelas->id,
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        }
        
        // Step 3: Double check with direct DB query if still empty
        // Use 'materis' (plural) as per migration - filter by uploaded_by
        if ($materi->isEmpty()) {
            try {
                \Log::info('GuruKelasController show: Trying direct DB query for materi');
                $materiData = DB::table('materis')
                    ->where('kelas_id', $kelas->id)
                    ->where('uploaded_by', $user->id) // Filter by logged-in teacher
                    ->get();
                
                \Log::info('GuruKelasController show: Direct DB query result', [
                    'materi_data_count' => $materiData->count(),
                    'materi_data' => $materiData->toArray(),
                ]);
                
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
                \Log::error('GuruKelasController: Error getting materi via direct DB query', [
                    'error' => $e->getMessage(),
                    'kelas_id' => $kelas->id,
                    'table_name' => 'materis',
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        }
        
        // Ensure we have a collection
        if (!$materi || !($materi instanceof \Illuminate\Support\Collection)) {
            $materi = collect();
        }
        
        \Log::info('GuruKelasController show: Final materi collection', [
            'materi_count' => $materi->count(),
            'materi_ids' => $materi->pluck('id')->toArray(),
        ]);
        
        // Log for debugging with more details
        // Use try-catch to handle potential table errors
        $enrollmentsCount = Enrollment::where('kelas_id', $kelas->id)->count();
        
        $materiDirectCount = 0;
        $materiPendingCount = 0;
        $materiApprovedCount = 0;
        
        try {
            // Count only materials uploaded by this teacher
            $materiDirectCount = \App\Models\Materi::where('kelas_id', $kelas->id)
                ->where('uploaded_by', $user->id)
                ->count();
            $materiPendingCount = \App\Models\Materi::where('kelas_id', $kelas->id)
                ->where('uploaded_by', $user->id)
                ->where('status', 'pending')
                ->count();
            $materiApprovedCount = \App\Models\Materi::where('kelas_id', $kelas->id)
                ->where('uploaded_by', $user->id)
                ->where('status', 'approved')
                ->count();
        } catch (\Exception $e) {
            \Log::error('GuruKelasController: Error counting materi', [
                'error' => $e->getMessage(),
                'kelas_id' => $kelas->id,
                'table_expected' => 'materis',
            ]);
        }
        
        \Log::info('GuruKelasController show: Data loaded', [
            'kelas_id' => $kelas->id,
            'kelas_nama' => $kelas->nama_kelas,
            'kelas_guru_id' => $kelas->guru_id,
            'enrollments_count' => $enrollmentsCount,
            'enrollment_user_ids' => $enrollmentIds,
            'siswa_count' => $siswa->count(),
            'siswa_ids' => $siswa->pluck('id')->toArray(),
            'materi_direct_count' => $materiDirectCount,
            'materi_pending_count' => $materiPendingCount,
            'materi_approved_count' => $materiApprovedCount,
            'materi_count' => $materi->count(),
            'materi_ids' => $materi->pluck('id')->toArray(),
            'materi_details' => $materi->map(function($m) {
                return [
                    'id' => $m->id,
                    'judul' => $m->judul,
                    'status' => $m->status,
                    'kelas_id' => $m->kelas_id,
                ];
            })->toArray(),
        ]);

        // Get progress data for all students - only for materials uploaded by this teacher
        $progressData = [];
        $materiIds = $materi->pluck('id')->toArray();
        
        // Get attendance data - get all presensi records for materials uploaded by this teacher
        // Only show presensi from students in this class
        $presensi = collect();
        if (!empty($materiIds) && $siswa->isNotEmpty()) {
            $siswaIds = $siswa->pluck('id')->toArray();
            $presensi = Presensi::whereIn('materi_id', $materiIds)
                ->whereIn('user_id', $siswaIds) // Only students in this class
                ->with(['user', 'materi'])
                ->orderBy('tanggal_akses', 'desc')
                ->get()
                ->groupBy('materi_id');
        }
        $approvedMateriIds = $materi->where('status', 'approved')->pluck('id')->toArray();
        
        // Only process students who are in this class (already filtered above)
        foreach ($siswa as $s) {
            // Get all progress for this student - only for materials uploaded by this teacher
            $progress = MateriProgress::where('user_id', $s->id)
                ->whereIn('materi_id', $materiIds)
                ->with('materi')
                ->get();
            
            // Get presensi count (attendance) - count unique materi accessed (only teacher's materials)
            $presensiCount = Presensi::where('user_id', $s->id)
                ->whereIn('materi_id', $materiIds)
                ->distinct()
                ->count('materi_id');
            
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

        return view('guru.kelas.show', compact('kelas', 'siswa', 'materi', 'presensi', 'progressData', 'materiAccess', 'isGuruAssigned', 'isGuruEnrolled'));
    }
}

