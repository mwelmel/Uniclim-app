<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang_keluar', function (Blueprint $table) {
        $table->string('id',20)->primary();
        $table->date('tanggal');
        $table->string('kode_barang');
        $table->string('nama_barang');
        $table->decimal('harga_awal', 15, 2)->nullable();
        $table->string('harga_dikonversi');
        $table->string('ukuran');
        $table->integer('jumlah');
        $table->string('ukuran_dipotong');
        $table->decimal('total', 15, 2);
        $table->timestamps();
        $table->string('mata_uang')->default('IDR'); // Tambahkan kolom mata_uang dengan default IDR
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_keluar');
    }
};
