<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\BarangMasuk;
use App\Models\LokasiBarang;

class BarangMasukSeeder extends Seeder
{
/*************  ✨ Codeium Command ⭐  *************/
    /**
     * Menyemai beberapa data contoh ke dalam tabel barang_masuk dan memperbarui stok di lokasi.
     * Jika barang sudah ada di lokasi, maka stok akan diupdate.
     * Jika barang belum ada di lokasi, maka data baru akan dibuat.
     */
/******  aac79412-e0c2-458e-aa57-2c1e04c574c5  *******/    public function run()
    {
        // Menyemai beberapa data contoh ke dalam tabel barang_masuk
        $barangMasuk = BarangMasuk::create([
            'id_barang' => 1,  // Ganti dengan id barang yang sesuai
            'id_supplier' => 1, // Ganti dengan id supplier yang sesuai
            'jumlah_barang_masuk' => 100,
            'exp' => Carbon::now()->addMonths(6)->toDateString(),
            'tgl_masuk' => Carbon::now()->toDateString(),
        ]);

        // Memeriksa apakah barang sudah ada di lokasi dan memperbarui stok
        $lokasiBarang = LokasiBarang::where('id_barang_masuk', $barangMasuk->id)
            ->where('id_rak', 1)  // Asumsi id_rak sesuai yang Anda inginkan
            ->first();

        if ($lokasiBarang) {
            // Jika barang sudah ada, update stok
            $lokasiBarang->jumlah_stock += $barangMasuk->jumlah_barang_masuk;
            $lokasiBarang->exp = $barangMasuk->exp;
            $lokasiBarang->save();
        } else {
            // Jika barang belum ada, buat data baru di lokasi
            LokasiBarang::create([
                'id_barang_masuk' => $barangMasuk->id,
                'id_rak' => 1, // Asumsi id_rak sesuai
                'jumlah_stock' => $barangMasuk->jumlah_barang_masuk,
                'exp' => $barangMasuk->exp,
            ]);
        }
    }
}
