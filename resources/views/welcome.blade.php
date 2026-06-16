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
            
                                    <!-- Profil Perusahaan Section -->
           <!-- Profil Perusahaan Section -->
<section id="profil-perusahaan" class="mt-32 py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Judul Section -->
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">CV. Sumber Sari Mulia</h2>
            <div class="mt-2 w-24 h-1 bg-[#C04000] mx-auto rounded"></div>
            <p class="mt-4 text-lg text-gray-600 font-semibold tracking-wide">General Contractor and Supplier</p>
            <p class="mt-1 text-md text-[#C04000] italic font-medium">"Do The Right Thing Right"</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start">
            <!-- Informasi Perusahaan & Kontak -->
            <div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Profil Perusahaan</h3>
                <p class="text-gray-600 mb-6 text-justify leading-relaxed">
                    <strong>CV. Sumber Sari Mulia</strong> adalah perusahaan yang bergerak di bidang layanan <em>General Contractor and Supplier</em>. Kami berdedikasi penuh untuk memberikan hasil pekerjaan yang berkualitas, detail, dan terstruktur sesuai dengan target perencanaan, dengan selalu berpegang pada prinsip kerja kami: <em>Do The Right Thing Right</em>.
                </p>
                
                <!-- Card Informasi Kontak -->
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-[#C04000]">
                    <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-[#C04000] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Informasi Kontak
                    </h4>
                    <ul class="space-y-3 text-sm text-gray-600">
                        <li class="flex items-start">
                            <span class="font-bold text-gray-800 w-20 flex-shrink-0">Alamat</span>
                            <span>: Jalan Balai Desa gang Wakaf No. 75 Medan (20126)</span>
                        </li>
                        <li class="flex items-start">
                            <span class="font-bold text-gray-800 w-20 flex-shrink-0">Telepon</span>
                            <span>: 085265595973</span>
                        </li>
                        <li class="flex items-start">
                            <span class="font-bold text-gray-800 w-20 flex-shrink-0">Email</span>
                            <span>: sumbersarimulia@gmail.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Lingkup Kerja (Scope of Work) -->
            <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-[#C04000]">
                <h3 class="text-xl font-bold text-[#C04000] mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Lingkup Kerja
                </h3>
                
                <div class="space-y-5">
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm bg-gray-100 p-2 rounded inline-block mb-2">GA & Finance Dept</h4>
                        <ul class="list-disc list-inside text-sm text-gray-600 space-y-1 ml-1">
                            <li>Audit Inventori Asset</li>
                            <li>Membuat Laporan Keuangan</li>
                            <li>Pelaporan Pajak</li>
                            <li>Menyiapkan Kebutuhan Operasional Kantor</li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-bold text-gray-800 text-sm bg-gray-100 p-2 rounded inline-block mb-2">Staff Ahli - Sipil</h4>
                        <ul class="list-disc list-inside text-sm text-gray-600 space-y-1 ml-1">
                            <li>Membuat Rencana Kerja</li>
                            <li>Koordinasi Dengan SPV Teknis</li>
                            <li>Analisa Pekerjaan Lapangan Berikut Progress</li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-bold text-gray-800 text-sm bg-gray-100 p-2 rounded inline-block mb-2">SPV Bidang</h4>
                        <ul class="list-disc list-inside text-sm text-gray-600 space-y-1 ml-1">
                            <li>Memastikan Persiapan Pekerjaan Secara Detail</li>
                            <li>Mentoring dan Monitoring Pekerjaan</li>
                            <li>Memastikan Progres Sesuai Time Schedul Pekerjaan</li>
                            <li>Membuat Laporan Progress</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
            </div>
        </div>

    </div>
</section>

            <footer class="mt-32 text-center text-sm text-gray-500 dark:text-gray-500 pb-8 font-medium">
                &copy; {{ date('Y') }} Tim Digistra Hexa. Hak Cipta Dilindungi.
            </footer>
        </div>
    </div>
</body>
</html>