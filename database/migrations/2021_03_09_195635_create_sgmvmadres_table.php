<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSgmvmadresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgmvmadres', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('codmadre',50);
            $table->date('fnac')->nullable();
            $table->string('tipologia',50)->nullable();
            $table->integer('id_tipologia')->unsigned();
            $table->integer('npartos')->nullable();
            $table->integer('nabortos')->nullable();
            $table->integer('nservicios')->nullable();
            $table->string('lote')->nullable();
            $table->string('sub_lote')->nullable();
            $table->string('observacion',80)->nullable(); 
            $table->date('faproxparto')->nullable();
            $table->integer('IDA')->nullable(); //Se coloca por tener registros
            $table->date('fepre')->nullable(); //Fecha de preñez
            $table->date('fecs')->nullable(); //Fecha de salida
            $table->date('fecup')->nullable(); //Fecha ultimo parto
            $table->string('vaquera',50)->nullable(); //Vaquera
            $table->integer('id_finca')->unsigned();

            //Referencia a la tabla sgtipologia
            $table->foreign('id_tipologia')->references('id_tipologia')->on('sgtipologias');
            //Referencia a la tabla sgfinca
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
        Schema::dropIfExists('sgmvmadres');
    }
}
