<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            // ['id' => 1,'name' => 'andre', 'email' => 'andre@gmail.com', 'password' => bcrypt('andre123'), 'role' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2,'name' => 'amel', 'email' => 'amel@gmail.com', 'password' => bcrypt('amel123'), 'role' => 'manager', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
