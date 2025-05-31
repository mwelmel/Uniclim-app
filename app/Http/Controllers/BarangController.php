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

    public function store(Request $request)
    {
    $request->validate([
        'tanggal' => 'required|date',
        'kode_barang' => 'required',
        'nama_barang' => 'required',
        'harga' => 'required|integer',
        'ukuran' => 'required',
        'jumlah' => 'required|integer',
    ]);

    Barang::create($request->all());

    return redirect()->back()->with('success', 'Barang berhasil ditambahkan!');
    }
    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $request->validate([
            'tanggal' => 'required|date',
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'harga' => 'required|integer',
            'ukuran' => 'required',
            'jumlah' => 'required|integer',
        ]);

        $barang->update($request->all());

        return redirect()->back()->with('success', 'Barang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Barang::destroy($id);
        return redirect()->back()->with('success', 'Barang berhasil dihapus!');
    }
}
