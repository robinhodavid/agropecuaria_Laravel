<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSgfincaprocesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgfincaprocesos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('id');
            //referencia a la tabla finca
            $table->integer('id_finca')->unsigned();
            $table->foreign('id_finca')->references('id_finca')->on('sgfincas');

            //referencia a la tabla procesos
            $table->integer('id_proceso')->unsigned();
            $table->foreign('id_proceso')->references('id_proceso')->on('sgprocesos');

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
        Schema::dropIfExists('sgfincaprocesos');
    }
}
