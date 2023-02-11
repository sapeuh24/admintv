<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class AplicacionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('aplicaciones')->insert([
            ['nombre' => 'Premier tv'],
            ['nombre' => 'Rolox tv'],
        ]);
    }
}
