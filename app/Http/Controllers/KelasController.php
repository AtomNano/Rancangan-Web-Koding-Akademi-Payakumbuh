<?php

namespace App\Http\Controllers;

use App\Exports\KelasAttendanceExport;
use App\Exports\StudentLearningLogExport;
use App\Helpers\ActivityLogger;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelasList = Kelas::with('guru', 'enrollments', 'materi')->latest()->get();
        
        // Get unassigned classes (classes without guru_id) for admin notice
        $unassignedKelas = Kelas::whereNull('guru_id')->get();

        // Count students enrolled in classes (not all students in system)
        $enrolledStudentIds = \App\Models\Enrollment::select('enrollments.user_id')
            ->join('users', 'enrollments.user_id', '=', 'users.id')
            ->where('users.role', 'siswa')
            ->distinct()
            ->pluck('user_id')
            ->toArray();
        $totalEnrolledSiswa = count($enrolledStudentIds);
        
        $stats = [
            'total_kelas' => \App\Models\Kelas::count(),
            'total_siswa' => $totalEnrolledSiswa, // Count enrolled students, not all students
            'total_guru' => \App\Models\User::where('role', 'guru')->count(),
            'total_materi' => \App\Models\Materi::count(),
            'unassigned_kelas_count' => $unassignedKelas->count(),
        ];

        return view('admin.kelas.index', [
            'kelasList' => $kelasList, 
            'stats' => $stats,
            'unassignedKelas' => $unassignedKelas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gurus = User::where('role', 'guru')->get();
        return view('admin.kelas.create', compact('gurus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'bidang' => 'required|in:coding,desain,robotik,umum,mahasiswa',
            'guru_id' => 'required|exists:users,id',
        ]);

        $kelas = Kelas::create([
            'nama_kelas' => $validated['nama_kelas'],
            'deskripsi' => $validated['deskripsi'],
            'bidang' => $validated['bidang'],
            'guru_id' => $validated['guru_id'],
            'status' => 'active',
        ]);

        // Log activity
        ActivityLogger::logClassCreated($kelas);

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kelas $kelas)
    {
        $kelas->load('guru'); // Load the teacher for the class
        $students = $kelas->students()->with('presensi')->get(); // Load students with their presensis
        $approvedMateri = $kelas->materi()->where('status', 'approved')->get();
        $totalApprovedMateri = $approvedMateri->count();

        $studentsProgress = [];
        foreach ($students as $student) {
            $completedMateriCount = $student->presensi ? $student->presensi->whereIn('materi_id', $approvedMateri->pluck('id'))->count() : 0;
            $progress = $totalApprovedMateri > 0 ? round(($completedMateriCount / $totalApprovedMateri) * 100, 2) : 0;
            $studentsProgress[] = [
                'student' => $student,
                'completed_materi_count' => $completedMateriCount,
                'total_approved_materi' => $totalApprovedMateri,
                'progress' => $progress,
            ];
        }

        $classProgress = 0;
        if (count($studentsProgress) > 0) {
            $totalProgress = array_sum(array_column($studentsProgress, 'progress'));
            $classProgress = round($totalProgress / count($studentsProgress), 2);
        }

        $materi = $kelas->materi()->with('uploadedBy')->paginate(10);
        
        return view('admin.kelas.show', compact('kelas', 'studentsProgress', 'materi', 'classProgress'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kelas $kelas)
    {
        $gurus = User::where('role', 'guru')->get();
        return view('admin.kelas.edit', compact('kelas', 'gurus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kelas $kelas)
    {
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'guru_id' => 'required|exists:users,id',
            'bidang' => 'required|in:coding,desain,robotik,umum,mahasiswa',
            'status' => 'required|in:active,inactive',
        ]);

        // Log activity
        $oldValues = $kelas->toArray();
        $kelas->update($validated);
        $newValues = $kelas->fresh()->toArray();
        ActivityLogger::logClassUpdated($kelas, $oldValues, $newValues);

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelas $kelas)
    {
        // Log activity
        ActivityLogger::logClassDeleted($kelas);
        
        $kelas->delete();

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil dihapus.');
    }

    /**
     * Show enrollment form for a class
     */
    public function enrollForm(Kelas $kelas)
    {
        $availableStudents = User::where('role', 'siswa')
            ->select('id', 'name', 'email', 'student_id', 'id_siswa', 'role')
            ->whereDoesntHave('enrollments', function($query) use ($kelas) {
                $query->where('kelas_id', $kelas->id)
                    ->whereIn('status', ['active', 'expiring']);
            })
            ->orderByRaw('COALESCE(student_id, id_siswa)')
            ->orderBy('name')
            ->get();

        return view('admin.kelas.enroll', compact('kelas', 'availableStudents'));
    }

    /**
     * Enroll students to a class
     */
    public function enroll(Request $request, Kelas $kelas)
    {
        $validated = $request->validate([
            'student_ids' => 'required|array|exists:users,id',
            'start_date' => 'required|date',
            'duration_months' => 'required|integer|min:1|max:12',
            'monthly_quota' => 'required|integer|in:4,8',
        ]);

        $targetSessions = $validated['duration_months'] * $validated['monthly_quota'];

        $created = 0;
        $reactivated = 0;

        foreach ($validated['student_ids'] as $studentId) {
            $student = User::find($studentId);
            $existingEnrollment = $kelas->enrollments()
                ->where('user_id', $studentId)
                ->latest('created_at')
                ->first();

            if ($existingEnrollment) {
                $newTarget = $targetSessions;

                if ($existingEnrollment->target_sessions) {
                    $newTarget += (int) $existingEnrollment->target_sessions;
                }

                $existingEnrollment->update([
                    'status' => 'active',
                    'start_date' => $validated['start_date'],
                    'duration_months' => $validated['duration_months'],
                    'monthly_quota' => $validated['monthly_quota'],
                    'target_sessions' => $newTarget,
                    'last_session_notified_at' => null,
                ]);

                $existingEnrollment->syncSessionProgress();
                $reactivated++;
            } else {
                $kelas->enrollments()->create([
                    'user_id' => $studentId,
                    'status' => 'active',
                    'start_date' => $validated['start_date'],
                    'duration_months' => $validated['duration_months'],
                    'monthly_quota' => $validated['monthly_quota'],
                    'target_sessions' => $targetSessions,
                    'sessions_attended' => 0,
                ]);
                $created++;
            }

            if ($student) {
                ActivityLogger::logStudentEnrolled($kelas, $student);
            }
        }

        $messageParts = [];
        if ($created > 0) {
            $messageParts[] = "$created siswa baru";
        }
        if ($reactivated > 0) {
            $messageParts[] = "$reactivated siswa diperpanjang";
        }

        $message = empty($messageParts)
            ? 'Perubahan enrollment berhasil disimpan.'
            : 'Berhasil diproses: ' . implode(', ', $messageParts) . '.';

        return redirect()->route('admin.kelas.show', $kelas)
            ->with('success', $message);
    }

    /**
     * Export attendance matrix for the class.
     */
    public function exportAttendance(Kelas $kelas)
    {
        $filename = 'kehadiran-kelas-' . $kelas->id . '.xlsx';

        return Excel::download(new KelasAttendanceExport($kelas), $filename);
    }

    /**
     * Export per-student learning log for a class
     */
    public function exportStudentLearningLog(Kelas $kelas, User $user)
    {
        // Ensure the user is a student enrolled in this class
        $enrolled = $kelas->enrollments()->where('user_id', $user->id)->exists();
        if (!$enrolled) {
            abort(404, 'Siswa tidak terdaftar di kelas ini');
        }

        $safeStudent = preg_replace('/[^a-zA-Z0-9_-]+/', '-', strtolower($user->name));
        $filename = 'log-belajar-' . $safeStudent . '-kelas-' . $kelas->id . '.xlsx';

        return Excel::download(new StudentLearningLogExport($kelas, $user), $filename);
    }

    /**
     * Unenroll a student from a class.
     */
    public function unenroll(Kelas $kelas, User $user)
    {
        // Log activity
        ActivityLogger::logStudentUnenrolled($kelas, $user);
        
        $kelas->enrollments()->where('user_id', $user->id)->delete();

        return redirect()->route('admin.kelas.show', $kelas)
            ->with('success', 'Siswa berhasil dikeluarkan dari kelas.');
    }
}
