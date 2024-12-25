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
        $data = [
            [
                'id' => 3,
                'nama_kat' => 'Haircare',
                'created_at' => '2024-12-22 12:25:03',
                'updated_at' => '2024-12-22 12:25:03',
            ],
            [
                'id' => 4,
                'nama_kat' => 'Parfum',
                'created_at' => '2024-12-22 12:25:15',
                'updated_at' => '2024-12-22 12:25:15',
            ],
            [
                'id' => 5,
                'nama_kat' => 'Bodycare',
                'created_at' => '2024-12-22 12:25:31',
                'updated_at' => '2024-12-22 12:25:31',
            ],
        ];

        DB::table('kategori')->insert($data);
    }
}
