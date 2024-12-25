<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangMasukSeeder extends Seeder
{
    public function run()
    {
        DB::table('barang_masuk')->insert([
            [
                'id_barang' => 1,
                'id_supplier' => 1,
                'id_tujuan' => 1,
                'id_user' => 1, // Tambahkan id_user
                'jumlah_barang_masuk' => 100,
                'exp' => '2025-06-25',
                'tgl_masuk' => now(),
            ],
            [
                'id_barang' => 2,
                'id_supplier' => 2,
                'id_tujuan' => 2,
                'id_user' => 2, // Tambahkan id_user
                'jumlah_barang_masuk' => 50,
                'exp' => '2025-03-25',
                'tgl_masuk' => now(),
            ],
        ]);
    }
}
