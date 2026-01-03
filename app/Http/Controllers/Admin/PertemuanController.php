<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Pertemuan;
use App\Models\Presensi;
use App\Models\Enrollment;
use App\Models\User;
use App\Notifications\SessionQuotaReminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PertemuanController extends Controller
{
    /**
     * Show class selection before managing pertemuan & absen.
     */
    public function selectKelas()
    {
        $kelasList = Kelas::with(['guru', 'pertemuan' => function ($q) {
            $q->withCount('presensi');
        }])->orderByDesc('created_at')->get();

        // Compute simple stats per class
        $kelasStats = $kelasList->mapWithKeys(function ($k) {
            $totalPertemuan = $k->pertemuan->count();
            $totalAbsen = $k->pertemuan->sum('presensi_count');
            $avgAbsen = $totalPertemuan > 0 ? round($totalAbsen / $totalPertemuan) : 0;

            return [
                $k->id => [
                    'total_pertemuan' => $totalPertemuan,
                    'total_absen' => $totalAbsen,
                    'avg_absen' => $avgAbsen,
                ],
            ];
        });

        return view('admin.pertemuan.select-kelas', [
            'kelasList' => $kelasList,
            'kelasStats' => $kelasStats,
        ]);
    }

    /**
     * Display a listing of all pertemuan for a class (Admin can see all)
     */
    public function index(Kelas $kelas)
    {
        // Admin has access to all classes and can view all pertemuan
        $pertemuans = Pertemuan::where('kelas_id', $kelas->id)
            ->orderBy('tanggal_pertemuan', 'desc')
            ->orderBy('waktu_mulai', 'desc')
            ->with('guru')
            ->withCount('presensi')
            ->paginate(10);

        return view('admin.pertemuan.index', compact('kelas', 'pertemuans'));
    }

    /**
     * Show the form for creating a new pertemuan
     */
    public function create(Kelas $kelas)
    {
        // Get available gurus for this class
        $guru = User::where('role', 'guru');
        
        // If class has assigned guru, prioritize it
        if ($kelas->guru_id) {
            $guru = $guru->orWhere('id', $kelas->guru_id);
        }
        
        $guru = $guru->orderBy('name')->get();

        return view('admin.pertemuan.create', compact('kelas', 'guru'));
    }

    /**
     * Store a newly created pertemuan
     */
    public function store(Request $request, Kelas $kelas)
    {
        $validated = $request->validate([
            'guru_id' => 'required|exists:users,id',
            'judul_pertemuan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_pertemuan' => 'required|date',
            'waktu_mulai' => 'nullable|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i|after:waktu_mulai',
            'materi' => 'nullable|string|max:255',
        ]);

        $pertemuan = Pertemuan::create([
            'kelas_id' => $kelas->id,
            'guru_id' => $validated['guru_id'],
            'judul_pertemuan' => $validated['judul_pertemuan'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'tanggal_pertemuan' => $validated['tanggal_pertemuan'],
            'waktu_mulai' => $validated['waktu_mulai'] ?? null,
            'waktu_selesai' => $validated['waktu_selesai'] ?? null,
            'materi' => $validated['materi'] ?? null,
        ]);

        return redirect()->route('admin.pertemuan.show', ['kelas' => $kelas->id, 'pertemuan' => $pertemuan->id])
            ->with('success', 'Pertemuan berhasil dibuat. Silakan input absen siswa.');
    }

    /**
     * Display the specified pertemuan and show absen form
     * Admin can access all pertemuan regardless of kelas - NO CHECKS!
     */
    public function show(Kelas $kelas, Pertemuan $pertemuan)
    {
        // No checks - admin can access any pertemuan from any kelas URL

        // Get all students enrolled in this class
        $enrollmentIds = Enrollment::where('kelas_id', $kelas->id)
            ->pluck('user_id')
            ->toArray();

        $siswa = User::whereIn('id', $enrollmentIds)
            ->where('role', 'siswa')
            ->select('id', 'name', 'email', 'student_id', 'id_siswa', 'role')
            ->orderBy('name')
            ->get();

        // Get existing presensi for this pertemuan
        $presensi = Presensi::where('pertemuan_id', $pertemuan->id)
            ->get()
            ->keyBy('user_id');

        return view('admin.pertemuan.show', compact('kelas', 'pertemuan', 'siswa', 'presensi'));
    }

    /**
     * Store absen for a pertemuan (Admin can input for any teacher's pertemuan)
     */
    public function storeAbsen(Request $request, Kelas $kelas, Pertemuan $pertemuan)
    {
        if ($pertemuan->kelas_id !== $kelas->id) {
            abort(403, 'Anda tidak diizinkan mengakses pertemuan ini.');
        }

        $validated = $request->validate([
            'absen' => 'required|array',
            'absen.*.user_id' => 'required|exists:users,id',
            'absen.*.status_kehadiran' => 'required|in:hadir,izin,sakit,alpha',
        ]);

        $created = 0;
        $updated = 0;
        $touchedUserIds = [];

        foreach ($validated['absen'] as $absenData) {
            $existingPresensi = Presensi::where('pertemuan_id', $pertemuan->id)
                ->where('user_id', $absenData['user_id'])
                ->first();

            if ($existingPresensi) {
                $existingPresensi->update([
                    'status_kehadiran' => $absenData['status_kehadiran'],
                    'tanggal_akses' => now(),
                ]);
                $updated++;
            } else {
                Presensi::create([
                    'pertemuan_id' => $pertemuan->id,
                    'user_id' => $absenData['user_id'],
                    'materi_id' => null,
                    'status_kehadiran' => $absenData['status_kehadiran'],
                    'tanggal_akses' => now(),
                ]);
                $created++;
            }

            $touchedUserIds[] = (int) $absenData['user_id'];
        }

        // Sync session progress and send quota reminders
        foreach (array_unique($touchedUserIds) as $touchedUserId) {
            $enrollment = Enrollment::where('user_id', $touchedUserId)
                ->where('kelas_id', $kelas->id)
                ->first();

            if (!$enrollment) {
                continue;
            }

            $progress = $enrollment->syncSessionProgress(1);

            if (
                $progress['target']
                && $progress['remaining'] === 1
                && $enrollment->needsQuotaReminder(1)
            ) {
                if ($enrollment->user) {
                    $enrollment->user->notify(new SessionQuotaReminder($enrollment, $progress['remaining'], $progress['target']));
                }

                if ($kelas->guru) {
                    $kelas->guru->notify(new SessionQuotaReminder($enrollment, $progress['remaining'], $progress['target']));
                }

                $enrollment->markQuotaNotified();
            }
        }

        $message = "Absen berhasil disimpan. {$created} siswa baru, {$updated} siswa diperbarui.";
        
        return redirect()->route('admin.pertemuan.show', ['kelas' => $kelas->id, 'pertemuan' => $pertemuan->id])
            ->with('success', $message);
    }

    /**
     * Show the form for editing the specified pertemuan
     * Admin can edit all pertemuan regardless of kelas - NO CHECKS!
     */
    public function edit(Kelas $kelas, Pertemuan $pertemuan)
    {
        // No checks - admin can edit any pertemuan from any kelas URL

        // Get available gurus for assignment
        $guru = User::where('role', 'guru')
            ->orderBy('name')
            ->get();

        return view('admin.pertemuan.edit', compact('kelas', 'pertemuan', 'guru'));
    }

    /**
     * Update the specified pertemuan
     * Admin can update all pertemuan regardless of kelas - NO CHECKS!
     */
    public function update(Request $request, Kelas $kelas, Pertemuan $pertemuan)
    {
        // No checks - admin can update any pertemuan from any kelas URL

        $validated = $request->validate([
            'guru_id' => 'required|exists:users,id',
            'judul_pertemuan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_pertemuan' => 'required|date',
            'waktu_mulai' => 'nullable|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i|after:waktu_mulai',
            'materi' => 'nullable|string|max:255',
        ]);

        $pertemuan->update($validated);

        return redirect()->route('admin.pertemuan.show', ['kelas' => $kelas->id, 'pertemuan' => $pertemuan->id])
            ->with('success', 'Pertemuan berhasil diperbarui.');
    }

    /**
     * Remove the specified pertemuan
     * Admin can delete all pertemuan regardless of kelas
     */
    public function destroy(Kelas $kelas, Pertemuan $pertemuan)
    {
        // No check needed - admin can delete from any kelas URL

        $pertemuan->delete();

        return redirect()->route('admin.pertemuan.index', $kelas->id)
            ->with('success', 'Pertemuan berhasil dihapus.');
    }

    /**
     * Show detailed attendance records for a pertemuan
     * Admin can access all attendance regardless of kelas - NO CHECKS!
     */
    public function absenDetail(Request $request, Kelas $kelas, Pertemuan $pertemuan)
    {
        // No checks - admin can access any attendance from any kelas URL

        // Get all students in the class
        $siswa = Enrollment::where('kelas_id', $kelas->id)
            ->pluck('user_id')
            ->toArray();
        $siswa = User::whereIn('id', $siswa)
            ->where('role', 'siswa')
            ->select('id', 'name', 'email', 'student_id', 'id_siswa', 'role')
            ->orderBy('name')
            ->get();

        // Get attendance for this pertemuan
        $presensi = Presensi::where('pertemuan_id', $pertemuan->id)
            ->with('user')
            ->orderBy('status_kehadiran', 'asc')
            ->orderBy('tanggal_akses', 'desc')
            ->get();

        // Group presensi by status
        $hadirList = $presensi->where('status_kehadiran', 'hadir')->values();
        $izinList = $presensi->where('status_kehadiran', 'izin')->values();
        $sakitList = $presensi->where('status_kehadiran', 'sakit')->values();
        $alphaList = $presensi->where('status_kehadiran', 'alpha')->values();

        return view('admin.pertemuan.absen-detail', compact(
            'kelas',
            'pertemuan',
            'siswa',
            'presensi',
            'hadirList',
            'izinList',
            'sakitList',
            'alphaList'
        ));
    }

    /**
     * Display individual student progress for admin review.
     */
    public function studentProgress(Request $request, Kelas $kelas, User $siswa)
    {
        $enrollment = Enrollment::where('kelas_id', $kelas->id)
            ->where('user_id', $siswa->id)
            ->firstOrFail();

        $pertemuans = Pertemuan::where('kelas_id', $kelas->id)
            ->orderBy('tanggal_pertemuan')
            ->orderBy('waktu_mulai')
            ->with('guru')
            ->get();

        $presensiList = Presensi::where('user_id', $siswa->id)
            ->whereIn('pertemuan_id', $pertemuans->pluck('id'))
            ->get()
            ->keyBy('pertemuan_id');

        $learningLog = [];
        foreach ($pertemuans as $index => $pertemuan) {
            $presensi = $presensiList->get($pertemuan->id);

            $learningLog[] = [
                'number' => $index + 1,
                'pertemuan' => $pertemuan,
                'presensi' => $presensi,
                'tanggal_belajar' => $pertemuan->tanggal_pertemuan,
                'nama_mentor' => $pertemuan->guru ? $pertemuan->guru->name : 'Tidak diketahui',
                'materi' => $pertemuan->materi,
                'status_kehadiran' => $presensi ? $presensi->status_kehadiran : null,
            ];
        }

        return view('admin.siswa.progress', compact(
            'kelas',
            'siswa',
            'enrollment',
            'learningLog'
        ));
    }
}

