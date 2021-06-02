<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlocknotasdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocknotasdetails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('contenido',200)->nullable();
            $table->boolean('read');
            $table->integer('id_blocknotas')->unsigned();
            $table->foreign('id_blocknotas')->references('id')->on('blocknotas');
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
        Schema::dropIfExists('blocknotasdetails');
    }
}
