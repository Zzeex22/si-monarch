<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    public function index()
    {
        // Ambil semua dokumen urut dari yang paling baru diunggah
        $documents = Document::latest()->get();
        return view('dokumen.index', compact('documents'));
    }

    // FUNGSI KHUSUS ADMIN: Upload Dokumen Tambahan
    public function store(Request $request)
    {
        // 1. Tambahkan validasi untuk kategori
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'kategori' => 'required|in:kontrak,laporan,lainnya',
            'file_dokumen' => 'required|file|max:10240', // max 10MB
        ]);

        if ($request->hasFile('file_dokumen')) {
            $file = $request->file('file_dokumen');
            $fileName = 'Dokumen_' . Str::slug($request->nama_dokumen) . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Simpan ke folder yang rapi
            $filePath = $file->storeAs('dokumen_manual', $fileName, 'public');

            // 2. Simpan kategori sesuai inputan dari form
            Document::create([
                'nama_dokumen' => $request->nama_dokumen,
                'kategori' => $request->kategori, 
                'file_path' => $filePath,
            ]);
        }

        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil diunggah dengan kategori yang dipilih!');
    }

    public function download($id)
    {
        $document = Document::findOrFail($id);
        if (Storage::disk('public')->exists($document->file_path)) {
            return Storage::disk('public')->download($document->file_path);
        }
        return back()->with('error', 'File fisik tidak ditemukan di server!');
    }

    public function view($id)
    {
        $document = Document::findOrFail($id);
        if (Storage::disk('public')->exists($document->file_path)) {
            return response()->file(storage_path('app/public/' . $document->file_path));
        }
        return back()->with('error', 'File fisik tidak ditemukan di server!');
    }

    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        
        // Hapus file fisik dari storage
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }
        
        // Hapus data dari database
        $document->delete();
        
        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil dihapus selamanya!');
    }
}