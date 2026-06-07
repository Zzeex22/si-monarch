<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relasi ke tabel Contract
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}