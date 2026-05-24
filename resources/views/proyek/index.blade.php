<link rel="stylesheet" href="{{ asset('css/kontrak.css') }}">

    <div class="sidebar">
        <h2>Si-MONARCH</h2>
        <a href="{{ url('/direktur/dashboard') }}">Dashboard</a>
        <a href="{{ url('/direktur/proyek') }}">Proyek</a>
        <a href="{{ url('/direktur/dokumen') }}">Dokumen</a>
        <a href="{{ url('/direktur/kontrak') }}" class="active">Kontrak</a>
    </div>

<div class="main-content">
    <div class="header">
        <h2>Manajemen Proyek</h2>
    </div>
    
    <div class="action-bar">
        <a href="{{ route('proyek.create') }}" class="btn-primary">+ Tambah Proyek</a>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nama Proyek</th>
                    <th>Client</th>
                    <th>Status</th>
                    <th>Progres</th>
                </tr>
            </thead>
            <tbody>
                @foreach($proyekList as $p)
                <tr>
                    <td>{{ $p->nama_proyek }}</td>
                    <td>{{ $p->klien }}</td>
                    <td>{{ $p->status }}</td>
                    <td>{{ $p->progres }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>