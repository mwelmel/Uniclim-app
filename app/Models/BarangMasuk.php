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
        'harga_awal',
        'harga_dikonversi',
        'ukuran',
        'jumlah',
        'ukuran_dipotong',
        'total',
    ];
}

