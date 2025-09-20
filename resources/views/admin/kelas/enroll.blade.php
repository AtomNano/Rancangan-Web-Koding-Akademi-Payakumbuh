<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftarkan Siswa ke Kelas: ') . $kelas->nama_kelas }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($errors->any())
                        <div class="mb-4">
                            <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>
                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.kelas.enroll.store', $kelas->id) }}" method="POST">
                        @csrf

                        <div class="mt-4">
                            <x-input-label for="student_ids" :value="__('Pilih Siswa untuk Didaftarkan')" />
                            <select name="student_ids[]" id="student_ids" multiple class="block mt-1 w-full h-64 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                @forelse ($availableStudents as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                                @empty
                                    <option disabled>Tidak ada siswa yang tersedia untuk didaftarkan.</option>
                                @endforelse
                            </select>
                            <p class="text-sm text-gray-500 mt-1">Tahan Ctrl (atau Cmd di Mac) untuk memilih lebih dari satu siswa.</p>
                            <x-input-error :messages="$errors->get('student_ids')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.kelas.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                {{ __('Batal') }}
                            </a>

                            <x-primary-button {{ $availableStudents->isEmpty() ? 'disabled' : '' }}>
                                {{ __('Daftarkan Siswa') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>