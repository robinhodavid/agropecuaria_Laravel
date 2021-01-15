<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSgdiagnosticpalpacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgdiagnosticpalpaciones', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_diagnostico');
            $table->string('nombre',50);
            $table->string('descrip',180)->nullable();
            
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
        Schema::dropIfExists('sgdiagnosticpalpaciones');
    }
}
