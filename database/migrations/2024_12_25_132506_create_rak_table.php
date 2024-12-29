<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRakTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('rak', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_barang')->nullable(); // Foreign key ke tabel barang
            $table->string('nama_rak'); // Nama Rak
            $table->string('nama_lokasi'); // Nama Lokasi
            $table->integer('jumlah')->default(0); // Jumlah stok
            $table->enum('status', ['available', 'not_available'])->default('available');
            $table->date('exp')->nullable(); // Kolom Exp (tanggal kedaluwarsa)
            $table->timestamps();

            // Definisi foreign key untuk barang (rak hanya boleh memiliki satu barang)
            $table->foreign('id_barang')
                ->references('id')
                ->on('barang')
                ->onDelete('set null'); // Set null jika barang dihapus
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('rak');
    }
}
