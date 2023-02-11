<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->date('fecha_creacion');
            $table->bigInteger('telefono')->nullable();
            $table->text('facebook_enlace')->nullable();
            $table->string('email');
            $table->string('slug');
            $table->text('notas')->nullable();
            $table->unsignedBigInteger('id_ciudad')->references('id')->on('ciudades');
            $table->unsignedBigInteger('id_usuario')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
