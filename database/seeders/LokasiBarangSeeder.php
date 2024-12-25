<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LokasiBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $data = [
            [
                // 'id_barang_masuk' => 8,  // Ganti dengan id_barang_masuk yang sesuai
                'id_rak' => 1,           // Ganti dengan id_rak yang sesuai
                'jumlah_stock' => 0,     // Stok diatur menjadi 0
                'exp' => null,           // Exp diubah menjadi null
            ],
            [
                // 'id_barang_masuk' => 8,  // Ganti dengan id_barang_masuk yang sesuai
                'id_rak' => 2,           // Ganti dengan id_rak yang sesuai
                'jumlah_stock' => 0,     // Stok diatur menjadi 0
                'exp' => null,           // Exp diubah menjadi null
            ],
            [
                // 'id_barang_masuk' => 8,  // Ganti dengan id_barang_masuk yang sesuai
                'id_rak' => 3,           // Ganti dengan id_rak yang sesuai
                'jumlah_stock' => 0,     // Stok diatur menjadi 0
                'exp' => null,           // Exp diubah menjadi null
            ],
        ];

        // Insert data ke tabel lokasi_barang
        DB::table('lokasi_barang')->insert($data);
    }
}
