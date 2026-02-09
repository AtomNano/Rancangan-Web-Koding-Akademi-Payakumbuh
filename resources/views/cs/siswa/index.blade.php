<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Siswa') }}
        </h2>
        <p class="text-sm text-gray-500">Kelola data siswa dan pendaftaran kelas</p>
    </x-slot>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Berhasil!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20">
                    <title>Close</title>
                    <path
                        d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.15a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.029a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.15 2.758 3.15a1.2 1.2 0 0 1 0 1.697z" />
                </svg>
            </span>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20">
                    <title>Close</title>
                    <path
                        d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.15a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.029a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.15 2.758 3.15a1.2 1.2 0 0 1 0 1.697z" />
                </svg>
            </span>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-5 rounded-lg shadow-sm flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-500">Total Siswa</p>
                <p class="text-3xl font-bold text-gray-800">{{ $stats['siswa'] }}</p>
            </div>
            <div class="bg-blue-100 p-3 rounded-full">
                <svg class="h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path
                        d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-5.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-5.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222 4 2.222V20" />
                </svg>
            </div>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-sm flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-500">Siswa Aktif</p>
                @php
                    $siswaAktif = \App\Models\User::where('role', 'siswa')->get()->filter(fn($u) => $u->is_active)->count();
                @endphp
                <p class="text-3xl font-bold text-gray-800">{{ $siswaAktif }}</p>
            </div>
            <div class="bg-green-100 p-3 rounded-full">
                <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-sm flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-500">Tidak Aktif</p>
                <p class="text-3xl font-bold text-gray-800">{{ $stats['inactive'] }}</p>
            </div>
            <div class="bg-red-100 p-3 rounded-full">
                <svg class="h-6 w-6 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="flex items-center space-x-2 mb-4 md:mb-0 w-full md:w-auto">
                <form action="{{ route('cs.siswa.index') }}" method="GET" class="w-full">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none">
                                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </span>
                        <input type="text" name="search"
                            class="w-full md:w-64 py-2 pl-10 pr-4 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            placeholder="Cari siswa..." value="{{ request('search') }}">
                    </div>
                </form>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('cs.siswa.create', ['role' => 'siswa']) }}"
                    class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg class="mr-2 -ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m0-6H6" />
                    </svg>
                    Tambah Siswa
                </a>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200">
        <div class="overflow-x-auto lg:overflow-x-visible">
            <table class="min-w-full divide-y divide-gray-200 table-auto">
                <thead class="bg-gradient-to-r from-gray-100 to-gray-50 border-b-2 border-gray-200">
                    <tr>
                        <th scope="col"
                            class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider whitespace-nowrap">
                            Siswa</th>
                        <th scope="col"
                            class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider whitespace-nowrap">
                            Sisa Sesi</th>
                        <th scope="col"
                            class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider whitespace-nowrap">
                            ID Siswa</th>
                        <th scope="col"
                            class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider whitespace-nowrap">
                            Kelas</th>
                        <th scope="col"
                            class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider whitespace-nowrap">
                            Status</th>
                        <th scope="col"
                            class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider whitespace-nowrap">
                            Bergabung</th>
                        <th scope="col"
                            class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider whitespace-nowrap">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($users as $user)
                        <tr class="hover:bg-indigo-50 transition-colors">
                            <td class="px-4 py-4 align-top">
                                <a href="{{ route('cs.siswa.show', $user->id) }}" class="hover:opacity-80 group">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div
                                                class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-lg flex items-center justify-center shadow group-hover:shadow-md transition">
                                                <span
                                                    class="text-white font-bold text-sm">{{ substr($user->name, 0, 2) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-gray-900">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-500 mt-0.5">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <!-- Sisa Sesi Belajar -->
                            <td class="px-4 py-4 align-top">
                                @php
                                    $remainingSessions = null;
                                    if ($user->enrolledClasses && $user->enrolledClasses->count() > 0) {
                                        $remainingSessions = 0;
                                        $hasTarget = false;
                                        foreach ($user->enrolledClasses as $kelas) {
                                            $ts = $kelas->pivot->target_sessions ?? null;
                                            $sa = $kelas->pivot->sessions_attended ?? 0;
                                            if (!is_null($ts)) {
                                                $hasTarget = true;
                                                $remainingSessions += max(0, (int) $ts - (int) $sa);
                                            }
                                        }
                                        if (!$hasTarget) {
                                            $remainingSessions = null;
                                        }
                                    }
                                @endphp
                                @if(!is_null($remainingSessions))
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-200">
                                        {{ $remainingSessions }} sesi
                                    </span>
                                @else
                                    <span class="text-gray-400 italic">-</span>
                                @endif
                            </td>
                            <!-- ID Siswa -->
                            <td class="px-4 py-4 align-top">
                                @php
                                    $displayIdSiswa = $user->student_id ?: $user->id_siswa;
                                @endphp
                                @if($displayIdSiswa)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-indigo-100 text-indigo-800 border border-indigo-200">
                                        {{ $displayIdSiswa }}
                                    </span>
                                @else
                                    <span class="text-gray-400 italic">-</span>
                                @endif
                            </td>
                            <!-- Kelas -->
                            <td class="px-4 py-4 text-sm text-gray-700 align-top">
                                @if($user->enrolledClasses->count() > 0)
                                    <div class="flex flex-wrap gap-1.5 max-w-xs">
                                        @foreach($user->enrolledClasses as $kelas)
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700 border border-indigo-200">
                                                {{ $kelas->nama_kelas }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-400 italic">-</span>
                                @endif
                            </td>
                            <!-- Status -->
                            <td class="px-4 py-4 align-top">
                                <div class="inline-flex items-center">
                                    @if($user->is_active)
                                        <div class="flex items-center">
                                            <div class="h-2 w-2 bg-green-500 rounded-full mr-2"></div>
                                            <span
                                                class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">Aktif</span>
                                        </div>
                                    @else
                                        <div class="flex items-center">
                                            <div class="h-2 w-2 bg-red-500 rounded-full mr-2"></div>
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">Tidak
                                                Aktif</span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <!-- Bergabung -->
                            <td class="px-4 py-4 text-sm font-medium text-gray-700 align-top">
                                {{ $user->created_at->format('d/m/Y') }}
                            </td>
                            <!-- Aksi -->
                            <td class="px-4 py-4 text-sm font-medium align-top">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('cs.siswa.edit', $user->id) }}"
                                        class="inline-flex items-center px-3 py-2 rounded-lg text-indigo-600 hover:text-white bg-indigo-50 hover:bg-indigo-600 transition-all duration-200 font-semibold text-xs"
                                        title="Edit">
                                        <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L16.732 3.732z" />
                                        </svg>
                                        Edit
                                    </a>
                                    @if($user->is_active)
                                        <form action="{{ route('cs.siswa.deactivate', $user->id) }}" method="POST"
                                            onsubmit="return confirm('Anda yakin ingin menonaktifkan siswa ini?');"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-2 rounded-lg text-yellow-600 hover:text-white bg-yellow-50 hover:bg-yellow-600 transition-all duration-200 font-semibold text-xs"
                                                title="Nonaktifkan">
                                                <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                </svg>
                                                Nonaktif
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('cs.siswa.activate', $user->id) }}" method="POST"
                                            onsubmit="return confirm('Anda yakin ingin mengaktifkan siswa ini?');"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-2 rounded-lg text-green-600 hover:text-white bg-green-50 hover:bg-green-600 transition-all duration-200 font-semibold text-xs"
                                                title="Aktifkan">
                                                <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Aktif
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('cs.siswa.destroy', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Anda yakin ingin menghapus siswa ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-2 rounded-lg text-red-600 hover:text-white bg-red-50 hover:bg-red-600 transition-all duration-200 font-semibold text-xs"
                                            title="Hapus">
                                            <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="inline-flex flex-col items-center">
                                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <p class="text-gray-500 font-medium text-sm">Tidak ada data siswa</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>
</x-app-layout>