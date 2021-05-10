<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSgparametrosReproduccionAnimalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgparametros_reproduccion_animals', function (Blueprint $table) {
            
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('diasentrecelo')->nullable();
            $table->integer('tiempogestacion')->nullable();
            $table->boolean('status')->nullable();
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
        Schema::dropIfExists('sgparametros_reproduccion_animals');
    }
}
