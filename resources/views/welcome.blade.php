<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Si-MONARCH | Sistem Manajemen Proyek</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white selection:bg-blue-500 selection:text-white">
    
    <div class="relative min-h-screen flex flex-col items-center justify-center overflow-hidden">
        
        <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-blue-400 dark:bg-blue-900 rounded-full mix-blend-multiply filter blur-[100px] opacity-40 animate-blob"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-indigo-400 dark:bg-indigo-900 rounded-full mix-blend-multiply filter blur-[100px] opacity-40 animate-blob animation-delay-2000"></div>

        <div class="relative z-10 w-full max-w-7xl px-6">
            
            <header class="flex justify-between items-center py-6 border-b border-gray-200 dark:border-gray-800">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center text-white font-black text-xl shadow-lg">S</div>
                    <span class="text-2xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400 tracking-tight">Si-MONARCH</span>
                </div>
                
                @if (Route::has('login'))
                    <nav class="flex space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-5 py-2 rounded-full font-semibold text-gray-700 bg-gray-200 hover:bg-gray-300 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition">Ke Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="px-6 py-2 rounded-full font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition">Log In</a>
                        @endauth
                    </nav>
                @endif
            </header>

            <main class="mt-20 flex flex-col items-center text-center">
                <div class="inline-block px-4 py-1.5 rounded-full border border-blue-200 dark:border-blue-900 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold text-sm mb-6">
                    🚀 Sistem Otomatisasi Kontrak & Proyek #1
                </div>
                
                <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-6 leading-tight">
                    Kelola Proyek Anda <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400">Lebih Cepat & Efisien.</span>
                </h1>
                
                <p class="text-lg md:text-xl text-gray-600 dark:text-gray-400 max-w-2xl mb-10 leading-relaxed">
                    Si-MONARCH hadir mempermudah Direktur dan Admin dalam satu wadah. Buat Kontrak PDF otomatis, pantau progres proyek <i>real-time</i>, dan amankan dokumen arsip Anda tanpa ribet.
                </p>
                
                <div class="flex gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-8 py-4 bg-blue-600 text-white rounded-full font-bold text-lg hover:bg-blue-700 transition shadow-xl shadow-blue-500/30">Mulai Bekerja &rarr;</a>
                    @else
                        <a href="{{ route('login') }}" class="px-8 py-4 bg-blue-600 text-white rounded-full font-bold text-lg hover:bg-blue-700 transition shadow-xl shadow-blue-500/30">Masuk ke Sistem</a>
                    @endauth
                </div>
            </main>
            
            <footer class="mt-32 text-center text-sm text-gray-500 dark:text-gray-500 pb-8 font-medium">
                &copy; {{ date('Y') }} Tim 3 All Store. Hak Cipta Dilindungi.
            </footer>
        </div>
    </div>
</body>
</html>