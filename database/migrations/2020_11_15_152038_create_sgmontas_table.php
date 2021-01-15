<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSgmontasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgmontas', function (Blueprint $table) {
            
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('id_serie')->unsigned();
            $table->string('serie',50)->notnull();
            $table->date('finim');
            $table->date('ffinm');
            $table->integer('tiempo'); //Tiempo en dias
            $table->integer('id_lote')->unsigned();
            $table->integer('idtipoentrante')->unsigned();
            $table->integer('idtiposalida')->unsigned();
            $table->integer('id_temp_repr')->unsigned();
            
            $table->foreign('id_serie')->references('id')->on('sganims');
            //Referencia a la tabla sgmlotes
           
            $table->foreign('id_lote')->references('id_lote')->on('sglotes');
            //Referencia a la tabla sgtiplogia
            
            $table->foreign('idtipoentrante')->references('id_tipologia')->on('sgtipologias');

            //Referencia a la tabla sgtiplogia
            
            $table->foreign('idtiposalida')->references('id_tipologia')->on('sgtipologias');

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
        Schema::dropIfExists('sgmontas');
    }
}
