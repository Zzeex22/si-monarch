<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 1. TERMINAL KEBERANGKATAN (Pemecah Jalan)
Route::get('/dashboard', function () {
    if (auth()->user()->role == 'admin') {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('direktur.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');


// 2. RUANGAN KHUSUS ADMIN (Tukang Input)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    // Nanti rute tambah proyek, tambah dokumen admin taruh di sini semua
});


// 3. RUANGAN KHUSUS DIREKTUR (Si Paling Bos)
Route::middleware(['auth', 'role:direktur'])->group(function () {
    Route::get('/direktur/dashboard', function () {
        return view('direktur.dashboard');
    })->name('direktur.dashboard');
    
    // Nanti rute lihat laporan direktur taruh di sini
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';