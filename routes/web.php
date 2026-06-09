<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DocumentController;
use App\Models\Contract;
use App\Models\Project;
use App\Models\Document;
use App\Models\Report;

    Route::get('/', function () {
    return view('welcome');
    });

    Route::get('/dashboard', function () {
    // Menghitung semua total untuk ditampilkan di Dashboard
    $totalKontrak = Contract::count();
    $kontrakAktif = Contract::where('status_kontrak', 'Aktif')->count();
    
    $totalProyek = Project::count();
    $proyekSelesai = Project::where('persentase', 100)->count();
    
    $totalDokumen = Document::count();
    $totalLaporan = Report::count();

    return view('dashboard', compact(
        'totalKontrak', 'kontrakAktif', 'totalProyek', 'proyekSelesai', 'totalDokumen', 'totalLaporan'
    ));
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

    // Route Manajemen Proyek
    Route::get('/proyek', [ProjectController::class, 'index'])->name('proyek.index');
    Route::get('/proyek/{id}', [ProjectController::class, 'show'])->name('proyek.show');
    Route::post('/proyek/{id}/report', [ProjectController::class, 'uploadReport'])->name('proyek.report');
    Route::post('/proyek/{id}/progress', [ProjectController::class, 'updateProgress'])->name('proyek.progress');
    Route::post('/report/{id}/status', [ProjectController::class, 'updateReportStatus'])->name('report.status');

    // Route Pusat Dokumen
    Route::get('/dokumen', [DocumentController::class, 'index'])->name('dokumen.index');
    Route::post('/dokumen', [DocumentController::class, 'store'])->name('dokumen.store');
    Route::get('/dokumen/download/{id}', [DocumentController::class, 'download'])->name('dokumen.download');
    Route::get('/dokumen/view/{id}', [DocumentController::class, 'view'])->name('dokumen.view');
    Route::delete('/dokumen/{id}', [DocumentController::class, 'destroy'])->name('dokumen.destroy');

    require __DIR__.'/auth.php';
