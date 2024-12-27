<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('gambar')->nullable(); // Gambar barang
            $table->string('nama_barang'); // Nama barang
            $table->unsignedBigInteger('id_kategori'); // Kolom id_kategori sebagai foreign key
            $table->string('varian'); // Varian barang
            $table->string('ukuran'); // Ukuran barang
            $table->text('deskripsi'); // Deskripsi barang
            $table->decimal('harga_beli', 10, 2)->default(0); // Harga Beli barang
            $table->decimal('harga_jual', 10, 2)->default(0); // Harga Jual barang
            $table->timestamps(); // Kolom created_at dan updated_at

            // Definisi foreign key untuk kategori
            $table->foreign('id_kategori')
                  ->references('id')
                  ->on('kategori')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
