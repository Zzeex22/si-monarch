<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyek;
use App\Models\Kontrak;
use App\Models\Dokumen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class KomisarisController extends Controller
{
    public function dashboard()
    {
        $totalProyek = Proyek::count();
        $kontrakAktif = Kontrak::where('status_kontrak', 'Aktif')->count();
        $arsipDokumen = Dokumen::count();
        $proyekTerbaru = Proyek::orderBy('id', 'desc')->take(5)->get();

        return view('komisaris.dashboard', compact('totalProyek', 'kontrakAktif', 'arsipDokumen', 'proyekTerbaru'));
    }

    public function proyek()
    {
        $proyekList = Proyek::orderBy('id', 'desc')->get();
        return view('komisaris.proyek', compact('proyekList'));
    }

    public function showProyek($id)
    {
        $proyek = Proyek::with('kontrak')->findOrFail($id);
        return view('komisaris.proyek-show', compact('proyek'));
    }

    public function dokumen()
    {
        $dokumenList = Dokumen::with(['proyek', 'kontrak'])->orderBy('id', 'desc')->get();
        return view('komisaris.dokumen', compact('dokumenList'));
    }

    public function viewDokumen($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        $filePath = public_path('dokumen/' . $dokumen->nama_file);
        
        if (File::exists($filePath)) {
            return response()->file($filePath);
        }
        return back()->with('error', 'File fisik tidak ditemukan di server!');
    }

    public function downloadDokumen($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        $filePath = public_path('dokumen/' . $dokumen->nama_file);
        
        if (File::exists($filePath)) {
            return response()->download($filePath);
        }
        return back()->with('error', 'File fisik tidak ditemukan di server!');
    }

    // ==========================================
    // FUNGSI DAFTAR KONTRAK KOMISARIS
    // ==========================================
    public function kontrak()
    {
        $kontrakList = Kontrak::with('klien')->orderBy('id', 'desc')->get();
        return view('komisaris.kontrak', compact('kontrakList'));
    }

    public function viewKontrak($id)
    {
        $kontrak = Kontrak::findOrFail($id);
        $filePath = public_path('pdf/' . $kontrak->file_pdf);
        
        if (File::exists($filePath)) {
            return response()->file($filePath);
        }
        return back()->with('error', 'File PDF Kontrak tidak ditemukan');
    }

    public function downloadKontrak($id)
    {
        $kontrak = Kontrak::findOrFail($id);
        $filePath = public_path('pdf/' . $kontrak->file_pdf);
        
        if (File::exists($filePath)) {
            return response()->download($filePath);
        }
        return back()->with('error', 'File PDF Kontrak tidak ditemukan ');
    }
}