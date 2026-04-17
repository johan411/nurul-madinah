<?php

use App\Http\Controllers\TaskilController;
use App\Http\Controllers\PekerjaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\DashboardController;

// ✅ Cara 1: Pakai array syntax (direkomendasikan)
use App\Http\Controllers\MonitoringController;

// ========================================
// ROUTE PEKERJA
// ========================================
Route::get('/pekerja/tambah', [PekerjaController::class, 'create']);
Route::post('/pekerja/simpan', [PekerjaController::class, 'store']);

// ========================================
// ROUTE TASKIL
// ========================================

// Form tambah
Route::get('/taskil/tambah', [TaskilController::class, 'create'])->name('taskil.tambah');

// Simpan data (POST) - hanya 1x deklarasi
Route::post('/taskil/simpan', [TaskilController::class, 'store'])->name('taskil.simpan');

// Cetak surat jalan - dengan where constraint untuk handle karakter "/"
Route::get('/taskil/cetak/{noj}', [TaskilController::class, 'cetak'])
    ->where('noj', '.*')  // ✅ WAJIB: agar parameter bisa mengandung slash (/)
    ->name('taskil.cetak');

// Test route sederhana (opsional, bisa dihapus nanti)
Route::get('/test-halaman', function () {
    return 'Test Berhasil!';
});

// Dashboard/List Taskil
Route::get('/taskil', [TaskilController::class, 'index'])->name('taskil.index');

// ✅ Route ini WAJIB ada:
Route::get('/taskil/cetak/{id}', [TaskilController::class, 'cetakById'])
    ->name('taskil.cetakById');


 // Route untuk halaman upgrade data pekerja
Route::get('/pekerja', [PekerjaController::class, 'index'])->name('pekerja.index');

// API untuk cascading dropdown
// API Routes untuk cascading dropdown
Route::get('/api/markas/{prof}', [PekerjaController::class, 'getMarkas']);
Route::get('/api/halaqoh/{mar}', [PekerjaController::class, 'getHalaqoh']);
Route::get('/api/mahala/{hal}', [PekerjaController::class, 'getMahala']);
// Route untuk filter data pekerja
Route::get('/pekerja/filter', [PekerjaController::class, 'getFilteredData']);

// Route untuk update data pekerja
Route::post('/pekerja/update', [PekerjaController::class, 'update'])->name('pekerja.update');

Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring');


Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring');

// ✅ Cara 2: Pakai string dengan namespace lengkap
Route::get('/monitoring', 'App\Http\Controllers\MonitoringController@index')->name('monitoring');



// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/home', [DashboardController::class, 'home'])->name('dashboard.home');

// Redirect root ke dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});