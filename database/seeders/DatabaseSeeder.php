<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersSeeder::class);
        $this->call(KategoriSeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(BarangSeeder::class);
        $this->call(RakSeeder::class);
        // $this->call(BarangMasukSeeder::class);
        // $this->call(LokasiBarangSeeder::class);
    }
}
