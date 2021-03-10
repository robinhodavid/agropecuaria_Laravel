<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSgservHistoricosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgserv_historicos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('id_serie')->unsigned(); 
            $table->string('serie',50)->notnull();
            $table->date('fecha')->nullable(); //Fecha en que se registra el servicio.
            $table->string('toro',50)->nullable();//Si el servicio se hace directamente con toro.
            $table->string('paju',50)->nullable();//Si el servicio se hace directamente con toro.
            $table->integer('marca')->nullable();//Si el servicio se hace directamente con toro.
            $table->integer('snro')->nullable();//Cantidad de pajuelas usadas 
            $table->string('edad',5)->nullable();//Registra la edad en formato aa-mm
            $table->float('peso')->nullable();//registra el peso actual de la serie a la hora de regisrar servicio.
            $table->string('nomi',50)->nullable();//Registra el nombre del responsable


            //Hace referencia a la tabla sganims a través de nuero de serie 
            $table->foreign('id_serie')->references('id')->on('sganims');

            //Referencia a la tabla sgtiplogia
            $table->integer('id_tipologia')->unsigned();
            $table->foreign('id_tipologia')->references('id_tipologia')->on('sgtipologias');
             //Hace referencia si la palpación está realizada en una temporada de monta
            $table->integer('id_ciclo')->unsigned();
            $table->foreign('id_ciclo')->references('id_ciclo')->on('sgciclos');
            $table->integer('id_finca')->unsigned();
            $table->foreign('id_finca')->references('id_finca')->on('sgfincas');

            $table->string('nciclo')->nullable(); //Nombre Ciclo = temporada de reproduccion.     
            $table->boolean('historias')->nullable();

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
        Schema::dropIfExists('sgserv_historicos');
    }
}
