<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kontrak | Si-MONARCH</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="sidebar">
        <h2>Si-MONARCH</h2>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('proyek.index') }}">Proyek</a>
        <a href="{{ route('dokumen.index') }}">Dokumen</a>
        <a href="{{ route('kontrak.index') }}" class="active">Kontrak</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h2>Manajemen Kontrak</h2>
            <div style="display: flex; align-items: center; gap: 15px;">
                <span>Mr. {{ Auth::user()->name ?? 'Admin' }}</span>
            </div>
        </div>

        <div class="card-container">
            <div class="card">
                <h3>Total Kontrak</h3>
                <div class="number">{{ $totalKontrak }}</div>
            </div>
            <div class="card">
                <h3>Kontrak Aktif</h3>
                <div class="number">{{ $kontrakAktif }}</div>
            </div>
            <div class="card">
                <h3>Total Nilai Pekerjaan</h3>
                <div class="number" style="font-size: 20px;">Rp {{ number_format($totalNilai, 0, ',', '.') }}</div>
            </div>
        </div>

        @if(session('success'))
            <div style="background-color: #22c55e; color: white; padding: 10px; border-radius: 5px; margin-bottom: 15px;">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div style="background-color: #ef4444; color: white; padding: 10px; border-radius: 5px; margin-bottom: 15px;">{{ session('error') }}</div>
        @endif

        <div class="action-bar">
            <a href="{{ route('kontrak.create') }}" class="btn-primary">+ Buat Kontrak Baru</a>
            <input type="text" id="searchKontrak" class="search-box" placeholder=" Cari no kontrak, klien, atau status...">
        </div>

        <div class="table-container">
            <h3>Tabel Kontrak <br><small style="color:#888; font-size: 12px;">Daftar Surat Perjanjian Kerja</small></h3>
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
                        <!-- VARIABEL INI YANG KU SESUAIKAN SAMA DATABASE LEK -->
                        <td>{{ $kontrak->nama_klien ?? 'Tanpa Klien' }}</td>
                        <td>Rp {{ number_format($kontrak->nilai_kontrak, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($kontrak->tgl_mulai)->format('d/m/Y') }}</td>
                        <td>
                            <span style="background-color: {{ $kontrak->status_kontrak == 'Aktif' ? '#22c55e' : '#ef4444' }}; padding: 3px 8px; border-radius: 4px; font-size: 12px; color: white;">
                                {{ $kontrak->status_kontrak }}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; justify-content: center; align-items: center; gap: 8px;">
                                
                                <a href="{{ route('kontrak.download', $kontrak->id) }}" class="btn-action btn-download" style="text-decoration: none;" title="Unduh">
                                    <img src="{{ asset('icons/unduh.png') }}" style="width: 20px; height: 20px;" alt="Download">
                                </a>
                                
                                <a href="{{ route('kontrak.view', $kontrak->id) }}" target="_blank" class="btn-action btn-view" style="text-decoration: none;" title="Lihat">
                                    <img src="{{ asset('icons/mata.png') }}" style="width: 20px; height: 20px;" alt="View">
                                </a>
                                
                                <form action="{{ route('kontrak.destroy', $kontrak->id) }}" method="POST" style="margin: 0; padding: 0; display: flex;" onsubmit="return confirm('Yakin mau hapus kontrak ini lek? Proyek dan Dokumen terkait tetap aman, cuma kontraknya aja yang kehapus.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" style="background-color: #ef4444; border: none; cursor: pointer; padding: 6px 12px; border-radius: 5px; display: flex; align-items: center; justify-content: center;" title="Hapus">
                                        <img src="{{ asset('icons/sampah.png') }}" style="width: 18px; height: 18px;" alt="Delete">
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center;">Belum ada data kontrak lek.</td>
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