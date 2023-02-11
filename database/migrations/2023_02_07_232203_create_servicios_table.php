<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tarifa')->references('id')->on('tarifas');
            $table->unsignedBigInteger('id_cliente')->references('id')->on('clientes');
            $table->unsignedBigInteger('id_aplicacion')->references('id')->on('aplicaciones');
            $table->date('fecha_creacion');
            $table->integer('creditos_restantes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicios');
    }
}
