<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSghistoricotempreprosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sghistoricotemprepros', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->date('fecharegistro')->nullable();
            $table->integer('nrocelo')->nullable();
            $table->integer('nropalpa')->nullable();
            $table->integer('nroservicio')->nullable();
            $table->integer('nropre')->nullable();
            $table->integer('nroabort')->nullable();
            $table->integer('nropart')->nullable();
            $table->integer('id_temp_repr')->unsigned();
            $table->foreign('id_temp_repr')->references('id')->on('sgtempreprods');   
            $table->integer('id_finca')->unsigned();
            $table->foreign('id_finca')->references('id_finca')->on('sgfincas'); 
            //Hace referencia a la tabla sganims a través de nuero de serie 
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
        Schema::dropIfExists('sghistoricotemprepros');
    }
}
