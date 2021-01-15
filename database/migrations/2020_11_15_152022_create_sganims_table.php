<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSganimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sganims', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('serie',50)->unique();
            $table->string('codmadre',50);
            $table->string('codpadre',50);
            $table->boolean('espajuela');
            $table->string('pajuela',50);
            $table->date('fnac');
            $table->date('fecr');
            $table->date('fecs');
            $table->date('fecentrada');
            $table->boolean('status');
            $table->string('tipo',50); //trae el valor del campo nombre de tipología de la tabla tipología
            $table->string('tipoanterior',50); //Este registra el valor del campo campo tipología actual (tipo)
            $table->boolean('sexo');
            $table->string('observa',180);
            $table->string('procede',180);
            $table->float('pesoi'); //pesoinicial o nacimiento
            $table->float('pesoactual');//Peso actual
            $table->date('fulpes');//Fecha utima pesada
            $table->boolean('destatado');
            $table->float('pesodestete');//Peso de destete y este va a depender del swith booleano si está destetado.
            $table->date('fecdes');//Fecha en que se realizó el destete
            $table->integer('nparto'); //registra el numero de parto que posee el animal
            $table->integer('dparto'); //registra la cantidad de dias o la diferencia de días que posee la serie entre el primer parto y el útlimo.
            $table->integer('nservi'); //registra la cantidad de servicios que posee el animal
            $table->date('fecua');//Fecha no identificada esta fecha para no perder el registro.
            $table->date('fecup');//Fecha ultima de parto.

            $table->integer('abort'); //registra la cantidad de aborto que posee la serie.
            $table->string('edad',5); //registra la edad del animal en formato aa-mm
            $table->string('edadpp',5); //registra la edad cuando el animal pare la primera vez en formato aa-mm
            $table->float('ultgdp'); //Ultima ganancia de peso

            $table->integer('ncrias');//numero de crias de una serie hembra

            $table->integer('npartorepor');//numero de parto reportado 

            $table->integer('nabortoreport');//numero de parto reportado     
            
            //Estos campos nos peritiran identificar la tipologias 
            $table->integer('nro_monta');
            $table->boolean('prenada');
            $table->boolean('parida');
            $table->boolean('tienecria');
            $table->boolean('criaviva');
            $table->boolean('ordenho');
            $table->boolean('detectacelo');        

            //Referencia a la tabla sgmotivoentradasalida
            $table->integer('id_motivo_salida')->unsigned();
            $table->foreign('id_motivo_salida')->references('id')->on('sgmotivoentradasalidas');
            //Referencia a la tabla sgtipologia
            $table->integer('id_tipologia')->unsigned();
            $table->foreign('id_tipologia')->references('id_tipologia')->on('sgtipologias');
             //Referencia a la tabla sgraza
            $table->integer('idraza')->unsigned();
            $table->foreign('idraza')->references('idraza')->on('sgrazas');

            //Referencia a la tabla sgcondicioncorporal
            $table->integer('id_condicion')->unsigned();
            $table->foreign('id_condicion')->references('id_condicion')->on('sgcondicioncorporals');

            //Referencia a la tabla sgmotivoentradasalida
            $table->integer('id_motivo_entrada')->unsigned();
            $table->foreign('id_motivo_entrada')->references('id')->on('sgmotivoentradasalidas');

             //Referencia a la tabla sglotes
            $table->integer('id_lote')->unsigned();
            $table->foreign('id_lote')
                    ->references('id_lote')
                    ->on('sglotes');

            //Referencia a la tabla sgfinca
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
        Schema::dropIfExists('sganims');
    }
}
