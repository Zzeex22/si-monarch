<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kontrak;
use App\Models\Dokumen;
use App\Models\Klien;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

class KontrakController extends Controller
{
    public function index()
    {
        $data = [
            'totalKontrak' => Kontrak::count(),
            'kontrakAktif' => Kontrak::where('status_kontrak', 'Aktif')->count(),
            'totalNilai' => Kontrak::sum('nilai_pekerjaan'),
            'kontrakList' => Kontrak::with(['proyek', 'klien'])->get()
        ];
        return view('kontrak.index', $data);
    }

    public function create()
    {
        return view('kontrak.create');
    }

    public function generatePdf(Request $request)
    {
        $klien = Klien::create([
            'nama_instansi' => $request->pt_pihak1,
            'nama_perwakilan' => $request->nama_pejabat1,
            'jabatan' => $request->jabatan1,
        ]);

        $kontrak = Kontrak::create([
            'klien_id' => $klien->id,
            'nomor_kontrak' => $request->no_pihak1,
            'jenis_perjanjian' => 'Harga Satuan',
            'tgl_kontrak' => date('Y-m-d'),
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'nilai_pekerjaan' => $request->nilai_angka,
            'status_kontrak' => 'Aktif',
        ]);

        $namaFile = "SPK_" . str_replace(' ', '_', strtoupper($request->cv_pihak2)) . "_" . time() . ".pdf";

        Dokumen::create([
            'kontrak_id' => $kontrak->id,
            'proyek_id' => null,
            'nama_file' => $namaFile,
            'jenis_dokumen' => 'Kontrak',
            'keterangan' => 'Kontrak otomatis: ' . $request->nama_pekerjaan,
            'tgl_upload' => date('Y-m-d'),
        ]);

        $data = $request->all();
        $data['tgl_dibuat_indo'] = $this->formatTanggalIndo(date('Y-m-d'));
        $data['waktu_hari_huruf'] = ucwords($this->terbilang((int)$request->waktu_hari));

        $pdf = Pdf::loadView('kontrak.pdf', $data)->setPaper('A4', 'portrait');

        $path = public_path('dokumen');
        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        $pdf->save($path . '/' . $namaFile); 

        return $pdf->download($namaFile); 
    }


    public function view($id)
    {
        $dokumen = Dokumen::where('kontrak_id', $id)->first();
        if ($dokumen && File::exists(public_path('dokumen/' . $dokumen->nama_file))) {
            return response()->file(public_path('dokumen/' . $dokumen->nama_file));
        }
        return back()->with('error', 'File PDF belum tersimpan di server');
    }


    public function download($id)
    {
        $dokumen = Dokumen::where('kontrak_id', $id)->first();
        if ($dokumen && File::exists(public_path('dokumen/' . $dokumen->nama_file))) {
            return response()->download(public_path('dokumen/' . $dokumen->nama_file));
        }
        return back()->with('error', 'File PDF belum tersimpan di server');
    }


    public function destroy($id)
    {
        $kontrak = Kontrak::findOrFail($id);
        

        $dokumen = Dokumen::where('kontrak_id', $id)->first();
        if ($dokumen) {
            $filePath = public_path('dokumen/' . $dokumen->nama_file);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
            $dokumen->delete();
        }


        $kontrak->delete();

        return back()->with('success', 'Kontrak beserta file PDF-nya berhasil dihapus!');
    }


    private function formatTanggalIndo($tanggal) {
        $bulan = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
        $hari = ['Sun'=>'Minggu','Mon'=>'Senin','Tue'=>'Selasa','Wed'=>'Rabu','Thu'=>'Kamis','Fri'=>'Jumat','Sat'=>'Sabtu'];
        $timestamp = strtotime($tanggal);
        return $hari[date('D', $timestamp)] . " tanggal " . date('d', $timestamp) . " bulan " . $bulan[date('m', $timestamp)] . " tahun " . date('Y', $timestamp);
    }

    private function penyebut($nilai) {
        $nilai = abs($nilai);
        $huruf = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];
        if ($nilai < 12) return " " . $huruf[$nilai];
        if ($nilai < 20) return $this->penyebut($nilai - 10) . " belas";
        if ($nilai < 100) return $this->penyebut((int)($nilai/10)) . " puluh" . $this->penyebut($nilai % 10);
        if ($nilai < 200) return " seratus" . $this->penyebut($nilai - 100);
        return $this->penyebut((int)($nilai/100)) . " ratus" . $this->penyebut($nilai % 100);
    }

    private function terbilang($nilai) {
        return trim(($nilai < 0 ? "minus " : "") . $this->penyebut($nilai));
    }
}