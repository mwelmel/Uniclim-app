<?php

namespace App\Http\Controllers;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $data = BarangKeluar::orderBy('tanggal','desc')->get();
        return  response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal'=>'required|date',
            'kode_barang'=>'required|string',
            'nama_barang' => 'required|string',
            'harga_dikonversi' => 'required|string',
            'ukuran' => 'required|string',
            'jumlah' => 'required|integer',
            'ukuran_dipotong' => 'required|string',
            'total' => 'required|numeric',
        ]);

        BarangKeluar::create($request->all());

        return response()->json(['message' => 'Barang keluar berhasil ditambahkan']);
    }

    public function update(Request $request, $id)
    {
        $barang = BarangKeluar::findOrFail($id);
        $barang->update($request->all());

        return response()->json(['message' => 'Barang keluar berhasil diperbarui']);
    }

    public function destroy($id)
    {
        BarangKeluar::destroy($id);

        return response()->json(['message' => 'Barang keluar berhasil dihapus']);
    }

}
