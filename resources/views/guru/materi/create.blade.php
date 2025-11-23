<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Materi Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form id="uploadForm" action="{{ route('guru.materi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Loading Overlay -->
                        <div id="loadingOverlay" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                                <div class="mt-3 text-center">
                                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 mb-4">
                                        <svg class="animate-spin h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Mengunggah Materi...</h3>
                                    <p class="text-sm text-gray-500">Mohon tunggu, file sedang diunggah. Jangan tutup halaman ini.</p>
                                    <div class="mt-4">
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div id="progressBar" class="bg-indigo-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <x-input-label for="judul" :value="__('Judul Materi')" />
                                <x-text-input id="judul" class="block mt-1 w-full" type="text" name="judul" :value="old('judul')" required autofocus />
                                <x-input-error :messages="$errors->get('judul')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="deskripsi" :value="__('Deskripsi')" />
                                <textarea id="deskripsi" name="deskripsi" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('deskripsi') }}</textarea>
                                <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="kelas_id" :value="__('Pilih Kelas')" />
                                <select id="kelas_id" name="kelas_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">-- Pilih Kelas yang Akan Diberi Materi --</option>
                                    @foreach($kelas as $k)
                                        <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama_kelas }} ({{ $k->bidang === 'coding' ? 'Coding' : ($k->bidang === 'desain' ? 'Desain' : 'Robotik') }})
                                        </option>
                                    @endforeach
                                </select>
                                <p class="mt-1 text-sm text-gray-500">Pilih kelas yang akan menerima materi ini. Hanya kelas yang Anda ajar yang tersedia.</p>
                                <x-input-error :messages="$errors->get('kelas_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="file_type" :value="__('Tipe File')" />
                                <select id="file_type" name="file_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Pilih Tipe File</option>
                                    <option value="pdf" {{ old('file_type') === 'pdf' ? 'selected' : '' }}>PDF</option>
                                    <option value="video" {{ old('file_type') === 'video' ? 'selected' : '' }}>Video</option>
                                    <option value="document" {{ old('file_type') === 'document' ? 'selected' : '' }}>Dokumen (Word)</option>
                                    <option value="link" {{ old('file_type') === 'link' ? 'selected' : '' }}>Link</option>
                                </select>
                                <x-input-error :messages="$errors->get('file_type')" class="mt-2" />
                            </div>

                            <div id="youtube_link_wrapper" class="{{ old('file_type') === 'video' ? '' : 'hidden' }}">
                                <x-input-label for="youtube_url" :value="__('Link YouTube')" />
                                <x-text-input id="youtube_url" class="block mt-1 w-full" type="url" name="youtube_url" :value="old('youtube_url')" placeholder="https://www.youtube.com/watch?v=..." />
                                <p class="mt-1 text-sm text-gray-500">Tempelkan tautan video YouTube. Video tidak akan diunggah ke server.</p>
                                <x-input-error :messages="$errors->get('youtube_url')" class="mt-2" />
                            </div>

                            <div id="file_input_wrapper" class="{{ old('file_type') === 'video' ? 'hidden' : '' }}">
                                <x-input-label for="file" :value="__('File')" />
                                <input id="file" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="file" name="file" {{ old('file_type') === 'video' ? '' : 'required' }} accept=".pdf,.mp4,.doc,.docx" />
                                <p class="mt-1 text-sm text-gray-500">
                                    <span id="file_size_info">Maksimal: PDF 5MB, Dokumen/Video 100MB</span>
                                </p>
                                <x-input-error :messages="$errors->get('file')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('guru.materi.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Batal
                            </a>
                            <x-primary-button id="submitButton" type="submit">
                                <span id="buttonText">{{ __('Upload Materi') }}</span>
                                <span id="buttonSpinner" class="hidden">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Mengunggah...
                                </span>
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('uploadForm');
            const loadingOverlay = document.getElementById('loadingOverlay');
            const submitButton = document.getElementById('submitButton');
            const buttonText = document.getElementById('buttonText');
            const buttonSpinner = document.getElementById('buttonSpinner');
            const progressBar = document.getElementById('progressBar');
            const fileTypeSelect = document.getElementById('file_type');
            const fileInputWrapper = document.getElementById('file_input_wrapper');
            const youtubeWrapper = document.getElementById('youtube_link_wrapper');
            const fileInput = document.getElementById('file');
            const youtubeInput = document.getElementById('youtube_url');

            function toggleMediaInputs() {
                if (!fileTypeSelect) {
                    return;
                }

                const isVideo = fileTypeSelect.value === 'video';
                if (isVideo) {
                    fileInputWrapper?.classList.add('hidden');
                    fileInput?.removeAttribute('required');
                    youtubeWrapper?.classList.remove('hidden');
                    youtubeInput?.setAttribute('required', 'required');
                } else {
                    fileInputWrapper?.classList.remove('hidden');
                    if (fileInput && !fileInput.hasAttribute('required')) {
                        fileInput.setAttribute('required', 'required');
                    }
                    youtubeWrapper?.classList.add('hidden');
                    youtubeInput?.removeAttribute('required');
                }
            }

            toggleMediaInputs();
            fileTypeSelect?.addEventListener('change', toggleMediaInputs);
            
            // File size validation and popup warning
            const fileSizeInfo = document.getElementById('file_size_info');
            const maxSizes = {
                'pdf': 5 * 1024 * 1024, // 5MB
                'document': 100 * 1024 * 1024, // 100MB
                'link': 0
            };
            
            fileInput?.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;
                
                const fileType = fileTypeSelect?.value;
                const maxSize = maxSizes[fileType] || (100 * 1024 * 1024); // Default 100MB
                
                if (file.size > maxSize) {
                    const maxSizeMB = (maxSize / (1024 * 1024)).toFixed(0);
                    const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
                    
                    alert(`⚠️ File terlalu besar!\n\nUkuran file: ${fileSizeMB} MB\nMaksimal yang diizinkan: ${maxSizeMB} MB\n\nSilakan pilih file yang lebih kecil.`);
                    
                    // Clear the file input
                    e.target.value = '';
                    return false;
                }
                
                // Show file size info
                const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
                fileSizeInfo.textContent = `Ukuran file: ${fileSizeMB} MB (Maksimal: ${(maxSize / (1024 * 1024)).toFixed(0)} MB)`;
            });
            
            // Update file size info when file type changes
            fileTypeSelect?.addEventListener('change', function() {
                const fileType = this.value;
                if (fileType === 'pdf') {
                    fileSizeInfo.textContent = 'Maksimal: 5 MB untuk PDF';
                } else if (fileType === 'document') {
                    fileSizeInfo.textContent = 'Maksimal: 100 MB untuk Dokumen';
                } else if (fileType === 'video') {
                    fileSizeInfo.textContent = 'Untuk video, gunakan link YouTube';
                } else {
                    fileSizeInfo.textContent = 'Maksimal: PDF 5MB, Dokumen/Video 100MB';
                }
            });
            
            // Hide loading on page load (in case of validation errors)
            loadingOverlay.classList.add('hidden');
            submitButton.disabled = false;
            buttonText.classList.remove('hidden');
            buttonSpinner.classList.add('hidden');
            progressBar.style.width = '0%';
            
            // Simulate progress (since we can't track actual upload progress with standard form)
            let progress = 0;
            let progressInterval;
            
            form.addEventListener('submit', function(e) {
                // Validate form before showing loading
                if (!form.checkValidity()) {
                    return;
                }
                
                // Show loading overlay
                loadingOverlay.classList.remove('hidden');
                
                // Disable submit button
                submitButton.disabled = true;
                buttonText.classList.add('hidden');
                buttonSpinner.classList.remove('hidden');
                
                // Simulate progress
                progress = 0;
                progressInterval = setInterval(function() {
                    progress += Math.random() * 15;
                    if (progress > 90) {
                        progress = 90; // Don't go to 100% until upload completes
                    }
                    progressBar.style.width = progress + '%';
                }, 200);
            });
            
            // Hide loading if page is reloaded (validation errors or back button)
            window.addEventListener('pageshow', function(event) {
                loadingOverlay.classList.add('hidden');
                submitButton.disabled = false;
                buttonText.classList.remove('hidden');
                buttonSpinner.classList.add('hidden');
                progressBar.style.width = '0%';
                if (progressInterval) {
                    clearInterval(progressInterval);
                }
            });
        });
    </script>
</x-app-layout>

