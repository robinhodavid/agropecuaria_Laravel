<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSgpedigreesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgpedigrees', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            
            $table->integer('id_serie')->unsigned();
            $table->string('serie',50);
            $table->date('fechanacimiento')->nullable();
            $table->string('nroreg1')->nullable();
            $table->string('nroreg2')->nullable();
            $table->string('asociacion1')->nullable();
            $table->string('asociacion2')->nullable();
            $table->string('seriepadre',50)->nullable();
            $table->string('nombrepadre',50)->nullable();
            $table->string('seriemadre',50)->nullable();
            $table->string('nombremadre',50)->nullable();
            $table->boolean('espajuelapadre'); //0= no es pajuela 1=pajuelapadre
            $table->string('comentario',180)->nullable();
            
            $table->foreign('id_serie')->references('id')->on('sganims');
            //hace referencia a la tabla raza
            $table->integer('idraza')->unsigned();
            $table->foreign('idraza')->references('idraza')->on('sgrazas');


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
        Schema::dropIfExists('sgpedigrees');
    }
}
