<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-800 leading-tight">
                {{ __('Verifikasi Materi') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-900">

                    @if (session('success'))
                        <div class="bg-green-500/10 border border-green-500/20 text-green-600 px-4 py-3 rounded-lg relative mb-5" role="alert">
                            <strong class="font-bold">Berhasil!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="mb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-900">Materi Menunggu Verifikasi</h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-600">
                            Berikut adalah daftar materi yang diunggah oleh guru dan memerlukan persetujuan Anda.
                        </p>
                    </div>

                    <!-- Filter and Search -->
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex space-x-4">
                            <a href="{{ route('admin.materi.index', ['status' => 'pending']) }}" class="px-3 py-2 text-sm font-medium rounded-md {{ request('status', 'pending') == 'pending' ? 'bg-indigo-600 text-white' : 'bg-gray-200 dark:bg-gray-200 text-gray-800 dark:text-gray-800' }}">
                                Pending
                            </a>
                            <a href="{{ route('admin.materi.index', ['status' => 'approved']) }}" class="px-3 py-2 text-sm font-medium rounded-md {{ request('status') == 'approved' ? 'bg-indigo-600 text-white' : 'bg-gray-200 dark:bg-gray-200 text-gray-800 dark:text-gray-800' }}">
                                Approved
                            </a>
                            <a href="{{ route('admin.materi.index', ['status' => 'rejected']) }}" class="px-3 py-2 text-sm font-medium rounded-md {{ request('status') == 'rejected' ? 'bg-indigo-600 text-white' : 'bg-gray-200 dark:bg-gray-200 text-gray-800 dark:text-gray-800' }}">
                                Rejected
                            </a>
                        </div>
                    </div>

                    <!-- Materi Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse ($materi as $item)
                            <div class="bg-white dark:bg-white rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300 border dark:border-gray-200">
                                <div class="p-5">
                                    <div class="flex justify-between items-start">
                                        <h4 class="text-lg font-bold text-gray-900 dark:text-gray-900 mb-2 truncate pr-4" title="{{ $item->judul }}">
                                            <a href="{{ route('admin.materi.show', $item->id) }}" class="hover:text-indigo-600 dark:hover:text-indigo-600">
                                                {{ $item->judul }}
                                            </a>
                                        </h4>
                                        @php
                                            $status_classes = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'approved' => 'bg-green-100 text-green-800',
                                                'rejected' => 'bg-red-100 text-red-800',
                                            ];
                                        @endphp
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $status_classes[$item->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </div>
                                    
                                    <p class="text-sm text-gray-600 dark:text-gray-600 mb-1">
                                        <span class="font-semibold">Kelas:</span> {{ $item->kelas->nama_kelas ?? 'N/A' }}
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-600 mb-3">
                                        <span class="font-semibold">Pengunggah:</span> {{ $item->uploadedBy->name ?? 'N/A' }}
                                    </p>
                                    
                                    <div class="border-t border-gray-200 dark:border-gray-200 pt-3">
                                        <div class="flex justify-between items-center">
                                            <p class="text-xs text-gray-500 dark:text-gray-500">
                                                {{ $item->created_at->diffForHumans() }}
                                            </p>
                                            
                                            @if ($item->status == 'pending')
                                                <div class="flex items-center space-x-3">
                                                    <form action="{{ route('admin.materi.approve', $item->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menyetujui materi ini?');">
                                                        @csrf
                                                        <button type="submit" class="text-green-600 hover:text-green-800 dark:text-green-600 dark:hover:text-green-800 font-semibold text-sm">Approve</button>
                                                    </form>
                                                    <form action="{{ route('admin.materi.reject', $item->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menolak materi ini?');">
                                                        @csrf
                                                        <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-600 dark:hover:text-red-800 font-semibold text-sm">Reject</button>
                                                    </form>
                                                </div>
                                            @else
                                                <a href="{{ route('admin.materi.show', $item->id) }}" class="text-indigo-600 dark:text-indigo-600 hover:underline text-sm font-semibold">Lihat Detail</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-16">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-900">Tidak Ada Materi</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-500">Tidak ada materi dengan status '{{ request('status', 'pending') }}' saat ini.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $materi->appends(request()->query())->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
