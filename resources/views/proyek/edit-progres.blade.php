<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Progres | Si-MONARCH</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .form-container { max-width: 600px; margin: 0 auto; }
        .info-box { background-color: #282936; padding: 15px; border-radius: 8px; border-left: 4px solid #0ea5e9; margin-bottom: 20px; }
        .info-box h4 { color: #0ea5e9; margin-bottom: 5px; }
        .info-box p { color: #a0aec0; font-size: 14px; }
        .file-upload-box { background-color: #1e1f29; border: 1px dashed #0ea5e9; padding: 20px; border-radius: 8px; text-align: center; margin-top: 20px; transition: 0.3s; }
        .file-upload-box:hover { border-color: #22c55e; background-color: #282936; }
    </style>
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
                <a href="{{ route('proyek.show', $proyek->id) }}" style="color: #ef4444; text-decoration: none; font-size: 24px;">↩</a> 
                Update Progres Lapangan
            </h2>
            <span>Mr. {{ Auth::user()->username ?? 'Direktur' }}</span>
        </div>

        <div class="form-container">
            <div class="info-box">
                <h4>{{ $proyek->nama_proyek }}</h4>
                <p>Klien: {{ $proyek->klien }} | Deadline: {{ \Carbon\Carbon::parse($proyek->deadline)->format('d M Y') }}</p>
            </div>

            <form action="{{ route('proyek.updateProgres', $proyek->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label>Status Proyek Terkini</label>
                    <select name="status" required style="padding: 15px; font-size: 16px;">
                        <option value="Perencanaan" {{ $proyek->status == 'Perencanaan' ? 'selected' : '' }}>Perencanaan</option>
                        <option value="Pelaksanaan" {{ $proyek->status == 'Pelaksanaan' ? 'selected' : '' }}>Pelaksanaan</option>
                        <option value="Evaluasi" {{ $proyek->status == 'Evaluasi' ? 'selected' : '' }}>Evaluasi</option>
                        <option value="Selesai" {{ $proyek->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Persentase Progres Kerja (0 - 100%)</label>
                    <input type="number" name="progres" min="0" max="100" value="{{ $proyek->progres }}" required style="padding: 15px; font-size: 24px; font-weight: bold; text-align: center; color: #22c55e;">
                </div>

                <div class="form-group">
                    <label>Lampirkan Dokumen Laporan (Opsional)</label>
                    <div class="file-upload-box">
                        <input type="file" name="dokumen_laporan" accept=".pdf,.doc,.docx" style="background: transparent; border: none; color: #fff; width: 100%; cursor: pointer;">
                        <small style="color: #eab308; display: block; margin-top: 10px; font-weight: bold;">
                            Klik untuk memilih file laporan progres (PDF, DOC, DOCX)
                        </small>
                    </div>
                </div>

                <div class="btn-group" style="justify-content: center; margin-top: 30px;">
                    <button type="submit" class="btn-submit" style="background-color: #22c55e; padding: 15px 40px;">Simpan Progres</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>