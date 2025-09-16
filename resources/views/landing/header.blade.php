<!-- Header / Navigasi -->
<header class="bg-white shadow-sm sticky top-0 z-50">
    <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-2">
             <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-lg">M</div>
             <span class="text-xl font-bold text-gray-800">Materi Online</span>
        </div>
        <div class="hidden md:flex items-center space-x-8">
            <a href="#fitur" class="text-gray-600 hover:text-indigo-600">Fitur</a>
            <a href="#kelas" class="text-gray-600 hover:text-indigo-600">Kelas</a>
            <a href="#alur" class="text-gray-600 hover:text-indigo-600">Alur Kerja</a>
            <a href="#kontak" class="text-gray-600 hover:text-indigo-600">Kontak</a>
        </div>
        <a href="/login" class="hidden md:block bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-300">
            Masuk
        </a>
        <button id="mobile-menu-button" class="md:hidden text-gray-700 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
        </button>
    </nav>
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden px-6 pb-4">
        <a href="#fitur" class="block py-2 text-gray-600 hover:text-indigo-600">Fitur</a>
        <a href="#kelas" class="block py-2 text-gray-600 hover:text-indigo-600">Kelas</a>
        <a href="#alur" class="block py-2 text-gray-600 hover:text-indigo-600">Alur Kerja</a>
        <a href="#kontak" class="block py-2 text-gray-600 hover:text-indigo-600">Kontak</a>
         <a href="/login" class="block w-full text-center mt-2 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-300">
            Masuk
        </a>
    </div>
</header>