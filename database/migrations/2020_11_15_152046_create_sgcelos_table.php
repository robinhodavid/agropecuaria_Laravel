<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSgcelosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgcelos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('id_serie')->unsigned();
            $table->string('serie',50)->notnull();
            $table->date('fechr'); //fecha de registro de celo
            $table->integer('dias'); //numero de días en celo
            $table->string('resp',50); //Registra el nombre del responsable
            $table->integer('fecestprocel');//Fecha estimada próximo celo.
            $table->integer('intdiaabi')->nullable(); //Intervalos de dias abiertos.
            $table->boolean('estemporada'); //0=celo registrado en no temporada; 1= celo registrado en temporada.
            $table->integer('id_temp_repr')->unsigned();    
            //Hace referencia a la tabla sganims a través de nuero de serie 
            $table->foreign('id_serie')->references('id')->on('sganims');
            //Referencia a la tabla sgtemprepods
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
        Schema::dropIfExists('sgcelos');
    }
}
