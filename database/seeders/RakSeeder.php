<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                'status' => 'unavail',
            ],
            [
                'nama_rak' => 'Rak B',
                'status' => 'unavail',
            ],
            [
                'nama_rak' => 'Rak C',
                'status' => 'unavail',
            ],
            [
                'nama_rak' => 'Rak D',
                'status' => 'unavail',
            ],
            [
                'nama_rak' => 'Rak E',
                'status' => 'unavail',
            ]
        ]);
    }
}
