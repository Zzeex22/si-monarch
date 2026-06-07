<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContractController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route Manajemen Kontrak
    Route::get('/kontrak', [ContractController::class, 'index'])->name('kontrak.index');
    Route::get('/kontrak/create', [ContractController::class, 'create'])->name('kontrak.create');
    Route::post('/kontrak/generate', [ContractController::class, 'generate'])->name('kontrak.generate');
    Route::get('/kontrak/download/{id}', [ContractController::class, 'download'])->name('kontrak.download');
    Route::get('/kontrak/view/{id}', [ContractController::class, 'view'])->name('kontrak.view');
    Route::delete('/kontrak/{id}', [ContractController::class, 'destroy'])->name('kontrak.destroy');
    
    // Dummy route sementara supaya menu sidebar-mu tidak error
    Route::get('/direktur/dashboard', function() { return 'Ini Dashboard'; })->name('dashboard.direktur');
    Route::get('/proyek', function() { return 'Halaman Proyek (Belum Dibuat)'; })->name('proyek.index');
    Route::get('/dokumen', function() { return 'Halaman Dokumen (Belum Dibuat)'; })->name('dokumen.index');

require __DIR__.'/auth.php';
