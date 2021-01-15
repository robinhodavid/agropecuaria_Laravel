<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSgpartosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgpartos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('id_serie')->unsigned(); 
            $table->string('serie',50)->notnull();
            $table->string('tipo',50)->nullable(); //Nombre
            $table->string('estado',50)->nullable();//condicion corporal
            $table->string('edad')->nullable(); //registra la edad en formato aa-mm   
            $table->string('tipoap',50)->nullable();
            $table->date('fecup')->nullable();
            $table->date('fecpar')->nullable();
            $table->boolean('sexo')->nullable();
            $table->boolean('sexo1')->nullable();
            $table->string('becer',50)->nullable();
            $table->string('becer1',50)->nullable();
            $table->string('obspar',180)->nullable();
            $table->string('edobece',50)->nullable();
            $table->string('edobece1',50)->nullable();
            $table->string('razabe',50)->nullable();//guarda el nombre de la raza
            $table->float('pesoib')->nullable();
            $table->float('pesoib1')->nullable();
            $table->integer('ientpar')->nullable();
            $table->integer('cod')->nullable();//id de la tipologia actual
            $table->integer('codap')->nullable();
            $table->string('marcabec1',2)->nullable();
            $table->string('marcabec2',2)->nullable();
            $table->string('causanm',50)->nullable();
            $table->string('obsernm',180)->nullable();
            $table->boolean('historia')->nullable();
            $table->string('nciclo',50)->nullable(); //nombre del ciclo
            //Hace referencia si la palpación está realizada en una temporada de monta
            $table->integer('id_temp_repr')->unsigned();
            $table->foreign('id_temp_repr')->references('id')->on('sgtempreprods');   
            //Hace referencia a la tabla sganims a través de nuero de serie 
            $table->foreign('id_serie')->references('id')->on('sganims');
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
        Schema::dropIfExists('sgpartos');
    }
}
