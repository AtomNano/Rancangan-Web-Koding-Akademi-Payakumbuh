<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Total Guru -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium text-gray-500">Total Guru</h3>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['total_guru'] ?? 0 }}</p>
                    </div>
                </div>
                <!-- Total Siswa -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium text-gray-500">Total Siswa</h3>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['total_siswa'] ?? 0 }}</p>
                    </div>
                </div>
                <!-- Total Kelas -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium text-gray-500">Total Kelas</h3>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['total_kelas'] ?? 0 }}</p>
                    </div>
                </div>
                <!-- Pending Materi -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium text-gray-500">Pending Materi</h3>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['pending_materi'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


