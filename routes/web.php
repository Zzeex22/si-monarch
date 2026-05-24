<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DirekturController;
use App\Http\Controllers\KontrakController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\DokumenController;

Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'Direktur' ? redirect('/direktur/dashboard') : redirect('/komisaris/dashboard');
    }
    return redirect('/login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/direktur/dashboard', [DirekturController::class, 'dashboard']);
    
    // Rute Manajemen Kontrak
    Route::get('/direktur/kontrak', [KontrakController::class, 'index'])->name('kontrak.index');
    Route::get('/direktur/kontrak/buat', [KontrakController::class, 'create'])->name('kontrak.create');
    Route::post('/direktur/kontrak/generate', [KontrakController::class, 'generatePdf'])->name('kontrak.generate');
    Route::get('/direktur/kontrak/view/{id}', [KontrakController::class, 'view'])->name('kontrak.view');
    Route::get('/direktur/kontrak/download/{id}', [KontrakController::class, 'download'])->name('kontrak.download');
    Route::delete('/direktur/kontrak/{id}', [KontrakController::class, 'destroy'])->name('kontrak.destroy');

    // Rute Manajemen Proyek
    Route::get('/direktur/proyek', [ProyekController::class, 'index'])->name('proyek.index');
    Route::get('/direktur/proyek/tambah', [ProyekController::class, 'create'])->name('proyek.create');
    Route::post('/direktur/proyek/store', [ProyekController::class, 'store'])->name('proyek.store');
    Route::get('/direktur/proyek/{id}', [ProyekController::class, 'show'])->name('proyek.show');
    Route::get('/direktur/proyek/{id}/edit', [ProyekController::class, 'edit'])->name('proyek.edit');
    Route::put('/direktur/proyek/{id}', [ProyekController::class, 'update'])->name('proyek.update');
    
    // Rute Update Progres Proyek
    Route::get('/direktur/proyek/{id}/progres', [ProyekController::class, 'editProgres'])->name('proyek.editProgres');
    Route::put('/direktur/proyek/{id}/progres', [ProyekController::class, 'updateProgres'])->name('proyek.updateProgres');

    Route::get('/komisaris/dashboard', function () {
        return 'Halaman Komisaris Belum Dibuat Lek';
    });

    // Rute Manajemen Dokumen
    Route::get('/direktur/dokumen', [DokumenController::class, 'index'])->name('dokumen.index');
    Route::get('/direktur/dokumen/tambah', [DokumenController::class, 'create'])->name('dokumen.create');
    Route::post('/direktur/dokumen/store', [DokumenController::class, 'store'])->name('dokumen.store');
    Route::get('/direktur/dokumen/view/{id}', [DokumenController::class, 'view'])->name('dokumen.view');
    Route::get('/direktur/dokumen/download/{id}', [DokumenController::class, 'download'])->name('dokumen.download');
    Route::delete('/direktur/dokumen/{id}', [DokumenController::class, 'destroy'])->name('dokumen.destroy');
});