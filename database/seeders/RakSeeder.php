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
                'nama_lokasi' => 'Lokasi 1',
                'jumlah' => 0,
                'status' => 'not_available',
                'exp' => Carbon::now()->addMonths(6)->toDateString(), // Default 6 bulan kedepan
            ],
            [
                'nama_rak' => 'Rak B',
                'nama_lokasi' => 'Lokasi 2',
                'jumlah' => 0,
                'status' => 'not_available',
                'exp' => Carbon::now()->addMonths(6)->toDateString(), // Default 6 bulan kedepan
            ],
            [
                'nama_rak' => 'Rak C',
                'nama_lokasi' => 'Lokasi 3',
                'jumlah' => 0,
                'status' => 'not_available',
                'exp' => Carbon::now()->addMonths(6)->toDateString(), // Default 6 bulan kedepan
            ],
            [
                'nama_rak' => 'Rak D',
                'nama_lokasi' => 'Lokasi 4',
                'jumlah' => 0,
                'status' => 'not_available',
                'exp' => Carbon::now()->addMonths(6)->toDateString(), // Default 6 bulan kedepan
            ],
            [
                'nama_rak' => 'Rak E',
                'nama_lokasi' => 'Lokasi 5',
                'jumlah' => 0,
                'status' => 'not_available',
                'exp' => Carbon::now()->addMonths(6)->toDateString(), // Default 6 bulan kedepan
            ]
        ]);
    }
}
