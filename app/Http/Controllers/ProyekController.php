<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyek;
use App\Models\Kontrak;
use Illuminate\Support\Facades\Auth;

class ProyekController extends Controller
{
    // Menampilkan halaman daftar proyek
    public function index()
    {
        $proyekList = Proyek::orderBy('id', 'desc')->get();
        return view('proyek.index', compact('proyekList'));
    }

    // Menampilkan form tambah proyek
    public function create()
    {
        // Tarik data kontrak yang belum punya proyek, lengkap dengan data kliennya
        $kontrakList = Kontrak::with('klien')->doesntHave('proyek')->get();
        return view('proyek.create', compact('kontrakList'));
    }

    // Menyimpan data proyek baru
    public function store(Request $request)
    {
        // Simpan ke database proyek menggunakan data otomatis dari form & kontrak
        Proyek::create([
            'kontrak_id' => $request->kontrak_id,
            'nama_proyek' => $request->nama_proyek,
            'kategori_proyek' => $request->kategori_proyek,
            'deskripsi_proyek' => $request->deskripsi_proyek,
            'lokasi_proyek' => $request->lokasi_proyek,
            'klien' => $request->klien, // Terisi otomatis dari JS
            'pic_klien' => $request->pic_klien, // Terisi otomatis dari JS
            'tgl_mulai' => $request->tgl_mulai,
            'deadline' => $request->deadline,
            'anggaran' => $request->anggaran ?? 0,
            'status' => 'Perencanaan', // Status awal sesuai laporan
            'progres' => 0,
        ]);

        return redirect()->route('proyek.index')->with('success', 'Proyek berhasil ditambahkan lek!');
    }

    // Menampilkan detail proyek
    public function show($id)
    {
        // Cari proyek berdasarkan ID, sekalian narik relasi kontraknya
        $proyek = Proyek::with('kontrak')->findOrFail($id);
        
        return view('proyek.show', compact('proyek'));
    }

} // <--- Nah, kurung kurawal penutup class-nya ada di paling bawah ini lek