<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pengguna: ') . $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8">
                    <!-- Header -->
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 pb-4 border-b border-gray-200">
                        <div class="flex items-center mb-4 md:mb-0">
                            <div class="w-20 h-20 bg-indigo-200 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <span class="text-indigo-700 font-bold text-3xl">{{ substr($user->name, 0, 2) }}</span>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                @if($user->isSiswa())
                                <div class="mt-2">
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        Status: {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="flex space-x-2 flex-shrink-0">
                            <a href="{{ route('admin.users.edit', $user->id) }}" 
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <svg class="mr-2 -ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L16.732 3.732z" /></svg>
                                Edit
                            </a>
                            <a href="{{ route('admin.users.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                Kembali
                            </a>
                        </div>
                    </div>

                    @if ($user->isSiswa())
                        <!-- Main Details Grid for SISWA -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <!-- Left Column: Personal & Academic -->
                            <div class="lg:col-span-2 space-y-8">
                                <!-- Data Diri -->
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Data Diri</h4>
                                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                                        <div class="p-3 bg-gray-50 rounded-lg">
                                            <dt class="text-sm font-medium text-gray-500">No. Telepon</dt>
                                            <dd class="text-sm text-gray-900 mt-1">{{ $user->no_telepon ?? '-' }}</dd>
                                        </div>
                                        <div class="p-3 bg-gray-50 rounded-lg">
                                            <dt class="text-sm font-medium text-gray-500">Tanggal Lahir</dt>
                                            <dd class="text-sm text-gray-900 mt-1">{{ $user->tanggal_lahir ? $user->tanggal_lahir->format('d F Y') : '-' }}</dd>
                                        </div>
                                        <div class="p-3 bg-gray-50 rounded-lg">
                                            <dt class="text-sm font-medium text-gray-500">Jenis Kelamin</dt>
                                            <dd class="text-sm text-gray-900 mt-1">{{ ucfirst($user->jenis_kelamin) ?? '-' }}</dd>
                                        </div>
                                        <div class="p-3 bg-gray-50 rounded-lg md:col-span-2">
                                            <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                                            <dd class="text-sm text-gray-900 mt-1">{{ $user->alamat ?? '-' }}</dd>
                                        </div>
                                    </dl>
                                </div>

                                <!-- Informasi Akademik -->
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Informasi Akademik</h4>
                                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                                        <div class="p-3 bg-gray-50 rounded-lg">
                                            <dt class="text-sm font-medium text-gray-500">Tanggal Pendaftaran</dt>
                                            <dd class="text-sm text-gray-900 mt-1">{{ $user->tanggal_pendaftaran ? $user->tanggal_pendaftaran->format('d F Y') : '-' }}</dd>
                                        </div>
                                        <div class="p-3 bg-gray-50 rounded-lg">
                                            <dt class="text-sm font-medium text-gray-500">Sekolah/Institusi</dt>
                                            <dd class="text-sm text-gray-900 mt-1">{{ $user->sekolah ?? '-' }}</dd>
                                        </div>
                                        <div class="p-3 bg-gray-50 rounded-lg">
                                            <dt class="text-sm font-medium text-gray-500">Durasi Program</dt>
                                            <dd class="text-sm text-gray-900 mt-1">{{ $user->durasi ?? '-' }}</dd>
                                        </div>
                                        <div class="p-3 bg-gray-50 rounded-lg">
                                            <dt class="text-sm font-medium text-gray-500">Hari Belajar</dt>
                                            <dd class="text-sm text-gray-900 mt-1">{{ is_array($user->hari_belajar) ? implode(', ', $user->hari_belajar) : '-' }}</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>

                            <!-- Right Column: Payment & Classes -->
                            <div class="space-y-8">
                                <!-- Informasi Pembayaran -->
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pembayaran</h4>
                                    <dl class="space-y-4">
                                        <div class="p-3 bg-blue-50 rounded-lg">
                                            <dt class="text-sm font-medium text-blue-700">Metode Pembayaran</dt>
                                            <dd class="text-sm text-blue-900 mt-1">{{ ucfirst($user->metode_pembayaran) ?? '-' }}</dd>
                                        </div>
                                        <div class="p-3 bg-blue-50 rounded-lg">
                                            <dt class="text-sm font-medium text-blue-700">Biaya Pendaftaran</dt>
                                            <dd class="text-sm text-blue-900 mt-1">Rp {{ number_format($user->biaya_pendaftaran ?? 0, 0, ',', '.') }}</dd>
                                        </div>
                                        <div class="p-3 bg-blue-50 rounded-lg">
                                            <dt class="text-sm font-medium text-blue-700">Biaya Angsuran</dt>
                                            <dd class="text-sm text-blue-900 mt-1">Rp {{ number_format($user->biaya_angsuran ?? 0, 0, ',', '.') }}</dd>
                                        </div>
                                        <div class="p-3 bg-blue-50 rounded-lg">
                                            <dt class="text-sm font-medium text-blue-700">Status Promo</dt>
                                            <dd class="text-sm text-blue-900 mt-1">{{ $user->status_promo ?? '-' }}</dd>
                                        </div>
                                    </dl>
                                </div>

                                <!-- Kelas yang Diikuti -->
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Kelas yang Diikuti</h4>
                                    <div class="space-y-2">
                                        @forelse($user->enrolledClasses as $kelas)
                                            <div class="flex items-center justify-between p-3 bg-gray-100 rounded-lg">
                                                <div>
                                                    <h5 class="text-sm font-medium text-gray-900">{{ $kelas->nama_kelas }}</h5>
                                                    <p class="text-xs text-gray-500">{{ ucfirst($kelas->bidang) }}</p>
                                                </div>
                                                @php
                                                    $status = $kelas->pivot->status;
                                                @endphp
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ ucfirst($status) }}
                                                </span>
                                            </div>
                                        @empty
                                            <p class="text-sm text-gray-500">Siswa ini belum terdaftar di kelas manapun.</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Simple Details for ADMIN / GURU -->
                        <div class="mt-6">
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <dt class="text-sm font-medium text-gray-500">Role</dt>
                                    <dd class="mt-1 text-lg font-semibold text-gray-900">{{ ucfirst($user->role) }}</dd>
                                </div>
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <dt class="text-sm font-medium text-gray-500">Bergabung Sejak</dt>
                                    <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $user->created_at->format('d F Y') }}</dd>
                                </div>

                                @if ($user->isGuru())
                                    <div class="p-4 bg-gray-50 rounded-lg">
                                        <dt class="text-sm font-medium text-gray-500">No. Telepon</dt>
                                        <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $user->no_telepon ?? '-' }}</dd>
                                    </div>
                                    <div class="md:col-span-2">
                                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Kelas yang Diajar</h4>
                                        <div class="space-y-2">
                                            @forelse($user->enrolledClasses as $kelas)
                                                <div class="flex items-center justify-between p-3 bg-gray-100 rounded-lg">
                                                    <div>
                                                        <h5 class="text-sm font-medium text-gray-900">{{ $kelas->nama_kelas }}</h5>
                                                        <p class="text-xs text-gray-500">{{ ucfirst($kelas->bidang) }}</p>
                                                    </div>
                                                </div>
                                            @empty
                                                <p class="text-sm text-gray-500">Guru ini belum mengajar kelas manapun.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
