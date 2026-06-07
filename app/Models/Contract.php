<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    // Ini kuncinya lek, artinya "izinkan semua kolom diisi"
    protected $guarded = []; 
}