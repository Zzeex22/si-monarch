<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Klien extends Model
{
    protected $table = 'klien'; // Sesuaikan kalau namanya beda
    public $timestamps = false;

    protected $fillable = [
        'nama_instansi', 'nama_perwakilan', 'jabatan', 'alamat', 'no_hp', 'email'
    ];
}