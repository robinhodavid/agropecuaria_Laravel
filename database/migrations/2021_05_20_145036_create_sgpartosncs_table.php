<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSgpartosncsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgpartosncs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('id_serie')->unsigned(); 
            $table->string('serie',50)->notnull();
            $table->date('fecregistro')->nullable();  //Registra la fecha ocurrido del aborto.
            $table->string('causa',180)->nullable(); //Describe la posible causa del aboto
            $table->integer('diaprenez')->nullable(); //dias de preñada cuando abortó.
            $table->string('trimestre')->nullable();
            
            $table->string('obser',180)->nullable();

            //Hace referencia a la tabla sganims a través de nuero de serie 
            $table->foreign('id_serie')->references('id')->on('sganims');
            //Hace referencia al ciclo de la temporada de monta
            $table->integer('id_ciclo')->nullable();
            
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
        Schema::dropIfExists('sgpartosncs');
    }
}
