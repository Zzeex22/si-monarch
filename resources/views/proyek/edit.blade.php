<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Proyek | Si-MONARCH</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="sidebar">
        <h2>Si-MONARCH</h2>
        <a href="{{ url('/direktur/dashboard') }}">Dashboard</a>
        <a href="{{ route('proyek.index') }}" class="active">Proyek</a>
        <a href="{{ route('dokumen.index') }}">Dokumen</a>
        <a href="{{ route('kontrak.index') }}">Kontrak</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h2 style="display: flex; align-items: center; gap: 10px;">
                <a href="{{ route('proyek.show', $proyek->id) }}" style="color: #ef4444; text-decoration: none; font-size: 24px;">↩</a> 
                Edit Proyek <br>
                <small style="font-size: 12px; color: #888; display: block; font-weight: normal;">Proyek > Edit Proyek</small>
            </h2>
            <span>Mr. {{ Auth::user()->username ?? 'Direktur' }}</span>
        </div>

        <div class="form-container">
            <form action="{{ route('proyek.update', $proyek->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid-2">
                    <div>
                        <div class="form-group">
                            <label>Nama Proyek</label>
                            <input type="text" name="nama_proyek" value="{{ $proyek->nama_proyek }}" required>
                        </div>
                        <div class="form-group">
                            <label>Kategori Proyek</label>
                            <input type="text" name="kategori_proyek" value="{{ $proyek->kategori_proyek }}" required>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi Proyek</label>
                            <textarea name="deskripsi_proyek" rows="4" required>{{ $proyek->deskripsi_proyek }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Lokasi Proyek</label>
                            <input type="text" name="lokasi_proyek" value="{{ $proyek->lokasi_proyek }}" required>
                        </div>
                        <div class="form-group">
                            <label>Kontrak Acuan</label>
                            <select name="kontrak_id" id="kontrak_id" onchange="isiDataKlienOtomatis()" required>
                                @foreach($kontrakList as $k)
                                    <option value="{{ $k->id }}" 
                                            data-klien="{{ $k->klien->nama_instansi ?? 'Tanpa Nama Instansi' }}" 
                                            data-pic="{{ $k->klien->nama_perwakilan ?? '-' }}"
                                            {{ $proyek->kontrak_id == $k->id ? 'selected' : '' }}>
                                        {{ $k->nomor_kontrak }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <div class="form-group">
                            <label>Client / Klien (Otomatis)</label>
                            <input type="text" name="klien" id="klien_input" value="{{ $proyek->klien }}" readonly required>
                        </div>
                        <div class="form-group">
                            <label>PIC / Penanggung Jawab (Otomatis)</label>
                            <input type="text" name="pic_klien" id="pic_input" value="{{ $proyek->pic_klien }}" readonly required>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Mulai</label>
                            <input type="date" name="tgl_mulai" value="{{ $proyek->tgl_mulai }}" required>
                        </div>
                        <div class="form-group">
                            <label>Deadline</label>
                            <input type="date" name="deadline" value="{{ $proyek->deadline }}" required>
                        </div>
                        <div class="form-group">
                            <label>Anggaran (Rp)</label>
                            <input type="number" name="anggaran" value="{{ $proyek->anggaran }}">
                        </div>
                    </div>
                </div>

                <div class="btn-group">
                    <a href="{{ route('proyek.show', $proyek->id) }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit">Update Proyek</button>
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