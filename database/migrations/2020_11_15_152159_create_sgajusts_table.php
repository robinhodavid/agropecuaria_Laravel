<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSgajustsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgajusts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('id_serie')->unsigned(); 
            $table->string('serie',50)->notnull();
            $table->boolean('sexo'); //0=hembra, 1= macho;
            $table->float('pesdes')->nullable(); //Peso de destete.
            $table->float('peso')->nullable(); //Peso actual.
            $table->float('difdia')->nullable();
            $table->float('difpeso')->nullable();
            $table->float('pesoi')->nullable();
            $table->float('pa1')->nullable();
            $table->float('pa2')->nullable();
            $table->float('pa3')->nullable();
            $table->float('pa4')->nullable();
            $table->float('c1')->nullable();
            $table->float('c2')->nullable();
            $table->float('c3')->nullable();
            $table->float('c4')->nullable();
            $table->float('v1')->nullable();
            $table->float('v2')->nullable();
            $table->float('v3')->nullable();
            $table->float('v4')->nullable();
            $table->float('gdp')->nullable();
            $table->date('fnac')->nullable();
            //Hace referencia a la tabla sganims a través de nuero de serie 
            
            $table->foreign('id_serie')->references('id')->on('sganims');
            //Hace referencia a la tabla raza
            $table->integer('idraza')->unsigned();
            $table->foreign('idraza')->references('idraza')->on('sgrazas');
            //Referencia a la tabla sgmlotes
            $table->integer('id_lote')->unsigned();
            $table->foreign('id_lote')->references('id_lote')->on('sglotes');    
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
        Schema::dropIfExists('sgajusts');
    }
}
