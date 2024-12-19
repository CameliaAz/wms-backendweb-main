<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemindahanTable extends Migration
{
    public function up(): void
    {
        Schema::create('pemindahan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_barang')->constrained('barang')->onDelete('cascade');
            $table->foreignId('lokasi_asal')->constrained('rak')->onDelete('cascade');
            $table->foreignId('lokasitujuan')->constrained('rak')->onDelete('cascade');
            $table->integer('jumlah');
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemindahan');
    }
}
