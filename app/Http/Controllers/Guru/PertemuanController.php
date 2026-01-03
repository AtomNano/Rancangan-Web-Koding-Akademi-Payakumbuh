<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Pertemuan;
use App\Models\Presensi;
use App\Models\Enrollment;
use App\Models\Materi;
use App\Models\User;
use App\Notifications\SessionQuotaReminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PertemuanController extends Controller
{
    /**
     * DEPRECATED: All guru can now access all classes for attendance
     * Check if guru has access to a class - NO LONGER USED
     */
    /*
    private function hasAccessToClass($user, $kelas)
    {
        $isAssignedAsGuru = $kelas->guru_id !== null && (int)$kelas->guru_id === (int)$user->id;
        $isEnrolled = Enrollment::where('user_id', $user->id)
            ->where('kelas_id', $kelas->id)
            ->exists();
        return $isAssignedAsGuru || $isEnrolled;
    }
    */

    /**
     * Display a listing of pertemuan for a class
     * All guru can view any class pertemuan
     */
    public function index(Kelas $kelas)
    {
        // Tampilkan semua pertemuan di kelas ini (tidak hanya yang dibuat oleh guru login)
        $pertemuans = Pertemuan::where('kelas_id', $kelas->id)
            ->orderBy('tanggal_pertemuan', 'desc')
            ->orderBy('waktu_mulai', 'desc')
            ->withCount('presensi')
            ->paginate(10);

        return view('guru.pertemuan.index', compact('kelas', 'pertemuans'));
    }

    /**
     * Show the form for creating a new pertemuan
     * All guru can create pertemuan in any class
     */
    public function create(Kelas $kelas)
    {
        $gurus = User::where('role', 'guru')->orderBy('name')->get();

        return view('guru.pertemuan.create', compact('kelas', 'gurus'));
    }

    /**
     * Store a newly created pertemuan
     * All guru can store pertemuan in any class
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

        return redirect()->route('guru.pertemuan.show', ['kelas' => $kelas->id, 'pertemuan' => $pertemuan->id])
            ->with('success', 'Pertemuan berhasil dibuat. Silakan input absen siswa.');
    }

    /**
     * Display the specified pertemuan and show absen form
     * All guru can access all pertemuan for attendance - NO CHECKS!
     */
    public function show(Kelas $kelas, Pertemuan $pertemuan)
    {
        // No checks - all guru can access any pertemuan from any kelas URL

        // Get all students enrolled in this class
        $enrollmentIds = Enrollment::where('kelas_id', $kelas->id)
            ->pluck('user_id')
            ->toArray();

        $siswa = \App\Models\User::whereIn('id', $enrollmentIds)
            ->where('role', 'siswa')
            ->select('id', 'name', 'email', 'student_id', 'id_siswa', 'role')
            ->orderBy('name')
            ->get();

        // Get existing presensi for this pertemuan
        $presensi = Presensi::where('pertemuan_id', $pertemuan->id)
            ->get()
            ->keyBy('user_id');

        return view('guru.pertemuan.show', compact('kelas', 'pertemuan', 'siswa', 'presensi'));
    }

    /**
     * Store absen for a pertemuan
     * All guru can input attendance for any class - NO CHECKS!
     */
    public function storeAbsen(Request $request, Kelas $kelas, Pertemuan $pertemuan)
    {
        // No checks - all guru can store absen for any pertemuan

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
                    'materi_id' => null, // Absen per pertemuan tidak perlu materi_id
                    'status_kehadiran' => $absenData['status_kehadiran'],
                    'tanggal_akses' => now(),
                ]);
                $created++;
            }

            $touchedUserIds[] = (int) $absenData['user_id'];
        }

        // Sinkronkan progres kuota sesi dan kirim notifikasi jika hampir habis
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
        
        return redirect()->route('guru.pertemuan.show', ['kelas' => $kelas->id, 'pertemuan' => $pertemuan->id])
            ->with('success', $message);
    }

    /**
     * Show the form for editing the specified pertemuan
     * All guru can edit any pertemuan - NO CHECKS!
     */
    public function edit(Kelas $kelas, Pertemuan $pertemuan)
    {
        // No checks - all guru can edit any pertemuan from any kelas URL

        $gurus = User::where('role', 'guru')->orderBy('name')->get();

        return view('guru.pertemuan.edit', compact('kelas', 'pertemuan', 'gurus'));
    }

    /**
     * Update the specified pertemuan
     * All guru can update any pertemuan - NO CHECKS!
     */
    public function update(Request $request, Kelas $kelas, Pertemuan $pertemuan)
    {
        // No checks - all guru can update any pertemuan from any kelas URL

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

        return redirect()->route('guru.pertemuan.show', ['kelas' => $kelas->id, 'pertemuan' => $pertemuan->id])
            ->with('success', 'Pertemuan berhasil diperbarui.');
    }

    /**
     * Remove the specified pertemuan
     * All guru can delete any pertemuan
     */
    public function destroy(Kelas $kelas, Pertemuan $pertemuan)
    {
        // No check needed - all guru can delete from any kelas

        $pertemuan->delete();

        return redirect()->route('guru.pertemuan.index', $kelas->id)
            ->with('success', 'Pertemuan berhasil dihapus.');
    }

    /**
     * Show attendance input selection (classes for guru)
     */
    public function attendanceIndex()
    {
        $user = Auth::user();
        
        // Get all classes assigned to or enrolled by this guru
        $enrolledKelasIds = $user->enrolledClasses->pluck('id')->toArray();
        $assignedKelasIds = Kelas::where('guru_id', $user->id)->pluck('id')->toArray();
        $kelasIds = array_unique(array_merge($enrolledKelasIds, $assignedKelasIds));
        
        if (empty($kelasIds)) {
            return view('guru.absen.index', ['kelas' => collect()]);
        }
        
        $kelas = Kelas::whereIn('id', $kelasIds)
            ->where('status', 'active')
            ->withCount('pertemuan')
            ->orderBy('nama_kelas')
            ->get();
        
        // If only one class, redirect directly to pertemuan management
        if ($kelas->count() === 1) {
            return redirect()->route('guru.pertemuan.index', $kelas->first()->id);
        }
        
        return view('guru.absen.index', compact('kelas'));
    }

    /**
     * Show pertemuan list for attendance input (for a specific class)
     * All guru can access attendance for any class
     */
    public function attendanceSelectPertemuan(Kelas $kelas)
    {
        $pertemuans = Pertemuan::where('kelas_id', $kelas->id)
            ->orderBy('tanggal_pertemuan', 'desc')
            ->orderBy('waktu_mulai', 'desc')
            ->withCount('presensi')
            ->get();

        return view('guru.absen.select-pertemuan', compact('kelas', 'pertemuans'));
    }

    /**
     * Show attendance detail for a pertemuan
     * All guru can view attendance for any class - NO CHECKS!
     */
    public function absenDetail(Request $request, Kelas $kelas, Pertemuan $pertemuan)
    {
        // No checks - all guru can view any attendance from any kelas URL

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

        return view('guru.pertemuan.absen-detail', compact(
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
     * Show individual student progress/learning log
     * All guru can view student progress in any class
     */
    public function studentProgress(Request $request, Kelas $kelas, User $siswa)
    {
        // Check if student is in this class
        $enrollment = Enrollment::where('kelas_id', $kelas->id)
            ->where('user_id', $siswa->id)
            ->firstOrFail();

        // Get all pertemuans in this class
        $pertemuans = Pertemuan::where('kelas_id', $kelas->id)
            ->orderBy('tanggal_pertemuan')
            ->get();

        // Get attendance records for this student
        $presensiList = Presensi::where('user_id', $siswa->id)
            ->whereIn('pertemuan_id', $pertemuans->pluck('id'))
            ->get()
            ->keyBy('pertemuan_id');

        // Build learning log data
        $learningLog = [];
        foreach ($pertemuans as $index => $pertemuan) {
            $presensi = $presensiList->get($pertemuan->id);
            
            $learningLog[] = [
                'number' => $index + 1,
                'pertemuan' => $pertemuan,
                'presensi' => $presensi,
                'tanggal_belajar' => $pertemuan->tanggal_pertemuan,
                'nama_mentor' => $pertemuan->guru ? $pertemuan->guru->name : 'N/A',
                'materi' => $pertemuan->materi,
                'status_kehadiran' => $presensi ? $presensi->status_kehadiran : null,
            ];
        }

        return view('guru.siswa.progress', compact(
            'kelas',
            'siswa',
            'enrollment',
            'learningLog'
        ));
    }

}
