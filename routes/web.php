<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DirekturController;
use App\Http\Controllers\KontrakController;

// Rute Utama yang Lebih Pintar
Route::get('/', function () {
    // Kalau user sudah login, langsung arahkan ke dashboard sesuai role-nya
    if (Auth::check()) {
        $role = Auth::user()->role;
        if ($role === 'Direktur') {
            return redirect('/direktur/dashboard');
        } elseif ($role === 'Komisaris') {
            return redirect('/komisaris/dashboard');
        }
    }
    
    // Kalau belum login, baru lempar ke halaman login
    return redirect('/login');
});

// Middleware 'guest' khusus buat yang BELUM login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Middleware 'auth' khusus buat yang UDAH login
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard Direktur
    Route::get('/direktur/dashboard', [DirekturController::class, 'dashboard']);

    // Kontrak
    Route::get('/direktur/kontrak', [KontrakController::class, 'index'])->name('kontrak.index');
    Route::get('/direktur/kontrak/buat', [KontrakController::class, 'create'])->name('kontrak.create');
    Route::post('/direktur/kontrak/generate', [KontrakController::class, 'generatePdf'])->name('kontrak.generate');

    // Dashboard Komisaris Sementara
    Route::get('/komisaris/dashboard', function () {
        return 'Halaman Komisaris Belum Dibuat Lek';
    });
});