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
        Schema::table('barang_masuk', function (Blueprint $table) {
        $table->decimal('harga', 15, 2)->nullable()->change();
        $table->decimal('total', 18, 2)->change();
        });
    }

    // /**
    //  * Reverse the migrations.
    //  */
    // public function down(): void
    // {
    //     Schema::table('barang_masuk', function (Blueprint $table) {
    //     $table->decimal('harga')->nullable()->change();  // atau tipe asal Anda
    //     $table->decimal('total')->change();            // atau tipe asal Anda
    //     });
    // }
};
