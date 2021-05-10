<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSgparametrosGanaderiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgparametros_ganaderias', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('diasaldestete')->nullable();
            $table->integer('pesoajustado18m')->nullable();
            $table->integer('pesoajustado12m')->nullable();
            $table->integer('pesoajustado24m')->nullable();
            $table->integer('pesoajustadoaldestete')->nullable();
            $table->boolean('status')->nullable();
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
        Schema::dropIfExists('sgparametros_ganaderias');
    }
}
