<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @auth
                <!-- Sidebar Layout for Authenticated Users -->
                <div class="flex">
                    <!-- Sidebar -->
                    <div class="hidden lg:flex lg:flex-shrink-0">
                        <div class="flex flex-col w-64">
                            <x-sidebar :user="auth()->user()" />
                        </div>
                    </div>

                    <!-- Main Content Area -->
                    <div class="flex-1 flex flex-col min-w-0">
                        <!-- Top Navigation Bar (Mobile) -->
                        <div class="lg:hidden">
                            @include('layouts.navigation')
                        </div>

                        <!-- Page Heading -->
                        @isset($header)
                            <header class="bg-white shadow">
                                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                                    {{ $header }}
                                </div>
                            </header>
                        @endisset

                        <!-- Page Content -->
                        <main class="flex-1">
                            {{ $slot }}
                        </main>
                    </div>
                </div>

                <!-- Mobile Sidebar -->
                <div class="lg:hidden">
                    <x-sidebar :user="auth()->user()" />
                </div>
            @else
                <!-- Guest Layout -->
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            @endauth
        </div>
    </body>
</html>
