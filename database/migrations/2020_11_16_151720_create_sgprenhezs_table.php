<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSgprenhezsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgprenhezs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('id_serie')->unsigned(); 
            $table->string('serie',50)->notnull();
            $table->date('fregp')->nullable(); //indica la fecha en que se registra la preñez.
            $table->date('fepre')->nullable(); //indica la fecha de preñez.
            $table->date('fecas')->nullable();//Fecha apróximada de secado.
            $table->date('fecap')->nullable();//fecha apróximada de parto.
            $table->date('fecpo')->nullable();//fecha proxima ordeño
            $table->date('fecfo')->nullable();//fecha final de ordeño.
            $table->float('prolt')->nullable();//produccion por litro
            $table->float('prom')->nullable(); //
            $table->integer('dialac')->nullable();//dias de lactancia
            $table->integer('diaord')->nullable();//dias de lactancia
            $table->date('fecser')->nullable();//fecha de servicio.
            $table->string('toropaj',50)->nullable(); //Toro pajuela.
            $table->string('nomi',50)->nullable(); //= Responsable.
            $table->integer('intdiaabi')->nullable();//Intervalo de Dias abiertos.
            $table->integer('intestpar')->nullable();//Intervalo entre partos.
            $table->float('pesopre')->nullable();//Peso de preñez = peso_pre?ez.
            $table->integer('mesespre')->nullable();//Meses preñada = meses_pre?ada.
            $table->string('metodo')->nullable();//Indica el método de Preñez, ya sea Temporada de Monta, Inseminación artificial o Monta Libre. 
            $table->string('torotemp')->nullable();//registra la serie del toro que participa en una temporada de toro. 

            //Hace referencia a la tabla sganims a través de nuero de serie 
            $table->foreign('id_serie')->references('id')->on('sganims');
           
            //Hace referencia si la palpación está realizada en una temporada de monta
            $table->integer('id_temp_repr')->unsigned();
            $table->foreign('id_temp_repr')->references('id')->on('sgtempreprods');   
           
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
        Schema::dropIfExists('sgprenhezs');
    }
}
