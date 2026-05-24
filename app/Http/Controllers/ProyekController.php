<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyek;
use App\Models\Kontrak;
use App\Models\Dokumen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

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

        return redirect()->route('proyek.index')->with('success', 'Proyek berhasil ditambahkan');
    }

    public function show($id)
    {
        $proyek = Proyek::with('kontrak')->findOrFail($id);
        return view('proyek.show', compact('proyek'));
    }

    public function edit($id)
    {
        $proyek = Proyek::findOrFail($id);
        $kontrakList = Kontrak::with('klien')->get();
        return view('proyek.edit', compact('proyek', 'kontrakList'));
    }

    public function update(Request $request, $id)
    {
        $proyek = Proyek::findOrFail($id);
        $proyek->update([
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
        ]);

        return redirect()->route('proyek.show', $id)->with('success', 'Data informasi proyek berhasil diperbarui ');
    }


    public function editProgres($id)
    {
        $proyek = Proyek::findOrFail($id);
        return view('proyek.edit-progres', compact('proyek'));
    }

    public function updateProgres(Request $request, $id)
    {
        $proyek = Proyek::findOrFail($id);
        $progresBaru = (int) $request->progres;

   
        if ($request->hasFile('dokumen_laporan')) {
            $file = $request->file('dokumen_laporan');
            $namaFile = "LAPORAN_PROGRES_" . str_replace(' ', '_', strtoupper($proyek->nama_proyek)) . "_" . time() . "." . $file->getClientOriginalExtension();

            $path = public_path('dokumen');
            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            $file->move($path, $namaFile);

            Dokumen::create([
                'kontrak_id' => $proyek->kontrak_id,
                'proyek_id' => $proyek->id,
                'nama_file' => $namaFile,
                'jenis_dokumen' => 'Laporan Progres',
                'keterangan' => 'Update progres otomatis dari lapangan',
                'tgl_upload' => date('Y-m-d'),
            ]);

            $progresBaru += 20;
            if ($progresBaru > 100) {
                $progresBaru = 100;
            }
        }


        $proyek->update([
            'status' => $request->status,
            'progres' => $progresBaru,
        ]);


        if ($proyek->kontrak_id) {
            $kontrak = Kontrak::find($proyek->kontrak_id);
            if ($kontrak) {
                if ($request->status == 'Selesai') {
                    $kontrak->update(['status_kontrak' => 'Selesai']);
                } else {

                    $kontrak->update(['status_kontrak' => 'Aktif']);
                }
            }
        }

        return redirect()->route('proyek.show', $id)->with('success', 'Status dan progres proyek berhasil diupdate.');
    }
}