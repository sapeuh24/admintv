<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicioAplicacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicio_aplicaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_servicio')->references('id')->on('servicios');
            $table->unsignedBigInteger('id_aplicacion')->references('id')->on('aplicaciones');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicio_aplicaciones');
    }
}
