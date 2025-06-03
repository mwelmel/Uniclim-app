<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangKeluar extends Model
{
    protected $table = 'barang_keluar';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'tanggal',
        'kode_barang',
        'nama_barang',
        'harga_awal',
        'ukuran',
        'jumlah',
        'ukuran_dipotong',
        'harga_dikonversi',
        'total',
        'mata_uang',
    ];

    protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        if (empty($model->id)) {
            $model->id = Str::random(10);
        }
    });
    }
}

