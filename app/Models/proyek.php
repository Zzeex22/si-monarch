<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    protected $table = 'proyek';
    public $timestamps = false;


    protected $fillable = [
        'kontrak_id',
        'nama_proyek',
        'kategori_proyek',
        'deskripsi_proyek',
        'lokasi_proyek',
        'klien',
        'pic_klien',
        'tgl_mulai',
        'deadline',
        'anggaran',
        'status',
        'progres',
        'catatan'
    ];

    public function kontrak()
    {
        return $this->belongsTo(Kontrak::class, 'kontrak_id', 'id');
    }


    public function dokumen()
    {
        return $this->hasMany(Dokumen::class, 'proyek_id', 'id');
    }
}