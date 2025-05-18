use App\Http\Controllers\StatController;

Route::get('/stats/latest', [StatController::class, 'latest']);
Route::post('/stats', [StatController::class, 'store']);
Route::get('/barang-keluar', [BarangKeluarController::class, 'index']);
Route::post('/barang-keluar', [BarangKeluarController::class, 'store']);
Route::put('/barang-keluar/{id}', [BarangKeluarController::class, 'update']);
Route::delete('/barang-keluar/{id}', [BarangKeluarController::class, 'destroy']);
