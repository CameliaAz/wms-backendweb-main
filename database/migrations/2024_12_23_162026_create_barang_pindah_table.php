<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangPindahTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang_pindah', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('id_barang') // Foreign key ke tabel barang
                  ->constrained('barang') // Nama tabel referensi
                  ->onDelete('cascade'); // Cascade jika data dihapus
            $table->foreignId('id_rak_sumber') // Foreign key ke tabel raks
                  ->constrained('rak') // Nama tabel referensi untuk rak sumber
                  ->onDelete('cascade'); // Cascade jika data dihapus
            $table->foreignId('id_rak_tujuan') // Foreign key ke tabel raks
                  ->constrained('rak') // Nama tabel referensi untuk rak tujuan
                  ->onDelete('cascade'); // Cascade jika data dihapus
            $table->integer('jumlah_pindah'); // Jumlah barang yang dipindahkan
            $table->timestamps(); // Kolom created_at dan updated_at
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_pindah');
    }
};
