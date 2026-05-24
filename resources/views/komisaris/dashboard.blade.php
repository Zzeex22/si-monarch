<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Komisaris | Si-MONARCH</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="sidebar">
        <h2>Si-MONARCH</h2>
        <a href="{{ route('komisaris.dashboard') }}" class="active">Dashboard</a>
        <a href="{{ route('komisaris.proyek') }}">Pantau Proyek</a>
        <a href="{{ route('komisaris.dokumen') }}">Arsip Dokumen</a>
        <a href="{{ route('komisaris.kontrak') }}">Daftar Kontrak</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h2>Dashboard Komisaris</h2>
            <div style="display: flex; align-items: center; gap: 15px;">
                <span style="color: #eab308; font-weight: bold;">Mr. {{ Auth::user()->username ?? 'Komisaris' }}</span>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" style="background-color: #ef4444; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; font-weight: bold;">Logout</button>
                </form>
            </div>
        </div>

        <div style="background-color: #282936; border-left: 4px solid #eab308; padding: 15px; border-radius: 8px; margin-bottom: 25px;">
            <p style="color: #a0aec0; margin: 0;">Selamat datang di panel pemantauan Si-MONARCH. Di sini Anda dapat meninjau seluruh perkembangan proyek dan arsip perusahaan.</p>
        </div>

        <div class="card-container" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
            <div class="card" style="background-color: #353646; padding: 25px; border-radius: 8px; border-top: 3px solid #0ea5e9;">
                <h3 style="color: #a0aec0; font-size: 14px; margin-bottom: 10px;">Total Proyek</h3>
                <div class="number" style="font-size: 28px; font-weight: bold; color: #fff;">{{ $totalProyek }}</div>
            </div>
            <div class="card" style="background-color: #353646; padding: 25px; border-radius: 8px; border-top: 3px solid #22c55e;">
                <h3 style="color: #a0aec0; font-size: 14px; margin-bottom: 10px;">Kontrak Aktif</h3>
                <div class="number" style="font-size: 28px; font-weight: bold; color: #fff;">{{ $kontrakAktif }}</div>
            </div>
            <div class="card" style="background-color: #353646; padding: 25px; border-radius: 8px; border-top: 3px solid #eab308;">
                <h3 style="color: #a0aec0; font-size: 14px; margin-bottom: 10px;">Arsip Dokumen</h3>
                <div class="number" style="font-size: 28px; font-weight: bold; color: #fff;">{{ $arsipDokumen }}</div>
            </div>
        </div>

        <div class="table-container" style="background-color: #353646; padding: 20px; border-radius: 8px;">
            <h3 style="margin-bottom: 20px; font-size: 18px; color: #fff;">Status Proyek Terkini</h3>
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
                        <td style="text-align: left; padding: 15px; border-bottom: 1px solid #4a4b5c; color: #cbd5e0; font-weight: 500;">{{ $p->nama_proyek }}</td>
                        <td style="text-align: center; padding: 15px; border-bottom: 1px solid #4a4b5c;">
                            <span style="background-color: {{ $p->status == 'Selesai' ? '#22c55e' : '#0ea5e9' }}; padding: 4px 10px; border-radius: 4px; font-size: 13px; color: white;">
                                {{ $p->status }}
                            </span>
                        </td>
                        <td style="text-align: center; padding: 15px; border-bottom: 1px solid #4a4b5c; color: #cbd5e0;">
                            <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                                <div style="background-color: #4a4b5c; border-radius: 4px; height: 6px; width: 100px; display: inline-block;">
                                    <div style="background-color: #22c55e; height: 100%; border-radius: 4px; width: {{ $p->progres }}%;"></div>
                                </div>
                                <span style="font-size: 13px; font-weight: bold;">{{ $p->progres }}%</span>
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