<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSghprenhezsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sghprenhezs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            
            $table->integer('id_serie')->unsigned(); 
            $table->string('serie',50)->notnull();
            $table->string('tipo',50)->nullable(); //Nombre
            $table->string('edad')->nullable(); //registra la edad en formato aa-mm   
            $table->integer('nservi')->nullable(); //registra el número de servicio   
            $table->string('tipops',50)->nullable();
            $table->float('pesps')->nullable();
            $table->date('fecps')->nullable();
            $table->string('edadps',5)->nullable();
            $table->date('fecspr')->nullable();
            $table->integer('codtp')->nullable();
            $table->string('respi',50)->nullable();
            $table->string('tipoap',50)->nullable();
            $table->date('fecup')->nullable();
            $table->string('edadpp',5)->nullable();
            $table->date('fecpar')->nullable();
            $table->boolean('sexo')->nullable();
            $table->boolean('sexo1')->nullable();
            $table->string('becer',50)->nullable();
            $table->string('becer1',50)->nullable();
            $table->string('obspar',180)->nullable();
            $table->float('pesoib')->nullable();
            $table->float('pesoib1')->nullable();
            $table->string('causab',50)->nullable();
            $table->string('aobsab',180)->nullable();
            $table->date('fecabo')->nullable();
            $table->integer('diapr')->nullable();
            $table->integer('ncelos')->nullable();
            $table->date('fecpc')->nullable();
            $table->string('edadpc',5)->nullable();
            $table->date('fecuc')->nullable();
            $table->date('fecpo')->nullable();
            $table->date('fecfo')->nullable();
            $table->float('prolt')->nullable();
            $table->float('prom')->nullable();
            $table->integer('dialac')->nullable();
            $table->integer('diapfo')->nullable();
            $table->integer('diaela')->nullable();
            $table->float('prodop')->nullable();
            $table->float('prodpfo')->nullable();
            $table->date('fecas')->nullable();
            $table->integer('diafoas')->nullable();
            $table->integer('iparpc')->nullable();
            $table->integer('iparps')->nullable();
            $table->integer('iparcon')->nullable();
            $table->integer('ientpar')->nullable();
            $table->integer('pentser')->nullable();
            $table->integer('iserv')->nullable();
            $table->integer('ientcel')->nullable();
            $table->integer('acumn')->nullable();
            $table->integer('acuia')->nullable();
            $table->integer('cod')->nullable();//id de la tipologia actual
            $table->integer('codps')->nullable();
            $table->integer('codap')->nullable();
            $table->string('marcabec1',2)->nullable();
            $table->string('marcabec2',2)->nullable();
            $table->string('causanm',50)->nullable();
            $table->string('obsernm',180)->nullable();
            $table->string('obsebec1',180)->nullable();
            $table->integer('codp')->nullable();
            $table->string('razapadre',50)->nullable();//guarda el nombre de la raza
            $table->string('tipopadre',50)->nullable();
            $table->string('nombrepadre',50)->nullable();
            $table->date('fechanacpadre')->nullable();
            $table->boolean('espajuela')->nullable();
            $table->boolean('historia')->nullable();
            $table->string('nciclo',50)->nullable();
            $table->string('torotemp',50)->nullable(); //guarda la serie torote porada
            $table->string('razabe',50)->nullable();//guarda el nombre de la raza
            $table->integer('idraza')->nullable();
            $table->string('raza',50)->nullable(); //nombre
            $table->string('estado',50)->nullable();//condicion corporal
            $table->string('edobece',50)->nullable();
            $table->string('edobece1',50)->nullable();
            $table->integer('id_temp_repr')->nullable();
            
            //Hace referencia a la tabla sganims a través de numero id de serie 
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
        Schema::dropIfExists('sghprenhezs');
    }
}
