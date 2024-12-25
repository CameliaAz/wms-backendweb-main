<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                'nama_sup' => 'Supplier Name',
                'telepon' => '1234567890',
                'alamat' => 'Lawang, Malang',
                'created_at' => '2024-12-20 05:11:32',
                'updated_at' => '2024-12-20 06:13:50',
            ],
            [
                'id' => 2,
                'nama_sup' => 'Supplier Name',
                'telepon' => '1234567890',
                'alamat' => 'Malang',
                'created_at' => '2024-12-20 05:37:12',
                'updated_at' => '2024-12-20 05:37:12',
            ],
        ];

        DB::table('supplier')->insert($data);
    }
}
