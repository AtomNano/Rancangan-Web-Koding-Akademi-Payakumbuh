<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = Kelas::withCount('students')->paginate(10);
        return view('admin.kelas.index', compact('kelas'));
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
            'bidang' => 'required|in:coding,desain,robotik',
            'guru_id' => 'required|exists:users,id',
        ]);

        Kelas::create([
            'nama_kelas' => $validated['nama_kelas'],
            'deskripsi' => $validated['deskripsi'],
            'bidang' => $validated['bidang'],
            'guru_id' => $validated['guru_id'],
            'status' => 'active',
        ]);

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kelas $kelas)
    {
        $students = $kelas->students()->paginate(10);
        $materi = $kelas->materi()->with('uploadedBy')->paginate(10);
        
        return view('admin.kelas.show', compact('kelas', 'students', 'materi'));
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
            'bidang' => 'required|in:coding,desain,robotik',
            'status' => 'required|in:active,inactive',
        ]);

        $kelas->update($validated);

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelas $kelas)
    {
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
            ->whereDoesntHave('enrollments', function($query) use ($kelas) {
                $query->where('kelas_id', $kelas->id);
            })
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
        ]);

        foreach ($validated['student_ids'] as $studentId) {
            $kelas->enrollments()->create([
                'user_id' => $studentId,
                'status' => 'active',
            ]);
        }

        return redirect()->route('admin.kelas.show', $kelas)
            ->with('success', 'Siswa berhasil didaftarkan ke kelas.');
    }
}
