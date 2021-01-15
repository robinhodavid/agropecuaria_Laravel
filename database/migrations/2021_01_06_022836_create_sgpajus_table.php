<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSgpajusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgpajus', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('serie',50)->notnull();
            $table->string('nomb',50)->nullable();
            $table->string('nombrelargo',50)->nullable();
            $table->integer('snom')->unsigned(); //Id de la raza
            $table->date('fecr')->nullable();
            $table->date('fnac')->nullable();
            $table->string('ubica',50)->nullable();
            $table->string('orig',50)->nullable();
            $table->integer('cant')->nullable();
            $table->integer('mini')->nullable();        
            $table->integer('maxi')->nullable();
            $table->string('unid',3)->nullable();
            $table->string('obser',180)->nullable();
           
            //registra el id de la raza
            $table->foreign('snom')->references('idraza')->on('sgrazas');
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
        Schema::dropIfExists('sgpajus');
    }
}
