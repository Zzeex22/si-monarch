<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Si-MONARCH') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
    </head>
    <body class="font-sans antialiased text-gray-900 dark:text-gray-100 overflow-hidden">
        
        <div class="flex h-screen bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
            
            <!-- Sidebar Navigation (Kiri) -->
            @include('layouts.navigation')

            <!-- Main Content Area (Kanan) -->
            <div class="flex-1 flex flex-col overflow-hidden pt-16 md:pt-0">
                
                <!-- Page Heading Khusus Desktop -->
                @if (isset($header))
                    <header class="bg-white dark:bg-gray-800 shadow z-10 hidden md:block">
                        <div class="py-4 px-6 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content (Bisa di-scroll) -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-gray-900 relative">
                    <!-- Page Heading Khusus Mobile (Muncuk di dalam konten) -->
                    @if (isset($header))
                        <div class="md:hidden bg-white dark:bg-gray-800 shadow px-4 py-3 mb-4">
                            {{ $header }}
                        </div>
                    @endif
                    
                    {{ $slot }}
                </main>
            </div>
        </div>

        <!-- Script Logika Dark Mode Toggle -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
                var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
                var themeToggleBtn = document.getElementById('theme-toggle');

                if (!themeToggleBtn) return;

                if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    themeToggleLightIcon.classList.remove('hidden');
                } else {
                    themeToggleDarkIcon.classList.remove('hidden');
                }

                themeToggleBtn.addEventListener('click', function() {
                    themeToggleDarkIcon.classList.toggle('hidden');
                    themeToggleLightIcon.classList.toggle('hidden');

                    if (localStorage.theme) {
                        if (localStorage.theme === 'light') {
                            document.documentElement.classList.add('dark');
                            localStorage.theme = 'dark';
                        } else {
                            document.documentElement.classList.remove('dark');
                            localStorage.theme = 'light';
                        }
                    } else {
                        if (document.documentElement.classList.contains('dark')) {
                            document.documentElement.classList.remove('dark');
                            localStorage.theme = 'light';
                        } else {
                            document.documentElement.classList.add('dark');
                            localStorage.theme = 'dark';
                        }
                    }
                });
            });
        </script>
    </body>
</html>