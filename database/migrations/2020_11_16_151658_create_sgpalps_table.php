<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSgpalpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgpalps', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('id_serie')->unsigned(); 
            $table->string('serie',50)->notnull();
            $table->date('fechr');
            $table->string('resp',50)->nullable();
            $table->string('eval',50)->nullable();
            $table->date('prcita'); //Indica la fecha de la proxima cita.

            //Hace referencia a la tabla sganims a través de nuero de serie 
            
            $table->foreign('id_serie')->references('id')->on('sganims');
            //Referencia a la tabla sgmlotes
            $table->integer('id_diagnostico')->unsigned();
            $table->foreign('id_diagnostico')->references('id_diagnostico')->on('sgdiagnosticpalpaciones'); 
            //Hace referencia si la palpación está realizada en una temporada de monta
            $table->integer('id_temp_repr')->unsigned();
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
        Schema::dropIfExists('sgpalps');
    }
}
