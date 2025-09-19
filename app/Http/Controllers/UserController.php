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
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

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
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ]);

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
