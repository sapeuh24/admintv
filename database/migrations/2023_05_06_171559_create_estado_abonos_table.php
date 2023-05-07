<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstadoAbonosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estado_abonos', function (Blueprint $table) {
            $table->id();
            $table->string('estado_abono');

            $table->unsignedBigInteger('id_abono');
            $table->foreign('id_abono')->references('id')->on('abonos');
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
        Schema::dropIfExists('estado_abonos');
    }
}
