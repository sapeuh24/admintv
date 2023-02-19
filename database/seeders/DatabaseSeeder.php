<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PasarelaSeeder::class,
            CiudadSeeder::class,
            AplicacionesTableSeeder::class,
            DispositivosTableSeeder::class,
            TarifaSeeder::class,
        ]);
    }
}