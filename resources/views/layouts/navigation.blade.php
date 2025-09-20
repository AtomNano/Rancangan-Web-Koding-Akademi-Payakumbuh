<nav class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-end h-16">
            <!-- Right-side elements -->
            <div class="flex items-center space-x-6">
                
                <!-- Search Bar -->
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                    <input type="text" class="w-full py-2 pl-10 pr-4 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Cari pengguna, kelas...">
                </div>

                <!-- Notification Bell -->
                <div class="relative">
                    <button class="p-2 bg-gray-100 rounded-full text-gray-600 hover:bg-gray-200 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>
                    <span class="absolute top-0 right-0 block h-2 w-2 transform -translate-y-1/2 translate-x-1/2 rounded-full text-white bg-red-500"></span>
                </div>

                <!-- User Avatar -->
                <div class="w-10 h-10 bg-indigo-500 rounded-full flex items-center justify-center">
                    <span class="text-white font-semibold text-lg">{{ substr(Auth::user()->name, 0, 1) }}</span>
                </div>

            </div>
        </div>
    </div>
</nav>