<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PasarelaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //insert some dummy records
        DB::table('pasarelas')->insert([
            ['nombre' => 'Paypal'],
            ['nombre' => 'Zelle'],
            ['nombre' => 'Stripe'],
            ['nombre' => 'WesterUnion'],
            ['nombre' => 'MoneyGram'],
            ['nombre' => 'Remitly'],
            ['nombre' => 'Intermex']
        ]);
    }
}
