<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Direktur | Si-MONARCH</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="sidebar">
        <h2>Si-MONARCH</h2>
        <a href="{{ url('/direktur/dashboard') }}" class="active">Dashboard</a>
        <a href="{{ route('proyek.index') }}">Proyek</a>
        <a href="{{ route('dokumen.index') }}">Dokumen</a>
        <a href="{{ route('kontrak.index') }}">Kontrak</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h2>Dashboard Direktur</h2>
            <div style="display: flex; align-items: center; gap: 15px;">
                <span>Mr. {{ Auth::user()->username ?? 'direktur' }}</span>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" style="background-color: #ef4444; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; font-weight: bold;">Logout</button>
                </form>
            </div>
        </div>

        <div class="card-container" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
            <div class="card" style="background-color: #353646; padding: 25px; border-radius: 8px;">
                <h3 style="color: #a0aec0; font-size: 14px; margin-bottom: 10px;">Total Proyek</h3>
                <div class="number" style="font-size: 28px; font-weight: bold; color: #fff;">{{ $totalProyek }}</div>
            </div>
            <div class="card" style="background-color: #353646; padding: 25px; border-radius: 8px;">
                <h3 style="color: #a0aec0; font-size: 14px; margin-bottom: 10px;">Kontrak Aktif</h3>
                <div class="number" style="font-size: 28px; font-weight: bold; color: #fff;">{{ $kontrakAktif }}</div>
            </div>
            <div class="card" style="background-color: #353646; padding: 25px; border-radius: 8px;">
                <h3 style="color: #a0aec0; font-size: 14px; margin-bottom: 10px;">Arsip Dokumen</h3>
                <div class="number" style="font-size: 28px; font-weight: bold; color: #fff;">{{ $arsipDokumen }}</div>
            </div>
        </div>

        <div style="margin-bottom: 30px; display: flex; gap: 15px;">
            <a href="{{ route('proyek.create') }}" style="background-color: #353646; color: #fff; padding: 10px 20px; border-radius: 5px; text-decoration: none; border: 1px solid #4a4b5c; transition: 0.3s;" onmouseover="this.style.backgroundColor='#4a4b5c'" onmouseout="this.style.backgroundColor='#353646'">+ Tambah Proyek</a>
            <a href="#" style="background-color: #353646; color: #fff; padding: 10px 20px; border-radius: 5px; text-decoration: none; border: 1px solid #4a4b5c; transition: 0.3s;" onmouseover="this.style.backgroundColor='#4a4b5c'" onmouseout="this.style.backgroundColor='#353646'">Upload Dokumen</a>
            <a href="{{ route('kontrak.create') }}" style="background-color: #353646; color: #fff; padding: 10px 20px; border-radius: 5px; text-decoration: none; border: 1px solid #4a4b5c; transition: 0.3s;" onmouseover="this.style.backgroundColor='#4a4b5c'" onmouseout="this.style.backgroundColor='#353646'">Buat Kontrak</a>
        </div>

        <div class="table-container" style="background-color: #353646; padding: 20px; border-radius: 8px;">
            <h3 style="margin-bottom: 20px; font-size: 18px; color: #fff;">Tabel Proyek</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align: left; padding: 12px 15px; background-color: #282936; color: #a0aec0; border-bottom: 1px solid #4a4b5c;">Nama Proyek</th>
                        <th style="text-align: center; padding: 12px 15px; background-color: #282936; color: #a0aec0; border-bottom: 1px solid #4a4b5c;">Status</th>
                        <th style="text-align: center; padding: 12px 15px; background-color: #282936; color: #a0aec0; border-bottom: 1px solid #4a4b5c;">Progres</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($proyekTerbaru as $p)
                    <tr>
                        <td style="text-align: left; padding: 15px; border-bottom: 1px solid #4a4b5c; color: #cbd5e0;">{{ $p->nama_proyek }}</td>
                        <td style="text-align: center; padding: 15px; border-bottom: 1px solid #4a4b5c; color: #cbd5e0;">{{ $p->status }}</td>
                        <td style="text-align: center; padding: 15px; border-bottom: 1px solid #4a4b5c; color: #cbd5e0;">
                            <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                                <div style="background-color: #4a4b5c; border-radius: 4px; height: 6px; width: 100px; display: inline-block;">
                                    <div style="background-color: #22c55e; height: 100%; border-radius: 4px; width: {{ $p->progres }}%;"></div>
                                </div>
                                <span style="font-size: 13px;">{{ $p->progres }}%</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 20px; color: #888;">Belum ada proyek yang berjalan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>