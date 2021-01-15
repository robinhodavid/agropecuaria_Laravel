<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSgtipologiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgtipologias', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_tipologia');
            $table->string('nombre_tipologia');
            $table->string('nomenclatura')->nullable();
            $table->integer('edad');
            $table->float('peso');
            $table->boolean('destetado');
            $table->integer('sexo');
            $table->integer('nro_monta');
            $table->boolean('prenada');
            $table->boolean('parida');
            $table->boolean('tienecria');
            $table->boolean('criaviva');
            $table->boolean('ordenho');
            $table->boolean('detectacelo');
            $table->string('descripcion', 160);

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
        Schema::dropIfExists('sgtipologias');
    }
}
