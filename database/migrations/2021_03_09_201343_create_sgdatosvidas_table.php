<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSgdatosvidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgdatosvidas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('seriem',50);
            $table->date('fecha')->nullable(); //Fecha en el que ocurre el evento. Sea Preñez, Parto, Aborto.
            $table->string('caso',80)->nullable();
            $table->integer('nservicios')->nullable();
            $table->float('pesps')->nullable();
            $table->string('edadps',5)->nullable();//Edad primer servicio
            $table->string('codp',50); //Codigo del padre
            $table->string('edadpp',5)->nullable(); //Edad primer parto
            $table->string('serieh',50)->nullable();
            $table->float('pespih')->nullable(); //Peso inicial del Hijo.
            $table->integer('diapr')->nullable();
            $table->integer('ncelos')->nullable();
            $table->string('edadpc',5)->nullable(); //Edad primer celo
            $table->date('fecpo')->nullable(); //Fecha Primer Ordeño
            $table->date('fecfo')->nullable(); //Fecha fin Ordeño
            $table->integer('prolt')->nullable();
            $table->float('prom')->nullable(); 
            $table->integer('dialac')->nullable(); //dias de lactancia
            $table->integer('diaord')->nullable(); //dias de ordeño
            $table->integer('diaop')->nullable(); //*
            $table->integer('diapfo')->nullable(); //*
            $table->integer('diaela')->nullable(); //*
            $table->float('prodop')->nullable(); 
            $table->float('prodpfo')->nullable(); 
            $table->date('fecas')->nullable(); //Fecha aproximada de secado.
            $table->integer('diafoas')->nullable(); //*

            $table->float('iparpc')->nullable(); 
            $table->float('iparps')->nullable(); 
            $table->float('iparcon')->nullable(); 
            $table->float('ientpar')->nullable(); //Intervalo entre parto
            $table->float('pentser')->nullable();
            $table->float('iserv')->nullable();   //Intervalo entre servicios
            $table->float('ientcel')->nullable();   //Intervalo entre servicios
            $table->float('acumn')->nullable(); 
            $table->float('acuia')->nullable();
            $table->float('iee')->nullable(); //Intervalo entre evento.
            $table->string('sw')->nullable();

            $table->integer('id_finca')->unsigned();
             //Referencia a la tabla sgfinca
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
        Schema::dropIfExists('sgdatosvidas');
    }
}
