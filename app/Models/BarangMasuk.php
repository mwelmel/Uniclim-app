<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangMasuk extends Model
{
    use HasFactory;

    protected $table = 'barang_masuk';

    protected $fillable = [
        'tanggal',
        'kode_barang',
        'nama_barang',
        'harga',
        'ukuran',
        'jumlah',
        'total',
    ];

    // Relasi BarangMasuk ke Barang berdasarkan kode_barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode_barang');
    }
}
