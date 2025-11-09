<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Materi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth facade

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
}
