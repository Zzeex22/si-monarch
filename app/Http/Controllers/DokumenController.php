<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Models\Proyek;
use App\Models\Kontrak;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class DokumenController extends Controller
{

    public function index()
    {
        $dokumenList = Dokumen::with(['proyek', 'kontrak'])->orderBy('id', 'desc')->get();
        return view('dokumen.index', compact('dokumenList'));
    }


    public function create()
    {
        $proyekList = Proyek::all();
        $kontrakList = Kontrak::all();
        return view('dokumen.create', compact('proyekList', 'kontrakList'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'file_dokumen' => 'required|mimes:pdf,doc,docx,jpg,png,xlsx|max:5120', 
        ]);

        if ($request->hasFile('file_dokumen')) {
            $file = $request->file('file_dokumen');

            $namaFile = time() . "_" . str_replace(' ', '_', $file->getClientOriginalName());


            $path = public_path('dokumen');
            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            $file->move($path, $namaFile);


            Dokumen::create([
                'kontrak_id' => $request->kontrak_id,
                'proyek_id' => $request->proyek_id,
                'nama_file' => $namaFile,
                'jenis_dokumen' => $request->jenis_dokumen,
                'keterangan' => $request->keterangan,
                'tgl_upload' => date('Y-m-d'),
            ]);

            return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil diunggah lek!');
        }

        return back()->with('error', 'Gagal mengunggah dokumen.');
    }


    public function view($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        $filePath = public_path('dokumen/' . $dokumen->nama_file);
        
        if (File::exists($filePath)) {
            return response()->file($filePath);
        }
        return back()->with('error', 'File fisik tidak ditemukan di server lek!');
    }


    public function download($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        $filePath = public_path('dokumen/' . $dokumen->nama_file);
        
        if (File::exists($filePath)) {
            return response()->download($filePath);
        }
        return back()->with('error', 'File fisik tidak ditemukan di server lek!');
    }


    public function destroy($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        $filePath = public_path('dokumen/' . $dokumen->nama_file);
        
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
        
        $dokumen->delete();
        return back()->with('success', 'Dokumen berhasil dihapus dari arsip!');
    }
}