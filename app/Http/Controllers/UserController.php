<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $role = $request->get('role', 'guru');
        $users = User::where('role', $role)->paginate(10);
        
        return view('admin.users.index', compact('users', 'role'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $role = $request->get('role', 'guru');
        $kelas = Kelas::all();
        
        return view('admin.users.create', compact('role', 'kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,guru,siswa',
            'kelas_ids' => 'array|exists:kelas,id',
            // Student-specific fields
            'tanggal_pendaftaran' => 'nullable|date',
            'sekolah' => 'nullable|string|max:255',
            'bidang_ajar' => 'nullable|string|max:255',
            'hari_belajar' => 'nullable|array',
            'durasi' => 'nullable|string|max:255',
            'metode_pembayaran' => 'nullable|in:transfer,cash',
            'biaya_pendaftaran' => 'nullable|numeric|min:0',
            'biaya_angsuran' => 'nullable|numeric|min:0',
            'total_biaya' => 'nullable|numeric|min:0',
            'status_promo' => 'nullable|string|max:255',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ];

        // Add student-specific fields if role is siswa
        if ($validated['role'] === 'siswa') {
            $userData = array_merge($userData, [
                'tanggal_pendaftaran' => $validated['tanggal_pendaftaran'] ?? now()->toDateString(),
                'sekolah' => $validated['sekolah'] ?? null,
                'bidang_ajar' => $validated['bidang_ajar'] ?? null,
                'hari_belajar' => $validated['hari_belajar'] ?? null,
                'durasi' => $validated['durasi'] ?? null,
                'metode_pembayaran' => $validated['metode_pembayaran'] ?? null,
                'biaya_pendaftaran' => $validated['biaya_pendaftaran'] ?? null,
                'biaya_angsuran' => $validated['biaya_angsuran'] ?? null,
                'total_biaya' => $validated['total_biaya'] ?? null,
                'status_promo' => $validated['status_promo'] ?? null,
                'no_telepon' => $validated['no_telepon'] ?? null,
                'alamat' => $validated['alamat'] ?? null,
                'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
                'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
            ]);
        }

        $user = User::create($userData);

        // If user is siswa, enroll them in selected classes
        if ($user->role === 'siswa' && isset($validated['kelas_ids'])) {
            foreach ($validated['kelas_ids'] as $kelasId) {
                $user->enrollments()->create([
                    'kelas_id' => $kelasId,
                    'status' => 'active',
                ]);
            }
        }

        return redirect()->route('admin.users.index', ['role' => $user->role])
            ->with('success', 'User berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $enrolledClasses = $user->enrolledClasses;
        return view('admin.users.show', compact('user', 'enrolledClasses'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $kelas = Kelas::all();
        $enrolledClassIds = $user->enrolledClasses->pluck('id')->toArray();
        
        return view('admin.users.edit', compact('user', 'kelas', 'enrolledClassIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,guru,siswa',
            'kelas_ids' => 'array|exists:kelas,id',
            // Student-specific fields
            'tanggal_pendaftaran' => 'nullable|date',
            'sekolah' => 'nullable|string|max:255',
            'bidang_ajar' => 'nullable|string|max:255',
            'hari_belajar' => 'nullable|array',
            'durasi' => 'nullable|string|max:255',
            'metode_pembayaran' => 'nullable|in:transfer,cash',
            'biaya_pendaftaran' => 'nullable|numeric|min:0',
            'biaya_angsuran' => 'nullable|numeric|min:0',
            'total_biaya' => 'nullable|numeric|min:0',
            'status_promo' => 'nullable|string|max:255',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];

        // Add student-specific fields if role is siswa
        if ($validated['role'] === 'siswa') {
            $userData = array_merge($userData, [
                'tanggal_pendaftaran' => $validated['tanggal_pendaftaran'] ?? $user->tanggal_pendaftaran,
                'sekolah' => $validated['sekolah'] ?? $user->sekolah,
                'bidang_ajar' => $validated['bidang_ajar'] ?? $user->bidang_ajar,
                'hari_belajar' => $validated['hari_belajar'] ?? $user->hari_belajar,
                'durasi' => $validated['durasi'] ?? $user->durasi,
                'metode_pembayaran' => $validated['metode_pembayaran'] ?? $user->metode_pembayaran,
                'biaya_pendaftaran' => $validated['biaya_pendaftaran'] ?? $user->biaya_pendaftaran,
                'biaya_angsuran' => $validated['biaya_angsuran'] ?? $user->biaya_angsuran,
                'total_biaya' => $validated['total_biaya'] ?? $user->total_biaya,
                'status_promo' => $validated['status_promo'] ?? $user->status_promo,
                'no_telepon' => $validated['no_telepon'] ?? $user->no_telepon,
                'alamat' => $validated['alamat'] ?? $user->alamat,
                'tanggal_lahir' => $validated['tanggal_lahir'] ?? $user->tanggal_lahir,
                'jenis_kelamin' => $validated['jenis_kelamin'] ?? $user->jenis_kelamin,
            ]);
        }

        $user->update($userData);

        if ($validated['password']) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        // Update class enrollments for siswa
        if ($user->role === 'siswa') {
            $user->enrollments()->delete();
            if (isset($validated['kelas_ids'])) {
                foreach ($validated['kelas_ids'] as $kelasId) {
                    $user->enrollments()->create([
                        'kelas_id' => $kelasId,
                        'status' => 'active',
                    ]);
                }
            }
        }

        return redirect()->route('admin.users.index', ['role' => $user->role])
            ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $role = $user->role;
        $user->delete();

        return redirect()->route('admin.users.index', ['role' => $role])
            ->with('success', 'User berhasil dihapus.');
    }
}
