<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DirekturController;
use App\Http\Controllers\KontrakController;
use App\Http\Controllers\ProyekController;

// Rute
Route::get('/', function () {
    //role 
    if (Auth::check()) {
        $role = Auth::user()->role;
        if ($role === 'Direktur') {
            return redirect('/direktur/dashboard');
        } elseif ($role === 'Komisaris') {
            return redirect('/komisaris/dashboard');
        }
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


    Route::get('/direktur/kontrak', [KontrakController::class, 'index'])->name('kontrak.index');
    Route::get('/direktur/kontrak/buat', [KontrakController::class, 'create'])->name('kontrak.create');
    Route::post('/direktur/kontrak/generate', [KontrakController::class, 'generatePdf'])->name('kontrak.generate');

    // Dashboard Komisaris Sementara
    Route::get('/komisaris/dashboard', function () {
        return 'Halaman Komisaris Belum Dibuat Lek';
    });
});

Route::get('/direktur/proyek', [ProyekController::class, 'index'])->name('proyek.index');
Route::get('/direktur/proyek/tambah', [ProyekController::class, 'create'])->name('proyek.create');
Route::post('/direktur/proyek/store', [ProyekController::class, 'store'])->name('proyek.store');

Route::get('/direktur/kontrak/buat', [KontrakController::class, 'create'])->name('kontrak.create');
Route::post('/direktur/kontrak/generate', [KontrakController::class, 'generatePdf'])->name('kontrak.generate');
    
  
Route::get('/direktur/kontrak/view/{id}', [KontrakController::class, 'view'])->name('kontrak.view');
Route::get('/direktur/kontrak/download/{id}', [KontrakController::class, 'download'])->name('kontrak.download');
Route::delete('/direktur/kontrak/{id}', [KontrakController::class, 'destroy'])->name('kontrak.destroy');

Route::get('/direktur/proyek', [ProyekController::class, 'index'])->name('proyek.index');
Route::get('/direktur/proyek/tambah', [ProyekController::class, 'create'])->name('proyek.create');
Route::post('/direktur/proyek/store', [ProyekController::class, 'store'])->name('proyek.store');

Route::get('/direktur/proyek/{id}', [ProyekController::class, 'show'])->name('proyek.show');