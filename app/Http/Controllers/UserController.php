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
        $baseValidated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,guru,siswa',
        ]);

        $userData = $baseValidated;
        $userData['password'] = Hash::make($baseValidated['password']);

        if ($request->role === 'siswa') {
            $payment_fields = ['biaya_pendaftaran', 'biaya_angsuran', 'total_biaya'];
            foreach ($payment_fields as $field) {
                if ($request->has($field)) {
                    $cleaned_value = preg_replace('/[^\d]/', '', $request->input($field));
                    $request->merge([$field => $cleaned_value === '' ? null : $cleaned_value]);
                }
            }

            $studentValidated = $request->validate([
                'tanggal_pendaftaran' => 'nullable|date',
                'sekolah' => 'nullable|string|max:255',
                'bidang_ajar' => 'nullable|array',
                'bidang_ajar.*' => 'exists:kelas,nama_kelas',
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
                'enrollment_status' => 'required|in:active,inactive',
            ]);
            $studentValidated['bidang_ajar'] = json_encode($studentValidated['bidang_ajar'] ?? []);
            $userData = array_merge($userData, $studentValidated);

        } elseif ($request->role === 'guru') {
            $guruValidated = $request->validate([
                'bidang_ajar' => 'nullable|array',
                'bidang_ajar.*' => 'exists:kelas,nama_kelas',
            ]);
            $userData['bidang_ajar'] = json_encode($guruValidated['bidang_ajar'] ?? []);
        }

        $user = User::create($userData);

        if (($request->role === 'siswa' || $request->role === 'guru') && !empty($request->bidang_ajar)) {
            $status = ($request->role === 'siswa') ? $request->enrollment_status : 'active';
            foreach ($request->bidang_ajar as $bidangAjarItem) {
                $kelas = Kelas::where('nama_kelas', $bidangAjarItem)->first();
                if ($kelas) {
                    $user->enrollments()->create([
                        'kelas_id' => $kelas->id,
                        'status' => $status,
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

        $baseValidated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,guru,siswa',
        ]);

        $userData = $baseValidated;

        if ($request->role === 'siswa') {
            $studentValidated = $request->validate([
                'tanggal_pendaftaran' => 'nullable|date',
                'sekolah' => 'nullable|string|max:255',
                'bidang_ajar' => 'nullable|array',
                'bidang_ajar.*' => 'exists:kelas,nama_kelas',
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
                'enrollment_status' => 'required|in:active,inactive',
            ]);
            $studentValidated['bidang_ajar'] = json_encode($studentValidated['bidang_ajar'] ?? []);
            $userData = array_merge($userData, $studentValidated);

        } elseif ($request->role === 'guru') {
            $guruValidated = $request->validate([
                'bidang_ajar' => 'nullable|array',
                'bidang_ajar.*' => 'exists:kelas,nama_kelas',
            ]);
            $userData['bidang_ajar'] = json_encode($guruValidated['bidang_ajar'] ?? []);
        }

        $user->update($userData);

        if ($baseValidated['password']) {
            $user->update(['password' => Hash::make($baseValidated['password'])]);
        }

        if (($request->role === 'siswa' || $request->role === 'guru')) {
            $selectedKelasIds = [];
            if (!empty($request->bidang_ajar)) {
                $selectedKelasIds = Kelas::whereIn('nama_kelas', $request->bidang_ajar)->pluck('id')->toArray();
            }

            $currentKelasIds = \App\Models\Enrollment::where('user_id', $user->id)->pluck('kelas_id')->toArray();

            $idsToDelete = array_diff($currentKelasIds, $selectedKelasIds);
            $idsToAdd = array_diff($selectedKelasIds, $currentKelasIds);
            $idsToUpdate = array_intersect($currentKelasIds, $selectedKelasIds);

            if (!empty($idsToDelete)) {
                \App\Models\Enrollment::where('user_id', $user->id)->whereIn('kelas_id', $idsToDelete)->delete();
            }

            foreach ($idsToAdd as $kelasId) {
                $status = ($request->role === 'siswa') ? $request->enrollment_status : 'active';
                \App\Models\Enrollment::create([
                    'user_id' => $user->id,
                    'kelas_id' => $kelasId,
                    'status' => $status,
                ]);
            }

            if (!empty($idsToUpdate)) {
                $status = ($request->role === 'siswa') ? $request->enrollment_status : 'active';
                \App\Models\Enrollment::where('user_id', $user->id)
                    ->whereIn('kelas_id', $idsToUpdate)
                    ->update(['status' => $status]);
            }
        }

        return redirect()->route('admin.users.index', ['role' => $user->role])
            ->with('success', 'User berhasil diperbarui.');
    }



    public function destroy(User $user)
    {
        $role = $user->role;
        $user->delete();

        return redirect()->route('admin.users.index', ['role' => $role])
            ->with('success', 'User berhasil dihapus.');
    }


}
