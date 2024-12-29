<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rak')->insert([
            [
                'nama_rak' => 'Rak A',
                'nama_lokasi' => 'Atas',
                'jumlah' => 0,
                'status' => 'available', // Ubah status menjadi 'available'
                'exp' => Carbon::now()->addMonths(6)->toDateString(), // Default 6 bulan kedepan
            ],
            [
                'nama_rak' => 'Rak A',
                'nama_lokasi' => 'Tengah',
                'jumlah' => 0,
                'status' => 'available', // Ubah status menjadi 'available'
                'exp' => Carbon::now()->addMonths(6)->toDateString(), // Default 6 bulan kedepan
            ],
            [
                'nama_rak' => 'Rak A',
                'nama_lokasi' => 'Bawah',
                'jumlah' => 0,
                'status' => 'available', // Ubah status menjadi 'available'
                'exp' => Carbon::now()->addMonths(6)->toDateString(), // Default 6 bulan kedepan
            ],
            [
                'nama_rak' => 'Rak B',
                'nama_lokasi' => 'Atas',
                'jumlah' => 0,
                'status' => 'available', // Ubah status menjadi 'available'
                'exp' => Carbon::now()->addMonths(6)->toDateString(), // Default 6 bulan kedepan
            ],
            [
                'nama_rak' => 'Rak B',
                'nama_lokasi' => 'Atas',
                'jumlah' => 0,
                'status' => 'available', // Ubah status menjadi 'available'
                'exp' => Carbon::now()->addMonths(6)->toDateString(), // Default 6 bulan kedepan
            ]
        ]);
    }
}