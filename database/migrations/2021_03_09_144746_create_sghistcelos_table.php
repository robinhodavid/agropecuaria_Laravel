<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSghistcelosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sghistcelos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('id_serie')->unsigned();

            $table->string('serie',50)->notnull();
            $table->date('fechr')->nullable(); //fecha de registro de celo
            $table->integer('dias')->nullable(); //numero de días en celo
            $table->string('resp',50)->nullable(); //Registra el nombre del responsable
            $table->integer('fecestprocel');//Fecha estimada próximo celo.
            $table->integer('intdiaabi')->nullable(); //Intervalos de dias abiertos.
            $table->boolean('estemporada'); //0=celo registrado en no temporada; 1= celo registrado en temporada.
            $table->integer('id_ciclo')->nullable(); //Ciclo = temporada de reproduccion.     
            $table->string('nciclo')->nullable(); //Nombre Ciclo = temporada de reproduccion.     
            $table->boolean('historias')->nullable();
            //Hace referencia a la tabla sganims a través de nuero de serie 
            $table->foreign('id_serie')->references('id')->on('sganims');
            //Referencia a la tabla sgtemprepods
            
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
        Schema::dropIfExists('sghistcelos');
    }
}
