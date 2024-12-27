<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'nama_sup' => 'BeautyCare Supplier', // Nama supplier yang relevan dengan industri kecantikan
                'telepon' => '081234567890',
                'alamat' => 'Jl. Raya No. 15, Surabaya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nama_sup' => 'Cosmetic Source', // Nama supplier yang relevan dengan produk kosmetik
                'telepon' => '082345678901',
                'alamat' => 'Jl. Melati No. 8, Jakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'nama_sup' => 'Herbal Beauty Supplies', // Nama supplier untuk produk berbasis herbal
                'telepon' => '083456789012',
                'alamat' => 'Jl. Kunti No. 25, Bandung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'nama_sup' => 'Perfume World', // Supplier untuk produk parfum
                'telepon' => '084567890123',
                'alamat' => 'Jl. Parfum No. 32, Yogyakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('supplier')->insert($data);
    }
}
