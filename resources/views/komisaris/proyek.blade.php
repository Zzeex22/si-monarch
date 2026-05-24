<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantau Proyek | Si-MONARCH</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="sidebar">
        <h2>Si-MONARCH</h2>
        <a href="{{ route('komisaris.dashboard') }}">Dashboard</a>
        <a href="{{ route('komisaris.proyek') }}" class="active">Pantau Proyek</a>
        <a href="{{ route('komisaris.dokumen') }}">Arsip Dokumen</a>
        <a href="{{ route('komisaris.kontrak') }}">Daftar Kontrak</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h2>Pemantauan Proyek</h2>
            <div style="display: flex; align-items: center; gap: 15px;">
                <span style="color: #eab308; font-weight: bold;">Mr. {{ Auth::user()->username ?? 'Komisaris' }}</span>
            </div>
        </div>

        <div class="action-bar" style="justify-content: flex-end;">
            <input type="text" id="searchProyek" class="search-box" placeholder="Cari nama proyek, klien, atau status...">
        </div>

        <div class="table-container">
            <h3>Tabel Monitoring Proyek <br><small style="color:#888; font-size: 12px;">Seluruh Proyek Perusahaan</small></h3>
            <table>
                <thead>
                    <tr>
                        <th style="text-align: left;">Nama Proyek</th>
                        <th>Client</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th>Progres</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBodyProyek">
                    @forelse($proyekList as $p)
                    <tr class="data-row">
                        <td style="text-align: left; font-weight: 500;">{{ $p->nama_proyek }}</td>
                        <td>{{ $p->klien }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->deadline)->format('d/m/Y') }}</td>
                        <td>
                            <span style="background-color: #0ea5e9; padding: 3px 8px; border-radius: 4px; font-size: 12px; color: white;">
                                {{ $p->status }}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; justify-content: center;">
                                <div style="background-color: #4a4b5c; border-radius: 4px; height: 6px; width: 60px; margin-right: 10px; display: inline-block;">
                                    <div style="background-color: #22c55e; height: 100%; border-radius: 4px; width: {{ $p->progres }}%;"></div>
                                </div>
                                <span>{{ $p->progres }}%</span>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('komisaris.proyek.show', $p->id) }}" class="btn-action btn-view" style="text-decoration: none;" title="Lihat Detail Proyek">
                                <img src="{{ asset('icons/mata.png') }}" style="width: 20px; height: 20px;" alt="View">
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center;">Belum ada proyek yang berjalan lek.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.getElementById('searchProyek').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#tableBodyProyek .data-row');
            
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