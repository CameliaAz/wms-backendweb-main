<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'nama_barang' => 'Shampoo Herbal Anti Rontok',
                'id_kategori' => 3, // ID untuk kategori 'Haircare'
                'varian' => 'Herbal',
                'ukuran' => '300ml',
                'deskripsi' => 'Shampoo herbal yang dirancang khusus untuk mengurangi kerontokan rambut dan merawat kulit kepala.',
                'gambar' => 'shampoo-herbal.jpg',
                'harga_beli' => 80000.00, // Harga beli
                'harga_jual' => 120000.00, // Harga jual
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nama_barang' => 'Parfum Wanita Eau de Parfum',
                'id_kategori' => 4, // ID untuk kategori 'Parfum'
                'varian' => 'Floral Bouquet',
                'ukuran' => '50ml',
                'deskripsi' => 'Parfum wanita dengan aroma bunga segar yang tahan lama dan elegan.',
                'gambar' => 'parfum-wanita.jpg',
                'harga_beli' => 150000.00,
                'harga_jual' => 250000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'nama_barang' => 'Body Lotion Moisturizing',
                'id_kategori' => 5, // ID untuk kategori 'Bodycare'
                'varian' => 'Vanilla',
                'ukuran' => '200ml',
                'deskripsi' => 'Body lotion yang memberikan kelembapan maksimal dengan aroma vanilla yang menyegarkan.',
                'gambar' => 'body-lotion-vanilla.jpg',
                'harga_beli' => 60000.00,
                'harga_jual' => 95000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('barang')->insert($data);
    }
}
