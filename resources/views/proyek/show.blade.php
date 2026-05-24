<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Proyek | Si-MONARCH</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .detail-box { background-color: #282936; border: 1px solid #4a4b5c; padding: 15px; border-radius: 5px; margin-bottom: 15px; }
        .detail-label { color: #a0aec0; font-size: 12px; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px; }
        .detail-value { color: #fff; font-size: 16px; font-weight: 500; }
        .progres-bar-container { background-color: #4a4b5c; border-radius: 8px; height: 12px; width: 100%; margin-top: 10px; overflow: hidden; }
        .progres-bar-fill { background-color: #22c55e; height: 100%; }
        .btn-edit-proyek { background-color: #eab308; color: #000; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold; font-size: 14px; transition: 0.3s; }
        .btn-edit-proyek:hover { background-color: #ca8a04; }
    </style>
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
                <a href="{{ route('proyek.index') }}" style="color: #ef4444; text-decoration: none; font-size: 24px;">↩</a> 
                Informasi Proyek <br>
                <small style="font-size: 12px; color: #888; display: block; font-weight: normal;">Proyek > Detail Proyek</small>
            </h2>
            
            <div style="display: flex; align-items: center; gap: 15px;">
                <a href="{{ route('proyek.edit', $proyek->id) }}" class="btn-edit-proyek"> Edit Proyek</a>
            </div>
        </div>

        @if(session('success'))
            <div style="background-color: #22c55e; color: white; padding: 12px; border-radius: 5px; margin-bottom: 20px; font-weight: bold;">
                {{ session('success') }}
            </div>
        @endif

        <div class="form-container">
            <h3 class="section-title">A. Informasi Utama Proyek</h3>
            <div class="grid-2">
                <div class="detail-box">
                    <div class="detail-label">Nama Proyek</div>
                    <div class="detail-value">{{ $proyek->nama_proyek }}</div>
                </div>
                <div class="detail-box">
                    <div class="detail-label">Kategori Proyek</div>
                    <div class="detail-value">{{ $proyek->kategori_proyek }}</div>
                </div>
            </div>
            
            <div class="detail-box">
                <div class="detail-label">Deskripsi Proyek</div>
                <div class="detail-value" style="font-weight: normal; line-height: 1.6;">{{ $proyek->deskripsi_proyek }}</div>
            </div>

            <h3 class="section-title">B. Data Kontrak & Klien</h3>
            <div class="grid-3">
                <div class="detail-box">
                    <div class="detail-label">Nomor Kontrak Acuan</div>
                    <div class="detail-value">{{ $proyek->kontrak->nomor_kontrak ?? 'Tidak ada data kontrak' }}</div>
                </div>
                <div class="detail-box">
                    <div class="detail-label">Nama Klien / Perusahaan</div>
                    <div class="detail-value">{{ $proyek->klien }}</div>
                </div>
                <div class="detail-box">
                    <div class="detail-label">PIC (Penanggung Jawab Klien)</div>
                    <div class="detail-value">{{ $proyek->pic_klien }}</div>
                </div>
            </div>

            <h3 class="section-title">C. Status & Pelaksanaan</h3>
            <div class="grid-3">
                <div class="detail-box">
                    <div class="detail-label">Lokasi Proyek</div>
                    <div class="detail-value">{{ $proyek->lokasi_proyek }}</div>
                </div>
                <div class="detail-box">
                    <div class="detail-label">Tanggal Mulai</div>
                    <div class="detail-value">{{ \Carbon\Carbon::parse($proyek->tgl_mulai)->format('d F Y') }}</div>
                </div>
                <div class="detail-box">
                    <div class="detail-label">Deadline / Berakhir</div>
                    <div class="detail-value" style="color: #ef4444;">{{ \Carbon\Carbon::parse($proyek->deadline)->format('d F Y') }}</div>
                </div>
            </div>

            <div class="grid-2">
                <div class="detail-box">
                    <div class="detail-label">Total Anggaran</div>
                    <div class="detail-value" style="color: #eab308;">Rp {{ number_format($proyek->anggaran, 0, ',', '.') }}</div>
                </div>
                <div class="detail-box">
                    <div class="detail-label">Status Saat Ini</div>
                    <div class="detail-value">
                        <span style="background-color: #0ea5e9; padding: 4px 10px; border-radius: 4px; font-size: 14px;">{{ $proyek->status }}</span>
                    </div>
                </div>
            </div>

            <div class="detail-box" style="margin-top: 10px;">
                <div class="detail-label" style="display: flex; justify-content: space-between;">
                    <span>Progres Keseluruhan</span>
                    <span style="color: #22c55e; font-weight: bold; font-size: 14px;">{{ $proyek->progres }}%</span>
                </div>
                <div class="progres-bar-container">
                    <div class="progres-bar-fill" style="width: {{ $proyek->progres }}%;"></div>
                </div>
            </div>
            
            <div style="margin-top: 30px; border-top: 1px solid #4a4b5c; padding-top: 25px; text-align: right;">
                <a href="{{ route('proyek.editProgres', $proyek->id) }}" style="background-color: #22c55e; color: #fff; padding: 15px 30px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 16px; display: inline-block; transition: 0.3s;" onmouseover="this.style.backgroundColor='#16a34a'" onmouseout="this.style.backgroundColor='#22c55e'">
                     Update Progres Proyek
                </a>
            </div>
            
        </div>
    </div>

</body>
</html>