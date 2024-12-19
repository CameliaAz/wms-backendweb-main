<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasukTable extends Migration
{
    public function up(): void
    {
        Schema::create('masuk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_barang')->constrained('barang')->onDelete('cascade');
            $table->foreignId('id_kategori')->constrained('kategori')->onDelete('cascade');
            $table->foreignId('id_supplier')->constrained('supplier')->onDelete('cascade');
            $table->integer('jumlah');
            $table->date('expired')->nullable();
            $table->decimal('harga_beli', 15, 2);
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('masuk');
    }
}
