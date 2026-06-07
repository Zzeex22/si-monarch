<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\Project;
use App\Models\Document;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContractController extends Controller
{
    public function index()
    {
        $kontrakList = Contract::orderBy('created_at', 'desc')->get();
        $totalKontrak = Contract::count();
        $kontrakAktif = Contract::where('status_kontrak', 'Aktif')->count();
        $totalNilai = Contract::sum('nilai_pekerjaan');

        return view('kontrak.index', compact('kontrakList', 'totalKontrak', 'kontrakAktif', 'totalNilai'));
    }

    public function create()
    {
        return view('kontrak.create');
    }

    public function generate(Request $request)
    {
        // 1. Siapkan semua data dari form untuk dilempar ke template PDF
        $data = $request->all();
        
        // Format tanggal indo (misal: 15 Agustus 2026)
        Carbon::setLocale('id');
        $data['tgl_dibuat_indo'] = Carbon::now()->translatedFormat('d F Y');
        
        // Otomatis ubah angka hari menjadi huruf (misal: 30 -> Tiga Puluh)
        $data['waktu_hari_huruf'] = $this->terbilang($request->waktu_hari);

        // 2. Generate PDF
        $pdf = Pdf::loadView('kontrak.pdf', $data)->setPaper('a4', 'portrait');
        
        // Buat nama file unik dan path penyimpanan
        $fileName = 'Kontrak_' . Str::slug($request->nama_pekerjaan) . '_' . time() . '.pdf';
        $filePath = 'kontrak/' . $fileName;

        // Simpan file fisik PDF ke folder storage/app/public/kontrak
        Storage::disk('public')->put($filePath, $pdf->output());

        // 3. Simpan ke database (Tabel Contracts)
        $contract = Contract::create([
            'nomor_kontrak' => $request->no_pihak1,
            'nama_klien' => $request->cv_pihak2, // Diambil dari nama CV pihak 2
            'nama_pekerjaan' => $request->nama_pekerjaan,
            'nilai_pekerjaan' => $request->nilai_angka,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'status_kontrak' => 'Aktif',
            'file_pdf' => $filePath,
        ]);

        // 4. OTOMATISASI: Buat Proyek Baru
        Project::create([
            'contract_id' => $contract->id,
            'nama_proyek' => $request->nama_pekerjaan,
            'persentase' => 0,
        ]);

        // 5. OTOMATISASI: Masukkan ke tabel Dokumen
        Document::create([
            'nama_dokumen' => 'SPK - ' . $request->nama_pekerjaan,
            'kategori' => 'kontrak',
            'file_path' => $filePath,
        ]);

        return redirect()->route('kontrak.index')->with('success', 'Kontrak berhasil dibuat! PDF, Proyek, dan Dokumen telah ter-generate otomatis.');
    }

    public function download($id)
    {
        $kontrak = Contract::findOrFail($id);
        return Storage::disk('public')->download($kontrak->file_pdf);
    }

    public function view($id)
    {
        $kontrak = Contract::findOrFail($id);
        return response()->file(storage_path('app/public/' . $kontrak->file_pdf));
    }

    public function destroy($id)
    {
        $kontrak = Contract::findOrFail($id);
        
        // Hapus file fisik PDF-nya juga
        if(Storage::disk('public')->exists($kontrak->file_pdf)){
            Storage::disk('public')->delete($kontrak->file_pdf);
        }
        
        // Hapus dari database (Project akan otomatis terhapus karena cascadeOnDelete)
        $kontrak->delete(); 

        return redirect()->route('kontrak.index')->with('success', 'Kontrak dan datanya berhasil dihapus!');
    }

    // --- FUNGSI HELPER UNTUK MENGUBAH ANGKA JADI HURUF ---
    private function terbilang($angka) {
        $angka = abs($angka);
        $baca = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        $terbilang = "";
        if ($angka < 12) { $terbilang = " " . $baca[$angka]; } 
        else if ($angka < 20) { $terbilang = $this->terbilang($angka - 10) . " Belas"; } 
        else if ($angka < 100) { $terbilang = $this->terbilang($angka / 10) . " Puluh" . $this->terbilang($angka % 10); } 
        else if ($angka < 200) { $terbilang = " Seratus" . $this->terbilang($angka - 100); } 
        else if ($angka < 1000) { $terbilang = $this->terbilang($angka / 100) . " Ratus" . $this->terbilang($angka % 100); }
        return trim($terbilang);
    }
}