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

    // Fungsi untuk generate kode_barang random (optional)
    private function generateKodeBarang()
    {
        do {
            $kode = 'KB' . random_int(100000, 999999); // contoh format KB + 6 digit angka
        } while (BarangMasuk::where('kode_barang', $kode)->exists());

        return $kode;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'kode_barang' => 'nullable|string|max:255',  // nullable jika mau generate otomatis
            'nama_barang' => 'required|string|max:255',
            'harga' => 'nullable|numeric|min:0',
            'ukuran' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'total' => 'required|numeric|min:0',
        ]);

        // Jika kode_barang tidak diisi, generate random
        if (empty($validated['kode_barang'])) {
            $validated['kode_barang'] = $this->generateKodeBarang();
        }

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
                'harga' => $validated['harga'] ?? 0,
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

        // Jika kode_barang berubah, sesuaikan stok lama dan baru
        if ($validated['kode_barang'] !== $barangMasuk->kode_barang) {
            // Kurangi stok lama
            $barangLama = Barang::where('kode_barang', $barangMasuk->kode_barang)->first();
            if ($barangLama) {
                $barangLama->jumlah -= $barangMasuk->jumlah;
                if ($barangLama->jumlah < 0) $barangLama->jumlah = 0;
                $barangLama->save();
            }

            // Tambah stok baru
            $barangBaru = Barang::where('kode_barang', $validated['kode_barang'])->first();
            if ($barangBaru) {
                $barangBaru->jumlah += $validated['jumlah'];
                $barangBaru->save();
            } else {
                Barang::create([
                    'tanggal' => $validated['tanggal'],
                    'kode_barang' => $validated['kode_barang'],
                    'nama_barang' => $validated['nama_barang'],
                    'harga' => $validated['harga'] ?? 0,
                    'ukuran' => $validated['ukuran'],
                    'jumlah' => $validated['jumlah'],
                ]);
            }
        } else {
            // Jika kode_barang tidak berubah, update stok sesuai selisih jumlah
            $barang = Barang::where('kode_barang', $validated['kode_barang'])->first();
            if ($barang) {
                $barang->jumlah += $selisihJumlah;
                if ($barang->jumlah < 0) $barang->jumlah = 0;
                $barang->save();
            }
        }

        $barangMasuk->update($validated);

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

    // Hubungan dengan model Barang, jika dibutuhkan
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode_barang');
    }

    // Fungsi konversi barang untuk AJAX
    public function konversi(Request $request)
    {
        $request->validate([
            'harga_awal' => 'required|numeric|min:0',
            'ukuran' => 'required|numeric|min:0.0001', // supaya tidak nol
            'ukuran_dipotong' => 'required|numeric|min:0',
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
