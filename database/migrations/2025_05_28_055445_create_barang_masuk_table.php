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
        Schema::create('barang_masuk', function (Blueprint $table) {
        $table->id();
        $table->date('tanggal');
        $table->string('kode_barang');
        $table->string('nama_barang');
        $table->decimal('harga')->nullable();
        $table->string('ukuran');
        $table->integer('jumlah');
        $table->decimal('total');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_masuk');
    }
};
