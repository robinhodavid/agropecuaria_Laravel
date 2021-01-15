<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSgpesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgpesos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('id_serie')->unsigned();           
            $table->string('serie',50)->notnull();
            $table->float('peso')->nullable();
            $table->float('gdp')->nullable();
            $table->integer('dias')->nullable();
            $table->float('pgan')->nullable();//Peso ganado
            $table->date('fecha')->nullable();
            $table->float('difdia')->nullable();
            
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
        Schema::dropIfExists('sgpesos');
    }
}
