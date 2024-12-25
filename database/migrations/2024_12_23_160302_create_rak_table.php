<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRak extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rak', function (Blueprint $table) {
            $table->id();
            $table->string('nama_rak'); // Nama Rak
            $table->enum('status', ['avail', 'unavail'])->default('avail'); // Status Rak
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rak');
    }
};
