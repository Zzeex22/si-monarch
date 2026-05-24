<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyek;
use App\Models\Kontrak;
use Illuminate\Support\Facades\Auth;

class ProyekController extends Controller
{

    public function index()
    {
        $proyekList = Proyek::orderBy('id', 'desc')->get();
        return view('proyek.index', compact('proyekList'));
    }


    public function create()
    {

        $kontrakList = Kontrak::with('klien')->doesntHave('proyek')->get();
        return view('proyek.create', compact('kontrakList'));
    }

    public function store(Request $request)
    {

        Proyek::create([
            'kontrak_id' => $request->kontrak_id,
            'nama_proyek' => $request->nama_proyek,
            'kategori_proyek' => $request->kategori_proyek,
            'deskripsi_proyek' => $request->deskripsi_proyek,
            'lokasi_proyek' => $request->lokasi_proyek,
            'klien' => $request->klien,
            'pic_klien' => $request->pic_klien, 
            'tgl_mulai' => $request->tgl_mulai,
            'deadline' => $request->deadline,
            'anggaran' => $request->anggaran ?? 0,
            'status' => 'Perencanaan', 
            'progres' => 0,
        ]);

        return redirect()->route('proyek.index')->with('success', 'Proyek berhasil ditambahkan lek!');
    }

    public function show($id)
    {

        $proyek = Proyek::with('kontrak')->findOrFail($id);
        
        return view('proyek.show', compact('proyek'));
    }

} 