<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('kontrak.index') }}" class="text-red-500 hover:text-red-700 transition" title="Kembali">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" /></svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Buat Kontrak Baru
                </h2>
                <span class="text-xs text-gray-500 dark:text-gray-400">Kontrak > Buat Kontrak Baru</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <form action="{{ route('kontrak.generate') }}" method="POST">
                        @csrf
                        
                        <div class="mb-8">
                            <h3 class="text-lg font-bold border-b border-gray-200 dark:border-gray-700 pb-2 mb-4 text-blue-600 dark:text-blue-400">A. Informasi Surat Kontrak</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium mb-1">Nomor SPK Pihak 1</label>
                                    <input type="text" name="no_pihak1" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Nomor SPK Pihak 2</label>
                                    <input type="text" name="no_pihak2" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Nama / Judul Pekerjaan</label>
                                <input type="text" name="nama_pekerjaan" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                            </div>
                        </div>

                        <div class="mb-8">
                            <h3 class="text-lg font-bold border-b border-gray-200 dark:border-gray-700 pb-2 mb-4 text-blue-600 dark:text-blue-400">B. Data Pihak Pertama (Pemberi Kerja)</h3>
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1">Nama Perusahaan / Instansi</label>
                                <input type="text" name="pt_pihak1" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-1">Nama Pejabat</label>
                                    <input type="text" name="nama_pejabat1" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Jabatan Pejabat</label>
                                    <input type="text" name="jabatan1" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                                </div>
                            </div>
                        </div>

                        <div class="mb-8">
                            <h3 class="text-lg font-bold border-b border-gray-200 dark:border-gray-700 pb-2 mb-4 text-blue-600 dark:text-blue-400">C. Data Pihak Kedua (Pelaksana / Vendor)</h3>
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1">Nama CV / PT Pelaksana</label>
                                <input type="text" name="cv_pihak2" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium mb-1">Nama Pejabat</label>
                                    <input type="text" name="nama_pejabat2" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Jabatan</label>
                                    <input type="text" name="jabatan2" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1">Dasar Hukum / Akta Notaris</label>
                                <input type="text" name="akta_notaris" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Alamat Lengkap Perusahaan</label>
                                <textarea name="alamat_pihak2" rows="2" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm"></textarea>
                            </div>
                        </div>

                        <div class="mb-8">
                            <h3 class="text-lg font-bold border-b border-gray-200 dark:border-gray-700 pb-2 mb-4 text-blue-600 dark:text-blue-400">D. Informasi Pembayaran & Pajak</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-1">Nama Bank</label>
                                    <input type="text" name="nama_bank" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Nomor Rekening</label>
                                    <input type="number" name="no_rek" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">NPWP Perusahaan</label>
                                    <input type="text" name="npwp" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                                </div>
                            </div>
                        </div>

                        <div class="mb-8">
                            <h3 class="text-lg font-bold border-b border-gray-200 dark:border-gray-700 pb-2 mb-4 text-blue-600 dark:text-blue-400">E. Detail Pelaksanaan & Nilai</h3>
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1">Lokasi Pekerjaan</label>
                                <input type="text" name="lokasi_kerja" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium mb-1">Durasi (Hari)</label>
                                    <input type="number" name="waktu_hari" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Tanggal Mulai</label>
                                    <input type="date" name="tgl_mulai" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm [color-scheme:light] dark:[color-scheme:dark]">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Tanggal Selesai</label>
                                    <input type="date" name="tgl_selesai" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm [color-scheme:light] dark:[color-scheme:dark]">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-1">Nilai Kontrak (Angka)</label>
                                    <input type="text" name="nilai_angka" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm font-bold text-blue-600 dark:text-blue-400" placeholder="Contoh: 15000000">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Nilai Kontrak (Huruf / Terbilang)</label>
                                    <input type="text" name="nilai_terbilang" readonly required class="w-full rounded-md border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-300 cursor-not-allowed shadow-sm focus:outline-none" placeholder="Otomatis terisi kalimat terbilang...">
                                </div>
                            </div>
                        </div>

                        <div class="mb-8">
                            <h3 class="text-lg font-bold border-b border-gray-200 dark:border-gray-700 pb-2 mb-4 text-blue-600 dark:text-blue-400">F. Detail Barang / Uraian Kerja</h3>
                            <div id="uraian-container">
                                <div class="dynamic-row bg-gray-50 dark:bg-gray-900 p-4 rounded-lg border border-gray-200 dark:border-gray-700 mb-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label class="block text-sm font-medium mb-1">Barang/Uraian Kerja</label>
                                            <textarea name="uraian[]" rows="2" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm"></textarea>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1">Spesifikasi</label>
                                            <textarea name="spek[]" rows="2" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm"></textarea>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium mb-1">Kebutuhan (Qty)</label>
                                            <input type="number" name="qty[]" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1">Satuan</label>
                                            <input type="text" name="satuan[]" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm" placeholder="Contoh: Unit / Set / Lot">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="button" onclick="tambahBaris()" class="mt-2 inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none transition">
                                + Tambah Baris Pekerjaan
                            </button>
                        </div>

                        <div class="flex items-center justify-end pt-4 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('kontrak.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition mr-3">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition">
                                Generate & Download Kontrak (PDF)
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // --- 1. LOGIKA TANGGAL EXCLUDE SABTU & MINGGU ---
            const inputDurasi = document.querySelector('input[name="waktu_hari"]');
            const inputTglMulai = document.querySelector('input[name="tgl_mulai"]');
            const inputTglSelesai = document.querySelector('input[name="tgl_selesai"]');

            function hitungTanggal() {
                let durasi = parseInt(inputDurasi.value);
                
                if (durasi > 0 && !inputTglMulai.value) {
                    let today = new Date();
                    let yyyy = today.getFullYear();
                    let mm = String(today.getMonth() + 1).padStart(2, '0');
                    let dd = String(today.getDate()).padStart(2, '0');
                    inputTglMulai.value = `${yyyy}-${mm}-${dd}`;
                }

                if (durasi > 0 && inputTglMulai.value) {
                    let startDate = new Date(inputTglMulai.value);
                    let daysToAdd = durasi - 1; 
                    let currentDate = new Date(startDate);

                    while (daysToAdd > 0) {
                        currentDate.setDate(currentDate.getDate() + 1);
                        if (currentDate.getDay() !== 0 && currentDate.getDay() !== 6) {
                            daysToAdd--;
                        }
                    }

                    if (currentDate.getDay() === 6) currentDate.setDate(currentDate.getDate() + 2); 
                    if (currentDate.getDay() === 0) currentDate.setDate(currentDate.getDate() + 1); 

                    let yyyySelesai = currentDate.getFullYear();
                    let mmSelesai = String(currentDate.getMonth() + 1).padStart(2, '0');
                    let ddSelesai = String(currentDate.getDate()).padStart(2, '0');
                    inputTglSelesai.value = `${yyyySelesai}-${mmSelesai}-${ddSelesai}`;
                } else {
                    inputTglSelesai.value = '';
                }
            }

            if (inputDurasi && inputTglMulai) {
                inputDurasi.addEventListener('input', hitungTanggal);
                inputTglMulai.addEventListener('change', hitungTanggal);
            }


            // --- 2. LOGIKA FORMAT RUPIAH & TERBILANG ---
            const inputAngka = document.querySelector('input[name="nilai_angka"]');
            // Menyesuaikan target dengan nama kolom di form milikmu
            const inputTerbilang = document.querySelector('input[name="nilai_terbilang"]');

            if (inputAngka) {
                inputAngka.addEventListener('input', function(e) {
                    // 1. Kasih format titik otomatis
                    this.value = formatRupiah(this.value);
                    
                    // 2. Terjemahkan ke huruf otomatis
                    if (inputTerbilang) {
                        // Bersihkan dulu titiknya biar bisa dihitung mesin
                        var angkaBersih = this.value.replace(/\./g, '');
                        
                        if (angkaBersih === '' || parseInt(angkaBersih) === 0 || isNaN(angkaBersih)) {
                            inputTerbilang.value = '';
                        } else {
                            let teks = terbilang(parseInt(angkaBersih)).trim();
                            // Ubah huruf pertama tiap kata jadi kapital (Title Case)
                            let titleCaseText = teks.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()).join(' ');
                            
                            // Isi form terbilang + " Rupiah"
                            inputTerbilang.value = titleCaseText + ' Rupiah';
                        }
                    }
                });
            }

            // Fungsi Pembantu: Kasih Titik Ribuan
            function formatRupiah(angka) {
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split         = number_string.split(','),
                    sisa          = split[0].length % 3,
                    rupiah        = split[0].substr(0, sisa),
                    ribuan        = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    var separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }
                return split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            }

            // Fungsi Pembantu: Mesin Terbilang
            function terbilang(angka) {
                var bilangan = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
                var result = '';
                angka = Math.abs(angka);

                if (angka < 12) {
                    result = bilangan[angka];
                } else if (angka < 20) {
                    result = terbilang(angka - 10) + ' Belas';
                } else if (angka < 100) {
                    result = terbilang(Math.floor(angka / 10)) + ' Puluh ' + terbilang(angka % 10);
                } else if (angka < 200) {
                    result = 'Seratus ' + terbilang(angka - 100);
                } else if (angka < 1000) {
                    result = terbilang(Math.floor(angka / 100)) + ' Ratus ' + terbilang(angka % 100);
                } else if (angka < 2000) {
                    result = 'Seribu ' + terbilang(angka - 1000);
                } else if (angka < 1000000) {
                    result = terbilang(Math.floor(angka / 1000)) + ' Ribu ' + terbilang(angka % 1000);
                } else if (angka < 1000000000) {
                    result = terbilang(Math.floor(angka / 1000000)) + ' Juta ' + terbilang(angka % 1000000);
                } else if (angka < 1000000000000) {
                    result = terbilang(Math.floor(angka / 1000000000)) + ' Miliar ' + terbilang(angka % 1000000000);
                } else if (angka < 1000000000000000) {
                    result = terbilang(Math.floor(angka / 1000000000000)) + ' Triliun ' + terbilang(angka % 1000000000000);
                }

                return result.replace(/\s+/g, ' ').trim();
            }
        });

        // --- 3. FUNGSI TAMBAH BARIS PEKERJAAN (Diluar DOMContentLoaded) ---
        function tambahBaris() {
            const container = document.getElementById('uraian-container');
            const row = document.createElement('div');
            row.className = 'dynamic-row relative bg-gray-50 dark:bg-gray-900 p-4 rounded-lg border border-gray-200 dark:border-gray-700 mb-4 mt-4';
            row.innerHTML = `
                <button type="button" onclick="this.parentElement.remove()" class="absolute top-2 right-2 text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 text-sm font-bold bg-red-100 dark:bg-red-900/30 px-2 py-1 rounded transition">X Hapus</button>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 mt-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Barang/Uraian Kerja</label>
                        <textarea name="uraian[]" rows="2" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Spesifikasi</label>
                        <textarea name="spek[]" rows="2" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm"></textarea>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Kebutuhan (Qty)</label>
                        <input type="number" name="qty[]" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Satuan</label>
                        <input type="text" name="satuan[]" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                    </div>
                </div>
            `;
            container.appendChild(row);
        }
    </script>
</x-app-layout>