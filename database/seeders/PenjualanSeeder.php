<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('penjualan')->insert([
            ['total_harga' => 150000, 'dibayar' => 200000, 'kembalian' => 50000, 'id_user' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
