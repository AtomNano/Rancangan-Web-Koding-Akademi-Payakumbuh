<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Pertemuan;
use App\Models\Presensi;
use App\Models\Enrollment;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PertemuanController extends Controller
{
    /**
     * Check if guru has access to a class
     */
    private function hasAccessToClass($user, $kelas)
    {
        $isAssignedAsGuru = $kelas->guru_id !== null && (int)$kelas->guru_id === (int)$user->id;
        $isEnrolled = Enrollment::where('user_id', $user->id)
            ->where('kelas_id', $kelas->id)
            ->exists();
        return $isAssignedAsGuru || $isEnrolled;
    }

    /**
     * Display a listing of pertemuan for a class
     */
    public function index(Kelas $kelas)
    {
        $user = Auth::user();
        
        if (!$this->hasAccessToClass($user, $kelas)) {
            abort(403, 'Anda tidak diizinkan mengakses kelas ini.');
        }

        $pertemuans = Pertemuan::where('kelas_id', $kelas->id)
            ->where('guru_id', $user->id)
            ->orderBy('tanggal_pertemuan', 'desc')
            ->orderBy('waktu_mulai', 'desc')
            ->withCount('presensi')
            ->paginate(10);

        return view('guru.pertemuan.index', compact('kelas', 'pertemuans'));
    }

    /**
     * Show the form for creating a new pertemuan
     */
    public function create(Kelas $kelas)
    {
        $user = Auth::user();
        
        if (!$this->hasAccessToClass($user, $kelas)) {
            abort(403, 'Anda tidak diizinkan mengakses kelas ini.');
        }

        // Get all active materials for this class
        $materis = Materi::where('kelas_id', $kelas->id)
            ->where('status', 'active')
            ->orderBy('judul')
            ->get();

        return view('guru.pertemuan.create', compact('kelas', 'materis'));
    }

    /**
     * Store a newly created pertemuan
     */
    public function store(Request $request, Kelas $kelas)
    {
        $user = Auth::user();
        
        if (!$this->hasAccessToClass($user, $kelas)) {
            abort(403, 'Anda tidak diizinkan mengakses kelas ini.');
        }

        $validated = $request->validate([
            'judul_pertemuan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_pertemuan' => 'required|date',
            'waktu_mulai' => 'nullable|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i|after:waktu_mulai',
            'materi_id' => 'nullable|exists:materis,id',
        ]);

        $pertemuan = Pertemuan::create([
            'kelas_id' => $kelas->id,
            'guru_id' => $user->id,
            'judul_pertemuan' => $validated['judul_pertemuan'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'tanggal_pertemuan' => $validated['tanggal_pertemuan'],
            'waktu_mulai' => $validated['waktu_mulai'] ?? null,
            'waktu_selesai' => $validated['waktu_selesai'] ?? null,
            'materi_id' => $validated['materi_id'] ?? null,
        ]);

        return redirect()->route('guru.pertemuan.show', ['kelas' => $kelas->id, 'pertemuan' => $pertemuan->id])
            ->with('success', 'Pertemuan berhasil dibuat. Silakan input absen siswa.');
    }

    /**
     * Display the specified pertemuan and show absen form
     */
    public function show(Kelas $kelas, Pertemuan $pertemuan)
    {
        $user = Auth::user();
        
        if (!$this->hasAccessToClass($user, $kelas)) {
            abort(403, 'Anda tidak diizinkan mengakses kelas ini.');
        }

        if ($pertemuan->kelas_id !== $kelas->id || $pertemuan->guru_id !== $user->id) {
            abort(403, 'Anda tidak diizinkan mengakses pertemuan ini.');
        }

        // Load materi relationship
        $pertemuan->load('materi');

        // Get all students enrolled in this class
        $enrollmentIds = Enrollment::where('kelas_id', $kelas->id)
            ->pluck('user_id')
            ->toArray();

        $siswa = \App\Models\User::whereIn('id', $enrollmentIds)
            ->where('role', 'siswa')
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
     */
    public function storeAbsen(Request $request, Kelas $kelas, Pertemuan $pertemuan)
    {
        $user = Auth::user();
        
        if (!$this->hasAccessToClass($user, $kelas)) {
            abort(403, 'Anda tidak diizinkan mengakses kelas ini.');
        }

        if ($pertemuan->kelas_id !== $kelas->id || $pertemuan->guru_id !== $user->id) {
            abort(403, 'Anda tidak diizinkan mengakses pertemuan ini.');
        }

        $validated = $request->validate([
            'absen' => 'required|array',
            'absen.*.user_id' => 'required|exists:users,id',
            'absen.*.status_kehadiran' => 'required|in:hadir,izin,sakit,alpha',
        ]);

        $created = 0;
        $updated = 0;

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
        }

        $message = "Absen berhasil disimpan. {$created} siswa baru, {$updated} siswa diperbarui.";
        
        return redirect()->route('guru.pertemuan.show', ['kelas' => $kelas->id, 'pertemuan' => $pertemuan->id])
            ->with('success', $message);
    }

    /**
     * Show the form for editing the specified pertemuan
     */
    public function edit(Kelas $kelas, Pertemuan $pertemuan)
    {
        $user = Auth::user();
        
        if (!$this->hasAccessToClass($user, $kelas)) {
            abort(403, 'Anda tidak diizinkan mengakses kelas ini.');
        }

        if ($pertemuan->kelas_id !== $kelas->id || $pertemuan->guru_id !== $user->id) {
            abort(403, 'Anda tidak diizinkan mengakses pertemuan ini.');
        }

        // Get all active materials for this class
        $materis = Materi::where('kelas_id', $kelas->id)
            ->where('status', 'active')
            ->orderBy('judul')
            ->get();

        return view('guru.pertemuan.edit', compact('kelas', 'pertemuan', 'materis'));
    }

    /**
     * Update the specified pertemuan
     */
    public function update(Request $request, Kelas $kelas, Pertemuan $pertemuan)
    {
        $user = Auth::user();
        
        if (!$this->hasAccessToClass($user, $kelas)) {
            abort(403, 'Anda tidak diizinkan mengakses kelas ini.');
        }

        if ($pertemuan->kelas_id !== $kelas->id || $pertemuan->guru_id !== $user->id) {
            abort(403, 'Anda tidak diizinkan mengakses pertemuan ini.');
        }

        $validated = $request->validate([
            'judul_pertemuan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_pertemuan' => 'required|date',
            'waktu_mulai' => 'nullable|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i|after:waktu_mulai',
            'materi_id' => 'nullable|exists:materis,id',
        ]);

        $pertemuan->update($validated);

        return redirect()->route('guru.pertemuan.show', ['kelas' => $kelas->id, 'pertemuan' => $pertemuan->id])
            ->with('success', 'Pertemuan berhasil diperbarui.');
    }

    /**
     * Remove the specified pertemuan
     */
    public function destroy(Kelas $kelas, Pertemuan $pertemuan)
    {
        $user = Auth::user();
        
        if (!$this->hasAccessToClass($user, $kelas)) {
            abort(403, 'Anda tidak diizinkan mengakses kelas ini.');
        }

        if ($pertemuan->kelas_id !== $kelas->id || $pertemuan->guru_id !== $user->id) {
            abort(403, 'Anda tidak diizinkan menghapus pertemuan ini.');
        }

        $pertemuan->delete();

        return redirect()->route('guru.pertemuan.index', $kelas->id)
            ->with('success', 'Pertemuan berhasil dihapus.');
    }
}
