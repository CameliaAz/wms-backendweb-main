<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLokasiBarang extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lokasi_barang', function (Blueprint $table) {
            $table->id(); // Primary key BIGINT unsigned
            $table->foreignId('id_barang_masuk') // Foreign key ke tabel barang_masuk
                  ->constrained('barang_masuk') // Nama tabel referensi
                  ->onDelete('cascade'); // Cascade jika data dihapus
            $table->foreignId('id_rak') // Foreign key ke tabel rak
                  ->constrained('rak') // Nama tabel referensi
                  ->onDelete('cascade'); // Cascade jika data dihapus
            $table->integer('jumlah_stock'); // Jumlah stok
            $table->date('exp')->nullable(); // Tanggal kadaluarsa, opsional
            $table->timestamps(); // Kolom created_at dan updated_at
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokasi_barang');
    }
};
