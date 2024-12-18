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
        DB::table('supplier')->insert([
            ['id' => 1,'nama' => 'Supplier A', 'alamat' => 'Jl. ABC No. 1', 'telepon' => '081234567890', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2,'nama' => 'Supplier B', 'alamat' => 'Jl. XYZ No. 2', 'telepon' => '082345678901', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
