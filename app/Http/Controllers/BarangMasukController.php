<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\Barang;
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
    $validated = $request->validate([
        'tanggal' => 'required|date',
        'kode_barang' => 'required|string',
        'nama_barang' => 'required|string',
        'harga' => 'nullable|numeric',
        'ukuran' => 'required|string',
        'jumlah' => 'required|integer',
        'total' => 'required|numeric',
    ]);

    // Simpan data barang masuk
    $barangMasuk = BarangMasuk::create($validated);

    // Update atau tambah stok barang
    $barang = Barang::where('kode_barang', $validated['kode_barang'])->first();

    if ($barang) {
        $barang->jumlah += $validated['jumlah'];
        $barang->save();
    } else {
        Barang::create([
            'tanggal' => $validated['tanggal'],
            'kode_barang' => $validated['kode_barang'],
            'nama_barang' => $validated['nama_barang'],
            'harga' => $validated['harga'],
            'ukuran' => $validated['ukuran'],
            'jumlah' => $validated['jumlah'],
        ]);
    }

    return redirect()->route('barangmasuk.index')->with('success', 'Barang masuk berhasil ditambahkan dan stok diperbarui.');
}

public function update(Request $request, $id)
{
    $barangMasuk = BarangMasuk::findOrFail($id);

    $validated = $request->validate([
        'tanggal' => 'required|date',
        'kode_barang' => 'required|string|max:255',
        'nama_barang' => 'required|string|max:255',
        'harga' => 'nullable|numeric|min:0',
        'ukuran' => 'required|string|max:255',
        'jumlah' => 'required|integer|min:1',
        'total' => 'required|numeric|min:0',
    ]);

    // Hitung selisih jumlah untuk update stok
    $selisihJumlah = $validated['jumlah'] - $barangMasuk->jumlah;

    $barangMasuk->update($validated);

    // Update stok barang
    $barang = Barang::where('kode_barang', $validated['kode_barang'])->first();
    if ($barang) {
        $barang->jumlah += $selisihJumlah;
        $barang->save();
    }

    return redirect()->route('barangmasuk.index')->with('success', 'Barang masuk berhasil diperbarui dan stok disesuaikan.');
}

public function destroy($id)
{
    $barangMasuk = BarangMasuk::findOrFail($id);

    // Kurangi stok barang sesuai jumlah yang dihapus
    $barang = Barang::where('kode_barang', $barangMasuk->kode_barang)->first();
    if ($barang) {
        $barang->jumlah -= $barangMasuk->jumlah;
        if ($barang->jumlah < 0) $barang->jumlah = 0; // Jangan sampai negatif
        $barang->save();
    }

    $barangMasuk->delete();

    return redirect()->route('barangmasuk.index')->with('success', 'Barang masuk berhasil dihapus dan stok disesuaikan.');
}

    // menyambungkan dengan data barang
    public function barang()
    {
    return $this->belongsTo(Barang::class, 'kode_barang', 'kode_barang');
    }


    // // Fungsi konversi barang
    // public function konversi(Request $request)
    // {
    //     $request->validate([
    //         'harga_awal' => 'required|numeric',
    //         'ukuran' => 'required|numeric',
    //         'ukuran_dipotong' => 'required|numeric',
    //     ]);

    //     $harga_awal = $request->harga_awal;
    //     $ukuran = $request->ukuran;
    //     $ukuran_dipotong = $request->ukuran_dipotong;

    //     if ($ukuran == 0) {
    //         return response()->json([
    //             'error' => 'Ukuran tidak boleh nol.'
    //         ], 422);
    //     }

    //     $harga_dikonversi = ($ukuran_dipotong / $ukuran) * $harga_awal;
    //     $jumlah = $request->input('jumlah', 1);
    //     $total = $harga_dikonversi * $jumlah;

    //     return response()->json([
    //         'harga_dikonversi' => round($harga_dikonversi, 2),
    //         'total' => round($total, 2),
    //     ]);
    // }
}
