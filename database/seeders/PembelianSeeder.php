<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PembelianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pembelian_detail')->insert([
            ['id_produk' => 1, 'harga_beli' => 20000, 'jumlah' => 5, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
