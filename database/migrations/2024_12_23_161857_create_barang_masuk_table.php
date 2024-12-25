<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangMasuk extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_barang');
            $table->unsignedBigInteger('id_supplier'); // Tambahkan id_supplier
            $table->integer('jumlah_barang_masuk'); // Kolom jumlah barang masuk
            $table->date('exp')->nullable(); // Kolom exp
            $table->date('tgl_masuk'); // Kolom tanggal masuk
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_barang')->references('id')->on('barang')->onDelete('cascade');
            $table->foreign('id_supplier')->references('id')->on('supplier')->onDelete('cascade'); // Relasi ke tabel suppliers
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_masuk');
    }
}
