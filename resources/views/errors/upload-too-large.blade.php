<x-app-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="text-center">
                <svg class="mx-auto h-12 w-12 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h2 class="mt-4 text-xl font-semibold text-gray-900">File Terlalu Besar</h2>
                <p class="mt-2 text-sm text-gray-600">
                    File yang Anda coba upload terlalu besar untuk ukuran yang diizinkan.
                </p>
                
                <div class="mt-4 p-4 bg-yellow-50 rounded-lg">
                    <p class="text-sm font-medium text-gray-900">Konfigurasi Server:</p>
                    <ul class="mt-2 text-sm text-gray-600 space-y-1">
                        <li>Upload Max Size: <strong>{{ $uploadMaxSize ?? 'Unknown' }}</strong></li>
                        <li>POST Max Size: <strong>{{ $maxSize ?? 'Unknown' }}</strong></li>
                    </ul>
                </div>
                
                <div class="mt-6">
                    <a href="{{ url()->previous() }}" 
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                        Kembali
                    </a>
                </div>
                
                @if(app()->environment('local'))
                <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                    <p class="text-xs font-medium text-blue-900">Untuk Development:</p>
                    <p class="mt-1 text-xs text-blue-700">
                        Pastikan Anda sudah <strong>restart Laravel Herd</strong> setelah mengubah php.ini.
                    </p>
                    <p class="mt-2 text-xs text-blue-700">
                        File php.ini: <code class="bg-blue-100 px-1 rounded">C:\Users\atom\.config\herd-lite\bin\php.ini</code>
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

