<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Direktur | Si-MONARCH</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>

<div class="sidebar">
        <h2>Si-MONARCH</h2>
        <a href="{{ url('/direktur/dashboard') }}" class="active">Dashboard</a>
        <a href="{{ url('/direktur/proyek') }}">Proyek</a>
        <a href="{{ url('/direktur/dokumen') }}">Dokumen</a>
        <a href="{{ url('/direktur/kontrak') }}">Kontrak</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h2>Dashboard Direktur</h2>
            <div style="display: flex; align-items: center; gap: 15px;">
                <span>Mr. {{ Auth::user()->username }}</span>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>

        <div class="card-container">
            <div class="card">
                <h3>Total Proyek</h3>
                <p class="number">{{ $totalProyek }}</p>
            </div>
            <div class="card">
                <h3>Kontrak Aktif</h3>
                <p class="number">{{ $kontrakAktif }}</p>
            </div>
            <div class="card">
                <h3>Arsip Dokumen</h3>
                <p class="number">{{ $totalDokumen }}</p>
            </div>
        </div>

        <div class="quick-menu">
            <a href="{{ url('/direktur/proyek') }}" class="quick-btn">+ Tambah Proyek</a>
            <a href="{{ url('/direktur/dokumen') }}" class="quick-btn">Upload Dokumen</a>
            <a href="{{ url('/direktur/kontrak') }}" class="quick-btn">Buat Kontrak</a>
        </div>

        <div class="table-container">
            <h3>Tabel Proyek</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nama Proyek</th>
                        <th>Status</th>
                        <th>Progres</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($proyekList as $proyek)
                    <tr>
                        <td>{{ $proyek->nama_proyek }}</td>
                        <td>{{ $proyek->status }}</td>
                        <td>
                            <div style="display: flex; align-items: center;">
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ $proyek->progres }}%;"></div>
                                </div>
                                <span>{{ $proyek->progres }}%</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="text-align: center;">Belum ada data proyek lek.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>