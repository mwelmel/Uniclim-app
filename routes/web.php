<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StatController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLoginForm']);


// Redirect root to dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard route (controller handles data passing)
Route::get('/dashboard', [DashboardController::class, 'index']);

// API/statistik routes
Route::get('/stats/latest', [StatController::class, 'latest']);
Route::post('/stats', [StatController::class, 'store']);

// Barang Keluar routes
Route::get('/barangkeluar', [BarangKeluarController::class, 'index'])->name('barangkeluar.index');
Route::post('/barangkeluar', [BarangKeluarController::class, 'store'])->name('barangkeluar.store');
Route::get('/barangkeluar/{id}/edit', [BarangKeluarController::class, 'edit'])->name('barangkeluar.edit');
Route::put('/barangkeluar/{id}', [BarangKeluarController::class, 'update'])->name('barangkeluar.update');
Route::delete('/barangkeluar/{id}', [BarangKeluarController::class, 'destroy'])->name('barangkeluar.destroy');
Route::post('barangkeluar/konversi', [BarangKeluarController::class, 'konversi'])->name('barangkeluar.konversi');


