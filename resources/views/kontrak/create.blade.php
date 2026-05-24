<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Kontrak | Si-MONARCH</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="sidebar">
        <h2>Si-MONARCH</h2>
        <a href="{{ url('/direktur/dashboard') }}">Dashboard</a>
        <a href="{{ route('proyek.index') }}">Proyek</a>
        <a href="#">Dokumen</a>
        <a href="{{ route('kontrak.index') }}" class="active">Kontrak</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h2 style="display: flex; align-items: center; gap: 10px;">
                <a href="{{ route('kontrak.index') }}" style="color: #ef4444; text-decoration: none; font-size: 24px;">↩</a> 
                Buat Kontrak Baru <br>
                <small style="font-size: 12px; color: #888; display: block; font-weight: normal;">Kontrak > Buat Kontrak Baru</small>
            </h2>
            <span>Mr. {{ Auth::user()->username ?? 'Direktur' }}</span>
        </div>

        <div class="form-container">
            <form action="{{ route('kontrak.generate') }}" method="POST">
                @csrf
                
                <h3 class="section-title">A. Informasi Surat Kontrak</h3>
                <div class="grid-2">
                    <div class="form-group"><label>Nomor SPK Pihak 1</label><input type="text" name="no_pihak1" required></div>
                    <div class="form-group"><label>Nomor SPK Pihak 2</label><input type="text" name="no_pihak2" required></div>
                </div>
                <div class="form-group"><label>Nama / Judul Pekerjaan</label><input type="text" name="nama_pekerjaan" required></div>

                <h3 class="section-title">B. Data Pihak Pertama (Pemberi Kerja)</h3>
                <div class="form-group"><label>Nama Perusahaan / Instansi</label><input type="text" name="pt_pihak1" required></div>
                <div class="grid-2">
                    <div class="form-group"><label>Nama Pejabat</label><input type="text" name="nama_pejabat1" required></div>
                    <div class="form-group"><label>Jabatan Pejabat</label><input type="text" name="jabatan1" required></div>
                </div>

                <h3 class="section-title">C. Data Pihak Kedua (Pelaksana / Vendor)</h3>
                <div class="form-group"><label>Nama CV / PT Pelaksana</label><input type="text" name="cv_pihak2" required></div>
                <div class="grid-2">
                    <div class="form-group"><label>Nama Pejabat</label><input type="text" name="nama_pejabat2" required></div>
                    <div class="form-group"><label>Jabatan</label><input type="text" name="jabatan2" required></div>
                </div>
                <div class="form-group"><label>Dasar Hukum / Akta Notaris</label><input type="text" name="akta_notaris" required></div>
                <div class="form-group"><label>Alamat Lengkap Perusahaan</label><textarea name="alamat_pihak2" rows="2" required></textarea></div>

                <h3 class="section-title">D. Informasi Pembayaran & Pajak</h3>
                <div class="grid-3">
                    <div class="form-group"><label>Nama Bank</label><input type="text" name="nama_bank" required></div>
                    <div class="form-group"><label>Nomor Rekening</label><input type="number" name="no_rek" required></div>
                    <div class="form-group"><label>NPWP Perusahaan</label><input type="text" name="npwp" required></div>
                </div>

                <h3 class="section-title">E. Detail Pelaksanaan & Nilai</h3>
                <div class="form-group"><label>Lokasi Pekerjaan</label><input type="text" name="lokasi_kerja" required></div>
                <div class="grid-3">
                    <div class="form-group"><label>Durasi (Hari)</label><input type="number" name="waktu_hari" required></div>
                    <div class="form-group"><label>Tanggal Mulai</label><input type="date" name="tgl_mulai" required></div>
                    <div class="form-group"><label>Tanggal Selesai</label><input type="date" name="tgl_selesai" required></div>
                </div>
                <div class="grid-2">
                    <div class="form-group"><label>Nilai Kontrak (Angka)</label><input type="number" name="nilai_angka" required></div>
                    <div class="form-group"><label>Nilai Kontrak (Huruf / Terbilang)</label><input type="text" name="nilai_terbilang" required></div>
                </div>

                <h3 class="section-title">F. Detail Barang / Uraian Kerja</h3>
                <div id="uraian-container">
                    <div class="dynamic-row">
                        <div class="grid-2">
                            <div class="form-group"><label>Barang/Uraian Kerja</label><textarea name="uraian[]" rows="2" required></textarea></div>
                            <div class="form-group"><label>Spesifikasi</label><textarea name="spek[]" rows="2" required></textarea></div>
                        </div>
                        <div class="grid-2">
                            <div class="form-group"><label>Kebutuhan (Qty)</label><input type="text" name="qty[]" required></div>
                            <div class="form-group"><label>Satuan</label><input type="text" name="satuan[]" required></div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-add" onclick="tambahBaris()">+ Tambah Baris Pekerjaan</button>

                <div class="btn-group">
                    <a href="{{ route('kontrak.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit">Generate & Download Kontrak (PDF)</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function tambahBaris() {
            const container = document.getElementById('uraian-container');
            const row = document.createElement('div');
            row.className = 'dynamic-row';
            row.innerHTML = `
                <button type="button" onclick="this.parentElement.remove()" class="btn-remove">X Hapus</button>
                <div class="grid-2">
                    <div class="form-group"><label>Barang/Uraian Kerja</label><textarea name="uraian[]" rows="2" required></textarea></div>
                    <div class="form-group"><label>Spesifikasi</label><textarea name="spek[]" rows="2" required></textarea></div>
                </div>
                <div class="grid-2">
                    <div class="form-group"><label>Kebutuhan (Qty)</label><input type="text" name="qty[]" required></div>
                    <div class="form-group"><label>Satuan</label><input type="text" name="satuan[]" required></div>
                </div>
            `;
            container.appendChild(row);
        }
    </script>
</body>
</html>