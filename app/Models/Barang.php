<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang'; // nama tabel di database
    protected $fillable = ['ID','kode_barang', 'nama_barang', 'harga', 'ukuran', 'jumlah', 'tanggal']; // sesuaikan kolomnya
}
