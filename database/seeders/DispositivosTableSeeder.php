<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DispositivosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dispositivos')->insert([
            ['nombre' => 'Iphone/Apple v'],
            ['nombre' => 'Fire tv'],
            ['nombre' => 'Android/Tv Box'],
        ]);
    }
}
