<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\KontrakController;
use App\Http\Controllers\DokumenController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// TERMINAL KEBERANGKATAN (Pemecah Jalan)
Route::get('/dashboard', function () {
    if (auth()->user()->role == 'admin') {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('direktur.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');


// ==========================================
// RUANGAN KHUSUS ADMIN (Tukang Input Data)
// ==========================================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    // --- RUTE KONTRAK (Sesuai dengan nama di HTML-mu) ---
    Route::get('/admin/kontrak', [KontrakController::class, 'index'])->name('kontrak.index');
    Route::get('/admin/kontrak/create', [KontrakController::class, 'create'])->name('kontrak.create');
    Route::post('/admin/kontrak/generate', [KontrakController::class, 'generate'])->name('kontrak.generate');
    Route::get('/admin/kontrak/{id}/view', [KontrakController::class, 'view'])->name('kontrak.view');
    Route::get('/admin/kontrak/{id}/download', [KontrakController::class, 'download'])->name('kontrak.download');
    Route::delete('/admin/kontrak/{id}', [KontrakController::class, 'destroy'])->name('kontrak.destroy');

    // --- RUTE PROYEK & DOKUMEN ---
    // (Ini ku-daftarin sementara biar link di sidebar HTML-mu gak error "Route not found")
    Route::get('/admin/proyek', [ProyekController::class, 'index'])->name('proyek.index');
    Route::get('/admin/dokumen', [DokumenController::class, 'index'])->name('dokumen.index');
});


// ==========================================
// RUANGAN KHUSUS DIREKTUR (Si Paling Bos)
// ==========================================
Route::middleware(['auth', 'role:direktur'])->group(function () {
    Route::get('/direktur/dashboard', function () {
        return view('direktur.dashboard');
    })->name('direktur.dashboard');
});


// Rute Profil Bawaan Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';