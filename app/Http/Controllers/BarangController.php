<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller
{
    public function index()
    {
        $dataBarang = Barang::all(); // Mengambil semua data barang
        return view('databarang', compact('dataBarang'));
    }

    // Tambahan method lain jika perlu: create, store, edit, update, delete, dll.
}
