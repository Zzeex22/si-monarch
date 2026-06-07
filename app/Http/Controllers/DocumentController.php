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

    // FUNGSI KHUSUS ADMIN: Upload Dokumen Tambahan (Lainnya)
    public function store(Request $request)
    {
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'file_dokumen' => 'required|file|max:10240', // max 10MB
        ]);

        if ($request->hasFile('file_dokumen')) {
            $file = $request->file('file_dokumen');
            $fileName = 'Dokumen_' . Str::slug($request->nama_dokumen) . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Simpan ke storage/app/public/dokumen_lainnya
            $filePath = $file->storeAs('dokumen_lainnya', $fileName, 'public');

            Document::create([
                'nama_dokumen' => $request->nama_dokumen,
                'kategori' => 'lainnya',
                'file_path' => $filePath,
            ]);
        }

        return redirect()->route('dokumen.index')->with('success', 'Dokumen tambahan berhasil diunggah!');
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