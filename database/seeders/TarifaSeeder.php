<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class TarifaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tarifas')->insert([
            ['tarifa' => '1 mes x $15.99 ', 'precio' => 15.99, 'creditos' => 1, 'comision' => 2.99, 'id_empresa' => 1]
        ]);
    }
}
