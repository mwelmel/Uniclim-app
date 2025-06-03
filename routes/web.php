<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StatController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangController;
use Illuminate\Support\Facades\Auth;

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');


Route::get('/login', function () {
    return view('auth.login');
});
Route::post('/login', [AuthController::class, 'login']);

Route::get('/account', [AuthController::class, 'accountPage']);
Route::post('/account/update', [AuthController::class, 'updateAccount']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/account', [AuthController::class, 'accountPage']);
    Route::post('/account/update', [AuthController::class, 'updateAccount']);
});

// Redirect root to login
Route::get('/', function () {
    return redirect('/login');
});

// Dashboard route (controller handles data passing)
Route::get('/dashboard', [DashboardController::class, 'index']);

// API/statistik routes
Route::get('/stats/latest', [StatController::class, 'latest']);
Route::post('/stats', [StatController::class, 'store']);

//Data Barang routes
Route::get('/databarang', [BarangController::class, 'index'])->name('databarang');
Route::post('/barang/store', [BarangController::class, 'store'])->name('barang.store');
Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');
Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');

// Barang Keluar routes
Route::get('/barangkeluar', [BarangKeluarController::class, 'index'])->name('barangkeluar.index');
Route::post('/barangkeluar', [BarangKeluarController::class, 'store'])->name('barangkeluar.store');
Route::get('/barangkeluar/{id}/edit', [BarangKeluarController::class, 'edit'])->name('barangkeluar.edit');
Route::put('/barangkeluar/{id}', [BarangKeluarController::class, 'update'])->name('barangkeluar.update');
Route::delete('/barangkeluar/{id}', [BarangKeluarController::class, 'destroy'])->name('barangkeluar.destroy');
Route::post('barangkeluar/konversi', [BarangKeluarController::class, 'konversi'])->name('barangkeluar.konversi');

// Barang Masuk routes
Route::get('/barangmasuk', [BarangMasukController::class, 'index'])->name('barangmasuk.index');
Route::post('/barangmasuk', [BarangMasukController::class, 'store'])->name('barangmasuk.store');
Route::get('/barangmasuk/{id}/edit', [BarangMasukController::class, 'edit'])->name('barangmasuk.edit');
Route::put('/barangmasuk/{id}', [BarangMasukController::class, 'update'])->name('barangmasuk.update');
Route::delete('/barangmasuk/{id}', [BarangMasukController::class, 'destroy'])->name('barangmasuk.destroy');
Route::post('/barangmasuk/konversi', [BarangMasukController::class, 'konversi'])->name('barangmasuk.konversi');
Route::resource('barangmasuk', BarangMasukController::class);
