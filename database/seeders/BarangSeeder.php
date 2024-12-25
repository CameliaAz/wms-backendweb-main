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
                'nama_barang' => 'Contoh Barang 1',
                'id_kategori' => 3, // ID untuk kategori 'Haircare'
                'varian' => 'Varian A',
                'ukuran' => 'Medium',
                'deskripsi' => 'Deskripsi barang 1',
                'gambar' => 'gambar1.jpg',
            ],
            [
                'id' => 2,
                'nama_barang' => 'Contoh Barang 2',
                'id_kategori' => 4, // ID untuk kategori 'Parfum'
                'varian' => 'Varian B',
                'ukuran' => 'Large',
                'deskripsi' => 'Deskripsi barang 2',
                'gambar' => 'gambar2.jpg',
            ],
            [
                'id' => 3,
                'nama_barang' => 'Contoh Barang 3',
                'id_kategori' => 5, // ID untuk kategori 'Bodycare'
                'varian' => 'Varian C',
                'ukuran' => 'Small',
                'deskripsi' => 'Deskripsi barang 3',
                'gambar' => 'gambar3.jpg',
            ],
        ];

        DB::table('barang')->insert($data);
    }
}
