<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    use HasFactory;
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
