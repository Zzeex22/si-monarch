<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kontrak | Si-MONARCH</title>
    <link rel="stylesheet" href="{{ asset('css/kontrak.css') }}">
</head>
<body>

    <div class="sidebar">
        <h2>Si-MONARCH</h2>
        <a href="{{ url('/direktur/dashboard') }}">Dashboard</a>
        <a href="{{ url('/direktur/proyek') }}">Proyek</a>
        <a href="{{ url('/direktur/dokumen') }}">Dokumen</a>
        <a href="{{ url('/direktur/kontrak') }}" class="active">Kontrak</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h2>Kontrak</h2>
            <div style="display: flex; align-items: center; gap: 15px;">
                <span>Mr. {{ Auth::user()->username }}</span>
            </div>
        </div>

        <div class="action-bar">
            <a href="{{ route('kontrak.create') }}" class="btn-primary">+ Buat Kontrak</a>
            <input type="text" class="search-box" placeholder=" Cari kontrak...">
        </div>

        <div class="card-container">
            <div class="card">
                <h3>Total Kontrak</h3>
                <p class="number">{{ $totalKontrak }}</p>
            </div>
            <div class="card">
                <h3>Kontrak Aktif</h3>
                <p class="number">{{ $kontrakAktif }}</p>
            </div>
            <div class="card">
                <h3>Total Nilai Kontrak</h3>
                <p class="number">Rp. {{ number_format($totalNilai, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="table-container">
            <h3>Tabel Kontrak <br><small style="color:#888; font-size: 12px;">Daftar Surat Kontrak</small></h3>
            <table>
                <thead>
                    <tr>
                        <th>Nomor Kontrak</th>
                        <th>Proyek</th>
                        <th>Status</th>
                        <th>Client</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kontrakList as $kontrak)
                    <tr>
                        <td>{{ $kontrak->nomor_kontrak ?? 'Belum ada nomor' }}</td>
                        
                        <td>{{ $kontrak->proyek->nama_proyek ?? '-' }}</td>
                        
                        <td>{{ $kontrak->status_kontrak }}</td>
                        
                        <td>{{ $kontrak->klien->nama_instansi ?? '-' }}</td>
                        
                        <td>
                            <a href="{{ route('kontrak.download', $kontrak->id) }}" class="btn-action btn-download" style="text-decoration: none; display: inline-block;" title="Unduh">📥</a>
                            
                            <a href="{{ route('kontrak.view', $kontrak->id) }}" target="_blank" class="btn-action btn-view" style="text-decoration: none; display: inline-block;" title="Lihat">👁️</a>
                            
                            <form action="{{ route('kontrak.destroy', $kontrak->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin mau hapus kontrak ini lek? File PDF juga bakal kehapus permanen loh!');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Hapus">🗑️</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center;">Belum ada data kontrak lek.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>