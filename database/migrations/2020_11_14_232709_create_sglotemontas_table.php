<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSglotemontasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sglotemontas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_lotemonta');
            $table->date('fechainirea');
            $table->date('fechafinrea');
            $table->date('anho1');
            $table->date('anho2');
            
            $table->integer('id_lote')->unsigned();
            $table->foreign('id_lote')->references('id_lote')->on('sglotes');
            
            $table->integer('id_ciclo')->unsigned();
            $table->foreign('id_ciclo')->references('id_ciclo')->on('sgciclos');
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
        Schema::dropIfExists('sglotemontas');
    }
}
