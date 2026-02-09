<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Log Aktivitas Saya') }}
        </h2>
        <p class="text-sm text-gray-500">Riwayat aktivitas yang Anda lakukan dalam sistem</p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Riwayat Aktivitas</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Waktu</th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi</th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Deskripsi</th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        IP Address</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($activities as $activity)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $activity->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $actionClasses = [
                                                    'create' => 'bg-green-100 text-green-800',
                                                    'update' => 'bg-blue-100 text-blue-800',
                                                    'delete' => 'bg-red-100 text-red-800',
                                                    'login' => 'bg-gray-100 text-gray-800',
                                                    'logout' => 'bg-gray-100 text-gray-800',
                                                    'enroll' => 'bg-purple-100 text-purple-800',
                                                    'unenroll' => 'bg-orange-100 text-orange-800',
                                                ];
                                                $class = $actionClasses[$activity->action] ?? 'bg-gray-100 text-gray-800';

                                                $actionLabels = [
                                                    'create' => 'Buat',
                                                    'update' => 'Ubah',
                                                    'delete' => 'Hapus',
                                                    'enroll' => 'Daftar Kelas',
                                                    'unenroll' => 'Keluar Kelas',
                                                ];
                                                $label = $actionLabels[$activity->action] ?? ucfirst($activity->action);
                                            @endphp
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $class }}">
                                                {{ $label }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $activity->description }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $activity->ip_address }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center italic">
                                            Belum ada aktivitas tercatat.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $activities->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>