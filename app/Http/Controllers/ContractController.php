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

    public function index()
    {
        $contracts = Contract::latest()->get();
        
        $totalKontrak = Contract::count();
        $kontrakAktif = Contract::where('status_kontrak', 'Aktif')->count();

        $totalNilai = Contract::sum('nilai_pekerjaan');

        return view('kontrak.index', compact('contracts', 'totalKontrak', 'kontrakAktif', 'totalNilai'));
    }

    public function create()
    {
        return view('kontrak.create');
    }

    public function generate(Request $request)
    {

        $nilaiAsli = str_replace('.', '', $request->nilai_angka);

        $dataPdf = $request->all();
        $dataPdf['nilaiAsli'] = $nilaiAsli;

        $pdf = Pdf::loadView('kontrak.pdf', $dataPdf);

        $fileName = 'Kontrak_' . Str::slug($request->nama_pekerjaan) . '_' . time() . '.pdf';
        $filePath = 'kontrak/' . $fileName;

        Storage::disk('public')->put($filePath, $pdf->output());

        $contract = Contract::create([
            'nomor_kontrak' => $request->no_pihak1,
            'nama_klien' => $request->pt_pihak1, 
            'nama_pekerjaan' => $request->nama_pekerjaan,
            'nilai_pekerjaan' => $nilaiAsli, 
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'status_kontrak' => 'Aktif',
            'file_pdf' => $filePath,
        ]);

        Project::create([
            'contract_id' => $contract->id,
            'nama_proyek' => $request->nama_pekerjaan,
            'persentase' => 0,
        ]);

        Document::create([
            'nama_dokumen' => 'Kontrak: ' . $request->nama_pekerjaan,
            'kategori' => 'kontrak',
            'file_path' => $filePath,
        ]);

        return redirect()->route('kontrak.index')->with('success', 'Kontrak berhasil di-generate, proyek aktif, dan arsip tersimpan!');
    }

    public function download($id)
    {
        $contract = Contract::findOrFail($id);
        if (Storage::disk('public')->exists($contract->file_pdf)) {
            return Storage::disk('public')->download($contract->file_pdf);
        }
        return back()->with('error', 'File fisik tidak ditemukan di server!');
    }

    public function view($id)
    {
        $contract = Contract::findOrFail($id);
        if (Storage::disk('public')->exists($contract->file_pdf)) {
            return response()->file(storage_path('app/public/' . $contract->file_pdf));
        }
        return back()->with('error', 'File fisik tidak ditemukan di server!');
    }

    public function destroy($id)
    {
        $contract = Contract::findOrFail($id);

        if (Storage::disk('public')->exists($contract->file_pdf)) {
            Storage::disk('public')->delete($contract->file_pdf);
        }

        $contract->delete();
        
        return redirect()->route('kontrak.index')->with('success', 'Kontrak beserta file fisiknya berhasil dihapus!');
    }
}