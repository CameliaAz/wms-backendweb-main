<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('penjualan_detail')->insert([
            ['id_produk' => 1, 'harga_jual' => 30000, 'jumlah' => 5, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
