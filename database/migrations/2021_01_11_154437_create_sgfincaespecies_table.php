<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSgfincaespeciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgfincaespecies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_finca')->unsigned();
            $table->integer('id_especie')->unsigned();

            $table->foreign('id_finca')->references('id_finca')->on('sgfincas');
            $table->foreign('id_especie')->references('id')->on('sgespecies');

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
        Schema::dropIfExists('sgfincaespecies');
    }
}
