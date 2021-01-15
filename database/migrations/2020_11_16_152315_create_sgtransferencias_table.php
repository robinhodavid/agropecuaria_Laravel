<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSgtransferenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgtransferencias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_serie')->unsigned(); 
            $table->string('serie',50)->notnull();
            $table->string('codm',50)->nullable();
            $table->string('codp',50)->nullable();
            $table->boolean('espajuela');
            $table->string('paju',50)->nullable();//Indica el Número de la pajuela
            $table->date('fnac')->nullable();
            $table->date('fecr')->nullable();
            $table->date('fecs')->nullable();
            $table->string('destino',50)->nullable();
            $table->integer('id_tipologia')->unsigned();
            $table->string('tipo',50)->nullable(); //trae el valor del campo nombre de tipología de la tabla tipología
            $table->integer('idraza')->unsigned();
            $table->boolean('sexo');
            $table->string('obser',180)->nullable();
            $table->string('procede',180)->nullable();
            $table->integer('id_condicion')->unsigned();
            $table->float('pesoi')->nullable(); //pesoinicial o nacimiento
            $table->float('pesoactual')->nullable();//Peso actual
            $table->date('fulpes')->nullable();//Fecha utima pesada
            $table->boolean('destatado');
            $table->float('pesodestete')->nullable();//Peso de destete y este va a depender del swith booleano si está destetado.
            $table->date('fecdes')->nullable();//Fecha en que se realizó el destete
            $table->integer('nparto')->nullable(); //registra el numero de parto que posee el animal
            $table->integer('dparto')->nullable(); //registra la cantidad de dias o la diferencia de días que posee la serie entre el primer parto y el útlimo.
            $table->integer('nservi')->nullable(); //registra la cantidad de servicios que posee el animal
            $table->date('fecua')->nullable();//Fecha no identificada esta fecha para no perder el registro.
            $table->date('fecup')->nullable();//Fecha ultima de parto.

            $table->integer('abort')->nullable(); //registra la cantidad de aborto que posee la serie.
            $table->string('edad',5); //registra la edad del animal en formato aa-mm
            $table->string('edadpp',5); //registra la edad cuando el animal pare la primera vez en formato aa-mm
            $table->string('tipoap',50)->nullable();//Tipología antes del parto.
            $table->string('tipops',50)->nullable();//Tipología primer servicio.
            $table->string('lote',50)->nullable();//nombre del lote
            $table->string('sublote',50)->nullable();//nombre sublote

            $table->string('lprod',50)->nullable();//lote producción
            $table->string('sublprod',50)->nullable();//sub lote producción

            $table->string('lpast',50)->nullable();//lote pastoreo
            $table->string('sublpast',50)->nullable();//sublote pastoreo

            $table->string('ltemp',50)->nullable();//lote temporada
            $table->string('subltemp',50)->nullable();//sublote temporada

            $table->float('ulgdp'); //Ultima ganancia de peso
            $table->float('pa1'); //Peso a 1
            $table->float('pa2'); //Peso a 1
            $table->float('pa3'); //Peso a 1
            $table->float('pa4'); //Peso a 1
            $table->float('ua'); //ua
            $table->integer('ncrias');//numero de crias de una serie hembra
            $table->integer('npartorepor');//numero de parto reportado 
            $table->integer('nabortoreport');//numero de parto reportado     
            
            //Referencia a la tabla sgmotivoentradasalida
            $table->integer('id_motivo_salida')->unsigned();
            $table->foreign('id_motivo_salida')->references('id')->on('sgmotivoentradasalidas');
            //Referencia a la tabla sgtipologia
           
            $table->foreign('id_tipologia')->references('id_tipologia')->on('sgtipologias');
             //Referencia a la tabla sgraza
            $table->foreign('idraza')->references('idraza')->on('sgrazas');

            //Referencia a la tabla sgcondicioncorporal
            
            $table->foreign('id_condicion')->references('id_condicion')->on('sgcondicioncorporals');

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
        Schema::dropIfExists('sgtransferencias');
    }
}
