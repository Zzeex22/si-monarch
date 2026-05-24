<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kontrak extends Model
{
    protected $table = 'kontrak';
    public $timestamps = false;

    protected $fillable = [
        'klien_id',
        'nomor_kontrak',
        'jenis_perjanjian',
        'tgl_kontrak',
        'tgl_mulai',
        'tgl_selesai',
        'nilai_pekerjaan',
        'status_kontrak'
    ];


    public function proyek()
    {
        return $this->hasOne(Proyek::class, 'kontrak_id', 'id');
    }


    public function klien()
    {
        return $this->belongsTo(Klien::class, 'klien_id', 'id');
    }
}