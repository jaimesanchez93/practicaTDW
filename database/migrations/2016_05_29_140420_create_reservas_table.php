<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('reservasTDW', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idUsuario');
            $table->string('nombre');
            $table->string('email');
            $table->string('pistas');
            $table->string('fecha_reserva');
            $table->enum('tipo',array('temporal','fija'));
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
        //
        Schema::drop('reservasTDW');
    }
}
