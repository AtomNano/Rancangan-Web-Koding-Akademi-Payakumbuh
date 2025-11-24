<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Coding Academy Payakumbuh</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/logo/logo-transparent.png') }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo/logo-transparent.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/logo/logo-transparent.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            }
            [x-cloak] {
                display: none !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-slate-50">
        <div x-data="{ sidebarOpen: false }" 
             x-init="
                // Set default sidebar state based on screen size
                if (window.innerWidth >= 768) {
                    sidebarOpen = true;
                }
                // Update on resize
                window.addEventListener('resize', () => {
                    if (window.innerWidth >= 768) {
                        sidebarOpen = true;
                    } else {
                        sidebarOpen = false;
                    }
                });
             "
             class="h-screen flex overflow-hidden">
            <!-- Sidebar -->
            @auth
                <x-sidebar :user="auth()->user()" />
            @endauth

            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden w-full md:w-auto">
                
                @auth
                    <!-- Top Bar -->
                    @include('layouts.navigation')
                @endauth

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white border-b border-slate-200/60 backdrop-blur-sm bg-white/95 sticky top-0 z-10">
                        <div class="max-w-7xl mx-auto py-3 sm:py-4 px-3 sm:px-4 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50">
                    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8 py-4 sm:py-6 lg:py-8">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>
