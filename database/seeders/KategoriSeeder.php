<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kategori')->insert([
            ['id' => 1,'nama_kategori' => 'Skincare', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2,'nama_kategori' => 'Makeup', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3,'nama_kategori' => 'Haircare', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
