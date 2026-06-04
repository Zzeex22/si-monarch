<?php

namespace App\Http\Controllers;

use App\Models\Kontrak;
use App\Models\Proyek;
use App\Models\Dokumen;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Wajib dipanggil biar bisa cetak PDF
use Carbon\Carbon; // Wajib dipanggil buat ngatur tanggal

class KontrakController extends Controller
{
    // 1. Nampilin Halaman Index Kontrak
    public function index()
    {
        $kontrakList = Kontrak::latest()->get();
        $totalKontrak = $kontrakList->count();
        $kontrakAktif = $kontrakList->where('status_kontrak', 'Aktif')->count();
        $totalNilai = $kontrakList->sum('nilai_kontrak');

        return view('admin.kontrak.index', compact('kontrakList', 'totalKontrak', 'kontrakAktif', 'totalNilai'));
    }

    // 2. Nampilin Form Create
    public function create()
    {
        return view('admin.kontrak.create');
    }

    // 3. Proses Generate PDF & Simpan Database Serentak (Sihirnya disini)
    public function generate(Request $request)
    {
        // Ambil semua inputan dari form
        $data = $request->all();
        
        // Bikin format tanggal cantik buat di PDF
        Carbon::setLocale('id'); // Pake bahasa indo
        $data['tgl_dibuat_indo'] = Carbon::now()->translatedFormat('d F Y');
        
        // Karena di form gak ada inputan "Waktu Hari (Huruf)", kita set manual dulu aja
        $data['waktu_hari_huruf'] = "Sesuai Kesepakatan"; 

        // Generate PDF dari view admin.kontrak.pdf
        $pdf = Pdf::loadView('admin.kontrak.pdf', $data);
        
        // Bikin nama file PDF-nya dan simpan ke folder public/dokumen
        $nama_file = time() . "_KONTRAK_" . str_replace(' ', '_', $request->cv_pihak2) . ".pdf";
        $pdf->save(public_path('dokumen/' . $nama_file));

        // SIMPAN KE TABEL KONTRAK
        $kontrak = Kontrak::create([
            'nomor_kontrak' => $request->no_pihak1,
            'judul_kontrak' => $request->nama_pekerjaan,
            'nama_klien' => $request->cv_pihak2,
            'nilai_kontrak' => $request->nilai_angka,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'status_kontrak' => 'Aktif',
            'file_kontrak' => $nama_file,
        ]);

        // SIMPAN KE TABEL PROYEK (Auto Create)
        Proyek::create([
            'kontrak_id' => $kontrak->id,
            'nama_proyek' => $request->nama_pekerjaan,
            'nama_klien' => $request->cv_pihak2,
            'tanggal_mulai' => $request->tgl_mulai,
            'tanggal_selesai' => $request->tgl_selesai,
            'progres' => 0,
        ]);

        // SIMPAN KE TABEL DOKUMEN (Brankas Digital)
        Dokumen::create([
            'nama_dokumen' => 'Kontrak: ' . $request->nama_pekerjaan,
            'file_pdf' => $nama_file,
            'keterangan' => 'File kontrak otomatis dari sistem untuk vendor ' . $request->cv_pihak2,
        ]);

        return redirect()->route('kontrak.index')->with('success', 'Ngeri Lek! Kontrak (PDF), Proyek, dan Dokumen berhasil diciptakan serentak!');
    }

    // 4. Lihat File PDF (Mata)
    public function view($id)
    {
        $kontrak = Kontrak::findOrFail($id);
        return response()->file(public_path('dokumen/' . $kontrak->file_kontrak));
    }

    // 5. Download File PDF (Unduh)
    public function download($id)
    {
        $kontrak = Kontrak::findOrFail($id);
        return response()->download(public_path('dokumen/' . $kontrak->file_kontrak));
    }

    // 6. Hapus Data Kontrak & File PDF nya
    public function destroy($id)
    {
        $kontrak = Kontrak::findOrFail($id);
        
        // Hapus file fisiknya dari folder
        if(file_exists(public_path('dokumen/' . $kontrak->file_kontrak))){
            unlink(public_path('dokumen/' . $kontrak->file_kontrak)); 
        }
        
        // Hapus dari database
        $kontrak->delete(); 
        
        return back()->with('success', 'Data Kontrak dan file PDF berhasil dibumihanguskan!');
    }
}