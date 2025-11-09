<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Materi;
use App\Models\User;
use App\Models\Presensi;
use App\Models\MateriProgress;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user) {
            switch ($user->role) {
                case 'admin':
                    // Student status calculation
                    $all_siswa = User::where('role', 'siswa')->get();
                    [$siswa_aktif, $siswa_tidak_aktif] = $all_siswa->partition(fn ($user) => $user->is_active);

                    $stats = [
                        'total_pengguna' => User::count(),
                        'total_guru' => User::where('role', 'guru')->count(),
                        'total_siswa' => $all_siswa->count(),
                        'siswa_aktif' => $siswa_aktif->count(),
                        'siswa_tidak_aktif' => $siswa_tidak_aktif->count(),
                        'total_kelas' => Kelas::count(),
                        'pending_materi' => Materi::where('status', 'pending')->count(),
                        'materi_aktif' => Materi::where('status', 'approved')->count(),
                    ];
                    $pending_verifications = Materi::where('status', 'pending')->with(['uploadedBy', 'kelas'])->latest()->take(5)->get();

                    return view('admin.dashboard', compact('stats', 'pending_verifications'));
                
                case 'guru':
                    $user = auth()->user();
                    
                    // Get classes assigned to this guru via guru_id
                    $kelas = Kelas::where('guru_id', $user->id)
                        ->withCount('students')
                        ->with('guru')
                        ->orderBy('created_at', 'desc')
                        ->get();
                    
                    // Also get classes where guru is enrolled (secondary method)
                    $enrolledKelasIds = \App\Models\Enrollment::where('user_id', $user->id)
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
                    
                    // Ensure we have a collection
                    if (!$kelas || !($kelas instanceof \Illuminate\Support\Collection)) {
                        $kelas = collect();
                    }
                    
                    $assignedKelasIds = $kelas->pluck('id')->toArray();
                    
                    // Log for debugging
                    \Log::info('DashboardController Guru: Loading classes for guru', [
                        'user_id' => $user->id,
                        'user_email' => $user->email,
                        'total_kelas_count' => $kelas->count(),
                        'kelas_list' => $kelas->pluck('id', 'nama_kelas')->toArray(),
                        'assigned_via_guru_id' => Kelas::where('guru_id', $user->id)->count(),
                        'enrolled_count' => count($enrolledKelasIds),
                    ]);
                    
                    // Calculate stats
                    if (empty($assignedKelasIds)) {
                        $materi_count = 0;
                        $pending_count = 0;
                        $approved_count = 0;
                    } else {
                        $materi_count = Materi::whereIn('kelas_id', $assignedKelasIds)->where('uploaded_by', $user->id)->count();
                        $pending_count = Materi::whereIn('kelas_id', $assignedKelasIds)->where('uploaded_by', $user->id)->where('status', 'pending')->count();
                        $approved_count = Materi::whereIn('kelas_id', $assignedKelasIds)->where('uploaded_by', $user->id)->where('status', 'approved')->count();
                    }
                    
                    $stats = [
                        'total_materi' => $materi_count,
                        'pending_materi' => $pending_count,
                        'approved_materi' => $approved_count,
                    ];
                    
                    // Debug logging
                    \Log::info('DashboardController Guru: Loading ALL classes (NO AUTH CHECK)', [
                        'user_id' => $user->id,
                        'user_email' => $user->email,
                        'user_name' => $user->name,
                        'total_kelas_found' => $kelas->count(),
                        'kelas_details' => $kelas->map(function($k) {
                            return [
                                'id' => $k->id, 
                                'nama' => $k->nama_kelas, 
                                'guru_id' => $k->guru_id, 
                                'status' => $k->status,
                                'students_count' => $k->students_count ?? 0
                            ];
                        })->toArray(),
                    ]);
                    
                    return view('guru.dashboard', compact('stats', 'kelas'));
                case 'siswa':
                    return redirect()->route('siswa.dashboard');
                default:
                    return view('dashboard'); // Default dashboard for other roles or no role
            }
        }

        return redirect('/login'); // Redirect to login if no user is authenticated
    }

    /**
     * Analytics dashboard for admin
     */
    public function analytics()
    {
        // Overall statistics
        $totalSiswa = User::where('role', 'siswa')->count();
        $totalKelas = Kelas::count();
        $totalMateri = Materi::where('status', 'approved')->count();
        
        // Progress statistics
        $totalProgress = MateriProgress::count();
        $completedProgress = MateriProgress::where('is_completed', true)->count();
        $avgProgress = MateriProgress::avg('progress_percentage') ?? 0;
        
        // Attendance statistics
        $totalPresensi = Presensi::count();
        $hadirCount = Presensi::where('status_kehadiran', 'hadir')->count();
        $izinCount = Presensi::where('status_kehadiran', 'izin')->count();
        $sakitCount = Presensi::where('status_kehadiran', 'sakit')->count();
        $alphaCount = Presensi::where('status_kehadiran', 'alpha')->count();
        
        // Progress by class
        $progressByKelas = [];
        $kelasList = Kelas::with('materi')->get();
        foreach ($kelasList as $kelas) {
            $materiIds = $kelas->materi()->where('status', 'approved')->pluck('id');
            $siswaIds = $kelas->students()->where('users.role', 'siswa')->pluck('users.id');
            
            $totalMateriKelas = $materiIds->count();
            $completedCount = MateriProgress::whereIn('materi_id', $materiIds)
                ->whereIn('user_id', $siswaIds)
                ->where('is_completed', true)
                ->distinct('materi_id', 'user_id')
                ->count();
            
            $avgProgressKelas = MateriProgress::whereIn('materi_id', $materiIds)
                ->whereIn('user_id', $siswaIds)
                ->avg('progress_percentage') ?? 0;
            
            $progressByKelas[] = [
                'kelas' => $kelas,
                'total_siswa' => $siswaIds->count(),
                'total_materi' => $totalMateriKelas,
                'completed_count' => $completedCount,
                'avg_progress' => round($avgProgressKelas, 1),
            ];
        }
        
        // Most accessed materials
        $mostAccessedMateri = Presensi::select('materi_id', DB::raw('count(*) as access_count'))
            ->with('materi')
            ->groupBy('materi_id')
            ->orderBy('access_count', 'desc')
            ->limit(10)
            ->get();
        
        // Student progress details
        $studentProgressDetails = [];
        $siswaList = User::where('role', 'siswa')->with('enrolledClasses')->get();
        foreach ($siswaList as $siswa) {
            $enrolledKelasIds = $siswa->enrolledClasses->pluck('id');
            $materiIds = Materi::whereIn('kelas_id', $enrolledKelasIds)
                ->where('status', 'approved')
                ->pluck('id');
            
            $totalMateriSiswa = $materiIds->count();
            $completedMateri = MateriProgress::where('user_id', $siswa->id)
                ->whereIn('materi_id', $materiIds)
                ->where('is_completed', true)
                ->count();
            
            $avgProgressSiswa = MateriProgress::where('user_id', $siswa->id)
                ->whereIn('materi_id', $materiIds)
                ->avg('progress_percentage') ?? 0;
            
            // Attendance stats for this student
            $presensiSiswa = Presensi::where('user_id', $siswa->id)
                ->whereIn('materi_id', $materiIds)
                ->get();
            
            $studentProgressDetails[] = [
                'siswa' => $siswa,
                'total_materi' => $totalMateriSiswa,
                'completed_materi' => $completedMateri,
                'avg_progress' => round($avgProgressSiswa, 1),
                'total_presensi' => $presensiSiswa->count(),
                'hadir' => $presensiSiswa->where('status_kehadiran', 'hadir')->count(),
                'izin' => $presensiSiswa->where('status_kehadiran', 'izin')->count(),
                'sakit' => $presensiSiswa->where('status_kehadiran', 'sakit')->count(),
                'alpha' => $presensiSiswa->where('status_kehadiran', 'alpha')->count(),
            ];
        }
        
        // Recent activity (last 30 days)
        $recentPresensi = Presensi::with(['user', 'materi'])
            ->where('tanggal_akses', '>=', now()->subDays(30))
            ->orderBy('tanggal_akses', 'desc')
            ->limit(20)
            ->get();
        
        return view('admin.analytics', compact(
            'totalSiswa',
            'totalKelas',
            'totalMateri',
            'totalProgress',
            'completedProgress',
            'avgProgress',
            'totalPresensi',
            'hadirCount',
            'izinCount',
            'sakitCount',
            'alphaCount',
            'progressByKelas',
            'mostAccessedMateri',
            'studentProgressDetails',
            'recentPresensi'
        ));
    }
}
