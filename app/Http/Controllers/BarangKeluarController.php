<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $barangKeluar = BarangKeluar::all();
        $barangList = Barang::all(); // Ambil data barang
        return view('barangkeluar', compact('barangKeluar', 'barangList'));
    }

    public function store(Request $request)
    {
        $currency = $request->currency;
        $request->validate([
            'tanggal' => 'required|date',
            'kode_barang' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'harga_awal' => 'required|numeric',
            'ukuran' => 'required|numeric',
            'jumlah' => 'required|integer|min:1',
            'ukuran_dipotong' => 'required|numeric',
            'harga_dikonversi' => 'required|string',
            'total' => 'required|string',
            'currency' => 'nullable|string|max:3',
        ]);

        // Hapus karakter Rp, $, spasi, dan titik ribuan, ganti koma dengan titik
        $harga_dikonversi_raw = $request->harga_dikonversi;
        $harga_dikonversi = floatval(str_replace(',', '.', preg_replace('/[^\d,\.]/', '', $harga_dikonversi_raw)));

        $total_raw = $request->total;
        $total = floatval(str_replace(',', '.', preg_replace('/[^\d,\.]/', '', $total_raw)));
        $id = Str::random(10); // Generate random ID
        
        BarangKeluar::create([
            'id' => $id,
            'tanggal' => $request->tanggal,
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'harga_awal' => $request->harga_awal,
            'ukuran' => $request->ukuran,
            'jumlah' => $request->jumlah,
            'ukuran_dipotong' => $request->ukuran_dipotong,
            'harga_dikonversi' => $harga_dikonversi,
            'total' => $total,
            'mata_uang' => $request->currency ?? 'IDR',
        ]);

        return redirect()->route('barangkeluar.index')->with('success', 'Barang keluar berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $barang = BarangKeluar::findOrFail($id);

        $request->validate([
            'tanggal' => 'required|date',
            'kode_barang' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'harga_awal' => 'required|numeric',
            'harga_dikonversi' => 'required|string',
            'ukuran' => 'required|numeric',
            'jumlah' => 'required|integer|min:1',
            'ukuran_dipotong' => 'required|numeric',
            'total' => 'required|string',
            'currency' => 'nullable|string|max:3',
        ]);

        $harga_dikonversi_raw = $request->harga_dikonversi;
        $harga_dikonversi = floatval(str_replace(',', '.', preg_replace('/[^\d,\.]/', '', $harga_dikonversi_raw)));

        $total_raw = $request->total;
        $total = floatval(str_replace(',', '.', preg_replace('/[^\d,\.]/', '', $total_raw)));

        $barang->update([
            'tanggal' => $request->tanggal,
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'harga_awal' => $request->harga_awal,
            'harga_dikonversi' => $harga_dikonversi,
            'ukuran' => $request->ukuran,
            'jumlah' => $request->jumlah,
            'ukuran_dipotong' => $request->ukuran_dipotong,
            'total' => $total,
            'mata_uang' => $request->currency ?? $barang->mata_uang,
        ]);

        return redirect()->route('barangkeluar.index')->with('success', 'Barang keluar berhasil diperbarui');
    }

    public function destroy($id)
    {
        BarangKeluar::destroy($id);

        return redirect()->route('barangkeluar.index')->with('success', 'Barang keluar berhasil dihapus');
    }

    public function edit($id)
    {
        $barang = BarangKeluar::findOrFail($id);
        return view('barangkeluar.edit', compact('barang'));
    }

    public function konversi(Request $request)
    {
        $request->validate([
            'harga_awal' => 'required|numeric',
            'ukuran' => 'required|numeric|gt:0',
            'ukuran_dipotong' => 'required|numeric|gt:0',
            'jumlah' => 'nullable|integer|min:1',
        ]);

        $harga_awal = $request->harga_awal;
        $ukuran = $request->ukuran;
        $ukuran_dipotong = $request->ukuran_dipotong;
        $jumlah = $request->input('jumlah', 1);

        $harga_dikonversi = ($ukuran_dipotong / $ukuran) * $harga_awal;
        $total = $harga_dikonversi * $jumlah;

        return response()->json([
            'harga_dikonversi' => round($harga_dikonversi, 2),
            'total' => round($total, 2),
        ]);
    }
}
