<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Dokumen | Si-MONARCH</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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
            <h2>Arsip Dokumen</h2>
            <div style="display: flex; align-items: center; gap: 15px;">
                <span>Mr. {{ Auth::user()->username ?? 'Direktur' }}</span>
            </div>
        </div>

        @if(session('success'))
            <div style="background-color: #22c55e; color: white; padding: 10px; border-radius: 5px; margin-bottom: 15px;">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div style="background-color: #ef4444; color: white; padding: 10px; border-radius: 5px; margin-bottom: 15px;">{{ session('error') }}</div>
        @endif

        <div class="action-bar">
            <a href="{{ route('dokumen.create') }}" class="btn-primary">+ Upload Dokumen</a>
            <input type="text" id="searchDokumen" class="search-box" placeholder="Cari nama file, jenis, atau keterangan...">
        </div>

        <div class="table-container">
            <h3>Tabel Arsip <br><small style="color:#888; font-size: 12px;">Daftar seluruh file tersimpan</small></h3>
            <table>
                <thead>
                    <tr>
                        <th style="text-align: left;">Nama File</th>
                        <th>Jenis Dokumen</th>
                        <th>Keterangan</th>
                        <th>Tgl Upload</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBodyDokumen">
                    @forelse($dokumenList as $dok)
                    <tr class="data-row">
                        <td style="text-align: left; color: #4299e1; max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $dok->nama_file }}">
                            {{ $dok->nama_file }}
                        </td>
                        <td>
                            <span style="background-color: #4a4b5c; padding: 4px 10px; border-radius: 4px; font-size: 12px;">
                                {{ $dok->jenis_dokumen }}
                            </span>
                        </td>
                        <td style="font-size: 13px; color: #a0aec0;">{{ $dok->keterangan ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($dok->tgl_upload)->format('d/m/Y') }}</td>
                        <td>
                            <div style="display: flex; justify-content: center; align-items: center; gap: 8px;">
                                <a href="{{ route('dokumen.download', $dok->id) }}" class="btn-action btn-download" style="text-decoration: none;" title="Unduh">
                                    <img src="{{ asset('icons/unduh.png') }}" style="width: 20px; height: 20px;" alt="Download">
                                </a>
                                
                                <a href="{{ route('dokumen.view', $dok->id) }}" target="_blank" class="btn-action btn-view" style="text-decoration: none;" title="Lihat">
                                    <img src="{{ asset('icons/mata.png') }}" style="width: 20px; height: 20px;" alt="View">
                                </a>
                                
                                <form action="{{ route('dokumen.destroy', $dok->id) }}" method="POST" style="margin: 0; padding: 0; display: flex;" onsubmit="return confirm('Yakin mau hapus dokumen ini? File akan terhapus permanen!');">
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
                        <td colspan="5" style="text-align: center;">Belum ada arsip dokumen lek.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.getElementById('searchDokumen').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#tableBodyDokumen .data-row');
            
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