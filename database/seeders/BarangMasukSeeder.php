<?php

namespace Database\Seeders;

use App\Models\BarangMasuk;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BarangMasukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Menyemai beberapa data contoh ke dalam tabel barang_masuk
        BarangMasuk::create([
            'id_barang' => 1,  // Ganti dengan id barang yang sesuai
            'id_supplier' => 1, // Ganti dengan id supplier yang sesuai
            'jumlah_barang_masuk' => 100,
            'exp' => Carbon::now()->addMonths(6)->toDateString(), // Exp tanggal 6 bulan dari sekarang
            'tgl_masuk' => Carbon::now()->toDateString(),
        ]);

        BarangMasuk::create([
            'id_barang' => 2,  // Ganti dengan id barang yang sesuai
            'id_supplier' => 2, // Ganti dengan id supplier yang sesuai
            'jumlah_barang_masuk' => 200,
            'exp' => Carbon::now()->addMonths(12)->toDateString(), // Exp tanggal 12 bulan dari sekarang
            'tgl_masuk' => Carbon::now()->toDateString(),
        ]);

        BarangMasuk::create([
            'id_barang' => 3,  // Ganti dengan id barang yang sesuai
            'id_supplier' => 1, // Ganti dengan id supplier yang sesuai
            'jumlah_barang_masuk' => 150,
            'exp' => Carbon::now()->addMonths(3)->toDateString(), // Exp tanggal 3 bulan dari sekarang
            'tgl_masuk' => Carbon::now()->toDateString(),
        ]);
    }
}
