<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $role = $request->get('role');
        $status = $request->get('status');

        $query = User::query();

        if ($role) {
            $query->where('role', $role);
        }

        // Handle status filtering for students, which requires accessor-based logic
        if ($status && $role === 'siswa') {
            $all_siswa = $query->latest()->get();
            $filtered_siswa = $all_siswa->filter(function ($user) use ($status) {
                return ($status === 'active') ? $user->is_active : !$user->is_active;
            });

            $page = $request->get('page', 1);
            $perPage = 10; // Or your desired number of items per page
            $users = new LengthAwarePaginator(
                $filtered_siswa->forPage($page, $perPage),
                $filtered_siswa->count(),
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        } else {
            $users = $query->latest()->paginate(10);
        }

        $stats = [
            'total' => User::count(),
            'guru' => User::where('role', 'guru')->count(),
            'siswa' => User::where('role', 'siswa')->count(),
            'inactive' => User::where('role', 'siswa')->get()->filter(fn($u) => !$u->is_active)->count(),
        ];
        
        return view('admin.users.index', compact('users', 'role', 'stats'));
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
        // Sanitize currency fields before validation
        $payment_fields = ['biaya_pendaftaran', 'biaya_angsuran', 'total_biaya'];
        foreach ($payment_fields as $field) {
            if ($request->has($field)) {
                $cleaned_value = preg_replace('/[^\d]/', '', $request->input($field));
                $request->merge([
                    $field => $cleaned_value === '' ? null : $cleaned_value
                ]);
            }
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,guru,siswa',
            // Student-specific fields
            'tanggal_pendaftaran' => 'nullable|date',
            'sekolah' => 'nullable|string|max:255',
            'bidang_ajar' => 'nullable|array', // Changed to array
            'bidang_ajar.*' => 'exists:kelas,nama_kelas', // Validate each item in the array by nama_kelas
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
            'enrollment_status' => 'required|in:active,inactive', // New validation
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
                'bidang_ajar' => json_encode($validated['bidang_ajar'] ?? []), // Store as JSON
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

        // If user is siswa and bidang_ajar is selected, create enrollments
        if ($user->role === 'siswa' && !empty($validated['bidang_ajar'])) {
            foreach ($validated['bidang_ajar'] as $bidangAjarItem) { // Iterate through class names
                $kelas = Kelas::where('nama_kelas', $bidangAjarItem)->first(); // Find class by name
                if ($kelas) {
                    $user->enrollments()->create([
                        'kelas_id' => $kelas->id, // Use class ID
                        'status' => $validated['enrollment_status'], // Use dynamic status
                    ]);
                }
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
        // Sanitize currency fields before validation
        $payment_fields = ['biaya_pendaftaran', 'biaya_angsuran', 'total_biaya'];
        foreach ($payment_fields as $field) {
            if ($request->has($field)) {
                $cleaned_value = preg_replace('/[^\d]/', '', $request->input($field));
                $request->merge([
                    $field => $cleaned_value === '' ? null : $cleaned_value
                ]);
            }
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,guru,siswa',
            'enrollment_status' => 'required|in:active,inactive',
            // Student-specific fields
            'tanggal_pendaftaran' => 'nullable|date',
            'sekolah' => 'nullable|string|max:255',
            'bidang_ajar' => 'nullable|array', // Changed to array
            'bidang_ajar.*' => 'exists:kelas,nama_kelas', // Validate each item in the array by nama_kelas
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
                'bidang_ajar' => json_encode($validated['bidang_ajar'] ?? []), // Store as JSON
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

        if ($user->role === 'siswa') {
            // 1. Get the submitted class IDs from the form's nama_kelas values
            $selectedKelasIds = [];
            if (!empty($validated['bidang_ajar'])) {
                $selectedKelasIds = Kelas::whereIn('nama_kelas', $validated['bidang_ajar'])->pluck('id')->toArray();
            }

            // 2. Get the user's current class IDs directly from the enrollments table
            $currentKelasIds = \App\Models\Enrollment::where('user_id', $user->id)->pluck('kelas_id')->toArray();

            // 3. Determine which enrollments to delete, add, or update
            $idsToDelete = array_diff($currentKelasIds, $selectedKelasIds);
            $idsToAdd = array_diff($selectedKelasIds, $currentKelasIds);
            $idsToUpdate = array_intersect($currentKelasIds, $selectedKelasIds);

            // 4. Perform deletion for classes the user is no longer enrolled in
            if (!empty($idsToDelete)) {
                \App\Models\Enrollment::where('user_id', $user->id)->whereIn('kelas_id', $idsToDelete)->delete();
            }

            // 5. Perform addition for new classes
            foreach ($idsToAdd as $kelasId) {
                \App\Models\Enrollment::create([
                    'user_id' => $user->id,
                    'kelas_id' => $kelasId,
                    'status' => $validated['enrollment_status'],
                ]);
            }

            // 6. Perform an update for classes the user remains enrolled in
            if (!empty($idsToUpdate)) {
                \App\Models\Enrollment::where('user_id', $user->id)
                    ->whereIn('kelas_id', $idsToUpdate)
                    ->update(['status' => $validated['enrollment_status']]);
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
