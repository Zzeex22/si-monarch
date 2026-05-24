<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Dokumen | Si-MONARCH</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .file-upload-box { background-color: #1e1f29; border: 1px dashed #0ea5e9; padding: 30px; border-radius: 8px; text-align: center; margin-top: 10px; transition: 0.3s; }
        .file-upload-box:hover { border-color: #22c55e; background-color: #282936; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Si-MONARCH</h2>
        <a href="{{ url('/direktur/dashboard') }}">Dashboard</a>
        <a href="{{ route('proyek.index') }}">Proyek</a>
        <a href="{{ route('dokumen.index') }}" class="active">Dokumen</a>
        <a href="{{ route('kontrak.index') }}">Kontrak</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h2 style="display: flex; align-items: center; gap: 10px;">
                <a href="{{ route('dokumen.index') }}" style="color: #ef4444; text-decoration: none; font-size: 24px;">↩</a> 
                Upload Dokumen Baru <br>
                <small style="font-size: 12px; color: #888; display: block; font-weight: normal;">Arsip Dokumen > Upload</small>
            </h2>
            <span>Mr. {{ Auth::user()->username ?? 'Direktur' }}</span>
        </div>

        <div class="form-container" style="max-width: 800px; margin: 0 auto;">
            <form action="{{ route('dokumen.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label>Pilih File Dokumen (PDF, Word, Excel, Gambar)</label>
                    <div class="file-upload-box">
                        <input type="file" name="file_dokumen" required style="background: transparent; border: none; color: #fff; width: 100%; cursor: pointer;">
                        <small style="color: #a0aec0; display: block; margin-top: 10px;">Ukuran maksimal file: 5 MB.</small>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label>Jenis Dokumen</label>
                        <select name="jenis_dokumen" required>
                            <option value="Laporan">Laporan</option>
                            <option value="Surat Tugas">Surat Tugas</option>
                            <option value="Invoice">Invoice / Kwitansi</option>
                            <option value="Desain">Desain / Gambar</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Keterangan / Judul Dokumen</label>
                        <input type="text" name="keterangan" placeholder="Contoh: Invoice Material Semen" required>
                    </div>
                </div>

                <h3 style="color: #a0aec0; font-size: 14px; margin-top: 20px; border-bottom: 1px solid #4a4b5c; padding-bottom: 10px;">Tautkan ke Proyek / Kontrak (Opsional)</h3>
                
                <div class="grid-2" style="margin-top: 15px;">
                    <div class="form-group">
                        <label>Terkait Proyek</label>
                        <select name="proyek_id">
                            <option value="">-- Tidak Terkait Proyek --</option>
                            @foreach($proyekList as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_proyek }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Terkait Kontrak</label>
                        <select name="kontrak_id">
                            <option value="">-- Tidak Terkait Kontrak --</option>
                            @foreach($kontrakList as $k)
                                <option value="{{ $k->id }}">{{ $k->nomor_kontrak }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="btn-group">
                    <a href="{{ route('dokumen.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit">Upload Sekarang</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>