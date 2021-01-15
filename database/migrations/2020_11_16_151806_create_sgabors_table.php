<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSgaborsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgabors', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('id_serie')->unsigned(); 
            $table->string('serie',50)->notnull();
            $table->date('fecr')->nullable();  //Registra la fecha ocurrido del aborto.
            $table->string('causa',180)->nullable(); //Describe la posible causa del aboto
            $table->integer('diap')->nullable(); //dias de preñada cuando abortó.
            $table->string('obser',180)->nullable();

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
        Schema::dropIfExists('sgabors');
    }
}
