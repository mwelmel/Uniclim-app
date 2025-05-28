<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangmasuk = BarangMasuk::orderBy('tanggal', 'desc')->get();
        return view('barangmasuk', compact('barangmasuk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kode_barang' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'harga_dikonversi' => 'required|string|max:255',
            'ukuran' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'ukuran_dipotong' => 'required|string|max:255',
            'total' => 'required|numeric|min:0',
        ]);

        BarangMasuk::create($request->all());

        return redirect()->route('barangmasuk.index')->with('success', 'Barang masuk berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $barang = BarangMasuk::findOrFail($id);

        $request->validate([
            'tanggal' => 'required|date',
            'kode_barang' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'harga_dikonversi' => 'required|string|max:255',
            'ukuran' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'ukuran_dipotong' => 'required|string|max:255',
            'total' => 'required|numeric|min:0',
        ]);

        $barang->update($request->all());

        return redirect()->route('barangmasuk.index')->with('success', 'Barang masuk berhasil diperbarui');
    }

    public function destroy($id)
    {
        BarangMasuk::destroy($id);

        return redirect()->route('barangmasuk.index')->with('success', 'Barang masuk berhasil dihapus');
    }

    public function edit($id)
    {
        $barang = BarangMasuk::findOrFail($id);
        return view('barangmasuk.edit', compact('barang'));
    }

    // Fungsi konversi barang
    public function konversi(Request $request)
    {
        $request->validate([
            'harga_awal' => 'required|numeric',
            'ukuran' => 'required|numeric',
            'ukuran_dipotong' => 'required|numeric',
        ]);

        $harga_awal = $request->harga_awal;
        $ukuran = $request->ukuran;
        $ukuran_dipotong = $request->ukuran_dipotong;

        if ($ukuran == 0) {
            return response()->json([
                'error' => 'Ukuran tidak boleh nol.'
            ], 422);
        }

        $harga_dikonversi = ($ukuran_dipotong / $ukuran) * $harga_awal;
        $jumlah = $request->input('jumlah', 1);
        $total = $harga_dikonversi * $jumlah;

        return response()->json([
            'harga_dikonversi' => round($harga_dikonversi, 2),
            'total' => round($total, 2),
        ]);
    }
}
