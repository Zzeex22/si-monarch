<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyek;
use App\Models\Kontrak;
use App\Models\Dokumen;
use Illuminate\Support\Facades\Auth;

class DirekturController extends Controller
{
    public function dashboard()
    {
        // Hitung total data seperti melakukan summary
        $totalProyek = Proyek::count();
        
        // Misalkan kita asumsikan kontrak aktif itu yang statusnya 'Aktif'
        $kontrakAktif = Kontrak::where('status_kontrak', 'Aktif')->count(); 
        
        $totalDokumen = Dokumen::count();

        // Ambil 4 proyek terbaru untuk ditampilkan di tabel
        $proyekList = Proyek::limit(4)->get();

        return view('direktur.dashboard', compact(
            'totalProyek', 
            'kontrakAktif', 
            'totalDokumen', 
            'proyekList'
        ));
    }
}