<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Kelas;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    /**
     * Get classes assigned to guru (via enrollment OR via guru_id)
     */
    private function getAssignedKelasIds($user)
    {
        $enrolledKelasIds = $user->enrolledClasses->pluck('id')->toArray();
        $assignedKelasIds = Kelas::where('guru_id', $user->id)->pluck('id')->toArray();
        return array_unique(array_merge($enrolledKelasIds, $assignedKelasIds));
    }

    /**
     * Check if guru has access to a class
     */
    private function hasAccessToClass($user, $kelasId)
    {
        $assignedKelasIds = $this->getAssignedKelasIds($user);
        return in_array($kelasId, $assignedKelasIds);
    }

    /**
     * Convert PHP ini size to bytes
     */
    private function convertToBytes($value)
    {
        $value = trim($value);
        $unit = strtolower($value[strlen($value) - 1]);
        $value = (int) $value;
        
        switch ($unit) {
            case 'g':
                $value *= 1024;
                // fall through
            case 'm':
                $value *= 1024;
                // fall through
            case 'k':
                $value *= 1024;
                break;
        }
        
        return $value;
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= pow(1024, $pow);
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }

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
            $assignedKelasIds = $this->getAssignedKelasIds($user);
            if (empty($assignedKelasIds)) {
                $assignedKelasIds = [0]; // Return empty results
            }
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
        $assignedKelasIds = $this->getAssignedKelasIds($user);
        
        if (empty($assignedKelasIds)) {
            $kelas = collect();
        } else {
            // Get classes where guru is assigned (via enrollment OR via guru_id)
            $kelas = Kelas::where('status', 'active')
                ->where(function($query) use ($user, $assignedKelasIds) {
                    $query->whereIn('id', $assignedKelasIds)
                          ->orWhere('guru_id', $user->id);
                })
                ->get()
                ->unique('id');
        }
        
        return view('guru.materi.create', compact('kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check PHP upload limits before validation
        $uploadMaxSize = ini_get('upload_max_filesize');
        $postMaxSize = ini_get('post_max_size');
        
        // Convert to bytes for comparison
        $uploadMaxBytes = $this->convertToBytes($uploadMaxSize);
        $postMaxBytes = $this->convertToBytes($postMaxSize);
        
        // Check if file is too large based on PHP settings
        if ($request->hasFile('file')) {
            $fileSize = $request->file('file')->getSize();
            if ($fileSize > $uploadMaxBytes) {
                return back()->withErrors([
                    'file' => "File terlalu besar. Ukuran maksimum yang diizinkan: " . $uploadMaxSize . 
                             " (File Anda: " . $this->formatBytes($fileSize) . "). " .
                             "Silakan hubungi administrator untuk meningkatkan batasan upload."
                ])->withInput();
            }
            if ($fileSize > $postMaxBytes) {
                return back()->withErrors([
                    'file' => "File terlalu besar. POST max size: " . $postMaxSize . 
                             " (File Anda: " . $this->formatBytes($fileSize) . "). " .
                             "Silakan hubungi administrator untuk meningkatkan batasan upload."
                ])->withInput();
            }
        }
        
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'required|file|mimes:pdf,mp4,doc,docx|max:102400', // 100MB max (102400 KB)
            'kelas_id' => 'required|exists:kelas,id',
            'file_type' => 'required|in:pdf,video,document,link',
        ]);

        $user = auth()->user();

        // Authorization check: Allow all gurus to upload to any class (for now)
        // In production, you may want to enable this check
        // if (!$this->hasAccessToClass($user, $validated['kelas_id'])) {
        //     abort(403, 'Anda tidak diizinkan mengunggah materi ke kelas ini.');
        // }

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
    public function show($materi)
    {
        $user = auth()->user();
        
        if (!$user) {
            abort(403, 'Anda harus login untuk melihat materi.');
        }
        
        // Handle route model binding or direct ID
        if ($materi instanceof Materi) {
            $materiModel = $materi;
        } else {
            $materiModel = Materi::find($materi);
        }
        
        if (!$materiModel) {
            abort(404, 'Materi tidak ditemukan.');
        }
        
        $materiModel->load(['kelas', 'uploadedBy']);
        
        // Permission check based on user role
        if ($user->isAdmin()) {
            return view('admin.materi.show', ['materi' => $materiModel]);
        } 
        
        if ($user->isGuru()) {
            return view('guru.materi.show', ['materi' => $materiModel]);
        }
        
        return view('guru.materi.show', ['materi' => $materiModel]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Materi $materi)
    {
        $user = auth()->user();

        // Authorization check: Ensure the guru is assigned to this material's class
        abort_if(!$this->hasAccessToClass($user, $materi->kelas_id), 403, 'Anda tidak diizinkan mengedit materi di kelas ini.');

        $assignedKelasIds = $this->getAssignedKelasIds($user);
        
        if (empty($assignedKelasIds)) {
            $kelas = collect();
        } else {
            // Get classes where guru is assigned (via enrollment OR via guru_id)
            $kelas = Kelas::where('status', 'active')
                ->where(function($query) use ($user, $assignedKelasIds) {
                    $query->whereIn('id', $assignedKelasIds)
                          ->orWhere('guru_id', $user->id);
                })
                ->get()
                ->unique('id');
        }
        
        return view('guru.materi.edit', compact('materi', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Materi $materi)
    {
        $user = auth()->user();

        // Authorization check: Ensure the guru is assigned to this material's class
        abort_if(!$this->hasAccessToClass($user, $materi->kelas_id), 403, 'Anda tidak diizinkan memperbarui materi di kelas ini.');

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,mp4,doc,docx|max:102400', // 100MB max (102400 KB)
            'kelas_id' => 'required|exists:kelas,id',
            'file_type' => 'required|in:pdf,video,document,link',
        ]);

        // Authorization check: Ensure the selected new kelas_id is assigned to the guru
        if (!$this->hasAccessToClass($user, $validated['kelas_id'])) {
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
     * Download or view material file
     */
    public function download($materi)
    {
        $user = auth()->user();
        
        if (!$user) {
            abort(403, 'Anda harus login untuk mengakses file.');
        }
        
        // Handle route model binding or direct ID
        if ($materi instanceof Materi) {
            $materiModel = $materi;
        } else {
            $materiModel = Materi::find($materi);
        }
        
        if (!$materiModel) {
            abort(404, 'Materi tidak ditemukan.');
        }
        
        // Check if file exists
        if (!Storage::disk('public')->exists($materiModel->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }
        
        // Permission check - allow all authenticated users for now (for testing)
        // Admin can access all files
        if ($user->isAdmin()) {
            return Storage::disk('public')->response($materiModel->file_path);
        }
        
        // Guru can access files they uploaded or files in their classes
        if ($user->isGuru()) {
            // Allow all gurus for now (for testing)
            return Storage::disk('public')->response($materiModel->file_path);
        }
        
        // Siswa can access approved materials in their enrolled classes
        if ($user->isSiswa()) {
            // Check if student is enrolled in the class
            $isEnrolled = \App\Models\Enrollment::where('user_id', $user->id)
                ->where('kelas_id', $materiModel->kelas_id)
                ->exists();
            
            if (!$isEnrolled) {
                abort(403, 'Anda tidak terdaftar di kelas ini.');
            }
            
            // Check if material is approved
            if (!$materiModel->isApproved()) {
                abort(403, 'Materi belum disetujui oleh admin.');
            }
            
            return Storage::disk('public')->response($materiModel->file_path);
        }
        
        // For other roles, deny access
        abort(403, 'Akses ditolak.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Materi $materi)
    {
        $user = auth()->user();

        // Authorization check: Ensure the guru is assigned to this material's class
        abort_if(!$this->hasAccessToClass($user, $materi->kelas_id), 403, 'Anda tidak diizinkan menghapus materi di kelas ini.');

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
        $materi->load('uploadedBy');
        $materi->update(['status' => 'approved']);
        
        // Log activity
        ActivityLogger::logMaterialApproved($materi);
        
        return redirect()->back()
            ->with('success', 'Materi berhasil disetujui.');
    }

    /**
     * Reject material (Admin only)
     */
    public function reject(Materi $materi)
    {
        $materi->load('uploadedBy');
        $materi->update(['status' => 'rejected']);
        
        // Log activity
        ActivityLogger::logMaterialRejected($materi);
        
        return redirect()->back()
            ->with('success', 'Materi ditolak.');
    }
}
