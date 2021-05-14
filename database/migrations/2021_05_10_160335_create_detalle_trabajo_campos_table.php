<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleTrabajoCamposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_trabajo_campos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('id_serie')->nullable();
            $table->string('serie')->nullable();
            $table->string('observacion')->nullable();
            $table->boolean('paso')->nullable();
            $table->string('diagnostico')->nullable();
            $table->string('evaluacion')->nullable();
            $table->string('caso')->nullable();
            
            $table->integer('id_finca')->unsigned();
            $table->foreign('id_finca')->references('id_finca')->on('sgfincas');

            $table->integer('id_tc')->unsigned();
            $table->foreign('id_tc')->references('id')->on('trabajocampos');

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
        Schema::dropIfExists('detalle_trabajo_campos');
    }
}
