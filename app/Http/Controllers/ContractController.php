<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\Project;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class ContractController extends Controller
{
    // Menampilkan daftar kontrak
    // Menampilkan daftar kontrak
    // Menampilkan daftar kontrak
    public function index()
    {
        $contracts = Contract::latest()->get();
        
        // TAMBAHAN: Hitung statistik buat ditampilin di kotak atas layar
        $totalKontrak = Contract::count();
        $kontrakAktif = Contract::where('status_kontrak', 'Aktif')->count();
        
        // JURUS BARU: Hitung total nilai semua kontrak (jumlahan dari kolom nilai_pekerjaan)
        $totalNilai = Contract::sum('nilai_pekerjaan');
        
        // Kirim semua variabelnya ke halaman view (pastikan 'totalNilai' ikut masuk compact)
        return view('kontrak.index', compact('contracts', 'totalKontrak', 'kontrakAktif', 'totalNilai'));
    }

    // Menampilkan form buat kontrak baru
    public function create()
    {
        return view('kontrak.create');
    }

    // Fungsi inti: Generate PDF & Simpan ke 3 Tabel
    public function generate(Request $request)
    {
        // 1. Bersihkan format angka (hapus titik dari form Javascript)
        $nilaiAsli = str_replace('.', '', $request->nilai_angka);

        // 2. Siapkan data untuk dikirim ke PDF
        // Kita tarik semua request pakai all() biar variabelnya langsung lepas (bisa dipanggil $pt_pihak1 dsb di Blade)
        $dataPdf = $request->all();
        $dataPdf['nilaiAsli'] = $nilaiAsli;

        // Generate PDF dari view template
        $pdf = Pdf::loadView('kontrak.pdf', $dataPdf);
        
        // Buat nama file unik biar nggak bentrok
        $fileName = 'Kontrak_' . Str::slug($request->nama_pekerjaan) . '_' . time() . '.pdf';
        $filePath = 'kontrak/' . $fileName;

        // Simpan file fisik PDF ke folder storage/app/public/kontrak
        Storage::disk('public')->put($filePath, $pdf->output());

        // 3. Simpan ke database (Tabel Contracts)
        $contract = Contract::create([
            'nomor_kontrak' => $request->no_pihak1,
            'nama_klien' => $request->pt_pihak1, // Sudah pakai Pihak 1
            'nama_pekerjaan' => $request->nama_pekerjaan,
            'nilai_pekerjaan' => $nilaiAsli, // Pakai nilai yang sudah bersih dari titik
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'status_kontrak' => 'Aktif',
            'file_pdf' => $filePath,
        ]);

        // 4. Otomatis buat Proyek baru
        Project::create([
            'contract_id' => $contract->id,
            'nama_proyek' => $request->nama_pekerjaan,
            'persentase' => 0,
        ]);

        // 5. Otomatis masuk ke Pusat Dokumen
        Document::create([
            'nama_dokumen' => 'Kontrak: ' . $request->nama_pekerjaan,
            'kategori' => 'kontrak',
            'file_path' => $filePath,
        ]);

        return redirect()->route('kontrak.index')->with('success', 'Kontrak berhasil di-generate, proyek aktif, dan arsip tersimpan!');
    }

    // Fungsi Unduh File PDF
    public function download($id)
    {
        $contract = Contract::findOrFail($id);
        if (Storage::disk('public')->exists($contract->file_pdf)) {
            return Storage::disk('public')->download($contract->file_pdf);
        }
        return back()->with('error', 'File fisik tidak ditemukan di server!');
    }

    // Fungsi Lihat File PDF di Browser
    public function view($id)
    {
        $contract = Contract::findOrFail($id);
        if (Storage::disk('public')->exists($contract->file_pdf)) {
            return response()->file(storage_path('app/public/' . $contract->file_pdf));
        }
        return back()->with('error', 'File fisik tidak ditemukan di server!');
    }

    // Fungsi Hapus Kontrak
    public function destroy($id)
    {
        $contract = Contract::findOrFail($id);
        
        // Hapus file fisik dari storage
        if (Storage::disk('public')->exists($contract->file_pdf)) {
            Storage::disk('public')->delete($contract->file_pdf);
        }
        
        // Hapus data dari database
        $contract->delete();
        
        return redirect()->route('kontrak.index')->with('success', 'Kontrak beserta file fisiknya berhasil dihapus!');
    }
}