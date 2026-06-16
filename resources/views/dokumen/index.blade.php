<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pusat Dokumen Terpadu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                    <p class="font-bold">Gagal!</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @if(Auth::user()->role === 'admin')
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">Upload Dokumen Tambahan</h3>
                <form action="{{ route('dokumen.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row gap-4 items-end">
                    @csrf
                    
                    <div class="flex-1 w-full">
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Nama Dokumen</label>
                        <input type="text" name="nama_dokumen" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm" placeholder="Contoh: Berita Acara Rapat">
                    </div>
                    
                    <div class="w-full md:w-48">
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Kategori</label>
                        <select name="kategori" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm text-sm">
                            <option value="lainnya">Lainnya</option>
                            <option value="kontrak">Kontrak</option>
                            <option value="laporan">Laporan</option>
                        </select>
                    </div>

                    <div class="flex-1 w-full">
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Pilih File (PDF/Gambar/Doc)</label>
                        <input type="file" name="file_dokumen" required class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-400">
                    </div>
                    
                    <div>
                        <button type="submit" style="background-color: #2563eb; color: white;" class="px-6 py-2 rounded-md font-semibold text-sm uppercase tracking-widest hover:opacity-90 transition shadow-sm h-[42px]">
                            Upload
                        </button>
                    </div>
                </form>
            </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Arsip Dokumen</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Semua kontrak, laporan proyek, dan dokumen manual ada di sini.</p>
                        </div>
                        
                        <div class="flex items-center gap-2 w-full md:w-auto">
                            <select id="filterKategori" class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:border-blue-500 shadow-sm text-sm">
                                <option value="">Kategori</option>
                                <option value="kontrak">Kontrak</option>
                                <option value="laporan">Laporan</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                            <input type="text" id="searchDokumen" placeholder="Cari nama dokumen..." class="w-full md:w-64 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 shadow-sm text-sm">
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900/50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama Dokumen</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kategori</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal Diunggah</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tableBodyDokumen" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($documents as $doc)
                                <tr class="data-row hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-gray-100 doc-name">{{ $doc->nama_dokumen }}</td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($doc->kategori == 'kontrak')
                                            <span class="doc-category px-2 py-1 text-xs font-semibold rounded bg-blue-100 text-blue-800 border border-blue-200">Kontrak</span>
                                        @elseif($doc->kategori == 'laporan')
                                            <span class="doc-category px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-800 border border-green-200">Laporan</span>
                                        @else
                                            <span class="doc-category px-2 py-1 text-xs font-semibold rounded bg-purple-100 text-purple-800 border border-purple-200">Lainnya</span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500 dark:text-gray-400">
                                        {{ $doc->created_at->format('d M Y H:i') }}
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('dokumen.download', $doc->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-100 dark:bg-blue-900/50 hover:bg-blue-200 dark:hover:bg-blue-900 p-2 rounded-md transition" title="Unduh">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                            </a>
                                            
                                            <a href="{{ route('dokumen.view', $doc->id) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 bg-indigo-100 dark:bg-indigo-900/50 hover:bg-indigo-200 dark:hover:bg-indigo-900 p-2 rounded-md transition" title="Lihat">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                            </a>

                                            @if(Auth::user()->role === 'admin')
                                            <form action="{{ route('dokumen.destroy', $doc->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin mau hapus dokumen ini selamanya lek?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 bg-red-100 dark:bg-red-900/50 hover:bg-red-200 dark:hover:bg-red-900 p-2 rounded-md transition" title="Hapus">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 whitespace-nowrap text-center text-sm text-gray-500 dark:text-gray-400">
                                        Belum ada dokumen apapun yang tersimpan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchDokumen');
            const filterSelect = document.getElementById('filterKategori');
            const rows = document.querySelectorAll('#tableBodyDokumen .data-row');

            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase();
                const filterCategory = filterSelect.value.toLowerCase();

                rows.forEach(row => {
                    const docName = row.querySelector('.doc-name').textContent.toLowerCase();
                    const docCat = row.querySelector('.doc-category').textContent.toLowerCase();

                    // Cek apakah input pencarian cocok & apakah filter kategori cocok
                    const matchesSearch = docName.includes(searchTerm);
                    const matchesCategory = filterCategory === "" || docCat === filterCategory;

                    if (matchesSearch && matchesCategory) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            // Jalankan fungsi saat ngetik atau ganti dropdown
            searchInput.addEventListener('keyup', filterTable);
            filterSelect.addEventListener('change', filterTable);
        });
    </script>
</x-app-layout>