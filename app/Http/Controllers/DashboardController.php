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
                    $materi_count = Materi::where('uploaded_by', $user->id)->count();
                    $pending_count = Materi::where('uploaded_by', $user->id)->where('status', 'pending')->count();
                    $approved_count = Materi::where('uploaded_by', $user->id)->where('status', 'approved')->count();
                    
                    $stats = [
                        'total_materi' => $materi_count,
                        'pending_materi' => $pending_count,
                        'approved_materi' => $approved_count,
                    ];
                    return view('guru.dashboard', compact('stats'));
                case 'siswa':
                    return redirect()->route('siswa.dashboard');
                default:
                    return view('dashboard'); // Default dashboard for other roles or no role
            }
        }

        return redirect('/login'); // Redirect to login if no user is authenticated
    }
}
