<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LokasiBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lokasi_barang')->insert([
            ['nama_lokasi' => 'Toko', 'stok' => 100, 'rak' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nama_lokasi' => 'Gudang', 'stok' => 50, 'rak' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
