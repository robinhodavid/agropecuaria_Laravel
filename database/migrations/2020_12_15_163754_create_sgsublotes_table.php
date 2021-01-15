<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSgsublotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgsublotes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_sublote');
            $table->string('nombre_lote',160)->nullable();
            $table->string('sub_lote',160)->nullable();

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
        Schema::dropIfExists('sgsublotes');
    }
}
