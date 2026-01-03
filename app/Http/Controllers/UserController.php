<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use App\Helpers\ActivityLogger;
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
        $search = $request->get('search');

        $query = User::query();

        // Eager-load enrolled classes with pivot fields for Sisa Sesi computation
        $query->with('enrolledClasses');

        if ($role) {
            $query->where('role', $role);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
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
        // Get all active classes - siswa can enroll in any class (dasar, umum, mahasiswa, etc.)
        $kelas = Kelas::where('status', 'active')->orderBy('nama_kelas')->get();
        
        return view('admin.users.create', compact('role', 'kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $baseValidated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->whereNull('deleted_at')],
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,guru,siswa',
        ]);

        $userData = $baseValidated;
        $userData['password'] = Hash::make($baseValidated['password']);

        if ($request->role === 'siswa') {
            $payment_fields = ['biaya_pendaftaran', 'biaya_angsuran', 'total_biaya', 'discount_value'];
            foreach ($payment_fields as $field) {
                if ($request->has($field)) {
                    $cleaned_value = preg_replace('/[^\d]/', '', $request->input($field));
                    $request->merge([$field => $cleaned_value === '' ? null : $cleaned_value]);
                }
            }

            $studentValidated = $request->validate([
                'tanggal_pendaftaran' => 'nullable|date',
                'enrollment_start_date' => 'required|date',
                'enrollment_duration_months' => 'required|integer|in:1,3,6,12',
                'enrollment_monthly_quota' => 'required|integer|in:4,8',
                'sekolah' => 'required|string|max:255',
                'kelas_sekolah' => 'required|string|max:50',
                'bidang_ajar' => 'nullable|array',
                'bidang_ajar.*' => 'exists:kelas,nama_kelas',
                'hari_belajar' => 'nullable|array',
                'durasi' => 'nullable|string|max:255',
                'metode_pembayaran' => 'nullable|in:transfer,cash',
                'biaya_pendaftaran' => 'nullable|numeric|min:0',
                'biaya_angsuran' => 'nullable|numeric|min:0',
                'total_biaya' => 'nullable|numeric|min:0',
                'status_promo' => 'nullable|string|max:255',
                'discount_type' => 'nullable|in:percentage,fixed',
                'discount_value' => 'nullable|numeric|min:0',
                'no_telepon' => 'nullable|string|max:20',
                'alamat' => 'nullable|string',
                // Address detail fields (optional, will be combined into alamat)
                'jalan' => 'nullable|string|max:255',
                'provinsi' => 'nullable|string|max:100',
                'kota' => 'nullable|string|max:100',
                'kecamatan' => 'nullable|string|max:100',
                'kelurahan' => 'nullable|string|max:100',
                'tanggal_lahir' => 'nullable|date|before_or_equal:today',
                'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
                'enrollment_status' => 'required|in:active,inactive',
            ]);

            $total_biaya = $studentValidated['total_biaya'] ?? 0;
            $discount_type = $studentValidated['discount_type'] ?? null;
            $discount_value = $studentValidated['discount_value'] ?? 0;
            $durationMonths = (int) ($studentValidated['enrollment_duration_months'] ?? 0);
            $monthlyQuota = (int) ($studentValidated['enrollment_monthly_quota'] ?? 0);
            $targetSessions = $durationMonths > 0 && $monthlyQuota > 0 ? $durationMonths * $monthlyQuota : null;

            // Backfill durasi string for compatibility
            if (empty($studentValidated['durasi']) && $durationMonths > 0) {
                $studentValidated['durasi'] = $durationMonths . ' Bulan';
            }

            if (isset($studentValidated['status_promo']) && $studentValidated['status_promo'] === 'Beasiswa') {
                $studentValidated['total_setelah_diskon'] = 0;
            } elseif ($total_biaya && $discount_type && $discount_value) {
                if ($discount_type === 'percentage') {
                    $studentValidated['total_setelah_diskon'] = $total_biaya - ($total_biaya * ($discount_value / 100));
                } else {
                    $studentValidated['total_setelah_diskon'] = $total_biaya - $discount_value;
                }
            } else {
                $studentValidated['total_setelah_diskon'] = $total_biaya;
            }
            
            // If alamat is not provided but address details are, combine them
            if (empty($studentValidated['alamat']) && 
                (!empty($request->jalan) || !empty($request->provinsi) || !empty($request->kota))) {
                $parts = [];
                if (!empty($request->jalan)) $parts[] = $request->jalan;
                if (!empty($request->kelurahan)) $parts[] = 'Kel. ' . $request->kelurahan;
                if (!empty($request->kecamatan)) $parts[] = 'Kec. ' . $request->kecamatan;
                if (!empty($request->kota)) $parts[] = $request->kota;
                if (!empty($request->provinsi)) $parts[] = $request->provinsi;
                $studentValidated['alamat'] = implode(', ', $parts);
            }
            
            // Store kelas_sekolah in sekolah field or create a new field
            // For now, we'll append it to sekolah field
            if (!empty($studentValidated['kelas_sekolah'])) {
                $studentValidated['sekolah'] = $studentValidated['sekolah'] . ' - ' . $studentValidated['kelas_sekolah'];
            }
            
            $userData = array_merge($userData, $studentValidated);

            // Save target sessions info for later enrollment creation
            $userData['_target_sessions'] = $targetSessions;
            $userData['_duration_months'] = $durationMonths;
            $userData['_monthly_quota'] = $monthlyQuota;
            $userData['_start_date'] = $studentValidated['enrollment_start_date'];

        } elseif ($request->role === 'guru') {
            $guruValidated = $request->validate([
                'bidang_ajar' => 'nullable|array',
                'bidang_ajar.*' => 'exists:kelas,nama_kelas',
                'no_telepon' => 'nullable|string|max:20',
            ]);
            $userData['bidang_ajar'] = $guruValidated['bidang_ajar'] ?? [];
            $userData['no_telepon'] = $guruValidated['no_telepon'] ?? null;
        }

        $metaKeys = ['_target_sessions', '_duration_months', '_monthly_quota', '_start_date'];
        $metaValues = [];
        foreach ($metaKeys as $key) {
            if (array_key_exists($key, $userData)) {
                $metaValues[$key] = $userData[$key];
                unset($userData[$key]);
            }
        }

        $existingUser = User::withTrashed()->where('email', $userData['email'])->first();
        $wasRestored = false;
        $oldValues = null;

        if ($existingUser && $existingUser->trashed()) {
            $wasRestored = true;
            $oldValues = $existingUser->toArray();
            $existingUser->restore();
            $existingUser->forceFill($userData);
            $existingUser->save();
            $user = $existingUser;
        } else {
            $user = User::create($userData);
        }

        $enrollmentMeta = [
            'start_date' => $metaValues['_start_date'] ?? null,
            'duration_months' => $metaValues['_duration_months'] ?? null,
            'monthly_quota' => $metaValues['_monthly_quota'] ?? null,
            'target_sessions' => $metaValues['_target_sessions'] ?? null,
        ];

        // Generate kode otomatis untuk admin dan guru bila belum ada
        if ($request->role === 'admin' && empty($user->kode_admin)) {
            $kodeAdmin = User::generateKodeAdmin();
            $user->update(['kode_admin' => $kodeAdmin]);
        } elseif ($request->role === 'guru' && empty($user->kode_guru)) {
            $kodeGuru = User::generateKodeGuru();
            $user->update(['kode_guru' => $kodeGuru]);
        }

        $selectedKelas = collect();
        if (($request->role === 'siswa' || $request->role === 'guru') && !empty($request->bidang_ajar)) {
            $selectedKelas = Kelas::whereIn('nama_kelas', $request->bidang_ajar)->get();
            $selectedKelasIds = $selectedKelas->pluck('id')->toArray();

            // Only create enrollments for SISWA, not for GURU
            if ($request->role === 'siswa') {
                if (!empty($selectedKelasIds)) {
                    $user->enrollments()->whereNotIn('kelas_id', $selectedKelasIds)->delete();
                }

                $status = $request->enrollment_status;

                foreach ($selectedKelas as $kelas) {
                    $enrollment = $user->enrollments()->where('kelas_id', $kelas->id)->first();

                    if ($enrollment) {
                        $enrollment->update([
                            'status' => $status,
                            'start_date' => $enrollmentMeta['start_date'],
                            'duration_months' => $enrollmentMeta['duration_months'],
                            'monthly_quota' => $enrollmentMeta['monthly_quota'],
                            'target_sessions' => $enrollmentMeta['target_sessions'],
                        ]);
                    } else {
                        $user->enrollments()->create([
                            'kelas_id' => $kelas->id,
                            'status' => $status,
                            'sessions_attended' => 0,
                            'start_date' => $enrollmentMeta['start_date'],
                            'duration_months' => $enrollmentMeta['duration_months'],
                            'monthly_quota' => $enrollmentMeta['monthly_quota'],
                            'target_sessions' => $enrollmentMeta['target_sessions'],
                        ]);

                        if (!$user->id_siswa) {
                            $idSiswa = User::generateIdSiswa($kelas->id);
                            $user->update(['id_siswa' => $idSiswa]);
                        }
                    }
                }
            } else {
                // For GURU/ADMIN, remove all enrollments since they don't need to be enrolled as students
                $user->enrollments()->delete();
            }
        }

        if ($request->role === 'siswa' && !$user->id_siswa && $user->enrollments()->exists()) {
            $kelasId = $user->enrollments()->value('kelas_id');
            if ($kelasId) {
                $user->update(['id_siswa' => User::generateIdSiswa($kelasId)]);
            }
        }

        // Log activity
        if ($wasRestored) {
            $newValues = $user->fresh()->toArray();
            ActivityLogger::logUserUpdated($user, $oldValues ?? [], $newValues);
            $message = 'User berhasil dipulihkan dan diperbarui.';
        } else {
            ActivityLogger::logUserCreated($user);
            $message = 'User berhasil dibuat.';
        }

        return redirect()->route('admin.users.index', ['role' => $user->role])
            ->with('success', $message);
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
        // Get all active classes - siswa can enroll in any class (dasar, umum, mahasiswa, etc.)
        $kelas = Kelas::where('status', 'active')->orderBy('nama_kelas')->get();
        $enrolledClassIds = $user->enrolledClasses->pluck('id')->toArray();
        
        return view('admin.users.edit', compact('user', 'kelas', 'enrolledClassIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Sanitize currency fields before validation
        $payment_fields = ['biaya_pendaftaran', 'biaya_angsuran', 'total_biaya', 'discount_value'];
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
            'role' => 'required|in:admin,guru,siswa',
        ]);

        $userData = $baseValidated;

        // Handle password separately
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);
            $userData['password'] = Hash::make($request->password);
        }

        if ($request->role === 'siswa') {
            $studentValidated = $request->validate([
                'tanggal_pendaftaran' => 'nullable|date',
                'enrollment_start_date' => 'required|date',
                'enrollment_duration_months' => 'required|integer|in:1,3,6,12',
                'enrollment_monthly_quota' => 'required|integer|in:4,8',
                'sekolah' => 'nullable|string|max:255',
                'kelas_sekolah' => 'nullable|string|max:50',
                'bidang_ajar' => 'nullable|array',
                'bidang_ajar.*' => 'exists:kelas,nama_kelas',
                'hari_belajar' => 'nullable|array',
                'durasi' => 'nullable|string|max:255',
                'metode_pembayaran' => 'nullable|in:transfer,cash',
                'biaya_pendaftaran' => 'nullable|numeric|min:0',
                'biaya_angsuran' => 'nullable|numeric|min:0',
                'total_biaya' => 'nullable|numeric|min:0',
                'status_promo' => 'nullable|string|max:255',
                'discount_type' => 'nullable|in:percentage,fixed',
                'discount_value' => 'nullable|numeric|min:0',
                'no_telepon' => 'nullable|string|max:20',
                'alamat' => 'nullable|string',
                'tanggal_lahir' => 'nullable|date|before_or_equal:today',
                'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
                'enrollment_status' => 'required|in:active,inactive',
            ]);

            // Combine school name and class level
            if (!empty($studentValidated['kelas_sekolah'])) {
                $studentValidated['sekolah'] = $studentValidated['sekolah'] . ' - ' . $studentValidated['kelas_sekolah'];
            }

            $total_biaya = $studentValidated['total_biaya'] ?? 0;
            $discount_type = $studentValidated['discount_type'] ?? null;
            $discount_value = $studentValidated['discount_value'] ?? 0;
            $durationMonths = (int) ($studentValidated['enrollment_duration_months'] ?? 0);
            $monthlyQuota = (int) ($studentValidated['enrollment_monthly_quota'] ?? 0);
            $targetSessions = $durationMonths > 0 && $monthlyQuota > 0 ? $durationMonths * $monthlyQuota : null;

            // Backfill durasi string for compatibility
            if (empty($studentValidated['durasi']) && $durationMonths > 0) {
                $studentValidated['durasi'] = $durationMonths . ' Bulan';
            }

            if (isset($studentValidated['status_promo']) && $studentValidated['status_promo'] === 'Beasiswa') {
                $studentValidated['total_setelah_diskon'] = 0;
            } elseif ($total_biaya && $discount_type && $discount_value) {
                if ($discount_type === 'percentage') {
                    $studentValidated['total_setelah_diskon'] = $total_biaya - ($total_biaya * ($discount_value / 100));
                } else {
                    $studentValidated['total_setelah_diskon'] = $total_biaya - $discount_value;
                }
            } else {
                $studentValidated['total_setelah_diskon'] = $total_biaya;
            }
            
            $userData = array_merge($userData, $studentValidated);

            // Save target sessions info for enrollment updates
            $userData['_target_sessions'] = $targetSessions;
            $userData['_duration_months'] = $durationMonths;
            $userData['_monthly_quota'] = $monthlyQuota;
            $userData['_start_date'] = $studentValidated['enrollment_start_date'];

        } elseif ($request->role === 'guru') {
            $guruValidated = $request->validate([
                'bidang_ajar' => 'nullable|array',
                'bidang_ajar.*' => 'exists:kelas,nama_kelas',
                'no_telepon' => 'nullable|string|max:20',
            ]);
            $userData['bidang_ajar'] = $guruValidated['bidang_ajar'] ?? [];
            $userData['no_telepon'] = $guruValidated['no_telepon'] ?? $user->no_telepon;
        }

        // Log activity
        $oldValues = $user->toArray();
        $user->update($userData);
        $newValues = $user->fresh()->toArray();

        // Handle enrollment ONLY for students, not for teachers
        if ($request->role === 'siswa') {
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
                \App\Models\Enrollment::create([
                    'user_id' => $user->id,
                    'kelas_id' => $kelasId,
                    'status' => $request->enrollment_status,
                    'start_date' => $userData['_start_date'] ?? null,
                    'duration_months' => $userData['_duration_months'] ?? null,
                    'monthly_quota' => $userData['_monthly_quota'] ?? null,
                    'target_sessions' => $userData['_target_sessions'] ?? null,
                    'sessions_attended' => 0,
                ]);
            }

            if (!empty($idsToUpdate)) {
                $updatePayload = [
                    'status' => $request->enrollment_status,
                    'start_date' => $userData['_start_date'] ?? null,
                    'duration_months' => $userData['_duration_months'] ?? null,
                    'monthly_quota' => $userData['_monthly_quota'] ?? null,
                    'target_sessions' => $userData['_target_sessions'] ?? null,
                ];

                \App\Models\Enrollment::where('user_id', $user->id)
                    ->whereIn('kelas_id', $idsToUpdate)
                    ->update($updatePayload);
            }

            // Auto-generate id_siswa if missing and siswa now has at least one kelas
            if ($request->role === 'siswa' && empty($user->id_siswa)) {
                $kelasIdForId = null;
                if (!empty($idsToAdd)) {
                    $kelasIdForId = reset($idsToAdd);
                } elseif (!empty($selectedKelasIds)) {
                    $kelasIdForId = reset($selectedKelasIds);
                } elseif (!empty($currentKelasIds)) {
                    $kelasIdForId = reset($currentKelasIds);
                }

                if ($kelasIdForId) {
                    $generated = \App\Models\User::generateIdSiswa($kelasIdForId);
                    $user->update(['id_siswa' => $generated]);
                }
            }
        }

        // Log activity
        ActivityLogger::logUserUpdated($user, $oldValues, $newValues);

        return redirect()->route('admin.users.index', ['role' => $user->role])
            ->with('success', 'User berhasil diperbarui.');
    }



    public function deactivate(User $user)
    {
        $role = $user->role;
        
        // Hanya bisa menonaktifkan siswa
        if (!$user->isSiswa()) {
            return redirect()->route('admin.users.index', ['role' => $role])
                ->with('error', 'Hanya siswa yang dapat dinonaktifkan.');
        }
        
        // Ubah semua enrollment status menjadi 'inactive'
        $user->enrollments()->update(['status' => 'inactive']);
        
        // Log activity
        ActivityLogger::logUserDeleted($user);

        return redirect()->route('admin.users.index', ['role' => $role])
            ->with('success', 'Siswa berhasil dinonaktifkan. Siswa tidak dapat mengakses sistem lagi.');
    }

    public function activate(User $user)
    {
        $role = $user->role;
        
        // Hanya bisa mengaktifkan siswa
        if (!$user->isSiswa()) {
            return redirect()->route('admin.users.index', ['role' => $role])
                ->with('error', 'Hanya siswa yang dapat diaktifkan.');
        }
        
        // Ubah semua enrollment status menjadi 'active'
        $user->enrollments()->update(['status' => 'active']);
        
        // Log activity
        ActivityLogger::logUserUpdated($user, [], []);

        return redirect()->route('admin.users.index', ['role' => $role])
            ->with('success', 'Siswa berhasil diaktifkan kembali. Siswa dapat mengakses sistem.');
    }

    public function destroy(User $user)
    {
        $role = $user->role;
        $userData = $user->toArray();
        
        // Log activity sebelum delete
        ActivityLogger::logUserDeleted($user);
        
        // Soft delete - data tidak dihapus permanen, hanya ditandai sebagai tidak aktif
        $user->delete();

        return redirect()->route('admin.users.index', ['role' => $role])
            ->with('success', 'User berhasil dinonaktifkan. Data masih tersimpan di database.');
    }

    /**
     * Tampilkan daftar user yang telah dihapus (soft deleted)
     */
    public function showDeleted(Request $request)
    {
        $role = $request->get('role');
        $search = $request->get('search');

        $query = User::onlyTrashed();

        if ($role) {
            $query->where('role', $role);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest('deleted_at')->paginate(10);

        return view('admin.users.deleted', compact('users', 'role'));
    }

    /**
     * Restore user yang telah dihapus
     */
    public function restore(Request $request, $id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        
        // Restore user
        $user->restore();

        // If role is siswa, also reactivate all enrollments
        if ($user->isSiswa()) {
            $user->enrollments()->where('status', 'inactive')->update(['status' => 'active']);
        }

        // Log activity
        ActivityLogger::logUserUpdated($user, ['deleted_at' => $user->deleted_at], []);

        return redirect()->route('admin.users.index', ['role' => $user->role])
            ->with('success', 'User berhasil di-restore. Email sudah bisa digunakan kembali untuk registrasi.');
    }


}
