<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Proyek | Si-MONARCH</title>
    <link rel="stylesheet" href="{{ asset('css/kontrak.css') }}">
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
            <h2>Manajemen Proyek</h2>
            <div style="display: flex; align-items: center; gap: 15px;">
                <span>Mr. {{ Auth::user()->username ?? 'Direktur' }}</span>
            </div>
        </div>

        @if(session('success'))
            <div style="background-color: #22c55e; color: white; padding: 10px; border-radius: 5px; margin-bottom: 15px;">{{ session('success') }}</div>
        @endif

        <div class="action-bar">
            <a href="{{ route('proyek.create') }}" class="btn-primary">+ Tambah Proyek</a>
            <input type="text" class="search-box" placeholder="🔍 Cari proyek...">
        </div>

        <div class="table-container">
            <h3>Tabel Proyek <br><small style="color:#888; font-size: 12px;">Daftar Proyek Utama</small></h3>
            <table>
                <table>
                <thead>
                    <tr>
                        <th style="text-align: left;">Nama Proyek</th>
                        <th>Client</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th>Progres</th>
                        <th>Aksi</th> </tr>
                </thead>
                <tbody>
                    @forelse($proyekList as $p)
                    <tr>
                        <td style="text-align: left;">{{ $p->nama_proyek }}</td>
                        <td>{{ $p->klien }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->deadline)->format('d/m/Y') }}</td>
                        <td>{{ $p->status }}</td>
                        <td>
                            <div style="display: flex; align-items: center; justify-content: center;">
                                <div style="background-color: #4a4b5c; border-radius: 4px; height: 6px; width: 60px; margin-right: 10px; display: inline-block;">
                                    <div style="background-color: #0ea5e9; height: 100%; border-radius: 4px; width: {{ $p->progres }}%;"></div>
                                </div>
                                <span>{{ $p->progres }}%</span>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('proyek.show', $p->id) }}" class="btn-action btn-view" style="text-decoration: none;" title="Lihat Detail Proyek">👁️</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center;">Belum ada proyek lek, silakan tambah proyek baru.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            </table>
        </div>
    </div>

</body>
</html>