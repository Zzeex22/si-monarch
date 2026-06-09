<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
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