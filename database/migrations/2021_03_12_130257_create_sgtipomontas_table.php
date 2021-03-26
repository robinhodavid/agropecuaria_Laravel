<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSgtipomontasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgtipomontas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->id();
            $table->string('nombre')->nullnable();
            $table->string('nomenclatura',5)->nullnable(); 
            $table->string('descripcion',120)->nullnable();

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
        Schema::dropIfExists('sgtipomontas');
    }
}
