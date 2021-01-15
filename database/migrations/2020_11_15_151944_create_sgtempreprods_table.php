<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSgtempreprodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgtempreprods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->date('fecini'); //Fecha inicial de la temporada.
            $table->date('fecfin'); //Fecha fin de la temporada.
            $table->date('fecdefcierre'); //Fecha fin de la temporada.
            $table->integer('id_finca')->unsigned();
            $table->foreign('id_finca')->references('id_finca')->on('sgfincas');
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
        Schema::dropIfExists('sgtempreprods');
    }
}
