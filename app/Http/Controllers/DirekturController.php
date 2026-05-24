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

        $totalProyek = Proyek::count();
        $kontrakAktif = Kontrak::where('status_kontrak', 'Aktif')->count();
        $arsipDokumen = Dokumen::count();


        $proyekTerbaru = Proyek::orderBy('id', 'desc')->take(5)->get();

        return view('direktur.dashboard', compact('totalProyek', 'kontrakAktif', 'arsipDokumen', 'proyekTerbaru'));
    }
}