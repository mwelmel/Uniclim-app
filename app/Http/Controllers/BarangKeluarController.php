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

    $harga_dikonversi_raw = $request->harga_dikonversi;
    $harga_dikonversi = floatval(str_replace(',', '.', preg_replace('/[^\d,\.]/', '', $harga_dikonversi_raw)));

    $total_raw = $request->total;
    $total = floatval(str_replace(',', '.', preg_replace('/[^\d,\.]/', '', $total_raw)));

    $id = Str::random(10);

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

    // Kurangi stok di tabel Barang
    $barang = Barang::where('kode_barang', $request->kode_barang)->first();
    if ($barang) {
        $barang->jumlah -= $request->jumlah;
        if ($barang->jumlah < 0) $barang->jumlah = 0;
        $barang->save();
    }

    return redirect()->route('barangkeluar.index')->with('success', 'Barang keluar berhasil ditambahkan dan stok dikurangi');
    }


    public function update(Request $request, $id)
{
    $barangKeluar = BarangKeluar::findOrFail($id);

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

    // Kembalikan stok lama
    $barang = Barang::where('kode_barang', $barangKeluar->kode_barang)->first();
    if ($barang) {
        $barang->jumlah += $barangKeluar->jumlah;
    }

    // Kurangi stok baru
    if ($request->kode_barang !== $barangKeluar->kode_barang) {
        // Kalau kode barang ganti, sesuaikan stok kedua barang
        if ($barang) $barang->save();

        $barangBaru = Barang::where('kode_barang', $request->kode_barang)->first();
        if ($barangBaru) {
            $barangBaru->jumlah -= $request->jumlah;
            if ($barangBaru->jumlah < 0) $barangBaru->jumlah = 0;
            $barangBaru->save();
        }
    } else {
        // Kalau kode barang sama
        $barang->jumlah -= $request->jumlah;
        if ($barang->jumlah < 0) $barang->jumlah = 0;
        $barang->save();
    }

    $barangKeluar->update([
        'tanggal' => $request->tanggal,
        'kode_barang' => $request->kode_barang,
        'nama_barang' => $request->nama_barang,
        'harga_awal' => $request->harga_awal,
        'harga_dikonversi' => $harga_dikonversi,
        'ukuran' => $request->ukuran,
        'jumlah' => $request->jumlah,
        'ukuran_dipotong' => $request->ukuran_dipotong,
        'total' => $total,
        'mata_uang' => $request->currency ?? $barangKeluar->mata_uang,
    ]);

    return redirect()->route('barangkeluar.index')->with('success', 'Barang keluar berhasil diperbarui dan stok disesuaikan');
    }


    public function destroy($id)
    {
    $barangKeluar = BarangKeluar::findOrFail($id);

    // Kembalikan stok
    $barang = Barang::where('kode_barang', $barangKeluar->kode_barang)->first();
    if ($barang) {
        $barang->jumlah += $barangKeluar->jumlah;
        $barang->save();
    }

    $barangKeluar->delete();

    return redirect()->route('barangkeluar.index')->with('success', 'Barang keluar berhasil dihapus dan stok dikembalikan');
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
