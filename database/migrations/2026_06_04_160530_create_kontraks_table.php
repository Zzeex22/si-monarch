<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kontraks', function (Blueprint $table) {
            $table->id();
            $table->string('judul_kontrak');
            $table->string('pihak_ketiga'); // Nama perusahaan/klien
            $table->bigInteger('nilai_kontrak'); // Pakai bigInteger biar muat angka miliaran
            $table->date('tanggal_sepakat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontraks');
    }
};
