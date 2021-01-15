<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSghsalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sghsals', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('id_serie')->unsigned();
            $table->string('serie',50)->notnull();
            $table->string('motivo',180);
            $table->date('fechs'); //indica la fecha de salida
            $table->string('procede',180)->nullable();
            $table->string('destino',180)->nullable();
            $table->float('peso')->nullable();
            $table->float('ingbs')->nullable(); //registrado por poseer registro
            $table->date('feche'); //indica la fecha de entrada al sistema
            $table->string('obser',180)->nullable();
            $table->boolean('e_s'); //indica si el registro es de entrada o desalida

            //Hace referencia a la tabla sganims a través de nuero de serie 
            $table->foreign('id_serie')->references('id')->on('sganims');
            //Hace referencia a la tabla sganims a través de nuero de serie 
            $table->integer('id_motsal')->unsigned();
            $table->foreign('id_motsal')->references('id')->on('sgmotivoentradasalidas');

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
        Schema::dropIfExists('sghsals');
    }
}
