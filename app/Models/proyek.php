<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    protected $table = 'proyek';
    public $timestamps = false;

    // Daftarin semua kolom yang ada di database biar bisa diisi
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

    // Relasi ke tabel Kontrak (1 Proyek punya 1 Kontrak)
    public function kontrak()
    {
        return $this->belongsTo(Kontrak::class, 'kontrak_id', 'id');
    }

    // Relasi ke tabel Dokumen (1 Proyek bisa punya banyak Dokumen)
    public function dokumen()
    {
        return $this->hasMany(Dokumen::class, 'proyek_id', 'id');
    }
}