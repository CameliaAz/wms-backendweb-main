<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('produk')->insert([
            ['id' => 1,'kode_produk' => 'SK001', 'nama' => 'Produk A','harga_beli' => 20000, 'harga_jual' => 30000, 'expired' => '2025-12-31', 'id_kategori' => 1, 'id_supplier' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2,'kode_produk' => 'MK002', 'nama'=> 'Produk B','harga_beli' => 50000, 'harga_jual' => 70000, 'expired' => '2026-01-31', 'id_kategori' => 2, 'id_supplier' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
