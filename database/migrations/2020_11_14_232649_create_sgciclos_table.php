<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSgciclosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgciclos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_ciclo');
            $table->string('ciclo',100);
            $table->date('fechainicialciclo');
            $table->date('fechafinalciclo');
            $table->string('duracion',5);

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
        Schema::dropIfExists('sgciclos');
    }
}
