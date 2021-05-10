<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColorescamposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colorescampos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre')->nullable();
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
        Schema::dropIfExists('colorescampos');
    }
}
