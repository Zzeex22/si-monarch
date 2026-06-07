<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('proyek.index') }}" class="text-red-500 hover:text-red-700 transition" title="Kembali">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" /></svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Detail Proyek: {{ $project->nama_proyek }}
                </h2>
                <span class="text-xs text-gray-500 dark:text-gray-400">Proyek > {{ $project->contract->nomor_kontrak }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                    <p class="font-bold">Gagal memproses lek!</p>
                    <ul class="list-disc pl-5 mt-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- 1. Header Detail Proyek -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Klien / Perusahaan</p>
                        <p class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ $project->contract->nama_klien }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Nilai Kontrak</p>
                        <p class="font-bold text-lg text-blue-600 dark:text-blue-400">Rp {{ number_format($project->contract->nilai_pekerjaan, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Timeline Pekerjaan</p>
                        <p class="font-bold text-gray-900 dark:text-gray-100">
                            {{ \Carbon\Carbon::parse($project->contract->tgl_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($project->contract->tgl_selesai)->format('d M Y') }}
                        </p>
                    </div>
                </div>

                <!-- Big Progress Bar -->
                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Status Progres Saat Ini</h3>
                        <span class="text-2xl font-black {{ $project->persentase == 100 ? 'text-green-600 dark:text-green-400' : 'text-blue-600 dark:text-blue-400' }}">{{ $project->persentase }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4 mb-2">
                        <div class="{{ $project->persentase == 100 ? 'bg-green-600' : 'bg-blue-600' }} h-4 rounded-full transition-all duration-1000" style="width: {{ $project->persentase }}%"></div>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 text-right">
                        @if($project->persentase == 100) Pekerjaan telah selesai 100%. @else Sedang dalam pengerjaan. @endif
                    </p>
                </div>
            </div>

            <!-- 2. Section Bawah (Daftar Laporan & Form Aksi) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Kolom Kiri: Riwayat Laporan -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">Riwayat Laporan Progres</h3>
                    
                    <div class="space-y-4">
                        @forelse($project->reports as $report)
                        <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                            
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h4 class="font-bold text-gray-900 dark:text-gray-100">{{ $report->judul_laporan }}</h4>
                                        <!-- Badge Status -->
                                        @if($report->status == 'pending')
                                            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-0.5 rounded border border-yellow-200">Menunggu Review</span>
                                        @elseif($report->status == 'disetujui')
                                            <span class="bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded border border-green-200">Disetujui</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs px-2 py-0.5 rounded border border-red-200">Perlu Revisi</span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $report->catatan ?? 'Tidak ada catatan.' }}</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Diunggah: {{ $report->created_at->format('d M Y H:i') }}</p>
                                </div>
                                <a href="{{ asset('storage/' . $report->file_laporan) }}" target="_blank" class="inline-flex items-center px-3 py-2 bg-indigo-100 text-indigo-700 dark:bg-indigo-900/50 dark:text-indigo-300 rounded hover:bg-indigo-200 transition text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    Lihat File
                                </a>
                            </div>

                            <!-- Pesan Revisi untuk Admin (Hanya muncul jika statusnya revisi) -->
                            @if($report->status == 'revisi' && $report->pesan_revisi)
                                <div class="mt-3 p-3 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 text-red-700 dark:text-red-400 text-sm">
                                    <strong>Catatan Revisi dari Direktur:</strong><br>
                                    {{ $report->pesan_revisi }}
                                </div>
                            @endif

                            <!-- TAMPILAN AKSI DIREKTUR -->
                            @if(Auth::user()->role === 'direktur' && $report->status == 'pending')
                                <div class="mt-4 pt-3 border-t border-gray-200 dark:border-gray-700 flex flex-wrap gap-2">
                                    <!-- Tombol Setujui -->
                                    <form action="{{ route('report.status', $report->id) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="status" value="disetujui">
                                        <button type="submit" style="background-color: #22c55e; color: white;" class="px-3 py-1.5 rounded text-sm font-semibold hover:opacity-90 transition shadow-sm">
                                            ✓ Setujui
                                        </button>
                                    </form>
                                    
                                    <!-- Form Minta Revisi -->
                                    <form action="{{ route('report.status', $report->id) }}" method="POST" class="flex-1 flex gap-2">
                                        @csrf
                                        <input type="hidden" name="status" value="revisi">
                                        <input type="text" name="pesan_revisi" placeholder="Tulis alasan revisi di sini..." required class="flex-1 text-sm rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 px-3 py-1.5 focus:ring-red-500 focus:border-red-500 shadow-sm">
                                        <button type="submit" style="background-color: #ef4444; color: white;" class="px-3 py-1.5 rounded text-sm font-semibold hover:opacity-90 transition shadow-sm whitespace-nowrap">
                                            Minta Revisi
                                        </button>
                                    </form>
                                </div>
                            @endif

                        </div>
                        @empty
                        <p class="text-gray-500 dark:text-gray-400 text-center py-4">Belum ada laporan yang diunggah.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Kolom Kanan: Form Aksi Sesuai Role -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700 p-6 self-start">
                    
                    @if(Auth::user()->role === 'admin')
                        <!-- TAMPILAN ADMIN: Form Upload Laporan -->
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">Upload Laporan Baru</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Laporan akan otomatis tersimpan ke halaman Dokumen.</p>
                        
                        <form action="{{ route('proyek.report', $project->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1">Judul Laporan</label>
                                <input type="text" name="judul_laporan" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm" placeholder="Contoh: Laporan Minggu 1">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1">Catatan (Opsional)</label>
                                <textarea name="catatan" rows="3" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm"></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1">File Laporan (PDF/Doc/Gambar)</label>
                                <input type="file" name="file_laporan" required class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-400">
                            </div>
                            <button type="submit" style="background-color: #2563eb; color: white;" class="w-full justify-center inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90 focus:outline-none transition">
                                Unggah Laporan
                            </button>
                        </form>

                    @elseif(Auth::user()->role === 'direktur')
                        <!-- TAMPILAN DIREKTUR: Form Update Progress -->
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">Evaluasi Direktur</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Periksa laporan di samping, lalu perbarui persentase proyek di bawah ini.</p>
                        
                        <form action="{{ route('proyek.progress', $project->id) }}" method="POST">
                            @csrf
                            <div class="mb-6">
                                <label class="block text-sm font-medium mb-2">Ubah Persentase (%)</label>
                                <div class="flex items-center gap-3">
                                    <input type="range" name="persentase" min="0" max="100" value="{{ $project->persentase }}" oninput="document.getElementById('persentase-output').textContent = this.value + '%'" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
                                    <span id="persentase-output" class="font-bold text-lg w-12 text-center text-blue-600 dark:text-blue-400">{{ $project->persentase }}%</span>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <button type="submit" style="background-color: #2563eb; color: white;" class="w-full justify-center inline-flex items-center px-4 py-3 border border-transparent rounded-md font-bold text-sm uppercase tracking-widest hover:opacity-90 focus:outline-none transition shadow-lg">
                                    Simpan Persentase
                                </button>
                            </div>
                        </form>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>