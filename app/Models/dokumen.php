<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    protected $table = 'dokumen';
    public $timestamps = false;

    protected $fillable = [
        'proyek_id',
        'kontrak_id',
        'nama_file',
        'jenis_dokumen',
        'keterangan',
        'tgl_upload'
    ];


    public function proyek()
    {
        return $this->belongsTo(Proyek::class, 'proyek_id', 'id');
    }
}