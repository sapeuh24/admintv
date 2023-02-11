<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicioDispositivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicio_dispositivos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_servicio')->references('id')->on('servicios');
            $table->unsignedBigInteger('id_dispositivo')->references('id')->on('dispositivos');
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
        Schema::dropIfExists('servicio_dispositivos');
    }
}