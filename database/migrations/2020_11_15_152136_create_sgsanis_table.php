<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSgsanisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgsanis', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('id_serie')->unsigned();
            $table->string('serie',50)->notnull();
            $table->string('status',50)->nullable();
            $table->date('fecha')->nullable();
            $table->string('medic',50)->nullable(); //Registra el nombre de la medicina
            $table->string('desc',50)->nullable(); //Registra el tipo de medicina.
            $table->float('cant')->nullable(); //Cantidad usada de l vitamina
            $table->string('unidad',50)->nullable();
            
            //Hace referencia a la tabla sganims a través de nuero de serie 
            $table->foreign('id_serie')->references('id')->on('sganims');
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
        Schema::dropIfExists('sgsanis');
    }
}
