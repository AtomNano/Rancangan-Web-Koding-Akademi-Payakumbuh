<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            $materi = Materi::with(['kelas', 'uploadedBy'])->latest()->paginate(10);
            return view('admin.materi.index', compact('materi'));
        } else {
            $assignedKelasIds = $user->enrolledClasses->pluck('id')->toArray();
            $materi = Materi::whereIn('kelas_id', $assignedKelasIds)->where('uploaded_by', $user->id)->with('kelas')->latest()->paginate(10);
        }
        
        return view('guru.materi.index', compact('materi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        $assignedKelasIds = $user->enrolledClasses->pluck('id')->toArray();
        $kelas = Kelas::where('status', 'active')->whereIn('id', $assignedKelasIds)->get();
        return view('guru.materi.create', compact('kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'required|file|mimes:pdf,mp4,doc,docx|max:10240', // 10MB max
            'kelas_id' => 'required|exists:kelas,id',
            'file_type' => 'required|in:pdf,video,document,link',
        ]);

        $user = auth()->user();
        $assignedKelasIds = $user->enrolledClasses->pluck('id')->toArray();

        // Authorization check: Ensure the selected kelas_id is assigned to the guru
        if (!in_array($validated['kelas_id'], $assignedKelasIds)) {
            abort(403, 'Anda tidak diizinkan mengunggah materi ke kelas ini.');
        }

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('materi', $fileName, 'public');

        Materi::create([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'file_path' => $filePath,
            'file_type' => $validated['file_type'],
            'kelas_id' => $validated['kelas_id'],
            'uploaded_by' => auth()->id(),
            'status' => 'pending',
        ]);

        return redirect()->route('guru.materi.index')
            ->with('success', 'Materi berhasil diunggah dan menunggu verifikasi admin.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Materi $materi)
    {
        $materi->load(['kelas', 'uploadedBy']);
        return view('guru.materi.show', compact('materi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Materi $materi)
    {
        $user = auth()->user();
        $assignedKelasIds = $user->enrolledClasses->pluck('id')->toArray();

        // Authorization check: Ensure the guru is assigned to this material's class
        abort_if(!in_array($materi->kelas_id, $assignedKelasIds), 403, 'Anda tidak diizinkan mengedit materi di kelas ini.');

        $kelas = Kelas::where('status', 'active')->whereIn('id', $assignedKelasIds)->get();
        return view('guru.materi.edit', compact('materi', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Materi $materi)
    {
        $user = auth()->user();
        $assignedKelasIds = $user->enrolledClasses->pluck('id')->toArray();

        // Authorization check: Ensure the guru is assigned to this material's class
        abort_if(!in_array($materi->kelas_id, $assignedKelasIds), 403, 'Anda tidak diizinkan memperbarui materi di kelas ini.');

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,mp4,doc,docx|max:10240',
            'kelas_id' => 'required|exists:kelas,id',
            'file_type' => 'required|in:pdf,video,document,link',
        ]);

        // Authorization check: Ensure the selected new kelas_id is assigned to the guru
        if (!in_array($validated['kelas_id'], $assignedKelasIds)) {
            abort(403, 'Anda tidak diizinkan memindahkan materi ke kelas ini.');
        }

        $materi->update([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'kelas_id' => $validated['kelas_id'],
            'file_type' => $validated['file_type'],
            'status' => 'pending', // Reset to pending when updated
        ]);

        if ($request->hasFile('file')) {
            // Delete old file
            Storage::disk('public')->delete($materi->file_path);
            
            // Upload new file
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('materi', $fileName, 'public');
            
            $materi->update(['file_path' => $filePath]);
        }

        return redirect()->route('guru.materi.index')
            ->with('success', 'Materi berhasil diperbarui dan menunggu verifikasi admin.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Materi $materi)
    {
        $user = auth()->user();
        $assignedKelasIds = $user->enrolledClasses->pluck('id')->toArray();

        // Authorization check: Ensure the guru is assigned to this material's class
        abort_if(!in_array($materi->kelas_id, $assignedKelasIds), 403, 'Anda tidak diizinkan menghapus materi di kelas ini.');

        Storage::disk('public')->delete($materi->file_path);
        $materi->delete();

        return redirect()->route('guru.materi.index')
            ->with('success', 'Materi berhasil dihapus.');
    }

    /**
     * Approve material (Admin only)
     */
    public function approve(Materi $materi)
    {
        $materi->update(['status' => 'approved']);
        
        return redirect()->back()
            ->with('success', 'Materi berhasil disetujui.');
    }

    /**
     * Reject material (Admin only)
     */
    public function reject(Materi $materi)
    {
        $materi->update(['status' => 'rejected']);
        
        return redirect()->back()
            ->with('success', 'Materi ditolak.');
    }
}
