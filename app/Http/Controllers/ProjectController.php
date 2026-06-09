<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Report;
use App\Models\Document;
use Illuminate\Support\Str;

class ProjectController extends Controller
{

    public function index()
    {
        $projects = Project::with('contract')->latest()->get();
        return view('proyek.index', compact('projects'));
    }

    public function show($id)
    {
        $project = Project::with(['contract', 'reports'])->findOrFail($id);
        return view('proyek.show', compact('project'));
    }

    public function uploadReport(Request $request, $id)
    {
        $request->validate([
            'judul_laporan' => 'required|string|max:255',
            'file_laporan' => 'required|mimes:pdf,doc,docx,jpg,png|max:5120', // max 5MB
        ]);

        $project = Project::findOrFail($id);

        if ($request->hasFile('file_laporan')) {
            $file = $request->file('file_laporan');
            $fileName = 'Laporan_' . Str::slug($request->judul_laporan) . '_' . time() . '.' . $file->getClientOriginalExtension();

            $filePath = $file->storeAs('laporan', $fileName, 'public');

            Report::create([
                'project_id' => $project->id,
                'judul_laporan' => $request->judul_laporan,
                'catatan' => $request->catatan,
                'file_laporan' => $filePath,
            ]);

            Document::create([
                'nama_dokumen' => 'Laporan: ' . $request->judul_laporan . ' (' . $project->nama_proyek . ')',
                'kategori' => 'laporan',
                'file_path' => $filePath,
            ]);
        }

        return redirect()->route('proyek.show', $id)->with('success', 'Laporan berhasil diunggah dan otomatis tersimpan di pusat Dokumen!');
    }

    public function updateProgress(Request $request, $id)
    {
        $request->validate([
            'persentase' => 'required|numeric|min:0|max:100',
        ]);

        $project = Project::findOrFail($id);
        $project->update([
            'persentase' => $request->persentase,
        ]);

        return redirect()->route('proyek.show', $id)->with('success', 'Persentase progres proyek berhasil diperbarui!');
    }

    public function updateReportStatus(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        
        $report->update([
            'status' => $request->status,
            'pesan_revisi' => $request->pesan_revisi,
        ]);

        $pesan = $request->status == 'disetujui' ? 'Laporan berhasil disetujui!' : 'Laporan dikembalikan ke Admin untuk direvisi.';
        
        return back()->with('success', $pesan);
    }
}