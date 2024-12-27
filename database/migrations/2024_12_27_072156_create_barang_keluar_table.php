<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangKeluarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_keluar', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('id_barang') // Foreign key ke tabel barang
                  ->constrained('barang') // Nama tabel referensi
                  ->onDelete('cascade'); // Cascade jika data barang dihapus
            $table->foreignId('id_rak') // Foreign key ke tabel rak
                  ->constrained('rak') // Nama tabel referensi
                  ->onDelete('cascade'); // Cascade jika data rak dihapus
            $table->foreignId('id_user') // Foreign key ke tabel users
                  ->constrained('users') // Nama tabel referensi
                  ->onDelete('cascade'); // Cascade jika data user dihapus
            $table->integer('jumlah_keluar'); // Jumlah barang keluar
            $table->date('tanggal_keluar'); // Tanggal barang keluar
            $table->string('alasan'); // Alasan barang keluar
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
        Schema::dropIfExists('barang_keluar');
    }
}
