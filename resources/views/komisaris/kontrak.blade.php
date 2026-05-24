<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kontrak | Si-MONARCH</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="sidebar">
        <h2>Si-MONARCH</h2>
        <a href="{{ route('komisaris.dashboard') }}">Dashboard</a>
        <a href="{{ route('komisaris.proyek') }}">Pantau Proyek</a>
        <a href="{{ route('komisaris.dokumen') }}">Arsip Dokumen</a>
        <a href="{{ route('komisaris.kontrak') }}" class="active">Daftar Kontrak</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h2>Pemantauan Kontrak Kerja (SPK)</h2>
            <div style="display: flex; align-items: center; gap: 15px;">
                <span style="color: #eab308; font-weight: bold;">Mr. {{ Auth::user()->username ?? 'Komisaris' }}</span>
            </div>
        </div>

        @if(session('error'))
            <div style="background-color: #ef4444; color: white; padding: 10px; border-radius: 5px; margin-bottom: 15px;">{{ session('error') }}</div>
        @endif

        <div class="action-bar" style="justify-content: flex-end;">
            <input type="text" id="searchKontrak" class="search-box" placeholder="Cari no kontrak, klien, atau status...">
        </div>

        <div class="table-container">
            <h3>Tabel Kontrak Perusahaan <br><small style="color:#888; font-size: 12px;">Daftar Surat Perjanjian Kerja Utama</small></h3>
            <table>
                <thead>
                    <tr>
                        <th style="text-align: left;">Nomor Kontrak</th>
                        <th>Client / Perusahaan</th>
                        <th>Nilai Kontrak</th>
                        <th>Tgl Mulai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBodyKontrak">
                    @forelse($kontrakList as $kontrak)
                    <tr class="data-row">
                        <td style="text-align: left; font-weight: bold; color: #4299e1;">{{ $kontrak->nomor_kontrak }}</td>
                        <td>{{ $kontrak->klien->nama_instansi ?? 'Tanpa Klien' }}</td>
                        <td>Rp {{ number_format($kontrak->nilai_pekerjaan, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($kontrak->tgl_mulai)->format('d/m/Y') }}</td>
                        <td>
                            <span style="background-color: {{ $kontrak->status_kontrak == 'Aktif' ? '#22c55e' : '#ef4444' }}; padding: 3px 8px; border-radius: 4px; font-size: 12px; color: white;">
                                {{ $kontrak->status_kontrak }}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; justify-content: center; align-items: center; gap: 8px;">
                                <a href="{{ route('komisaris.kontrak.download', $kontrak->id) }}" class="btn-action btn-download" style="text-decoration: none;" title="Unduh PDF Kontrak">
                                    <img src="{{ asset('icons/unduh.png') }}" style="width: 20px; height: 20px;" alt="Download">
                                </a>
                                
                                <a href="{{ route('komisaris.kontrak.view', $kontrak->id) }}" target="_blank" class="btn-action btn-view" style="text-decoration: none;" title="Lihat PDF Kontrak">
                                    <img src="{{ asset('icons/mata.png') }}" style="width: 20px; height: 20px;" alt="View">
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center;">Belum ada data kontrak tersimpan lek.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.getElementById('searchKontrak').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#tableBodyKontrak .data-row');
            
            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                if(text.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>

</body>
</html>