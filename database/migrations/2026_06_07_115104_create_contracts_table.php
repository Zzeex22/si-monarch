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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kontrak'); 
            $table->string('nama_klien'); 
            $table->string('nama_pekerjaan');
            $table->bigInteger('nilai_pekerjaan');
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->enum('status_kontrak', ['Aktif', 'Selesai'])->default('Aktif');
            $table->string('file_pdf')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
