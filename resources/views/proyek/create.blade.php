<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Proyek | Si-MONARCH</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="sidebar">
        <h2>Si-MONARCH</h2>
        <a href="{{ url('/direktur/dashboard') }}">Dashboard</a>
        <a href="{{ route('proyek.index') }}" class="active">Proyek</a>
        <a href="#">Dokumen</a>
        <a href="{{ route('kontrak.index') }}">Kontrak</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h2 style="display: flex; align-items: center; gap: 10px;">
                <a href="{{ route('proyek.index') }}" style="color: #ef4444; text-decoration: none; font-size: 24px;">↩</a> 
                Tambah Proyek <br>
                <small style="font-size: 12px; color: #888; display: block; font-weight: normal;">Proyek > Tambah Proyek</small>
            </h2>
            <span>Mr. {{ Auth::user()->username ?? 'Direktur' }}</span>
        </div>

        <div class="form-container">
            <form action="{{ route('proyek.store') }}" method="POST">
                @csrf
                <div class="grid-2">
                    <div>
                        <div class="form-group">
                            <label>Nama Proyek</label>
                            <input type="text" name="nama_proyek" placeholder="Contoh: Renovasi Stasiun Deli" required>
                        </div>
                        <div class="form-group">
                            <label>Kategori Proyek</label>
                            <input type="text" name="kategori_proyek" placeholder="Pilih kategori proyek..." required>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi Proyek</label>
                            <textarea name="deskripsi_proyek" rows="4" placeholder="Jelaskan rincian proyek..." required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Lokasi Proyek</label>
                            <input type="text" name="lokasi_proyek" placeholder="Contoh: Medan, Indonesia" required>
                        </div>
                        <div class="form-group">
                            <label>Kontrak</label>
                            <select name="kontrak_id" id="kontrak_id" onchange="isiDataKlienOtomatis()" required>
                                <option value="">Pilih Kontrak Proyek...</option>
                                @foreach($kontrakList as $k)
                                    <option value="{{ $k->id }}" 
                                            data-klien="{{ $k->klien->nama_instansi ?? 'Tanpa Nama Instansi' }}" 
                                            data-pic="{{ $k->klien->nama_perwakilan ?? '-' }}">
                                        {{ $k->nomor_kontrak }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <div class="form-group">
                            <label>Client / Klien (Otomatis)</label>
                            <input type="text" name="klien" id="klien_input" placeholder="Akan terisi otomatis saat kontrak dipilih..." readonly required>
                        </div>
                        <div class="form-group">
                            <label>PIC / Penanggung Jawab (Otomatis)</label>
                            <input type="text" name="pic_klien" id="pic_input" placeholder="Akan terisi otomatis saat kontrak dipilih..." readonly required>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Mulai</label>
                            <input type="date" name="tgl_mulai" required>
                        </div>
                        <div class="form-group">
                            <label>Deadline</label>
                            <input type="date" name="deadline" required>
                        </div>
                        <div class="form-group">
                            <label>Anggaran (Opsional)</label>
                            <input type="number" name="anggaran" placeholder="Contoh: 500000000">
                        </div>
                    </div>
                </div>

                <div class="btn-group">
                    <a href="{{ route('proyek.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit">Simpan Proyek</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function isiDataKlienOtomatis() {
            const selectKontrak = document.getElementById('kontrak_id');
            const selectedOption = selectKontrak.options[selectKontrak.selectedIndex];
            

            const namaKlien = selectedOption.getAttribute('data-klien') || '';
            const namaPic = selectedOption.getAttribute('data-pic') || '';
            

            document.getElementById('klien_input').value = namaKlien;
            document.getElementById('pic_input').value = namaPic;
        }
    </script>

</body>
</html>