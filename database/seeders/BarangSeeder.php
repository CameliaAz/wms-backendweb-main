<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                'id_kategori' => 1,
                'varian' => 'Varian A',
                'ukuran' => 'Medium',
                'deskripsi' => 'Deskripsi barang 1',
                'gambar' => 'gambar1.jpg',
            ],
            [
                'id' => 2,
                'nama_barang' => 'Contoh Barang 2',
                'id_kategori' => 2,
                'varian' => 'Varian B',
                'ukuran' => 'Large',
                'deskripsi' => 'Deskripsi barang 2',
                'gambar' => 'gambar2.jpg',
            ],
        ];

        DB::table('barang')->insert($data);
    }
}
