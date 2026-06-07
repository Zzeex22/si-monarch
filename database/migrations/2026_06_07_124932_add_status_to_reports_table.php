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
    Schema::table('reports', function (Blueprint $table) {
        // Tambahkan 2 kolom ini
        $table->enum('status', ['pending', 'disetujui', 'revisi'])->default('pending');
        $table->text('pesan_revisi')->nullable();
    });
}

public function down(): void
{
    Schema::table('reports', function (Blueprint $table) {
        $table->dropColumn(['status', 'pesan_revisi']);
    });
}
};
