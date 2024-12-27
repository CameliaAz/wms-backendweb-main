<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangPindahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_pindah', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('id_barang') // Foreign key ke tabel barang
                  ->constrained('barang') // Nama tabel referensi
                  ->onDelete('cascade'); // Cascade jika data dihapus
            $table->foreignId('id_lokasi_sumber') // Foreign key ke tabel lokasi (sumber)
                  ->constrained('rak') // Nama tabel referensi untuk lokasi sumber (rak)
                  ->onDelete('cascade'); // Cascade jika data dihapus
            $table->foreignId('id_lokasi_tujuan') // Foreign key ke tabel lokasi (tujuan)
                  ->constrained('rak') // Nama tabel referensi untuk lokasi tujuan (rak)
                  ->onDelete('cascade'); // Cascade jika data dihapus
            $table->foreignId('id_user') // Foreign key ke tabel users
                  ->constrained('users') // Nama tabel referensi untuk users
                  ->onDelete('cascade'); // Cascade jika data dihapus
            $table->integer('jumlah_pindah'); // Jumlah barang yang dipindahkan
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang_pindah');
    }
}
