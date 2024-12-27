<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'nama_kat' => 'Haircare', // Kategori untuk perawatan rambut
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nama_kat' => 'Skincare', // Kategori untuk perawatan kulit
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'nama_kat' => 'Makeup', // Kategori untuk produk makeup
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'nama_kat' => 'Fragrance', // Kategori untuk parfum
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'nama_kat' => 'Bodycare', // Kategori untuk perawatan tubuh
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('kategori')->insert($data);
    }
}
