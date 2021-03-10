<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSgmv1sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgmv1s', function (Blueprint $table) {
            
            $table->engine = 'InnoDB';
            
            $table->increments('id');
            $table->string('codmadre',50);
            $table->string('serie_hijo',50)->nullable();
            $table->string('codpadre',50)->nullable();
            $table->string('tipologia',50)->nullable();
            $table->integer('id_tipologia')->unsigned();
            $table->string('pajuela',50)->nullable();
            $table->float('pesodestete')->nullable();//Peso actual
            $table->string('caso',80)->nullable(); //Si corresponde a un Aborto, Parto o Nacido Muerto
            $table->date('fecha')->nullable();
            $table->date('fecs')->nullable();
            
            $table->integer('id_finca')->unsigned();

            //Referencia a la tabla sgtipologia
            $table->foreign('id_tipologia')->references('id_tipologia')->on('sgtipologias');
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
        Schema::dropIfExists('sgmv1s');
    }
}
